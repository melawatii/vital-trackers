<?php

namespace App\Notifications;

use App\Mail\ResetPasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    protected $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        $url = $this->resetUrl($notifiable);

        return new ResetPasswordMail($notifiable, $url);
    }

    /**
     * Build the reset URL used in the email.
     */
    protected function resetUrl($notifiable): string
    {
        // Build the route for password.reset and append the email as query param
        $routePath = route('password.reset', ['token' => $this->token], false);
        $emailParam = isset($notifiable->email) ? '?email=' . urlencode($notifiable->email) : '';

        return url($routePath . $emailParam);
    }
}
