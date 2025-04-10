<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewMemberNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;
    protected $adminName;

    public function __construct($project, $adminName)
    {
        $this->project = $project;
        $this->adminName = $adminName;
    }

    public function via($notifiable)
    {
        return ['database']; // Adicione 'mail' se quiser enviar por e-mail também
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Você foi adicionado a um projeto!',
            'message' => 'Você agora é membro do projeto "' . $this->project->title . '" adicionado por ' . $this->adminName . '.',
            'url' => route('projects.show', $this->project->id_project),
            'time' => now()->diffForHumans(),
            'icon' => 'fa fa-user-plus',
            'color' => 'success'
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Você foi adicionado ao projeto ' . $this->project->title)
            ->line('Você foi adicionado ao projeto "' . $this->project->title . '" por ' . $this->adminName . '.')
            ->action('Acessar Projeto', route('projects.show', $this->project->id_project))
            ->line('Obrigado por usar nossa aplicação!');
    }
}