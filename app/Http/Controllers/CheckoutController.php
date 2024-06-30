<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CustomerAddress;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $totalPrice = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $shippingPrice = 8; // Shipping price

        return Inertia::render('Cart/CheckoutSummary', [
            'cart' => $cartItems,
            'address' => $address,
            'totalPrice' => $totalPrice,
            'shippingPrice' => $shippingPrice,
            'finalTotal' => $totalPrice + $shippingPrice,
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

    public function showPaymentPage()
    {
        return Inertia::render('Cart/Payment');
    }

        public function processPayment(Request $request)
        {
            $request->validate([
                'payment_method' => 'required|string',
                'payment_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);
        
            $userId = auth()->id();
            $cartItems = Cart::where('user_id', $userId)->with('product')->get();
            $totalPrice = $cartItems->sum(fn($item) => $item->price * $item->quantity);
            $shippingPrice = 8; // Assuming fixed shipping price
            $finalTotal = $totalPrice + $shippingPrice;
        
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->withErrors('Your cart is empty.');
            }
        
            $address = CustomerAddress::where('user_id', $userId)->first();

            DB::beginTransaction();
            $paymentFilePath = $request->file('payment_file')->store('payments', 'public');

            try {
                // Create order
                $order = new Order();
                $order->user_id = $userId;
                $order->price = $finalTotal;
                $order->status = 'Pending';
                $order->address_line_1 = $address->address_line_1;
                $order->address_line_2 = $address->address_line_2;
                $order->city = $address->city;
                $order->state = $address->state;
                $order->postal_code = $address->postal_code;
                $order->receipt_path = $paymentFilePath;
                $order->total_price = $finalTotal;
                $order->save();
        
                // Create order items
                foreach ($cartItems as $item) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $item->product_id;
                    $orderItem->quantity = $item->quantity;
                    $orderItem->unit_price = $item->price;
                    $orderItem->save();
                }
        
                // Save payment proof
                $paymentFilePath = $request->file('payment_file')->store('payments', 'public');
        
                // Create payment record
                $payment = new Payment();
                $payment->order_id = $order->id;
                $payment->type = $request->payment_method;
                $payment->receipt_path = $paymentFilePath;
                $payment->amount = $finalTotal;
                $payment->total_amount = $finalTotal;
                $payment->status = 'Pending';
                $payment->save();
        
                // Clear cart
                Cart::where('user_id', $userId)->delete();
        
                DB::commit();
        
            return redirect()->route('checkout.success')->with('success', 'Payment successful and order placed.');

        
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Payment processing failed: ' . $e->getMessage());
                \Log::info('Reached processPayment method.');
                return redirect()->route('checkout.summary')->withErrors('Failed to process payment. Please try again.');
            }
        }

        public function showSuccessPage()
        {
            return Inertia::render('Cart/Success');
        }

    

}
