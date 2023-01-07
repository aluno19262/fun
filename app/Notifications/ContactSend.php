<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactSend extends Notification implements ShouldQueue
{
    use Queueable;
    public $subject;
    public $type;
    public $message;
    public $name;
    public $email;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject,$type,$message,$name,$email)
    {
        $this->subject = $subject;
        $this->type = $type;
        $this->message = $message;
        $this->name = $name;
        $this->email = $email;
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
        return (new MailMessage)->markdown('mail.contacts.send',['message' => $this->message,'subject' => $this->subject, 'type' => $this->type, 'name' => $this->name, 'email' => $this->email ])->subject($this->type == Contact::TYPE_OTHER ? $this->subject : Contact::getTypeLabel($this->type));
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
