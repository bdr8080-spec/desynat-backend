<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\seller;

class StaffCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $seller_details;
    public $password;

    public function __construct($seller_details, $password)
    {
        $this->seller_details = $seller_details;
        $this->password = $password;

    }

    // public function build()
    // {
    //     return $this->subject('Your Staff Login Credentials')
    //                 ->view('emails.Emailstaff_credentials');
    // }

     public function build()
    {
        return $this->from(
                        env('MAIL_NOREPLY_FROM_ADDRESS'),
                        env('MAIL_NOREPLY_FROM_NAME')
                    )
                    ->subject('Your Staff Login Credentials')
                    ->view('emails.Emailstaff_credentials');
    }
}