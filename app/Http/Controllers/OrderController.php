<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
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
    public function updateShipping(Request $request, Order $order)
    {
        $request->validate([
            'shipping_type' => 'required|string',
            'tracking_number' => 'required|string',
        ]);
    
        $order->update([
            'shipping_type' => $request->shipping_type,
            'tracking_number' => $request->tracking_number,
        ]);
    
        return redirect()->route('admin.orders.index')->with('success', 'Shipping information updated.');
    }
    
    public function destroy(Order $order)
    {
        try {// Delete associated order items
        $order->orderItems()->delete();
    
        // Delete associated payment (assuming one-to-one relationship)
        if ($order->payment) {
            $order->payment->delete();
        }
    
        // Delete the order itself
        $order->delete();
    
        return redirect()->route('order-centre')->with('success', 'Order and related records deleted.');
    } catch (\Exception $e) {
        // Handle any errors if necessary
        return redirect()->route('order-centre')->with('error', 'Failed to delete order.');
    }
    }
}
