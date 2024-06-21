<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController; 
use App\Http\Controllers\SubscriptionController; 
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/billing', [ProfileController::class, 'updateBilling'])->name('profile.updateBilling');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin

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
Route::post('/subscription/step6', [SubscriptionController::class, 'step6'])->name('subscription.step6');
Route::post('/subscription/recommendation', [SubscriptionController::class, 'recommendation'])->name('subscription.recommendation');

require __DIR__.'/auth.php';
