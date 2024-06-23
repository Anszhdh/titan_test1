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

    public function recommendation(Request $request)
    {
        $data = $request->session()->get('subscription', []);
        $data['step5'] = $request->input('step5');
        $request->session()->put('subscription', $data);

        // Generate recommendations based on the collected data
        $recommendations = $this->generateRecommendations($data);

        return Inertia::render('Subscription/Recommendation', [
            'recommendations' => $recommendations
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

        // Sample logic using IDs instead of labels
        if ($q1 == 2 && $q2 == 6 && $q3 == 13 && $q4 == 16 && $q5 == 20) {
            $recommendations[] = ['name' => 'Ethiopian Yirgacheffe', 'description' => 'Ethiopian Yirgacheffe with nutty flavor and light roast'];
        } elseif ($q1 == 1 && $q2 == 7 && $q3 == 10 && $q4 == 14 && $q5 == 20) {
            $recommendations[] = ['name' => 'Decaf Colombian', 'description' => 'Decaf Colombian with fruity flavor and medium roast'];
        } elseif ($q1 == 3 && $q2 == 8 && $q3 == 12 && $q4 == 16 && $q5 == 21) {
            $recommendations[] = ['name' => 'Dark Roast Espresso', 'description' => 'Dark Roast Espresso with chocolatey flavor'];
        } elseif ($q1 == 4 && $q2 == 9 && $q3 == 12 && $q4 == 16 && $q5 == 21) {
            $recommendations[] = ['name' => 'Spicy Espresso Blend', 'description' => 'Spicy Espresso Blend'];
        } elseif ($q1 == 3 && $q2 == 7 && $q3 == 10 && $q4 == 16 && $q5 == 20) {
            $recommendations[] = ['name' => 'Medium Roast Mocha Java', 'description' => 'Medium Roast Mocha Java'];
        } elseif ($q1 == 1 && $q2 == 8 && $q3 == 10 && $q4 == 16 && $q5 == 20) {
            $recommendations[] = ['name' => 'Dark Roast Hazelnut', 'description' => 'Dark Roast Hazelnut'];
        } elseif ($q1 == 2 && $q2 == 6 && $q3 == 13 && $q4 == 16 && $q5 == 20) {
            $recommendations[] = ['name' => 'Light Roast Tropical Blend', 'description' => 'Light Roast Tropical Blend'];
        } elseif ($q1 == 3 && $q2 == 7 && $q3 == 10 && $q4 == 14 && $q5 == 20) {
            $recommendations[] = ['name' => 'Decaf Chocolate Blend', 'description' => 'Decaf Chocolate Blend'];
        } elseif ($q1 == 4 && $q2 == 8 && $q3 == 12 && $q4 == 16 && $q5 == 21) {
            $recommendations[] = ['name' => 'Spicy Dark Espresso', 'description' => 'Spicy Dark Espresso'];
        } elseif ($q1 == 2 && $q2 == 6 && $q3 == 13 && $q4 == 16 && $q5 == 20) {
            $recommendations[] = ['name' => 'Light Roast Fruit Blend', 'description' => 'Light Roast Fruit Blend'];
        } elseif ($q1 == 5 && $q2 == 7 && $q3 == 10 && $q4 == 16 && $q5 == 20) {
            $recommendations[] = ['name' => 'Vietnamese Coffee', 'description' => 'Vietnamese Coffee'];
        } elseif ($q1 == 5 && $q2 == 8 && $q3 == 11 && $q4 == 16 && $q5 == 19) {
            $recommendations[] = ['name' => 'Indonesian Coffee', 'description' => 'Indonesian Coffee'];
        } elseif ($q1 == 5 && $q2 == 8 && $q3 == 12 && $q4 == 17 && $q5 == 21) {
            $recommendations[] = ['name' => 'Robusta Coffee', 'description' => 'Robusta Coffee'];
        } elseif ($q1 == 5 && $q2 == 7 && $q3 == 13 && $q4 == 16 && $q5 == 20) {
            $recommendations[] = ['name' => 'Arabica Coffee', 'description' => 'Arabica Coffee'];
        } else {
            $recommendations[] = ['name' => 'House Blend', 'description' => 'Our special House Blend'];
        }

        return $recommendations;
    }
}
