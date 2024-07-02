<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription; // Adjust based on your model setup

class SubscriptionController extends Controller
{
    public function getSalesData()
    {
        // Example logic to fetch subscription sales data
        $salesData = Subscription::selectRaw('MONTH(created_at) as month, SUM(amount) as total_sales')
                                 ->groupBy('month')
                                 ->get();

        return response()->json($salesData);
    }
}
