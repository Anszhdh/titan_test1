<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\CheckoutController;

class ProductController extends Controller
{
    public function index()
    {
        $authenticated = auth()->check();
        $products = Product::all()->map(function ($product) {
            $product->image = asset('product/' . $product->image);
            return $product;
        });

        return Inertia::render('Products/Index', [
            'products' => $products,
            'authenticated' => $authenticated,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}
