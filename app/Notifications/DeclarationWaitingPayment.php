<?php

namespace App\Notifications;

use App\Models\Declaration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeclarationWaitingPayment extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $declaration;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order,$declaration)
    {
        $this->order = $order;
        $this->declaration = $declaration;
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
        return (new MailMessage)->markdown('mail.declaration.waiting_payment',['order' => $this->order, 'declaration' => $this->declaration])->subject(__($this->declaration->declarationTemplate->name  .' a aguardar pagamento'));

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
