<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationsBell extends Component
{
    public $notifications;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Auth::user()
            ->projectNotifications()
            ->where('read', false)
            ->latest()
            ->take(5)
            ->get();
    }

    public function markAsRead($id, $url = null)
    {
        $notification = Auth::user()->projectNotifications()->find($id);

        if ($notification) {

            // Marcar como lida
            $notification->update(['read' => true]);

            // Se for convite de projeto, aceitar automaticamente
            if ($notification->type === 'project_invitation') {

                $data = json_decode($notification->params, true);

                $projectId = $data['project_id'] ?? null;
                $userId = Auth::id();

                if ($projectId && $userId) {
                    DB::table('members')
                        ->where('id_user', $userId)
                        ->where('id_project', $projectId)
                        ->where('status', 'pending')
                        ->update([
                            'status' => 'accepted',
                            'invitation_token' => null
                        ]);
                }
            }

        }

        $this->loadNotifications();

        if ($url) {
            return redirect()->to($url);
        }
    }


    public function markAllAsRead()
    {
        Auth::user()
            ->projectNotifications()
            ->where('read', false)
            ->update(['read' => true]);

        $this->mount(); // recarregar lista
    }


    public function render()
    {
        return view('livewire.notifications-bell');
    }
}
