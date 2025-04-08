<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewProjectNotification extends Notification
{
    use Queueable;

    protected $project;

    public function __construct($project)
    {
        $this->project = $project;
    }

    public function via($notifiable)
    {
        return ['database']; // É possivel add 'mail' para enviar e-mail também
    }

    public function toDatabase($notifiable)
{
    return [
        'title' => 'Novo projeto criado!',
        'message' => 'O projeto "' . $this->project->title . '" foi criado com sucesso.', // 
        'url' => route('projects.show', $this->project->id_project), // Ajuste
        'time' => now()->diffForHumans(), // Para mostrar "há x minutos"
        'icon' => 'fa fa-project-diagram' // Ícone do FontAwesome para projetos
    ];
}

    /*
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Novo Projeto Criado!')
            ->line('O projeto "' . $this->project->name . '" foi criado.')
            ->action('Ver Projeto', route('projects.show', $this->project->id));
    }
     */
}
