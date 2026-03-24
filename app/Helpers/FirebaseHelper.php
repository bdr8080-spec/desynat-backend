<?php

use Google\Auth\OAuth2;
use Illuminate\Support\Facades\Http;

if (!function_exists('sendPushNotificationNew')) {
    function sendPushNotificationNew($deviceToken, $title, $body)
    {

        $projectId = 'desynat';
        $keyFilePath = storage_path('desynat-firebase-adminsdk-fbsvc-511856a90e.json');

        $clientEmail = json_decode(file_get_contents($keyFilePath), true)['client_email'];
        $privateKey = json_decode(file_get_contents($keyFilePath), true)['private_key'];

        $oauth = new OAuth2([
            'audience' => 'https://oauth2.googleapis.com/token',
            'issuer' => $clientEmail,
            'signingAlgorithm' => 'RS256',
            'signingKey' => $privateKey,
            'tokenCredentialUri' => 'https://oauth2.googleapis.com/token',
            'scope' => ['https://www.googleapis.com/auth/firebase.messaging'],
        ]);

        $oauth->fetchAuthToken();
        $accessToken = $oauth->getLastReceivedToken()['access_token'];

        $response = Http::withToken($accessToken)->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'android' => [
                    'priority' => 'high',
                ],
                'apns' => [
                    'headers' => [
                        'apns-priority' => '10',
                    ],
                ],
            ],
        ]);

        return $response->json();
    }
}