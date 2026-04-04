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

       $uid=rand(00000000,999999999);
        $livechat_details->update(['uid'=>$uid]);

        $channelName = $livechat_details->channel_id;
        $uid = $livechat_details->uid ?? 0;



        // $request->validate([
        //     'channel' => 'required|string',
        //     'uid' => 'nullable|integer'
        // ]);

        $token = $this->agora->generateRtcToken(
            $channelName,
            $uid ?? 0,
            $request->role
        );
        
       $token_record=  [
            'token' => $token,
            'appId' => config('services.agora.app_id'),
            'channel' => $channelName,
            'uid' => $uid ?? 0
        ];


        // return response()->json([
        //     'token' => $token,
        //     'channel' => $request->channel,
        //     'uid' => $request->uid ?? 0
        // ]);

            return ApiResponse::generateResponse('success','agora token generate',$token_record, 200);

    }



     public function generateTokenWeb(Request $request)
    {
        $request->validate([
            // 'id'=>'required|exists:live_requests,id'
            'channel_name' => 'required|string',
            'uid' => 'nullable|integer'
        ]);

        $channelName = $request->channel_id;
        $uid = $request->uid ?? 0;

     $livechat_details=LiveRequest::where('channel_id',$request->channel_name)->first();

     if($livechat_details){
         $uid = $livechat_details->uid ;
     }

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

     public function agoraViewPageWeb(Request $request)
    {

    $id=$request->id??43;
    
    $uid=rand(00000000,999999999);

    $livechat_details=  LiveRequest::where('id',$id)->first();
    $livechat_details->update(['uid'=>$uid]);


    return view('agora',compact('livechat_details'));
    }


    
}