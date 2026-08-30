<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class CustomResetPassword extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Gamitin ang same URL generator sa AppServiceProvider
        $url = URL::to('/reset-password/' . $this->token) . '?email=' . urlencode($notifiable->email);
        
        \Log::info('Reset URL: ' . $url);
        
        return (new MailMessage)
            ->subject('Reset Your Password - AERPharmacy')
            ->greeting('Hello ' . ($notifiable->username ?? $notifiable->email) . '!')
            ->line('We received a password reset request for your account.')
            ->action('Reset Password', $url)
            ->line('This link will expire in 60 minutes.')
            ->line('If you did not request this, please ignore this email.');
    }
}