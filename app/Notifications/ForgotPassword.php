<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Support\Facades\URL;

class ForgotPassword extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
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
         $url = URL::temporarySignedRoute('change-password', now()->addHours(12), ['id' => $this->token]);
         return (new MailMessage)
                    ->greeting(__('notification.reset_password.greeting'))
                    ->subject(__('notification.reset_password.subject'))
                    ->line(__('notification.reset_password.line_1'))
                    ->action(__('notification.reset_password.action'), $url)
                    ->line(__('notification.reset_password.line_2'))
                    ->line(__('notification.reset_password.thanks'));
     }
     
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
