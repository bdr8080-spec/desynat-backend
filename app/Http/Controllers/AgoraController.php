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
           'id'=>'required|exists:live_requests,id'

            ]);
            
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }
       

      $livechat_details=  LiveRequest::where('id',$request->id)->first();

       $uid=rand(00000000,999999999);
        $livechat_details->update(['uid'=>$uid]);

        $channelName = $livechat_details->channel_id;
        $uid = $livechat_details->uid ?? 0;



        // $request->validate([
        //     'channel' => 'required|string',
        //     'uid' => 'nullable|integer'
        // ]);

        $token = $this->agora->generateRtcToken(
            $request->channel,
            $uid ?? 0
        );
        
       $token_record=  [
            'token' => $token,
            'appId' => config('services.agora.app_id'),
            'channel' => $request->channel,
            'uid' => $uid ?? 0
        ];


        // return response()->json([
        //     'token' => $token,
        //     'channel' => $request->channel,
        //     'uid' => $request->uid ?? 0
        // ]);

            return ApiResponse::generateResponse('success','agora token generate',$token_record, 200);

    }
}