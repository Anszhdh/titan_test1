<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $admin = auth()->user(); // Assuming admin is authenticated
        $notifications = $admin->notifications()->latest()->get();

        return Inertia::render('Admin/Notifications', [
            'notifications' => $notifications,
        ]);
    }
}
