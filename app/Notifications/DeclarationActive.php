<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeclarationActive extends Notification implements ShouldQueue
{
    use Queueable;
    public $declaration;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($declaration)
    {
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
        if($this->declaration->hasMedia('final_document')){
            return (new MailMessage)->markdown('mail.declaration.active',['declaration' => $this->declaration])->subject('Emissão de Declaração de '. $this->declaration->declarationTemplate->name)->attach($this->declaration->getFirstMediaUrl('final_document'));
        }else{
            return (new MailMessage)->markdown('mail.declaration.active',['declaration' => $this->declaration])->subject('Emissão de Declaração de '. $this->declaration->declarationTemplate->name);
        }

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
