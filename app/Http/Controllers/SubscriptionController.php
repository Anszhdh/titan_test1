<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

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

    public function step6(Request $request)
    {
        $data = $request->session()->get('subscription', []);
        $data['step5'] = $request->input('step5');
        $request->session()->put('subscription', $data);

        return Inertia::render('Subscription/Step6');
    }

    public function recommendation(Request $request)
    {
        $data = $request->session()->get('subscription', []);
        $data['step6'] = $request->input('step6');
        $request->session()->put('subscription', $data);

        // Generate recommendations based on the collected data
        $recommendations = $this->generateRecommendations($data);

        return Inertia::render('Subscription/Recommendation', [
            'recommendations' => $recommendations
        ]);
    }

    private function generateRecommendations($data)
    {
        // Refined recommendation logic
        // Example logic based on user preferences
        $recommendations = [];

        if (in_array('Black', $data['step1']) && in_array('High caffeine', $data['step5'])) {
            $recommendations[] = ['name' => 'Espresso', 'description' => 'Strong and bold coffee with high caffeine'];
        } elseif (in_array('Cream', $data['step1']) && in_array('Nutty Flavor', $data['step2'])) {
            $recommendations[] = ['name' => 'Latte', 'description' => 'Smooth and creamy coffee with a nutty flavor'];
        }
        // Continue adding conditions based on user preferences...

        if (empty($recommendations)) {
            $recommendations[] = ['name' => 'House Blend', 'description' => 'A balanced blend suitable for various preferences'];
        }

        return $recommendations;
    }
}
