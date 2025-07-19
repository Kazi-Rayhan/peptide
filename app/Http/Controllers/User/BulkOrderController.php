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
        return response()->json($result);
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
        return view('user.bulk-order', compact('paymentMethodsArray', 'user'));
    }

    public function submit(Request $request, BulkOrderService $service)
    {
        Log::info('BulkOrderController@submit started', [
            'user_id' => auth()->id(),
            'request_data' => $request->except(['products']), // Exclude products for brevity
            'has_products' => $request->has('products'),
            'products_type' => gettype($request->input('products')),
            'payment_method' => $request->input('payment')
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
                'billing' => 'required|array',
                'shipping' => 'required|array',
                'payment' => 'required|string',
            ]);

            Log::info('BulkOrderController validation passed', [
                'products_count' => count($request->input('products')),
                'billing_keys' => array_keys($request->input('billing')),
                'shipping_keys' => array_keys($request->input('shipping'))
            ]);

            $order = $service->createBulkOrder(
                auth()->user(),
                $request->input('products'),
                $request->input('billing'),
                $request->input('shipping'),
                $request->input('payment')
            );

            Log::info('BulkOrderController order created successfully', [
                'order_id' => $order->id,
                'order_total' => $order->total,
                'payment_method' => $order->payment_method,
                'payment_status' => $order->payment_status
            ]);

            // Handle payment processing
            $paymentMethod = $request->input('payment');
            
            if ($paymentMethod === 'paypal') {
                Log::info('BulkOrderController processing PayPal payment', [
                    'order_id' => $order->id,
                    'user_id' => auth()->id()
                ]);

                // Use PayPalService to create PayPal payment
                $paypalService = new \App\Services\PayPalService();
                $orderData = [
                    'total' => $order->total,
                    'order_id' => $order->id,
                    'order_number' => 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                    'return_url' => route('paypal.success', ['order' => $order->id]),
                    'cancel_url' => route('user.orders.show', $order->id),
                ];

                $result = $paypalService->createPayment($orderData);
                
                Log::info('BulkOrderController PayPal payment result', [
                    'result' => $result,
                    'order_id' => $order->id
                ]);

                if ($result['success'] && isset($result['approval_url'])) {
                    return response()->json([
                        'success' => true,
                        'redirect_required' => true,
                        'redirect_url' => $result['approval_url'],
                        'message' => 'Redirecting to PayPal...'
                    ]);
                }
            } elseif ($paymentMethod === 'stripe') {
                Log::info('BulkOrderController processing Stripe payment', [
                    'order_id' => $order->id,
                    'user_id' => auth()->id(),
                    'payment_token' => $request->input('payment_token')
                ]);

                // Process Stripe payment directly
                try {
                    $stripeSecret = setting('payments.stripe_secret');
                    Log::info('BulkOrderController Stripe configuration', [
                        'stripe_secret_length' => strlen($stripeSecret),
                        'stripe_secret_starts_with' => substr($stripeSecret, 0, 7),
                        'stripe_publishable_key' => setting('payments.stripe_publishable_key')
                    ]);
                    
                    // Set Stripe API key
                    \Stripe\Stripe::setApiKey($stripeSecret);
                    
                    $stripe = new \Stripe\StripeClient($stripeSecret);
                    
                    // Create payment intent
                    $paymentIntent = $stripe->paymentIntents->create([
                        'amount' => (int)($order->total * 100), // Convert to cents
                        'currency' => 'usd',
                        'payment_method' => $request->input('payment_token'),
                        'payment_method_types' => ['card'],
                        'confirmation_method' => 'manual',
                        'confirm' => true,
                        'metadata' => [
                            'order_id' => $order->id,
                            'order_number' => 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                            'customer_email' => $request->input('billing.email')
                        ]
                    ]);

                    Log::info('BulkOrderController Stripe payment intent created', [
                        'payment_intent_id' => $paymentIntent->id,
                        'status' => $paymentIntent->status,
                        'order_id' => $order->id
                    ]);

                    if ($paymentIntent->status === 'succeeded') {
                        // Update order with payment information
                        $order->update([
                            'payment_intent_id' => $paymentIntent->id,
                            'payment_status' => 'paid',
                            'status' => 'confirmed'
                        ]);

                        // Send confirmation emails
                        $emailService = new \App\Services\OrderEmailService();
                        $emailService->sendNewOrderEmails($order);

                        return response()->json([
                            'success' => true,
                            'redirect_url' => route('checkout.order-details', $order->id),
                            'message' => 'Payment processed successfully!'
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Payment failed: ' . ($paymentIntent->last_payment_error?->message ?? 'Unknown error')
                        ], 422);
                    }
                } catch (\Exception $e) {
                    Log::error('BulkOrderController Stripe payment failed', [
                        'error' => $e->getMessage(),
                        'order_id' => $order->id
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Payment failed: ' . $e->getMessage()
                    ], 422);
                }
            }

            return response()->json([
                'success' => true,
                'redirect_url' => route('checkout.order-details', $order->id),
                'message' => 'Bulk order placed successfully!'
            ]);

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
} 