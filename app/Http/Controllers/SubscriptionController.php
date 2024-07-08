<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\SubscriptionShipping;
use App\Models\Recommendation;
use App\Models\Product;
use App\Models\User;
use App\Models\UserRecommendation;
use App\Notifications\AdminConfirmSubscriptionNotification;
use App\Notifications\AdminCancelSubscriptionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;


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
        // \Log::debug('Recommendations:', $recommendations);
        // Save recommendations to the database and collect recommendation IDs

        $recommendationIds = [];
        foreach ($recommendations as $rec) {
            // Check if the recommendation has a valid product id
            if ($rec['id']) {
                $recommendation = Recommendation::create(['product_id' => $rec['id']]);
                UserRecommendation::create([
                    'user_id' => auth()->id(),
                    'recommendation_id' => $recommendation->id
                ]);
                $recommendationIds[] = $recommendation->id;
            }
        }
    
        $request->session()->put('user_id', auth()->id());
        $request->session()->put('recommendation_ids', $recommendationIds);
    
  
        return Inertia::render('Subscription/Recommendation', [
            'recommendations' => $recommendations,
            'products' => Product::whereIn('id', collect($recommendations)->pluck('id'))->get()
        ]);
    }
    
    
    private function generateRecommendations($data)
    {
        $flavor = $data['step1'][0] ?? null;
        $roastLevel = $data['step2'][0] ?? null;
        $brewingMethod = $data['step3'][0] ?? null;
        $preGround = $data['step4'] ?? null;
        $decaf = $data['step5'] ?? null;
    
        $query = Product::query();
    
        if ($flavor) {
            $query->where('flavor', $flavor);
        }
        if ($roastLevel) {
            $query->where('roast_level', $roastLevel);
        }
        if ($brewingMethod) {
            $query->where('brewing_method', $brewingMethod);
        }
        if ($preGround !== null) {
            $query->where('pre_ground', $preGround);
        }
        if ($decaf !== null) {
            $query->where('decaf', $decaf);
        }
    
        // Attempt to find an exact match first
        $products = $query->get();
    
        if ($products->isEmpty()) {
            // No exact match found, relax criteria
            // Remove one criteria at a time and search again
            $query = Product::query();
    
            if ($flavor) {
                $query->where('flavor', $flavor);
            }
            if ($roastLevel) {
                $query->where('roast_level', $roastLevel);
            }
            if ($brewingMethod) {
                $query->where('brewing_method', $brewingMethod);
            }
            // Ignore pre_ground and decaf
    
            $products = $query->get();
    
            if ($products->isEmpty()) {
                // Further relax criteria
                $query = Product::query();
    
                if ($flavor) {
                    $query->where('flavor', $flavor);
                }
                if ($roastLevel) {
                    $query->where('roast_level', $roastLevel);
                }
                // Ignore brewing_method, pre_ground, and decaf
    
                $products = $query->get();
    
                if ($products->isEmpty()) {
                    // Return default recommendation if no match found
                    return [
                        [
                            'id' => null,
                            'name' => 'House Blend',
                            'description' => 'Our special House Blend'
                        ]
                    ];
                }
            }
        }
    
        // Convert products to recommendation format
        $recommendations = [];
        foreach ($products as $product) {
            $recommendations[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description
            ];
        }
    
        return $recommendations;
    }
    

    public function handleRecommendations(Request $request)
{
    $data = $request->all();
    $recommendations = $this->generateRecommendations($data);

    $recommendationIds = [];

    foreach ($recommendations as $rec) {
        // Check if the recommendation has a valid product id
        if ($rec['id']) {
            $recommendation = Recommendation::create(['product_id' => $rec['id']]);

            UserRecommendation::create([
                'user_id' => auth()->id(),
                'recommendation_id' => $recommendation->id
            ]);

            $recommendationIds[] = $recommendation->id;
        } else {
            // Handle case where product_id is null or invalid
            // You may choose to log this or create a default recommendation
            // For now, we will skip this recommendation
        }
    }

    // Continue with the rest of your logic
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
            $user = auth()->user();
            $subscriptions = Subscription::where('user_id', $user->id)
                ->with(['shipping', 'payments', 'recommendation.product']) // Eager load relationships
                ->get();

            // Log the fetched subscriptions
            // \Log::info('Fetched subscriptions:', $subscriptions->toArray());

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
        // \Log::info('Confirm Subscription API called');
    
        try {
            DB::transaction(function () use ($subscription) {
                // Update subscription payments status
                $subscription->payments()->update(['status' => 'Confirmed']);
    
                // Update subscription payment_ver field
                $subscription->update(['payment_ver' => 1]);
            });
            $user = $subscription->user; // Assuming you have a user relationship in Subscription model

            // Notify the user about the confirmation
            $user->notify(new AdminConfirmSubscriptionNotification($subscription));
    

            return response()->json(['message' => 'Subscription confirmed successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error confirming subscription: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to confirm subscription'], 500);
        }
    }
    

    public function cancelSubscription(Subscription $subscription)
    {
        // \Log::info('Cancel Subscription API called');

        DB::transaction(function () use ($subscription) {
            // Update SubscriptionPayment status to 'Cancelled'
            $subscription->payments()->update(['status' => 'Cancelled']);

            // Update Subscription status to 'Inactive'
            $subscription->update(['status' => 'Inactive']);
        });

        $user = $subscription->user; // Assuming you have a user relationship in Subscription model

        // Notify the user about the confirmation
        $user->notify(new AdminCancelSubscriptionNotification($subscription));


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
            $subscription->payments()->delete();
            
            // Delete the subscription itself
            $subscription->delete();
    
            return response()->json(['message' => 'Subscription and related records deleted successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Failed to delete subscription: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete subscription and related records'], 500);
        }
    }
    

    public function generatePdf()
    {
        try {
            $subscriptions = Subscription::all(); // Fetch all subscriptions
    
            // Pass data to the view
            $data = [
                'subscriptions' => $subscriptions,
            ];
    
            // Load the view and generate PDF
            $pdf = PDF::loadView('Subscriptionpdf', $data);
    
            // Download the PDF file
            return $pdf->download('subscriptions.pdf');
    
        } catch (\Exception $e) {
            \Log::error('Error generating PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate PDF'], 500);
        }
    }
    
}