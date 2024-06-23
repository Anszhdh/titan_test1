<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        // Retrieve subscription data from session
        $data = $request->session()->get('subscription', []);
    
        // Store step6 input in session
        $data['step6'] = $request->input('step6');
        $request->session()->put('subscription', $data);
    
        // Ensure all steps are set, providing default values if necessary
        $step1 = isset($data['step1']) ? $data['step1'] : '';
        $step2 = isset($data['step2']) ? $data['step2'] : '';
        $step3 = isset($data['step3']) ? $data['step3'] : '';
        $step4 = isset($data['step4']) ? $data['step4'] : '';
        $step5 = isset($data['step5']) ? $data['step5'] : '';
        $step6 = isset($data['step6']) ? $data['step6'] : '';
    
        // Debugging: Check if any steps are missing
        if (empty($step1) || empty($step2) || empty($step3) || empty($step4) || empty($step5) || empty($step6)) {
            \Log::error('One or more steps are missing', [
                'step1' => $step1,
                'step2' => $step2,
                'step3' => $step3,
                'step4' => $step4,
                'step5' => $step5,
                'step6' => $step6,
            ]);
        }
    
        // Send HTTP POST request to Flask server
        $response = Http::post('http://127.0.0.1:5000/recommendation', [
            'q1' => $step1,
            'q2' => $step2,
            'q3' => $step3,
            'q4' => $step4,
            'q5' => $step5,
            'q6' => $step6,
        ]);
    
        // Handle response from Flask server
        if ($response->successful()) {
            $recommendation = $response->json();
            return Inertia::render('Subscription/Recommendation', [
                'recommendations' => $recommendation['suggestion']
            ]);
        } else {
            // Handle error response
            \Log::error('Error from Flask server', ['response' => $response->body()]);
            return back()->withErrors('An error occurred while processing your request.');
        }
    }
    
}
