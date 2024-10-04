<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Fetch all users
    
        return Inertia::render('Admin/Users/Index', [
            'users' => $users, // Pass users array to Vue component
        ]);
    }

    public function dealerIndex()
    {
        // Fetch only users with role 3 (dealer)
        $dealers = User::where('role', 3)->get();
        
        return Inertia::render('Admin/Users/DealerIndex', [
            'dealers' => $dealers, // Pass dealers array to Vue component
        ]);
    }
    
}
