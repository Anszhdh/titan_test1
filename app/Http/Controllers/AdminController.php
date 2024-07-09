<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch recent subscriptions (mock data)
        $recentSubscriptions = Subscription::with('recommendation', 'user')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
          
        
        // Example: Other data needed for the dashboard
        $totalSubscriptions = Subscription::count();
        $totalRevenue = Subscription::sum('amount_paid');
        
        return Inertia::render('Admin/Dashboard', [
            'recentSubscriptions' => $recentSubscriptions,
            'totalSubscriptions' => $totalSubscriptions,
            'totalRevenue' => $totalRevenue,
        ]);
    }

    public function confirmPayment($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $subscription->update(['payment_ver' => true]);

        return redirect()->back()->with('success', 'Payment confirmed.');
    }
}
