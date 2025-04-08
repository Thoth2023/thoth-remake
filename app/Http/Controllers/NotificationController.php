<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        auth()->user()->unreadNotifications()->where('id', $id)->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function destroy(string $id)
{
    try {
        // 1. Encontra a notificação ou retorna erro 404
        $notification = Auth::user()->notifications()
                          ->where('id', $id)
                          ->firstOrFail();

        // 2. Registra a atividade (opcional)
        $activity = "Deleted notification ".$notification->id;
        

        // 3. Executa a exclusão
        $notification->delete();

        // 4. Retorna resposta JSON para requisições AJAX
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully',
                'unread_count' => Auth::user()->unreadNotifications()->count()
            ]);
        }

        // 5. Redireciona para requisições normais
        return redirect()->back()->with('success', 'Notification deleted successfully');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Notificação não encontrada
        if (request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }
        return redirect()->back()->with('error', 'Notification not found');

    } catch (\Exception $e) {
        // Outros erros
        \Log::error("Error deleting notification: ".$e->getMessage());
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting notification'
            ], 500);
        }
        return redirect()->back()->with('error', 'Error deleting notification');
    }
}

    public function unreadCount()
    {
        return response()->json([
            'count' => auth()->user()->unreadNotifications->count()
        ]);
    }
}