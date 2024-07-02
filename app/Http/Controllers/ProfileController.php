<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     * 
     * 
     */


     public function edit(Request $request)
     {
         $user = $request->user();
     
         return Inertia::render('Profile/Edit', [
             'mustVerifyEmail' => $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail,
             'status' => session('status'),
             'auth' => $user ? [
                 'user' => $user->only('id', 'name', 'email', 'birthday', 'email_verified_at'),
             ] : null,
         ]);
     }
    /**
     * Update the user's profile information.
     */
        public function update(ProfileUpdateRequest $request): RedirectResponse
        {
            $user = $request->user();

            $user->update($request->validated());

            // If email has changed, reset verification status
            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            $request->user()->save();

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }
        
        public function updateBilling(Request $request): RedirectResponse
    {
        $request->validate([
            'address_line_1' => ['nullable', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
        ]);

        $user = $request->user();

        // Update address information
        $addressData = $request->only([
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'postal_code',
            'phone_number'
        ]);

        $user->address()->updateOrCreate(['user_id' => $user->id], $addressData);

        return Redirect::route('profile.edit')->with('status', 'billing-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
