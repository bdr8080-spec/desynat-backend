<?php

namespace App\Services\Agora;

class AccessToken
{
    const VERSION = "007";
    const PRIVILEGE_JOIN_CHANNEL = 1;

    public static function buildToken($appID, $appCertificate, $channelName, $uid, $expireTimestamp)
    {
        $signature = hash_hmac('sha256', $channelName . $uid . $expireTimestamp, $appCertificate);

        return self::VERSION . base64_encode(json_encode([
            'appID' => $appID,
            'channel' => $channelName,
            'uid' => $uid,
            'expire' => $expireTimestamp,
            'sig' => $signature,
        ]));
    }
}