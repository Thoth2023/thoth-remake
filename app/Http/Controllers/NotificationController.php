<?php

namespace App\Http\Controllers;

use App\Models\ProjectNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = ProjectNotification::findOrFail($id);

        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->markAsRead();

        return response()->json(['status' => 'ok']);
    }
}

