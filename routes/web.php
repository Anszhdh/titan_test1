<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController; 
use App\Http\Controllers\SubscriptionController; 
use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/billing', [ProfileController::class, 'updateBilling'])->name('profile.updateBilling');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
// });
Route::get('admin/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->name('dashboard');
Route::get('admin/notifications', function () {
    return Inertia::render('Notifications');
})->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->name('notifications');
Route::get('admin/order-centre', function () {
    return Inertia::render('ordercentre');
})->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->name('order-centre');
Route::get('admin/product-centre', function () {
    return Inertia::render('productcentre');
})->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->name('product-centre');
Route::get('admin/subscription-centre', function () {
    return Inertia::render('subscriptioncentre');
})->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->name('subscription-centre');
Route::get('admin/subscription-product', function () {
    return Inertia::render('subscriptionproduct');
})->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->name('subscription-product');
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
    Route::post('/checkout/process', [CheckoutController::class, 'processPayment'])->name('checkout.process');
    Route::get('/checkout/summary', [CheckoutController::class, 'showSummary'])->name('checkout.summary');
    Route::post('/checkout/address', [CheckoutController::class, 'submitAddress'])->name('checkout.address'); // New route
    Route::get('/checkout/payment', function () {
        return inertia('Cart/Payment'); // Replace with your actual rendering logic if needed
    })->name('checkout.payment');
    
    // POST route to handle submission of payment proof
    Route::post('/checkout/payment', [CheckoutController::class, 'submitPayment'])->name('checkout.submitPayment');
    Route::get('/checkout/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');
});


//subscription page
Route::get('/subscription', function () {
    return Inertia::render('Subscription/SubscriptionIndex');
})->name('subscription.main');
Route::get('/subscription/step1', [SubscriptionController::class, 'step1'])->name('subscription.step1');
Route::post('/subscription/step2', [SubscriptionController::class, 'step2'])->name('subscription.step2');
Route::post('/subscription/step3', [SubscriptionController::class, 'step3'])->name('subscription.step3');
Route::post('/subscription/step4', [SubscriptionController::class, 'step4'])->name('subscription.step4');
Route::post('/subscription/step5', [SubscriptionController::class, 'step5'])->name('subscription.step5');
Route::post('/subscription/recommendation', [SubscriptionController::class, 'recommendation'])->name('subscription.recommendation');

require __DIR__.'/auth.php';
