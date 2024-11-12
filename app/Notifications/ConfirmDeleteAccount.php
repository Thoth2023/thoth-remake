<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ConfirmDeleteAccount extends Notification
{
    use Queueable;

    /**
     * Cria uma nova instância de notificação.
     *
     * @return void
     */
    public function __construct()
    {
        // Pode passar parâmetros adicionais aqui, se necessário
    }

    /**
     * Define os canais de entrega da notificação.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Cria o e-mail de notificação para exclusão de conta.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // URL temporária assinada válida por 24 horas
        $url = URL::temporarySignedRoute('confirm-delete-account', now()->addHours(24), ['id' => $notifiable->id]);

        return (new MailMessage)
            ->greeting(__('notification.delete_account.greeting'))
            ->subject(__('notification.delete_account.subject'))
            ->line(__('notification.delete_account.line_1'))
            ->action(__('notification.delete_account.action'), $url)
            ->line(__('notification.delete_account.line_2'))
            ->line(__('notification.delete_account.thanks'));
    }

    /**
     * Representação da notificação em array.
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
