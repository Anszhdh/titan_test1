<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch recent subscriptions and load user relationship
        $recentSubscriptions = Subscription::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    
        // Calculate total sales for the current month
        $totalSubscriptionSales = Subscription::sum('price');
        $totalOrderSales = Order::sum('total_price');
        $totalSales = $totalSubscriptionSales + $totalOrderSales;
    
        // Calculate total sales for the last 7 days
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        
        $salesData = [];
    
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $dateString = $date->toDateString();
            $subscriptionSales = Subscription::whereDate('created_at', $dateString)->sum('price');
            $orderSales = Order::whereDate('created_at', $dateString)->sum('total_price');
            $salesData[$dateString] = $subscriptionSales + $orderSales;
        }
    
        $previousMonthStartDate = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEndDate = Carbon::now()->subMonth()->endOfMonth();
    
        $previousOrderSales = Order::whereBetween('created_at', [$previousMonthStartDate, $previousMonthEndDate])->sum('total_price');
        // Log the sales data
        \Log::info('Sales Data: ', $salesData);

        $previousSubscriptionSales = Subscription::whereBetween('created_at', [$previousMonthStartDate, $previousMonthEndDate])->sum('price');
        $previousSales = $previousOrderSales  + $previousSubscriptionSales;
    
        return Inertia::render('Dashboard', [
            'recentSubscriptions' => $recentSubscriptions,
            'totalSubscriptionSales' => $totalSubscriptionSales,
            'totalOrderSales' => $totalOrderSales,
            'totalSales' => $totalSales,
            'previousOrderSales' => $previousOrderSales,
            'previousSubscriptionSales' => $previousSubscriptionSales,
            'salesData' => $salesData,
            'previousSales' => $previousSales,
        ]);
    }
    


    public function confirmPayment($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $subscription->update(['payment_ver' => true]);

        return redirect()->back()->with('success', 'Payment confirmed.');
    }
}
