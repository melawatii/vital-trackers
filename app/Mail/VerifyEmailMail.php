<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use SerializesModels;

    public string $url;

    public function __construct(public $user, string $url)
    {
        $this->url = $url;
    }

    public function build()
    {
        return $this->to($this->user->email)
                    ->subject('Verify Email Address')
                    ->view('auth.verify-email')
                    ->with(['url' => $this->url]);
    }
}
