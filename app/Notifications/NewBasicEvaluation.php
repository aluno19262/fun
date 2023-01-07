<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBasicEvaluation extends Notification implements ShouldQueue
{
    use Queueable;
    public $associate;
    public $secretariado;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($associate,$secretariado)
    {
        $this->associate = $associate;
        $this->secretariado = $secretariado;
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
        return (new MailMessage)->markdown('mail.evaluation.basic',['associate' => $this->associate, 'secretariado' => $this->secretariado])->subject('A Aguardar Aprovação');
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
