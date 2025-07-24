<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\ProductListExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\BulkOrderService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use App\Facades\Cart;
use App\Facades\Checkout;
use App\Models\Product;
use App\Services\CartService;

class BulkOrderController extends Controller
{
    public function downloadProductListExcel()
    {
        return Excel::download(new ProductListExport, 'product_list.xlsx');
    }

    public function downloadExampleCsv()
    {
        return response()->download(storage_path('app/example_bulk_order.csv'));
    }

    public function parseCsv(Request $request, BulkOrderService $service)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);
        $result = $service->parseCsv($request->file('csv_file'));

        foreach ($result['products'] as  $data) {

            $product = Product::where('sku', $data['sku'])->first();
          
            Cart::add(
                $product->id,
                $data['quantity'],
                null,
                null, // will be null for simple products
                $data['type'] // new parameter for unit/kit selection
            );
        }
        return redirect()->route('checkout.index');
    }

    public function showForm()
    {
        // Fetch payment methods
        $paymentMethods = \App\Facades\Checkout::getPaymentMethods();
        $paymentMethodsArray = [];
        foreach ($paymentMethods as $method) {
            $paymentMethodsArray[$method['id']] = $method['name'];
        }
        $user = auth()->user();
        // Optionally split name if needed, similar to CheckoutController
        if ($user) {
            $nameParts = explode(' ', $user->name, 2);
            $user->first_name = $nameParts[0] ?? '';
            $user->last_name = $nameParts[1] ?? '';
        }
        // Fetch countries and states for dropdowns
        $countries = \App\Models\Country::orderBy('name')->get();
        $states = \App\Models\State::orderBy('name')->get();
        return view('user.bulk-order', compact('paymentMethodsArray', 'user', 'countries', 'states'));
    }

    public function submit(Request $request, BulkOrderService $service)
    {
        Log::info('BulkOrderController@submit started', [
            'user_id' => auth()->id(),
            'request_data' => $request->except(['products']), // Exclude products for brevity
            'has_products' => $request->has('products'),
            'products_type' => gettype($request->input('products')),
            'payment_method' => $request->input('payment_method')
        ]);

        // Decode products JSON string to array if needed
        if ($request->has('products') && is_string($request->products)) {
            $products = json_decode($request->products, true);
            $request->merge(['products' => $products]);
            Log::info('Products decoded from JSON', [
                'products_count' => count($products),
                'first_product' => $products[0] ?? null
            ]);
        }

        try {
            $request->validate([
                'products' => 'required|array',
                'billing_address' => 'required|array',
                'shipping_address' => 'required|array',
                'payment_method' => 'required|string',
                'payment_token' => 'required|string',
            ]);

            Log::info('BulkOrderController validation passed', [
                'products_count' => count($request->input('products')),
                'billing_keys' => array_keys($request->input('billing_address')),
                'shipping_keys' => array_keys($request->input('shipping_address'))
            ]);

            // Clear the cart before adding new products
            Cart::clear();

            // Add each product from the CSV to the cart
            foreach ($request->input('products') as $item) {
                // Required: sku, quantity, type (retail/wholesale)
                $sku = $item['sku'] ?? null;
                $quantity = $item['quantity'] ?? 1;
                $pricingType = $item['type'] ?? null;
                if (!$sku || !$quantity) continue;
                $product = \App\Models\Product::where('sku', $sku)->first();
                if ($product) {
                    Cart::add($product->id, $quantity, [], null, $pricingType);
                }
            }

            // Prepare checkout data
            $checkoutData = $request->all();

            // Use the main checkout logic
            $result = Checkout::processCheckout($checkoutData, $request->payment_method);

            // Ensure result has the expected structure
            if (!is_array($result) || !isset($result['success'])) {
                Log::error('Invalid checkout result structure (bulk order)', [
                    'result' => $result,
                    'user_id' => auth()->id(),
                    'request_data' => $request->all()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Checkout processing failed due to invalid response.'
                ], 500);
            }

            if ($result['success']) {
                Log::info('Bulk order checkout successful', [
                    'order_id' => $result['order_id'] ?? 'unknown',
                    'order_number' => $result['order_number'] ?? 'unknown',
                    'user_id' => auth()->id()
                ]);

                // Check if PayPal redirect is required
                if (isset($result['redirect_required']) && $result['redirect_required']) {
                    return response()->json([
                        'success' => true,
                        'order_id' => $result['order_id'] ?? null,
                        'order_number' => $result['order_number'] ?? null,
                        'message' => $result['message'] ?? 'Order placed successfully!',
                        'redirect_required' => true,
                        'redirect_url' => $result['redirect_url'] ?? null
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'order_id' => $result['order_id'] ?? null,
                    'order_number' => $result['order_number'] ?? null,
                    'message' => $result['message'] ?? 'Order placed successfully!',
                    'redirect_url' => route('checkout.confirmation', $result['order_id'] ?? 0)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Checkout failed. Please try again.'
            ], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('BulkOrderController validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->except(['products'])
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('BulkOrderController submit failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);
            throw $e;
        }
    }

    /**
     * Calculate tax, shipping, and total dynamically for bulk order (AJAX)
     */
    public function calculateTotals(Request $request)
    {
        $products = $request->input('products', []);
        // Accept both new and old keys for backward compatibility
        $billing = $request->input('billing_address', $request->input('billing', []));
        $shipping = $request->input('shipping_address', $request->input('shipping', []));

        // Calculate subtotal from products
        $subtotal = 0;
        foreach ($products as $item) {
            $subtotal += isset($item['subtotal']) ? $item['subtotal'] : 0;
        }

        // Get country/state (convert ISO2 to ID)
        $billingCountry = $billing['country'] ?? null;
        $shippingCountry = $shipping['country'] ?? null;
        $billingCountryId = $billingCountry;
        $shippingCountryId = $shippingCountry;
        if ($billingCountry && !is_numeric($billingCountry)) {
            $country = \App\Models\Country::where('iso2', $billingCountry)->first();
            $billingCountryId = $country ? $country->id : null;
        }
        if ($shippingCountry && !is_numeric($shippingCountry)) {
            $country = \App\Models\Country::where('iso2', $shippingCountry)->first();
            $shippingCountryId = $country ? $country->id : null;
        }
        $billingStateId = $billing['state'] ?? null;
        $shippingStateId = $shipping['state'] ?? null;
        $storeShippingMethodId = setting('shipping_method_id');

        // Use CartService for tax/shipping logic
        $cartService = app(\App\Services\CartService::class);
        $tax = $cartService->getTaxAmount($billingCountryId, $billingStateId);

        $shippingCost = $cartService->getShippingCost($shippingCountryId, $shippingStateId, $storeShippingMethodId);

        $discount = 0; // No coupon for bulk order by default
        $total = $subtotal - $discount + $tax + $shippingCost;

        return response()->json([
            'success' => true,
            'subtotal' => round($subtotal, 2),
            'tax' => round($tax, 2),
            'shipping' => round($shippingCost, 2),
            'discount' => round($discount, 2),
            'total' => round($total, 2),
        ]);
    }
}
