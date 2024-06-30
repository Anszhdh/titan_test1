<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController; 
use App\Http\Controllers\SubscriptionController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Notification;
use App\Http\Controllers\SubscriptionCartController;
use App\Http\Controllers\SubscriptionCheckoutController;
use Illuminate\Support\Facades\Route;
use App\Models\Subscription;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile', [ProfileController::class, 'updateBilling'])->name('profile.updateBilling');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
// });
Route::get('admin/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->name('dashboard');

Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('admin/notifications', [NotificationController::class, 'Index'])->name('notifications');

});

//admin order
// routes/web.php or routes/api.php

Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('admin/order-centre', [OrderController::class, 'index'])->name('order-centre');
    Route::post('/orders/{order}/confirm', [OrderController::class, 'confirmOrder'])->name('confirm-order');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('cancel-order');
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

//subscription centre
Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('admin/subscription-centre', [SubscriptionController::class, 'adminIndex'])->name('subscription-centre');

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
Route::get('/category/{category}', [ProductController::class, 'showByCategory'])->name('category.show');

// Cart
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
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
Route::get('/subscription/recommendation', [SubscriptionController::class, 'recommendation'])->name('subscription.recommendation');
Route::post('/subscription/recommendation', [SubscriptionController::class, 'recommendation'])->name('subscription.recommendation');
Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');

//subscription cart
Route::post('/subscription-cart/add', [SubscriptionCartController::class, 'add'])->name('subscart.add');
Route::get('/subscription-cart', [SubscriptionCartController::class, 'index'])->name('subscart.index');
Route::get('/api/latest-product', function () {
    return session('latest_product');
});
Route::get('/subscription-checkout', [SubscriptionCartController::class, 'checkoutForm'])->name('checkout.form');
Route::post('/subscription-checkout', [SubscriptionCartController::class, 'processCheckout'])->name('checkout.process');

require __DIR__.'/auth.php';
