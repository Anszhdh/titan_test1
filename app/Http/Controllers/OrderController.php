<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'payment'])->get();

        return Inertia::render('Admin/OrderCentre', [
            'orders' => $orders,
        ]);
    }

    public function confirmOrder(Order $order)
    {
        \Log::info('Confirm Order API called');
        DB::transaction(function () use ($order) {
            $order->update(['status' => 'Confirmed']);
            $order->payment->update(['status' => 'Confirmed']);
        });
    
        return response()->json(['message' => 'Order confirmed successfully'], 200);
    }
    
    public function cancelOrder(Order $order)
    {
        \Log::info('Cancel Order API called');
        DB::transaction(function () use ($order) {
            $order->update(['status' => 'Cancelled']);
            $order->payment->update(['status' => 'Cancelled']);
        });
    
        return response()->json(['message' => 'Order cancelled successfully'], 200);
    }
    
}
