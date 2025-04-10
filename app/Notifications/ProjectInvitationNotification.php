<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Project;

class ProjectInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;
    protected $token;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Project  $project
     * @param  string  $token
     * @return void
     */
    public function __construct(Project $project, $token)
    {
        $this->project = $project;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; //  Removido 'mail' para testar notificação interna
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

     /*
    public function toMail($notifiable)
    {
        $url = route('projects.accept-invitation', [
            'id' => $this->project->id_project,
            'token' => $this->token
        ]);

        return (new MailMessage)
            ->subject('Convite para o projeto: ' . $this->project->title)
            ->greeting('Olá ' . $notifiable->username . '!')
            ->line('Você recebeu um convite para participar do projeto: ' . $this->project->title)
            ->action('Aceitar Convite', $url)
            ->line('Este link expirará em 7 dias.')
            ->line('Se você não solicitou este convite, pode ignorar este e-mail.');
    }
*/
    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\DatabaseMessage
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Convite para projeto',
            'message' => 'Você foi convidado para o projeto "' . $this->project->title . '"',
            'url' => route('projects.accept-invitation', [
                'id' => $this->project->id_project,
                'token' => $this->token
            ]),
            'time' => now()->diffForHumans(),
            'icon' => 'fa fa-envelope',
            'color' => 'info'
        ];
    }
}