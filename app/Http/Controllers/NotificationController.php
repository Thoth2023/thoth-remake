<?php

namespace App\Http\Controllers;

<<<<<<< Updated upstream
use App\Models\ProjectNotification;
=======
use Illuminate\Http\Request;
>>>>>>> Stashed changes

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = ProjectNotification::findOrFail($id);
<<<<<<< Updated upstream
        $notification->markAsRead();
        
=======
        $notification->update(['read' => true]);
>>>>>>> Stashed changes
        return response()->json(['success' => true]);
    }
}