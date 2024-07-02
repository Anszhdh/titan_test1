<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order; // Adjust based on your model setup

class OrderGraphController extends Controller
{
    public function getSalesData()
    {
        // Example logic to fetch order sales data
        $salesData = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total_sales')
                          ->groupBy('month')
                          ->get();

        return response()->json($salesData);
    }

    public function fetchSales()
{
    $salesData = Order::select('date', 'total')->get(); // Example query
    return response()->json($salesData);
}
}
