<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionCheckoutController extends Controller
{
    public function checkoutForm(Request $request)
    {
        $productDetails = $request->session()->get('latest_product');
        return view('checkout.form', compact('productDetails'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,qr',
            'payment_file' => 'required|file',
        ]);

        $user = auth()->user();
        $productDetails = $request->session()->get('latest_product');

        $durationMapping = [
            'Monthly' => 30,
            'Bi-Weekly' => 14,
            'Weekly' => 7,
        ];

        $duration = $durationMapping[$productDetails['frequency']];
        $startDate = now();
        $endDate = $startDate->copy()->addDays($duration);

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'type' => strtolower($productDetails['frequency']),
            'price' => $productDetails['total_cost'],
            'duration' => $duration,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        $filePath = $request->file('payment_file')->store('payments', 'public');

        Payment::create([
            'subscription_id' => $subscription->id,
            'amount' => $productDetails['total_cost'],
            'total_amount' => $productDetails['total_cost'],
            'status' => 'pending',
            'type' => $request->payment_method,
            'payment_path' => $filePath,
        ]);

        return redirect()->route('subscriptions.index')->with('success', 'Payment submitted for verification.');
    }

  

}
