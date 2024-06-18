<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CustomerAddress;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function showSummary()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $address = CustomerAddress::where('user_id', auth()->id())->first();

        if (!$address) {
            $address = new CustomerAddress();
        }

        return Inertia::render('Cart/CheckoutSummary', [
            'cart' => $cartItems,
            'address' => $address,
            'totalPrice' => $cartItems->sum(fn($item) => $item->price * $item->quantity),
        ]);
    }

    public function submitAddress(Request $request)
    {
        $request->validate([
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string',
            'phone_number' => 'nullable|string',
        ]);

        $address = CustomerAddress::updateOrCreate(
            ['user_id' => auth()->id()],
            $request->only(['address_line_1', 'address_line_2', 'city', 'state', 'postal_code', 'phone_number'])
        );

        return redirect()->route('checkout.summary');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'totalPrice' => 'required|numeric',
            'address_id' => 'required|exists:customer_addresses,id',
            'payment_type' => 'required|string',
        ]);

        $order = new Order();
        $order->user_id = auth()->id();
        $order->total_price = $request->input('totalPrice');
        $order->price = $request->input('totalPrice'); // Assuming the final amount is the same for now
        $order->status = 'Pending';
        $order->payment_type = $request->input('payment_type');
        $order->address_id = $request->input('address_id');
        $order->save();

        $cartItems = Cart::where('user_id', auth()->id())->get();
        foreach ($cartItems as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->unit_price = $cartItem->price;
            $orderItem->save();
        }

        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('checkout.success', ['order_id' => $order->id]);
    }

    public function submitPayment(Request $request)
    {

        dd($request->all());
        $addressData = json_decode($request->input('addressData'), true);
    
        $order = Order::where('user_id', auth()->id())
                      ->where('status', 'Pending')
                      ->latest()
                      ->first();
    
        if (!$order) {
            $order = new Order();
            $order->user_id = auth()->id();
            $order->total_price = $addressData['totalPrice'];
            $order->price = $addressData['totalPrice'];
            $order->status = 'Pending';
            $order->payment_type = $addressData['paymentType'];
            // Assuming you have an 'address_id' in the order table or you associate it with the address
            $order->address_id = $addressData['address_id'];
            $order->save();
    
            foreach ($addressData['cart'] as $cartItem) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cartItem['product_id'];
                $orderItem->quantity = $cartItem['quantity'];
                $orderItem->unit_price = $cartItem['price'];
                $orderItem->save();
            }
        }
    
        $receiptPath = $request->file('receipt')->store('receipts');
        $order->receipt_path = $receiptPath;
        $order->save();
    
        return redirect()->route('checkout.success', ['order_id' => $order->id]);
    }

    public function showSuccess($order_id)
    {
        $order = Order::with('orderItems.product')->findOrFail($order_id);

        return Inertia::render('Cart/Success', [
            'order' => $order,
        ]);
    }
}
