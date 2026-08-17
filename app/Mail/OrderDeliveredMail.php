<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDeliveredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $orderId;
    public $ratingUrl;

    public function __construct($userName, $orderId, $ratingUrl)
    {
        $this->userName = $userName;
        $this->orderId = $orderId;
        $this->ratingUrl = $ratingUrl;
    }

    public function build()
    {
        return $this->subject('Order Delivered Successfully')
                    ->view('emails.order_delivered');
    }
}