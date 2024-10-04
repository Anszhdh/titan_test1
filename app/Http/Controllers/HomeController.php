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
            'isLoggedIn' => $authenticated,
            'laravelVersion' => Application::VERSION,
            'products' => $products,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function about()
    {
        $authenticated = auth()->check();
        return Inertia::render('About', [
            'isLoggedIn' => $authenticated,
        ]);
    }

    public function contact()
    {
        $authenticated = auth()->check();
        return Inertia::render('Contact', [
            'isLoggedIn' => $authenticated,
        ]);
    }

    public function discover()
    {
        $authenticated = auth()->check();
        return Inertia::render('Discover', [
            'isLoggedIn' => $authenticated,
            'dealerRegisterUrl' => route('register.dealer'),
        ]);
        
    }
}
