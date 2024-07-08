<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role == 1 ? 'admin' : 'user'; // Assuming role 1 is for admin

        $notifications = $user->notifications()->where('data->type', $role)->get();
        $unreadCount = $user->unreadNotifications()->where('data->type', $role)->count();

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
    
        return response()->json(['success' => true]);
    }
}