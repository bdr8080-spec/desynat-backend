<?php

use Google\Auth\OAuth2;
use Illuminate\Support\Facades\Http;
use App\Models\Notification;
use App\Models\User;
use App\Models\Admin;
use App\Models\seller;
use App\Models\AffilatedUser;
use App\Models\DeliveryBoy;



// if (!function_exists('sendPushNotificationNew')) {
//     function sendPushNotificationNew($deviceTokens, $title, $body, $deviceType = 0, $badge = 0)
//     {
//         $projectId = 'desynat';
//         $keyFilePath = storage_path('desynat-firebase-adminsdk-fbsvc-511856a90e.json');

//         $credentials = json_decode(file_get_contents($keyFilePath), true);

//         $oauth = new \Google\Auth\OAuth2([
//             'audience' => 'https://oauth2.googleapis.com/token',
//             'issuer' => $credentials['client_email'],
//             'signingAlgorithm' => 'RS256',
//             'signingKey' => $credentials['private_key'],
//             'tokenCredentialUri' => 'https://oauth2.googleapis.com/token',
//             'scope' => ['https://www.googleapis.com/auth/firebase.messaging'],
//         ]);

//         $oauth->fetchAuthToken();
//         $accessToken = $oauth->getLastReceivedToken()['access_token'];

//         $responses = [];

//         foreach ($deviceTokens as $token) {

//             if (empty($token)) continue;

//             // Base payload
//             if($deviceType !== '2'){
//                 $message = [
//                     'token' => $token,
//                     'notification' => [
//                         'title' => $title,
//                         'body'  => $body,
//                     ],
//                 ];
//             }else{
//                 $message = [
//                     'token' => $token,
//                 ];
//             }


//             //  WEB
//             if ($deviceType == '0') {
//                 $message['webpush'] = [
//                     'headers' => [
//                         'Urgency' => 'high',
//                     ],
//                     'notification' => [
//                         'icon' => url('/logo.png'), // optional
//                     ],
//                 ];
//             }

//             //  iOS
//             if ($deviceType == '1') {
//                 $message['apns'] = [
//                     'headers' => [
//                         'apns-priority' => '10',
//                     ],
//                     'payload' => [ 
//                         'aps' => [
//                             'badge' => (int)$badge,
//                             'sound' => 'default',
//                         ],
//                     ],
//                 ];
//             }

//             //  ANDROID
//             if ($deviceType == '2') {
//                 $message['android'] = [
//                     'priority' => 'high',
//                 ];

//                 // Android badge (handled in app)
//                 $message['data'] = (object)[
//                     'badge' => (string)$badge,
//                     'title' => $title,
//                     'body'  => $body,
//                 ];
//             }
//             //dd($message);
//             $response = Http::withToken($accessToken)
//                 ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
//                     'message' => $message
//                 ]);

//             $responses[] = $response->json();
//             //dd($responses);
//         }

//         return $responses;
//     }
// }

