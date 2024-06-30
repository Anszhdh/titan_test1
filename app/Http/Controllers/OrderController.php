<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'payment'])->get();

        return Inertia::render('Admin/OrderCentre', [
            'orders' => $orders,
        ]);
    }
}
