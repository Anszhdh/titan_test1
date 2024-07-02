<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Models\Product;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $authenticated = auth()->check();
        $products = Product::all(); 
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'authenticated' => $authenticated,
            'laravelVersion' => Application::VERSION,
            'products' => $products,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
