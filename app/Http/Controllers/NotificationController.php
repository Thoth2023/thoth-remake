<?php

namespace App\Http\Controllers;

use App\Models\ProjectNotification;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = ProjectNotification::findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }
}