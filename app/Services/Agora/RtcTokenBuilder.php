<?php

namespace App\Services\Agora;

class RtcTokenBuilder
{
    const RoleAttendee = 1;
    const RolePublisher = 2;

    public static function buildTokenWithUid(
        $appId,
        $appCertificate,
        $channelName,
        $uid,
        $role,
        $privilegeExpiredTs
    ) {
        return self::buildTokenWithUserAccount(
            $appId,
            $appCertificate,
            $channelName,
            (string)$uid,
            $role,
            $privilegeExpiredTs
        );
    }

    public static function buildTokenWithUserAccount(
        $appId,
        $appCertificate,
        $channelName,
        $account,
        $role,
        $privilegeExpiredTs
    ) {
        $token = new AccessToken($appId, $appCertificate, $channelName, $account);

        $token->addPrivilege(Privileges::kJoinChannel, $privilegeExpiredTs);

        if ($role == self::RoleAttendee || $role == self::RolePublisher) {
            $token->addPrivilege(Privileges::kPublishAudioStream, $privilegeExpiredTs);
            $token->addPrivilege(Privileges::kPublishVideoStream, $privilegeExpiredTs);
            $token->addPrivilege(Privileges::kPublishDataStream, $privilegeExpiredTs);
        }

        return $token->build();
    }
}

/**
 * AccessToken class
 */
class AccessToken
{
    public $appId;
    public $appCertificate;
    public $channelName;
    public $uid;
    public $ts;
    public $salt;
    public $messages = [];

    public function __construct($appId, $appCertificate, $channelName, $uid)
    {
        $this->appId = $appId;
        $this->appCertificate = $appCertificate;
        $this->channelName = $channelName;
        $this->uid = $uid;
        $this->ts = time() + 24 * 3600;
        $this->salt = rand(1, 99999999);
    }

    public function addPrivilege($privilege, $expireTimestamp)
    {
        $this->messages[$privilege] = $expireTimestamp;
    }

    public function build()
    {
        ksort($this->messages);

        $raw = $this->packString($this->appId)
            . $this->packString($this->channelName)
            . $this->packString($this->uid)
            . pack("V", $this->ts)
            . pack("V", $this->salt)
            . pack("V", count($this->messages));

        foreach ($this->messages as $privilege => $expireTimestamp) {
            $raw .= pack("V", $privilege);
            $raw .= pack("V", $expireTimestamp);
        }

        $signature = hash_hmac('sha256', $raw, $this->appCertificate, true);

        return base64_encode(
            pack("v", strlen($signature)) . $signature . $raw
        );
    }

    private function packString($str)
    {
        return pack("v", strlen($str)) . $str;
    }
}

/**
 * Privileges class
 */
class Privileges
{
    const kJoinChannel = 1;
    const kPublishAudioStream = 2;
    const kPublishVideoStream = 3;
    const kPublishDataStream = 4;
}