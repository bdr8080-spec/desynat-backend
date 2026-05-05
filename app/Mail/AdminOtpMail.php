<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class AdminOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $otp;

    public function __construct($admin, $otp)
    {
        $this->admin = $admin;
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Your OTP for Password Reset')
                    ->view('emails.admin_otp');
    }
}