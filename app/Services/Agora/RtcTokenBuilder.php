<?php

namespace App\Services\Agora;

class RtcTokenBuilder
{
    const RoleAttendee = 1;
    const RolePublisher = 2;

    public static function buildTokenWithUid(
        $appID,
        $appCertificate,
        $channelName,
        $uid,
        $role,
        $privilegeExpiredTs
    ) {
        return AccessToken::buildToken(
            $appID,
            $appCertificate,
            $channelName,
            $uid,
            $privilegeExpiredTs
        );
    }
}