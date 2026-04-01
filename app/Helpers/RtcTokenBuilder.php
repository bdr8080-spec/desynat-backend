<?php

namespace App\Helpers;

class RtcTokenBuilder
{
    const RoleAttendee = 0;
    const RolePublisher = 1;

    public static function buildTokenWithUid($appId, $appCertificate, $channelName, $uid, $role, $expireTimestamp)
    {
        // SIMPLE DEMO TOKEN (for testing only)
        return md5($appId . $channelName . $uid . $expireTimestamp);
    }
}