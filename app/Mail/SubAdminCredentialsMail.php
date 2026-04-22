<?php
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

    public function build()
    {
        return $this->subject('Your Sub Admin Credentials')
                    ->view('emails.subadmin_credentials');
    }
}