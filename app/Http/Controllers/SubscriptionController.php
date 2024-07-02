<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\SubscriptionShipping;
use App\Models\Recommendation;
use App\Models\Product;
use App\Models\UserRecommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SubscriptionController extends Controller
{
    public function step1()
    {
        
        return Inertia::render('Subscription/Step1');
    }

    public function step2(Request $request)
    {
        $data = $request->session()->get('subscription', []);
        $data['step1'] = $request->input('step1');
        $request->session()->put('subscription', $data);

        return Inertia::render('Subscription/Step2');
    }

    public function step3(Request $request)
    {
        $data = $request->session()->get('subscription', []);
        $data['step2'] = $request->input('step2');
        $request->session()->put('subscription', $data);

        return Inertia::render('Subscription/Step3');
    }

    public function step4(Request $request)
    {
        $data = $request->session()->get('subscription', []);
        $data['step3'] = $request->input('step3');
        $request->session()->put('subscription', $data);

        return Inertia::render('Subscription/Step4');
    }

    public function step5(Request $request)
    {
        $data = $request->session()->get('subscription', []);
        $data['step4'] = $request->input('step4');
        $request->session()->put('subscription', $data);

        return Inertia::render('Subscription/Step5');
    }

    public function recommendation(Request $request)
    {
        $data = $request->session()->get('subscription', []);
        $data['step5'] = $request->input('step5');
        $request->session()->put('subscription', $data);
    
        // Generate recommendations based on the collected data
        $recommendations = $this->generateRecommendations($data);
    
        // Save recommendations to the database and collect recommendation IDs
        $recommendationIds = [];
        foreach ($recommendations as $rec) {
            $recommendation = Recommendation::create(['product_id' => $rec['product_id']]);
            UserRecommendation::create([
                'user_id' => auth()->id(),
                'recommendation_id' => $recommendation->id
            ]);
            $rec['recommendation_id'] = $recommendation->id;
            $recommendationIds[] = $recommendation->id;
        }
    
        // Store user_id in session for use in SubscriptionCartController
        $request->session()->put('user_id', auth()->id());
        $request->session()->put('recommendation_ids', $recommendationIds);
        // Fetch product details from the database
        $productIds = array_column($recommendations, 'product_id');
        $products = Product::whereIn('id', $productIds)->get();
    
        return Inertia::render('Subscription/Recommendation', [
            'recommendations' => $recommendations,
            'products' => $products,
        ]);
    }
    
    
    private function generateRecommendations($data)
{
    $recommendations = [];
    
    $q1 = $data['step1'][0] ?? null;
    $q2 = $data['step2'][0] ?? null;
    $q3 = $data['step3'][0] ?? null;
    $q4 = $data['step4'][0] ?? null;
    $q5 = $data['step5'][0] ?? null;

    $userInputKey = "$q1-$q2-$q3-$q4-$q5";

    $recommendationMap = [
        '2-6-13-16-20' => ['product_id' => 1, 'name' => 'Ethiopian Yirgacheffe', 'description' => 'Ethiopian Yirgacheffe with nutty flavor and light roast'],
        '1-7-10-14-20' => ['product_id' => 2, 'name' => 'Decaf Colombian', 'description' => 'Decaf Colombian with fruity flavor and medium roast'],
        '3-8-12-16-21' => ['product_id' => 3, 'name' => 'Dark Roast Espresso', 'description' => 'Dark Roast Espresso with chocolatey flavor'],
        '4-9-12-16-21' => ['product_id' => 4, 'name' => 'Spicy Espresso Blend', 'description' => 'Spicy Espresso Blend'],
        '3-7-10-16-20' => ['product_id' => 5, 'name' => 'Medium Roast Mocha Java', 'description' => 'Medium Roast Mocha Java'],
        '1-8-10-16-20' => ['product_id' => 6, 'name' => 'Dark Roast Hazelnut', 'description' => 'Dark Roast Hazelnut'],
        '5-7-10-16-20' => ['product_id' => 7, 'name' => 'Vietnamese Coffee', 'description' => 'Vietnamese Coffee'],
        '5-8-11-16-19' => ['product_id' => 8, 'name' => 'Indonesian Coffee', 'description' => 'Indonesian Coffee'],
        '5-8-12-17-21' => ['product_id' => 9, 'name' => 'Robusta Coffee', 'description' => 'Robusta Coffee'],
        '5-7-13-16-20' => ['product_id' => 10, 'name' => 'Arabica Coffee', 'description' => 'Arabica Coffee'],
    ];

    if (isset($recommendationMap[$userInputKey])) {
        $recommendations[] = $recommendationMap[$userInputKey];
    } else {
        // If no exact match is found, find the closest match or return a default product
        $closestMatch = $this->findClosestMatch($userInputKey, $recommendationMap);
        $recommendations[] = $closestMatch ?: ['name' => 'House Blend', 'description' => 'Our special House Blend'];
    }

    return $recommendations;
}

private function findClosestMatch($userInputKey, $recommendationMap)
{
    // Split the user input key into an array of criteria
    $userInputArray = explode('-', $userInputKey);
    
    $closestMatch = null;
    $maxMatches = -1;

    foreach ($recommendationMap as $key => $value) {
        // Split the recommendation key into an array of criteria
        $keyArray = explode('-', $key);
        
        // Count the number of matching criteria
        $matches = count(array_intersect($userInputArray, $keyArray));
        
        // Update the closest match if this one has more matches
        if ($matches > $maxMatches) {
            $maxMatches = $matches;
            $closestMatch = $value;
        }
    }

    return $closestMatch;
}

       
        public function userSubscriptions()
        {
            // Assuming you're fetching subscriptions for the authenticated user
            $user = auth()->user();
            $subscriptions = Subscription::where('user_id', $user->id)
                ->with([ 'shipping', 'payments']) // Eager load relationships
                ->get();

            // Log the fetched subscriptions
            \Log::info('Fetched subscriptions:', $subscriptions->toArray());


            // Pass subscriptions to the Inertia view
            return Inertia::render('Subscription/Index', [
                'subscriptions' => $subscriptions
            ]);
        }
        public function adminIndex()
        {
            $subscriptions = Subscription::with('user', 'shipping', 'payments')->get();

            return Inertia::render('Admin/SubscriptionCentre', [
                'subscriptions' => $subscriptions,
            ]);
        }
        
    public function confirmSubscription(Subscription $subscription)
    {
        \Log::info('Confirm Subscription API called');
    
        try {
            DB::transaction(function () use ($subscription) {
                // Update subscription payments status
                $subscription->subscriptionPayments()->update(['status' => 'Confirmed']);
    
                // Update subscription payment_ver field
                $subscription->update(['payment_ver' => 1]);
            });
    
            return response()->json(['message' => 'Subscription confirmed successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error confirming subscription: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to confirm subscription'], 500);
        }
    }
    

    public function cancelSubscription(Subscription $subscription)
    {
        \Log::info('Cancel Subscription API called');

        DB::transaction(function () use ($subscription) {
            // Update SubscriptionPayment status to 'Cancelled'
            $subscription->subscriptionPayments()->update(['status' => 'Cancelled']);

            // Update Subscription status to 'Inactive'
            $subscription->update(['status' => 'Inactive']);
        });

        return response()->json(['message' => 'Subscription cancelled successfully'], 200);
    }

    public function updateShipping(Request $request, Subscription $subscription)
    {
        $request->validate([
            'shipping_type' => 'required|string',
            'tracking_number' => 'required|string',
        ]);
    
        // Find the shipping information for the order or create a new one
        $shipping = SubscriptionShipping::updateOrCreate(
            ['subscription_id' => $subscription->id],
            [
                'shipping_type' => $request->shipping_type,
                'tracking_number' => $request->tracking_number,
            ]
        );
    
        return redirect()->route('subscription-centre')->with('success', 'Shipping information updated.');
    }
    public function destroy(Subscription $subscription)
    {
        try {
            // Delete all related payments
            $subscription->subscriptionPayments()->delete();
            
            // Delete the subscription itself
            $subscription->delete();
    
            return response()->json(['message' => 'Subscription and related records deleted successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Failed to delete subscription: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete subscription and related records'], 500);
        }
    }
    

}