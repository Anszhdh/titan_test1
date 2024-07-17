<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController; 
use App\Http\Controllers\SalesController; 
use App\Http\Controllers\SubscriptionController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Notification;
use App\Http\Controllers\SubscriptionCartController;
use App\Http\Controllers\SubscriptionCheckoutController;
use App\Http\Controllers\Api\SubscriptionGraphController;
use App\Http\Controllers\Api\OrderGraphController;
use Illuminate\Support\Facades\Route;
use App\Models\Subscription;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/discover', [HomeController::class, 'discover'])->name('discover');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile-update', [ProfileController::class, 'updateprofile'])->name('profile.update');
    Route::patch('/profile-billing', [ProfileController::class, 'updateBilling'])->name('profile.updateBilling');
    Route::delete('/profile-destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
// });
Route::get('admin/dashboard', [AdminController::class, 'index'])
    ->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});



Route::get('/orders/{orderId}/invoice', [OrderController::class, 'generateInvoiceUser'])->name('orders.invoice');
Route::get('/subscription/{subscriptionId}/invoice', [SubscriptionController::class, 'generateInvoiceUser'])->name('subscription.invoice');

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'userOrders'])->name('user.orders');
    Route::post('/orders/{order}/review', [OrderController::class, 'submitReview'])->name('orders.review');
});
//subscription display
Route::middleware('auth')->group(function () {
    Route::get('/subscriptions', [SubscriptionController::class, 'userSubscriptions'])->name('user.subscriptions');
});


//product centre
Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('admin/product-centre', [ProductController::class, 'adminIndex'])->name('product-centre');
    Route::get('admin/product-centre/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('admin/product-centre', [ProductController::class, 'store'])->name('product-centre.store');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('admin/product-centre/{product}', [ProductController::class, 'update'])->name('product-centre.update');
    Route::delete('admin/product-centre/{product}', [ProductController::class, 'destroy'])->name('product-centre.destroy');
});

//order centre
Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('admin/order-centre', [OrderController::class, 'adminIndex'])->name('order-centre');
    Route::post('/orders/{order}/confirm', [OrderController::class, 'confirmOrder'])->name('confirm-order');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('cancel-order');
    Route::put('/admin/orders/{order}/update-shipping', [OrderController::class, 'updateShipping'])->name('orders.updateShipping');
    Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/admin/orders/report', [OrderController::class, 'generateReport']);
    Route::get('/admin/orders/{orderId}/invoice', [OrderController::class, 'generateInvoice'])->name('admin.orders.invoice');

});

//subscription centre
Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('admin/subscription-centre', [SubscriptionController::class, 'adminIndex'])->name('subscription-centre');
    Route::post('/admin/subscriptions/{subscription}/confirm', [SubscriptionController::class, 'confirmSubscription']);
    Route::post('/admin/subscriptions/{subscription}/cancel', [SubscriptionController::class, 'cancelSubscription']);
    Route::put('/admin/subscriptions/{subscription}/update-shipping', [subscriptionController::class, 'updateShipping'])->name('subscriptions.updateShipping');
    Route::delete('/admin/subscriptions/{subscription}', [subscriptionController::class, 'destroy'])->name('subscriptions.destroy');
    Route::get('/admin/subscriptions/pdf', [SubscriptionController::class, 'generatePdf'])->name('subscriptions.pdf');
    Route::get('/admin/subscription/{subscriptionId}/invoice', [SubscriptionController::class, 'generateInvoice'])->name('admin.subscription.invoice');
});


Route::get('admin/sales-report', function () {
    return Inertia::render('salesreport');
})->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->name('sales-report');
Route::get('admin/billings-report', function () {
    return Inertia::render('billingreport');
})->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->name('billings-report');
Route::get('admin/settings', function () {
    return Inertia::render('settings');
})->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->name('settings');

// Product
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{category}', [ProductController::class, 'showByCategory'])->name('category.show');

// Cart
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
});

// Checkout
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout/summary', [CheckoutController::class, 'showSummary'])->name('checkout.summary');
    Route::post('/checkout/address', [CheckoutController::class, 'submitAddress'])->name('checkout.address');
    Route::get('/checkout/payment', [CheckoutController::class, 'showPaymentPage'])->name('checkout.payment');
    Route::post('/checkout/process', [CheckoutController::class, 'processPayment'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'showSuccessPage'])->name('checkout.success');
});

//subscribtion

Route::get('/subscription', function () {
    $hasActiveSubscription = Subscription::where('user_id', auth()->id())
        ->where('status', 'active')
        ->exists();

    if ($hasActiveSubscription) {
        return Inertia::render('Subscription/SubscriptionIndex', [
            'error' => 'You already have an existing subscription. Please go to your profile to manage subscription.'
        ]);
    }

    return Inertia::render('Subscription/SubscriptionIndex');
})->name('subscription.main');


Route::get('/subscription/step1', [SubscriptionController::class, 'step1'])->name('subscription.step1');
Route::post('/subscription/step2', [SubscriptionController::class, 'step2'])->name('subscription.step2');
Route::post('/subscription/step3', [SubscriptionController::class, 'step3'])->name('subscription.step3');
Route::post('/subscription/step4', [SubscriptionController::class, 'step4'])->name('subscription.step4');
Route::post('/subscription/step5', [SubscriptionController::class, 'step5'])->name('subscription.step5');
Route::post('/subscription/recommendation', [SubscriptionController::class, 'recommendation'])->name('subscription.recommendation');
Route::get('/subscription/recommendation', [SubscriptionController::class, 'recommendation'])->name('subscription.recommendation.cart');
Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');

//subscription cart
Route::post('/subscription-cart/add', [SubscriptionCartController::class, 'add'])->name('subscart.add');
Route::get('/subscription-cart', [SubscriptionCartController::class, 'index'])->name('subscart.index');
Route::get('/api/latest-product', function () {
    return session('latest_product');
});
Route::get('/subscription-checkout', [SubscriptionCartController::class, 'checkoutForm'])->name('checkout.form');
Route::post('/subscription-checkout', [SubscriptionCartController::class, 'processCheckout'])->name('subs.checkout.process');
Route::get('/subscription/success', [SubscriptionCartController::class, 'showSuccessPage'])->name('subscription.success');


//graph
Route::middleware('auth:api')->group(function () {
    Route::get('/subscriptions/sales', 'App\Http\Controllers\SubscriptionGraphController@fetchSales');
    Route::get('/orders/sales', 'App\Http\Controllers\OrderGraphController@fetchSales');
});


Route::middleware('auth:api')->group(function () {
    Route::get('/todays-sales', [SalesController::class, 'todaysSales']);
    Route::get('/subscription-total', [SalesController::class, 'subscriptionTotal']);
    Route::get('/order-total', [SalesController::class, 'orderTotal']);
    Route::get('/this-month-subscription-sales', [SalesController::class, 'thisMonthSubscriptionSales']);
});

Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
});


Route::get('/api/recent-subscribers', [SubscriptionController::class, 'recentSubscribers']);

require __DIR__.'/auth.php';
