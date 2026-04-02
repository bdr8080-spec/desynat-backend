<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LiveRequest;
use App\Services\AgoraService;

use App\Helpers\ApiResponse;

use Validator;

class AgoraController extends Controller
{

    public function generateToken(Request $request)
    {

         $validate = Validator::make($request->all(), [
           'id'=>'required|exists:live_requests,id'

            ]);
            
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }
       

      $livechat_details=  LiveRequest::where('id',$request->id)->first();

        $channelName = $livechat_details->channel_id;
        $uid = $livechat_details->uid ?? 0;

        $token = AgoraService::generateToken($channelName, $uid);
        
        $livechat_details->update(['liveToken'=>$token]);
                
        $token_record=[
            'token' => $token,
            'uid' => $uid
        ];
        
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


    $livechat_details=  LiveRequest::where('id',$id)->first();
    

    return view('agora',compact('livechat_details'));
    }
    


}