<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class UserLogin extends Notification 
{
    use Queueable;

    public $title, $info;

    public function __construct($title, $info)
    {
        $this->title = $title;
        $this->info = $info;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $locationInfo = $this->info;
        $mailMessage = (new MailMessage)
                    ->line('New login.')
                    ->action('Notification Action', url('/'))
                    ->line('Someone has logged into your account from a new browser/device. If it wasn\'t you, please change your password.')
                    ->line('Here is the login information: ');

        foreach ($locationInfo as $key => $value) {
            $mailMessage->line("$key: $value");
        }

        return $mailMessage;
    }

    public function toDatabase($notifiable)
    {
        $locationInfo = $this->info;
        $slug = Str::slug($this->title . "-" . now()->format('Y-m-d'), "-");

        $data = [
            'message' => 'Login alert',
            'action' => url('/'),
            'description' => 'Someone has logged into your account from a new browser/device. If it wasn\'t you, please change your password.',
            'login_information' => [],
            'slug' => $slug
        ];

        foreach ($locationInfo as $key => $value) {
            $data['login_information'][$key] = $value;
        }

        return $data;
    }
}
