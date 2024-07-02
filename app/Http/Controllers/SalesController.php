<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Order;
use Carbon\Carbon;


class SalesController extends Controller
{
    public function todaysSales()
    {
        // Fetch today's sales from both subscriptions and orders
        $todaySales = [
            'today_subscription_sales' => Subscription::whereDate('created_at', today())->sum('amount'),
            'today_order_sales' => Order::whereDate('created_at', today())->sum('total_amount'),
        ];

        return response()->json($todaySales);
    }

    public function subscriptionTotal()
    {
        // Fetch total subscriptions
        $subscriptionTotal = Subscription::sum('amount');

        return response()->json(['subscription_total' => $subscriptionTotal]);
    }

    public function orderTotal()
    {
        // Fetch total orders
        $orderTotal = Order::sum('total_amount');

        return response()->json(['order_total' => $orderTotal]);
    }

    public function thisMonthSubscriptionSales()
    {
        // Fetch this month's subscription sales
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $thisMonthSubscriptionSales = Subscription::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        return response()->json(['this_month_subscription_sales' => $thisMonthSubscriptionSales]);
    }
}
