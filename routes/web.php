<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderPrintController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\PageController;
use App\Mail\NewOrderNotification;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\WelcomeEmail;
use App\Models\Product;
use App\Http\Controllers\User\BulkOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $products = Product::all();
    return view('home', compact('products'));
})->name('home');
Route::post('/newsletter/subscribe', [HomeController::class, 'store'])->name('newsletter.subscribe');
// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'store'])->name('contact.store');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

// E-commerce Frontend Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply-coupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove-coupon');
Route::get('/cart/count', [CartController::class, 'count']);

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/checkout/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
    Route::get('/checkout/order-details/{order}', [CheckoutController::class, 'orderDetails'])->name('checkout.order-details');
    Route::get('/checkout/download-invoice/{order}', [CheckoutController::class, 'downloadInvoice'])->name('checkout.download-invoice');
});
Route::get('/checkout/repay/{order}', [CheckoutController::class, 'repay'])->name('checkout.repay')->middleware('auth');
Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');
Route::get('/checkout/summary', [CheckoutController::class, 'getSummary'])->name('checkout.summary');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/checkout/repay/process/{order}', [CheckoutController::class, 'repayProcess'])->name('checkout.repay.process')->middleware('auth');
Route::post('/checkout/calculate-totals', [App\Http\Controllers\CheckoutController::class, 'calculateTotals'])->name('checkout.calculate-totals');

// PayPal Routes
Route::get('/paypal/success/{order?}', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');
Route::post('/paypal/webhook', [PayPalController::class, 'webhook'])->name('paypal.webhook');

// PayPal Test Route (remove in production)
Route::get('/paypal/test', function () {
    $paypalService = new \App\Services\PayPalService();
    return response()->json($paypalService->testConnection());
})->name('paypal.test');

// Stripe Test Route (remove in production)
Route::get('/stripe/test', function () {
    $stripeKey = config('services.stripe.publishable_key');
    $stripeSecret = config('services.stripe.secret_key');

    return response()->json([
        'publishable_key_configured' => !empty($stripeKey),
        'secret_key_configured' => !empty($stripeSecret),
        'publishable_key_length' => strlen($stripeKey),
        'secret_key_length' => strlen($stripeSecret),
        'environment' => config('app.env')
    ]);
})->name('stripe.test');

// Order Routes
Route::get('/orders/{order}', [CheckoutController::class, 'orderDetails'])->name('order.details');

// Print Routes
Route::get('/orders/{order}/print-invoice', [OrderPrintController::class, 'printInvoice'])->name('orders.print-invoice');
Route::get('/orders/{order}/print-shipping-label', [OrderPrintController::class, 'printShippingLabel'])->name('orders.print-shipping-label');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');

Auth::routes();

// User Dashboard Routes (Protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/profile/change-password', [UserController::class, 'changePassword'])->name('user.password.change');

    // Order Management
    Route::get('/orders', [UserController::class, 'orders'])->name('user.orders.index');
    Route::get('/orders/{order}', [UserController::class, 'showOrder'])->name('user.orders.show');
    });

Route::middleware(['auth', 'wholesaler'])->get('/dashboard/bulk-order', [\App\Http\Controllers\User\BulkOrderController::class, 'showForm'])->name('user.bulk-order');

Route::middleware(['auth', 'wholesaler'])->prefix('user/bulk-order')->group(function () {
    Route::get('download-product-list', [BulkOrderController::class, 'downloadProductListExcel'])->name('bulk-order.downloadProductList');
    Route::get('download-example-csv', [BulkOrderController::class, 'downloadExampleCsv'])->name('bulk-order.downloadExampleCsv');
    Route::post('parse-csv', [BulkOrderController::class, 'parseCsv'])->name('bulk-order.parseCsv');
    Route::post('submit', [BulkOrderController::class, 'submit'])->name('bulk-order.submit');
    Route::post('calculate-totals', [BulkOrderController::class, 'calculateTotals'])->name('bulk-order.calculate-totals');
});




Route::get('/test-welcome-email', function () {
    $user = Auth::user() ?? \App\Models\User::first(); // fallback to first user
    if (!$user) {
        abort(404, 'No user found to send test email.');
    }
    Mail::to($user->email)->send(new WelcomeEmail($user));
    return 'Welcome email sent to ' . $user->email;
});

Route::get('/test-order-confirmation/{order}', function (Order $order) {
    Mail::to('test@example.com')->send(new OrderConfirmation($order));
    Mail::to('test@example.com')->send(new NewOrderNotification($order));
    return 'New order notification email sent!';
})->name('test.order-confirmation');

// Test route for bulk order payment debugging
Route::get('/test-bulk-order-payment/{order}', function (Order $order) {
    Log::info('Test bulk order payment route accessed', [
        'order_id' => $order->id,
        'order_total' => $order->total,
        'payment_method' => $order->payment_method,
        'payment_status' => $order->payment_status,
        'status' => $order->status,
        'user_id' => $order->user_id,
        'billing_address' => $order->billing_address,
        'shipping_address' => $order->shipping_address
    ]);
//only for test
    return response()->json([
        'order_id' => $order->id,
        'total' => $order->total,
        'payment_method' => $order->payment_method,
        'payment_status' => $order->payment_status,
        'status' => $order->status,
        'lines_count' => $order->lines()->count(),
        'created_at' => $order->created_at
    ]);
})->name('test.bulk-order-payment');

// Debug page route
Route::get('/debug-payment', function () {
    return view('debug-payment');
})->name('debug.payment');


Route::get('/login-as/{user}', function ($user) {
    Auth::loginUsingId($user);
    return redirect()->route('dashboard');
})->name('login.as');

