<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Project;
use Illuminate\Support\HtmlString;

class ProjectInvitationNotification extends Notification
{
    use Queueable;

    protected $project;
    protected $token;
    protected $isInvitedGuest;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Project  $project
     * @param  string  $token
     * @return void
     */


    public function __construct(Project $project, $token, $isInvitedGuest = false)
    {
        $this->project = $project;
        $this->token = $token;
        $this->isInvitedGuest = $isInvitedGuest;
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
        // Se o usuário foi convidado e ainda não completou cadastro
        if ($this->isInvitedGuest) {
            $actionUrl = url("/invite/complete/{$this->token}");
        } else {
            $actionUrl = url("/project/{$this->project->id_project}/accept-invitation?token={$this->token}");
        }

        $declineUrl = url("/project/{$this->project->id_project}/decline-invitation?token={$this->token}");

        return (new MailMessage)
            ->subject(__('project/projects.email.subject_invitation', ['project' => $this->project->title]))
            ->greeting(__('project/projects.email.greeting', ['name' => $notifiable->username]))
            ->line(__('project/projects.email.invited', ['project' => $this->project->title]))
            ->action(__('project/projects.email.accept_button'), $actionUrl)
            ->line(new HtmlString(__('project/projects.email.decline_text', ['url' => $declineUrl])));
    }

}