if (!function_exists('sendPushNotificationNew')) {
    function sendPushNotificationNew($deviceTokens, $title_en, $title_ar = null, $body_en=null, $body_ar = null, $deviceType = 0, $badge = 0, $lang = 'en')
    {
        $projectId = 'desynat';
        $keyFilePath = storage_path('desynat-firebase-adminsdk-fbsvc-511856a90e.json');

        $credentials = json_decode(file_get_contents($keyFilePath), true);

        $oauth = new \Google\Auth\OAuth2([
            'audience' => 'https://oauth2.googleapis.com/token',
            'issuer' => $credentials['client_email'],
            'signingAlgorithm' => 'RS256',
            'signingKey' => $credentials['private_key'],
            'tokenCredentialUri' => 'https://oauth2.googleapis.com/token',
            'scope' => ['https://www.googleapis.com/auth/firebase.messaging'],
        ]);

        $oauth->fetchAuthToken();
        $accessToken = $oauth->getLastReceivedToken()['access_token'];

        $title = ($lang == 'ar' && !empty($title_ar)) ? $title_ar : $title_en;

        $body = ($lang == 'ar' && !empty($body_ar)) ? $body_ar : $body_en;

        $responses = [];

        foreach ($deviceTokens as $token) {

            if (empty($token)) continue;

            // Base payload
            if($deviceType !== '2'){
                $message = [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                    ],
                ];
            }else{
                $message = [
                    'token' => $token,
                ];
            }


            //  WEB
            if ($deviceType == '0') {
                $message['webpush'] = [
                    'headers' => [
                        'Urgency' => 'high',
                    ],
                    'notification' => [
                        'icon' => url('/logo.png'), // optional
                    ],
                ];
            }

            //  iOS
            if ($deviceType == '1') {
                $message['apns'] = [
                    'headers' => [
                        'apns-priority' => '10',
                    ],
                    'payload' => [ 
                        'aps' => [
                            'badge' => (int)$badge,
                            'sound' => 'default',
                        ],
                    ],
                ];
            }

            //  ANDROID
            if ($deviceType == '2') {
                $message['android'] = [
                    'priority' => 'high',
                ];

                // Android badge (handled in app)
                $message['data'] = (object)[
                    'badge' => (string)$badge,
                    'title' => $title,
                    'body'  => $body,
                ];
            }

            //dd($message);
            $response = Http::withToken($accessToken)
                ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                    'message' => $message
                ]);

            $responses[] = $response->json();
            //dd($responses);
        }

        return $responses;
    }
}




// This code for change dynamic value for send  dynamic text in Firebase send Notification 
if (!function_exists('parseNotificationText')) {
    function parseNotificationText($text, $data = [])
    {
        foreach ($data as $key => $value) {
            $text = str_replace("{{$key}}", $value, $text);
        }
        return $text;
    }
}


if (!function_exists('CreateNotification')) {
    function CreateNotification($data = [])
    {
        try {

            $receiver = null;

            switch ($data['receiver_type']) {
                case 1: $receiver = Admin::find($data['receiver_id']); break;
                case 2: $receiver = User::find($data['receiver_id']); break;
                case 3: $receiver = Seller::find($data['receiver_id']); break;
                case 4: $receiver = AffilatedUser::find($data['receiver_id']); break;
                case 5: $receiver = DeliveryBoy::find($data['receiver_id']); break;
            }

            if (!$receiver) {
                return false;
            }

            // STEP 1: FLAGS
            $sendPush = $receiver->notification == 1;
            $saveDb   = $receiver->app_notification == 1;

            // CASE: both disabled → exit
            if (!$sendPush && !$saveDb) {
                return false;
            }

            $notification = null;

            // STEP 2: DB INSERT ONLY IF app_notification = 1
            if ($saveDb) {


                $notification = Notification::create([
                    'sender_id'             => $data['sender_id'],
                    'sender_type'           => $data['sender_type'],
                    'receiver_id'           => $data['receiver_id'],
                    'receiver_type'         => $data['receiver_type'],
                    'title_english'         => $data['title_english'],
                    'title_arabic'         => $data['title_arabic'] ?? null,
                    'description_english'   => $data['description_english'],
                    'description_arabic'   => $data['description_arabic'] ?? null,
                    'notification_type'     => $data['notification_type'] ?? null,
                    'is_read'               => 0,
                ]);
            }

            // STEP 3: PUSH ONLY IF notification = 1
            if ($sendPush) {

                $tokens = [];
                $deviceType = 0;

                if (!empty($receiver->fcm_token)) {
                    $tokens = explode(',', $receiver->fcm_token);
                }

                $deviceType = $receiver->device_type ?? 0;

                $badgeCount = Notification::where('receiver_id', $data['receiver_id'])
                    ->where('receiver_type', $data['receiver_type'])
                    ->where('is_read', '0')
                    ->count();

                $lang = $receiver->lang ?? 'en';

                if (!empty($tokens)) {
                    sendPushNotificationNew(
                        $tokens,
                        $data['title_english'],
                        $data['title_arabic'],
                        $data['description_english'],
                        $data['description_arabic'],
                        $deviceType,
                        $badgeCount,
                        $lang
                    );
                }
            }

            return $notification;

        } catch (\Exception $e) {
            \Log::error('Notification Error: ' . $e->getMessage());
            return false;
        }
    }
}