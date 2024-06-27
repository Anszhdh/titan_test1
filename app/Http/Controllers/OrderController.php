<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::with('user')->get();
        
        return Inertia::render('Admin/OrderCentre', [
            'order' => $order,
        ]);
    }
}
