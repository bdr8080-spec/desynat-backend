<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AgoraService;


use App\Models\LiveRequest;
use App\Helpers\ApiResponse;

use Validator;


class AgoraController extends Controller
{
    protected $agora;

    public function __construct(AgoraService $agora)
    {
        $this->agora = $agora;
    }

    public function generateToken(Request $request)
    {

          $validate = Validator::make($request->all(), [
           'id'=>'required|exists:live_requests,id',
           'role'=>'required|in:1,2' // 1 view 2 broadcast
            ]);
            
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

      $livechat_details=  LiveRequest::where('id',$request->id)->first();

      if($request->role==1){
                
        $uid=rand(00000000,999999999);
        $livechat_details->update(['uid'=>$uid]);
      }

      $livechat_details->update(['live_user'=> $livechat_details->live_user+1]);

        $channelName = $livechat_details->channel_id;
        $uid = $livechat_details->uid ?? 0;

        $token = $this->agora->generateRtcToken(
            $channelName,
            $uid ?? 0
        );
  
        $token_record=  [
            'token' => $token,
            'appId' => config('services.agora.app_id'),
            'channel' => $channelName,
            'uid' => $uid ?? 0
        ];


    return ApiResponse::generateResponse('success','agora token generate',$token_record, 200);


    }



    public function generateTokenWeb(Request $request)
    {

        // $request->validate([
        //     'channel' => 'required|string',
        //     'uid' => 'nullable|integer'
        // ]);
        
    $livechat_details=  LiveRequest::where('channel_id',$request->channel)->first();
    $livechat_details->update(['live_user'=> $livechat_details->live_user+1]);

        $uid= rand(00000,99999);

        $token = $this->agora->generateRtcToken(
            $request->channel,
            $uid
        );
        
          return response()->json([
            'token' => $token,
            'appId' => config('services.agora.app_id'),
            'channel' => $request->channel,
            'uid' => $uid
        ]);


        // return response()->json([
        //     'token' => $token,
        //     'channel' => $request->channel,
        //     'uid' => $request->uid ?? 0
        // ]);
    }
}