<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuotasExpire7DaysBefore extends Notification implements ShouldQueue
{
    use Queueable;
    public $order;
    public $associate;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order,$associate)
    {
        $this->order = $order;
        $this->associate = $associate;
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
        return (new MailMessage)->markdown('mail.quotas.expire_7_days_before',['order'=> $this->order, 'associate' => $this->associate])->subject('As suas quotas APAP expiram dentro de 7 dias');
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
