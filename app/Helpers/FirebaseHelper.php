<?php

use Google\Auth\OAuth2;
use Illuminate\Support\Facades\Http;
if (!function_exists('sendPushNotificationNew')) {
    function sendPushNotificationNew($deviceTokens, $title, $body)
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

            $response = Http::withToken($accessToken)
                ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                    'message' => [
                        'token' => $token,
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

            $responses[] = $response->json();
        }

        return $responses;
    }
}