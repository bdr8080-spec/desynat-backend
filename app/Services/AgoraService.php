<?php

namespace App\Services;

use App\Services\Agora\RtcTokenBuilder;



class AgoraService
{
    public static function generateToken($channelName, $uid = 0)
    {

        // dd(class_exists(\App\Services\Agora\RtcTokenBuilder::class));

        $appID = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');

        $role = RtcTokenBuilder::RoleAttendee;

        $expireTimeInSeconds = 3600;
        $currentTimestamp = now()->timestamp;
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        return RtcTokenBuilder::buildTokenWithUid(
            $appID,
            $appCertificate,
            $channelName,
            $uid,
            $role,
            $privilegeExpiredTs
        );
    }
}