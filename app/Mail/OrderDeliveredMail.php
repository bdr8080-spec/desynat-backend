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
    public $locale;

    public function __construct($userName, $orderId, $ratingUrl, $locale = null)
    {
        $this->userName = $userName;
        $this->orderId = $orderId;
        $this->ratingUrl = $ratingUrl;
        $this->locale = $locale ?: config('app.locale');
    }

    public function build()
    {
        return $this->locale($this->locale)
                    ->subject(__('user_messages.order_delivered_subject'))
                    ->view('emails.order_delivered');
    }
}
