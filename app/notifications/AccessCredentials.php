<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccessCredentials extends Notification
{
    use Queueable;
    private $details;

    public function __construct($details){
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->greeting($this->details['greeting'])
                ->line($this->details['body'])
                ->line($this->details['credentials'])
                ->line($this->details['email'])
                ->line($this->details['password'])
                ->action('The Link', url($this->details['url']))
                ->line($this->details['thanks']);
    }


    public function toArray($notifiable)
    {
       
    }
}
