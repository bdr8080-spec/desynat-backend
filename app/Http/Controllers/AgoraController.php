<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LiveRequest;
use App\Services\AgoraService;

class AgoraController extends Controller
{
    public function generateToken(Request $request)
    {
        $request->validate([
            'id'=>'required|exists:live_requests,id'
            // 'channel_name' => 'required|string',
            // 'uid' => 'nullable|integer'
        ]);

      $livechat_details=  LiveRequest::where('id',$request->id)->first();

        $channelName = $livechat_details->channel_id;
        $uid = $livechat_details->uid ?? 0;

        $token = AgoraService::generateToken($channelName, $uid);
        
        $livechat_details->update(['liveToken'=>$token]);
        

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