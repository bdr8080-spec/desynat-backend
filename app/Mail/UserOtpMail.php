<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class UserOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp;

    public function __construct($user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    // public function build()
    // {
    //     return $this->subject('Your OTP for Verification')
    //                 ->view('emails.user_otp');
    // }

    public function build()
    {
        return $this->from(
                        env('MAIL_NOREPLY_FROM_ADDRESS'),
                        env('MAIL_NOREPLY_FROM_NAME')
                    )
                    ->subject('Your OTP for Verification')
                    ->view('emails.user_otp');
    }
}