<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use SerializesModels;

    public $user;
    public $url;

    public function __construct($user, string $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    public function build()
    {
        return $this->to($this->user->email)
                    ->subject('Reset Password Notification')
                    ->view('emails.reset-password')
                    ->with([
                        'url' => $this->url,
                        'user' => $this->user,
                    ]);
    }
}
