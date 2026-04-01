<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AgoraService;

class AgoraController extends Controller
{
    public function generateToken(Request $request)
    {
        $request->validate([
            'channel_name' => 'required|string',
            // 'uid' => 'nullable|integer'
        ]);

        $channelName = $request->channel_name;
        $uid = $request->uid ?? 0;

        $token = AgoraService::generateToken($channelName, $uid);


    return response()->json([
        'token' => $token,
        'uid' => $uid
    ]);

        // return response()->json([
        //     'status' => true,
        //     'token' => $token,
        //     'channel' => $channelName,
        //     'uid' => $uid
        // ]);
    }
}