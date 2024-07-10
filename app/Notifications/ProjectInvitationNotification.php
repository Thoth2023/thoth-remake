<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Project;

class ProjectInvitationNotification extends Notification
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
{
    $url = url("/project/{$this->project->id_project}/accept-invitation?token={$this->token}"); // Certifique-se de que 'id_project' é o nome correto do campo ID no modelo Project.

    return (new MailMessage)
                ->greeting('Hello ' . $notifiable->username) // Certifique-se de que username é a propriedade correta
                ->line('You have been invited to join the project: ' . $this->project->title)
                ->action('Accept Invitation', $url)
                ->line('If you have any questions, reply to this email.');
}

}
