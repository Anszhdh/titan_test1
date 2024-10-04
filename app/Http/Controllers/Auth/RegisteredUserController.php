<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BusinessInformation;
use App\Models\ContactPersonInformation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function createDealer(): Response
    {
        return Inertia::render('Auth/RegisterDealer');
    }
    

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'birthday' => 'required|date',
            
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthday' => $request->birthday,
            'role' => 0,
          
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }

    public function storeDealer(Request $request): RedirectResponse
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'birthday' => 'required|date',
        'business_name' => 'required|string|max:255',
        'email'=> 'required',
        'business_registration_no' => 'required|string|max:255',
        'name_of_owner' => 'required|string|max:255',
        'address' => 'required|string',
        'tel_no' => 'required|string|max:15',
        'contact_name' => 'required|string|max:255',
        'contact_email' => 'required|email|max:255',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'birthday' => $request->birthday,
        'role' => 2, // Dealer role
    ]);

    $business = $user->businessInformation()->create([
        'business_name' => $request->business_name,
        'business_registration_no' => $request->business_registration_no,
        'name_of_owner' => $request->name_of_owner,
        'address' => $request->address,
        'tel_no' => $request->tel_no,
        'social_media' => $request->social_media,
        'email' => $request->email,
        'website' => $request->website,
        'year_started' => $request->year_started,
        'business_structure' => $request->business_structure,
        'number_of_employees' => $request->number_of_employees,
    ]);

    $business->contactPersonInformation()->create([
        'name' => $request->contact_name,
        'position' => $request->contact_position,
        'email' => $request->contact_email,
        'tel_no' => $request->contact_tel_no,
        'mobile_phone' => $request->contact_mobile_phone,
    ]);

    Auth::login($user);

    return redirect()->route('home');
}

}
