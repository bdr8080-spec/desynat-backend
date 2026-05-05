<?php

namespace App\Services;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use DB;


class TwilioService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->from = config('services.twilio.from');
    }


    // public function sendOtp($to, $otp)
    // {
    //     return $this->client->messages->create($to, [
    //         'from' => $this->from,
    //         'body' => "Your verification Code Is $otp"
    //     ]);
    // }

    public function sendOtp($to, $body)
    {
        return $this->client->messages->create($to, [
            'from' => $this->from,
            'body' => $body
        ]);
    }

    // public function sendWhatsAppOTP(string $to, string $otp)
    // {
    //     return  $this->client->messages->create(
    //         "whatsapp:$to",
    //         [
    //             'from' => config('services.twilio.whatsapp_from'),
    //             'body' => "Your verification code is $otp ",
    //         ]
    //     );

    // }


    public function sendWhatsAppOTP(string $to, string $otp)
{

    try {

        Log::info('Sending SMS', [
            'contentSid'=>env('TWILIO_CONTENTSID'),
            'to' => $to,
            'from' => env('TWILIO_WHATSAPP_FROM'),
            'body' => 'Your message',
            "messagingServiceSid" => env('TWILIO_MESSAGING_SERVICE_SID'),
        ]);


    $message=$this->client->messages->create(
        "whatsapp:$to", // Recipient's phone number with country code
        [
            "contentSid" =>  env('TWILIO_CONTENTSID'), // Your template SID
            "from" => env('TWILIO_WHATSAPP_FROM'), // WhatsApp number from config
            "contentVariables" => json_encode([
                '1' => "$otp", // OTP variable for the template
            ]),
            // "messagingServiceSid" => "MG06149af190692adf71f78735ee474e4c" // Messaging service SID
            "messagingServiceSid" => env('TWILIO_MESSAGING_SERVICE_SID') // Messaging service SID

        ]
    );



    // return [
    //     'sid' => $message->sid,
    //     'to' => $message->to,
    //     'from' => $message->from,
    //     'status' => $message->status, // queued, sent, delivered, etc.
    //     'dateCreated' => $message->dateCreated,
    //     'direction' => $message->direction,
    // ];

} catch (\Exception $e) {
    Log::error('Twilio error: ' . $e->getMessage());
}


}

// function checkWhatsAppNumber($toNumber)
// {
//     $sid    = config('services.twilio.sid');
//     $token  = config('services.twilio.token');
//     $from   = config('services.twilio.whatsapp_from'); // WhatsApp-enabled number

//     $client = new Client($sid, $token);

//     try {
//         $message = $client->messages->create(
//             "whatsapp:{$toNumber}", // the number you want to check, in E.164 format
//             [
//                 'from' => $from,
//                 'body' => 'Test message from Laravel/Twilio'
//             ]
//         );

//         // Optionally, fetch the message later to check the delivery status
//         // $status = $client->messages($message->sid)->fetch()->status;

//         return [
//             'success' => true,
//             'sid'     => $message->sid,
//             'status'  => $message->status
//         ];
//     } catch (\Twilio\Exceptions\RestException $e) {
//         // Handle known error codes here, e.g., 63016 means the number is not registered
//         return [
//             'success' => false,
//             'error_code' => $e->getCode(),
//             'message'    => $e->getMessage()
//         ];
//     }
// }


// public function sendWhatsAppTemplate($to)
// {
//     $client = new Client(
//         config('services.twilio.sid'),
//         config('services.twilio.token')
//     );

//     try {
//         $message = $client->messages->create("whatsapp:$to", [
//             'messagingServiceSid' => config('services.twilio.messaging_service_sid'),
//             'contentSid' => 'HX90b43fc0c3ac174df46d5a1a1ea4ec58',
//         ]);

//         return [
//             'success' => true,
//             'sid' => $message->sid,
//             'status' => $message->status
//         ];
//     } catch (\Exception $e) {
//         return [
//             'success' => false,
//             'error' => $e->getMessage()
//         ];
//     }
// }





}