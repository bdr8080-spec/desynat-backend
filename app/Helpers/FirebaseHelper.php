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
//     function sendPushNotificationNew($deviceTokens, $title, $body)
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

//             $response = Http::withToken($accessToken)
//                 ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
//                     'message' => [
//                         'token' => $token,
//                         'notification' => [
//                             'title' => $title,
//                             'body' => $body,
//                         ],
//                         'android' => [
//                             'priority' => 'high',
//                         ],
//                         'apns' => [
//                             'headers' => [
//                                 'apns-priority' => '10',
//                             ],
//                         ],
//                     ],
//                 ]);

//             $responses[] = $response->json();
//         }

//         return $responses;
//     }
// }

if (!function_exists('sendPushNotificationNew')) {
    function sendPushNotificationNew($deviceTokens, $title, $body, $deviceType = 0, $badge = 0)
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

        $responses = [];

        foreach ($deviceTokens as $token) {

            if (empty($token)) continue;

            // Base payload
            $message = [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
            ];


            // ✅ WEB
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

            // ✅ iOS
            if ($deviceType == '1') {
                $message['apns'] = [
                    'headers' => [
                        'apns-priority' => '10',
                    ],
                    'payload' => [
                        'aps' => [
                            'badge' => (int)$badge, // ✅ correct badge
                            'sound' => 'default',
                        ],
                    ],
                ];
            }

            // ✅ ANDROID
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

            $response = Http::withToken($accessToken)
                ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                    'message' => $message
                ]);

            $responses[] = $response->json();
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


// if (!function_exists('CreateNotification')) {
//     function CreateNotification($data = [])
//     {
//        // dd($data);
//         try {
//             $notification = Notification::create([
//                 'sender_id'             => $data['sender_id'],
//                 'sender_type'           => $data['sender_type'],
//                 'receiver_id'           => $data['receiver_id'],
//                 'receiver_type'         => $data['receiver_type'],
//                 'title_english'         => $data['title_english'],
//                 //'title_arabic'          => $data['title_arabic'] ?? null,
//                 'description_english'   => $data['description_english'],
//                // 'description_arabic'    => $data['description_arabic'] ?? null,
//                 'notification_type'     => $data['notification_type'] ?? null,
//                 'is_read'               => 0,
//             ]);

//             $receiver = null;

//             switch ($data['receiver_type']) {
//                 case 1: // Admin
//                     $receiver = Admin::find($data['receiver_id']);
//                     break;

//                 case 2: // User
//                     $receiver = User::find($data['receiver_id']);
//                     break;

//                 case 3: // Seller
//                     $receiver = seller::find($data['receiver_id']);
//                     break;

//                 case 4: // Affiliate
//                     $receiver = AffilatedUser::find($data['receiver_id']);
//                     break;

//                 case 5: // Driver
//                     $receiver = DeliveryBoy::find($data['receiver_id']);
//                     break;
//             }

//             $tokens = [];

//             if ($receiver && !empty($receiver->fcm_token)) {
//                 $tokens = explode(',', $receiver->fcm_token);
//             }

//             //  Send Push Notification
//             if (!empty($tokens)) {
//                 sendPushNotificationNew(
//                     $tokens,
//                     $data['title_english'],
//                     $data['description_english']
//                 );
//             }

//             return $notification;

//         } catch (\Exception $e) {
//             \Log::error('Notification Error: ' . $e->getMessage());
//             return false;
//         }
//     }
// }

if (!function_exists('CreateNotification')) {
    function CreateNotification($data = [])
    {
        try {
            // dd($data);
            // Save notification in DB
            $notification = Notification::create([
                'sender_id'             => $data['sender_id'],
                'sender_type'           => $data['sender_type'],
                'receiver_id'           => $data['receiver_id'],
                'receiver_type'         => $data['receiver_type'],
                'title_english'         => $data['title_english'],
                'description_english'   => $data['description_english'],
                'notification_type'     => $data['notification_type'] ?? null,
                'is_read'               => 0,
            ]);

            // Fetch the receiver based on type
            $receiver = null;
            switch ($data['receiver_type']) {
                case 1: $receiver = Admin::find($data['receiver_id']); break;
                case 2: $receiver = User::find($data['receiver_id']); break;
                case 3: $receiver = Seller::find($data['receiver_id']); break;
                case 4: $receiver = AffilatedUser::find($data['receiver_id']); break;
                case 5: $receiver = DeliveryBoy::find($data['receiver_id']); break;
            }

            $tokens = [];
            $deviceType = 0; // default web
            $badgeCount = 0;

            if ($receiver) {
                if (!empty($receiver->fcm_token)) {
                    $tokens = explode(',', $receiver->fcm_token);
                }
                $deviceType = $receiver->device_type ?? 0;

                // Count unread notifications for badge
                $badgeCount = Notification::where('receiver_id', $receiver->id)
                    ->where('receiver_type', $data['receiver_type'])
                    ->where('is_read', '0')
                    ->count();
                //dd($badgeCount);
            }

            // Send push notification
            if (!empty($tokens)) {
                //dd($tokens);
                sendPushNotificationNew(
                    $tokens,
                    $data['title_english'],
                    $data['description_english'],
                    $deviceType,
                    $badgeCount
                );
            }

            return $notification;

        } catch (\Exception $e) {
            \Log::error('Notification Error: ' . $e->getMessage());
            return false;
        }
    }
}