<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Review;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{


   // OrderController.php

    public function index()
    {
        $userId = auth()->id();
        $orders = Order::where('user_id', $userId)
                    ->with(['orderItems.product'])
                    ->get();

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function userOrders()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)
            ->with(['orderItems.product', 'orderItems.product.reviews' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }, 'shipping']) // Load the shipping relationship
            ->get();
    
        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }
    
    
   

    public function submitReview(Request $request, Order $order)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:255',
            'product_id' => 'required|integer|exists:products,id',
        ]);
    
        // Create a review for the order
        $order->reviews()->create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);
    
        // Optionally, you can eager load the updated order with order items and reviews
        $order->load(['orderItems.product', 'reviews']);
    
        // Return updated order data
        return response()->json(['message' => 'Review submitted successfully', 'order' => $order]);
    }
    

    
    
    public function adminIndex()
    {
        $orders = Order::with(['user', 'payment', 'shipping'])->get();

        return Inertia::render('Admin/OrderCentre', [
            'orders' => $orders,
            'flash' => session('success') ? ['success' => session('success')] : null,
        ]);
    }

    public function confirmOrder(Order $order)
    {
        // \Log::info('Confirm Order API called');
        DB::transaction(function () use ($order) {
            $order->update(['status' => 'Confirmed']);
            $order->payment->update(['status' => 'Confirmed']);
        });
    
        return response()->json(['message' => 'Order confirmed successfully'], 200);
    }
    
    public function cancelOrder(Order $order)
    {
        // \Log::info('Cancel Order API called');
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
    
        // Find the shipping information for the order or create a new one
        $shipping = Shipping::updateOrCreate(
            ['order_id' => $order->id],
            [
                'shipping_type' => $request->shipping_type,
                'tracking_number' => $request->tracking_number,
            ]
        );
    
        return redirect()->route('order-centre')->with('success', 'Shipping information updated.');
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

    public function generateReport()
    {
        $orders = Order::with('user', 'payment', 'orderItems.product','shipping')->get();
        $pdf = PDF::loadView('Orderspdf', ['orders' => $orders]);

        return $pdf->download('orders_report.pdf');
    }

        public function generateInvoice($orderId)
        {
            // Log::info('Generating invoice for order ID: ' . $orderId);

            $order = Order::with('orderItems.product')->findOrFail($orderId);
            // Log::debug('Order details:', $order->toArray());

            // Log order items
            
            foreach ($order->orderItems as $item) {
                Log::debug('Order Item:', $item->toArray());
            }

            // Generate PDF content using a view
            $pdf = PDF::loadView('invoicepdf', compact('order'));

            // Optionally, you can save the PDF or download it directly
            return $pdf->download('invoice_' . $order->id . '.pdf');
        }

        
        public function generateInvoiceUser($orderId)
        {
            // Log::info('Generating invoice for order ID: ' . $orderId);

            $order = Order::with('orderItems.product')->findOrFail($orderId);
            Log::debug('Order details:', $order->toArray());

            // Log order items
            
            foreach ($order->orderItems as $item) {
                Log::debug('Order Item:', $item->toArray());
            }

            // Generate PDF content using a view
            $pdf = PDF::loadView('invoicepdf', compact('order'));

            // Optionally, you can save the PDF or download it directly
            return $pdf->download('invoice_' . $order->id . '.pdf');
        }

}
