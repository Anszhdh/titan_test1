<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Notifications\UserNewSubscriptionNotification;
use App\Notifications\AdminNewSubscriptionNotification;
use App\Models\CustomerAddress;
use App\Models\Product;
use App\Models\SubscriptionPayment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Str;





class SubscriptionCartController extends Controller
{

    
    public function add(Request $request)
{
    // Store user_id in session for use in SubscriptionCartController
    $request->session()->put('user_id', auth()->id());
    $recommendationIds = $request->session()->get('recommendation_ids', []);
    // Here you might choose the first recommendation_id from the list, adjust this as per your logic
    $recommendationId = count($recommendationIds) > 0 ? $recommendationIds[0] : null;

    // Retrieve input data from the request
    $data = $request->only(['product_id', 'name', 'price', 'frequency', 'image_url']);
    
    // Store original price before adjustments
    $originalPrice = floatval($data['price']);  // Ensure original_price is cast to float
    
    // Calculate adjusted price based on frequency
    switch ($data['frequency']) {
        case 'Monthly':
            $data['price'] += 40;
            break;
        case 'Weekly':
            $data['price'] += 10;
            break;
        case 'Bi-Weekly':
            $data['price'] += 20;
            break;
        // Add more cases if needed
    }
    
    // Add shipping cost (RM 8)
    $data['shipping_cost'] = 8;
    $data['original_price'] = $originalPrice;
    // Calculate total cost (price + shipping cost)
    $data['total_cost'] = $data['price'] + $data['shipping_cost'];
    
    $data['recommendation_id'] = $recommendationId;
    // Store all relevant data in the session
    $request->session()->put('latest_product', $data);
    $request->session()->put('recommendation_id', $recommendationId);

    return back()->with('success', 'Product added to cart!');
}


    
    

    public function index(Request $request)
    {
        $productDetails = $request->session()->get('latest_product');
        $customerAddress = CustomerAddress::where('user_id', auth()->id())->first();

        return Inertia::render('Subscription/Cart/SubscriptionCart', [
            'productDetails' => $productDetails,
            'customerAddress' => $customerAddress,
        ]);
    }

    public function checkoutForm()
    {
        return Inertia::render('Subscription/Cart/SubscriptionCheckout');
    }

    public function processCheckout(Request $request)
{
    $validatedData = $request->validate([
        'payment_method' => 'required|string',
        'payment_file' => 'required|file',
    ]);


    // Retrieve session data
    $productDetails = $request->session()->get('latest_product');
    $recommendationId = $productDetails['recommendation_id'] ?? null;
    
    if (!$productDetails || !$recommendationId) {
        return redirect()->back()->with('error', 'Product details or recommendation ID are missing. Please try again.');
    }

    // Calculate adjusted price based on frequency
    $basePrice = isset($productDetails['original_price']) ? (float) $productDetails['original_price'] : 0;
    switch ($productDetails['frequency']) {
        case 'Monthly':
            $basePrice += 40;
            break;
        case 'Weekly':
            $basePrice += 10;
            break;
        case 'Bi-Weekly':
            $basePrice += 20;
            break;
        // Add more cases if needed
    }
 
    $shippingCost = isset($productDetails['shipping_cost']) ? (float) $productDetails['shipping_cost'] : 0;

    // Calculate total cost including shipping
    $totalCost = $basePrice + $shippingCost;
    $durationInDays = $this->getDuration($productDetails['frequency']);
  

    // Create a new subscription
    $subscription = Subscription::create([
        'user_id' => auth()->id(),
        'type' => $productDetails['frequency'],
        'price' => $totalCost,
        'base_price' => $basePrice,
        'shipping_price' => $shippingCost,
        'payment_ver' => 0, 
        'trial_days' => 0,
        'duration' => $durationInDays,
        'recommendation_id' => $recommendationId,
        'total_price' => $totalCost, 
        'start_date' => now(),
        'end_date' => now()->addDays($durationInDays),
        'status' => 'active',
    ]);

        // Trigger the notification for the user
        $user = auth()->user();
        $user->notify(new UserNewSubscriptionNotification($subscription));
        
        $admin = User::where('role', 1)->first();
        if ($admin) {
            $admin->notify(new AdminNewSubscriptionNotification($subscription));
        }

    // Store payment proof
    $paymentPath = $request->file('payment_file')->store('subscribtionpayments', 'public');

    // Create a new payment
    SubscriptionPayment::create([
        'subscription_id' => $subscription->id,
        'amount' => $productDetails['total_cost'],
        'total_amount' => $productDetails['total_cost'],
        'status' => 'pending',
        'type' => $request->input('payment_method'),
        'payment_path' => $paymentPath,
    ]);

    return redirect()->route('subscription.success')->with('success', 'Subscription successfully created. Waiting for admin approval.');
}

    private function getDuration($frequency)
    {
        switch ($frequency) {
            case 'Monthly':
                return 30;
            case 'Bi-Weekly':
                return 14;
            case 'Weekly':
                return 7;
            default:
                return 30;
        }
    }
    public function showSuccessPage()
    {
        return Inertia::render('Subscription/Cart/Success');
    }
}
