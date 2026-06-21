<?php

namespace App\Notifications;

use App\Mail\VerifyEmailMail;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
{
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
        $verificationUrl = $this->verificationUrl($notifiable);
        return new VerifyEmailMail($verificationUrl);
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable): string
    {
        return \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            \Carbon\Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
