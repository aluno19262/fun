<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Only will be sent from quotas generated manually
 */
class QuotasWaitingPayment extends Notification implements ShouldQueue
{
    use Queueable;
    public $associate;
    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($associate, $order)
    {
        $this->associate = $associate;
        $this->order = $order;
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
        return (new MailMessage)->markdown('mail.quotas.waiting_payment',['associate'=>$this->associate, 'order' => $this->order])->subject('Têm quotas a aguardar pagamento');
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
