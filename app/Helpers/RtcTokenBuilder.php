<?php

namespace App\Helpers;

class RtcTokenBuilder
{
    const RoleAttendee = 0;
    const RolePublisher = 1;

    public static function buildTokenWithUid($appId, $appCertificate, $channelName, $uid, $role, $expireTimestamp)
    {
        // SIMPLE DEMO TOKEN (for testing only)
        // return md5($appId . $channelName . $uid . $expireTimestamp);


         $salt = rand(1, 999999);

    $msg = $appId . $channelName . $uid . $expireTimestamp . $salt;

    return base64_encode(
        hash_hmac('sha256', $msg, $appCertificate, true)
    );


    }
}