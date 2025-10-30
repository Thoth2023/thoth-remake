<?php

namespace App\Livewire;

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
            $notification->update(['read' => true]);
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
