<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubAdminCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $password;

    public function __construct($admin, $password)
    {
        $this->admin = $admin;
        $this->password = $password;
    }

    // public function build()
    // {
    //     return $this->subject('Your Sub Admin Credentials')
    //                 ->view('emails.subadmin_credentials');
    // }

    public function build()
    {
        return $this->from(
                        env('MAIL_NOREPLY_FROM_ADDRESS'),
                        env('MAIL_NOREPLY_FROM_NAME')
                    )
                    ->subject('Your Sub Admin Credentials')
                    ->view('emails.subadmin_credentials');
    }
}