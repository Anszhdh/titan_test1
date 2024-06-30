<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function confirmPayment($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $subscription->update(['payment_ver' => true]);

        return redirect()->back()->with('success', 'Payment confirmed.');
    }
}
