<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $invoiceUrl;

    public function __construct($order, $invoiceUrl)
    {
        $this->order = $order;
        $this->invoiceUrl = $invoiceUrl;
    }

    public function build()
    {
        return $this->from(
                        env('MAIL_INVOICE_FROM_ADDRESS'),
                        env('MAIL_INVOICE_FROM_NAME')
                    )
                    ->subject('Your Order Invoice')
                    ->view('emails.invoice_email');
    }
}