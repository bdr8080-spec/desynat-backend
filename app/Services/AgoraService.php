<?php

namespace App\Services;

use App\Services\Agora\RtcTokenBuilder;


class AgoraService
{
    protected $appId;
    protected $appCertificate;

    public function __construct()
    {
        $this->appId = config('services.agora.app_id');
        $this->appCertificate = config('services.agora.app_certificate');
    }

    public function generateRtcToken($channelName, $uid = 0, $role = 1)
    {

        $expireTimeInSeconds = 3600; // 1 hour
        $currentTimestamp = now()->timestamp;
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        return RtcTokenBuilder::buildTokenWithUid(
            $this->appId,
            $this->appCertificate,
            $channelName,
            $uid,
            $role,
            $privilegeExpiredTs
        );
    }
}