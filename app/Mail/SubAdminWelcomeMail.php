<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubAdminWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;

    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    // public function build()
    // {
    //     return $this->subject('Welcome to Sub Admin Panel')
    //                 ->view('emails.subadmin_welcome');
    // }

    public function build()
    {
        return $this->from(
                        env('MAIL_NOREPLY_FROM_ADDRESS'),
                        env('MAIL_NOREPLY_FROM_NAME')
                    )
                    ->subject('Welcome to Sub Admin Panel')
                    ->view('emails.subadmin_welcome');
    }
}
