<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
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
                    ->subject('Verify Email Address')
                    ->view('auth.verify-email')
                    ->with([
                        'url' => $this->url,
                        'user' => $this->user,
                    ]);
    }
}
