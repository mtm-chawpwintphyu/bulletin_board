<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;
    public $userName;
    public $userEmail;
    public function __construct($resetUrl, $userName, $userEmail)
    {
        $this->resetUrl = $resetUrl;
        $this->userName = $userName;
        $this->userEmail = $userEmail;
    }
    public function build()
    {
        return $this->view('auth.passwords.passwordreset')
            ->with([
                'resetUrl' => $this->resetUrl,
                'userName' => $this->userName,
                'userEmail' => $this->userEmail,
            ]);
    }
}
