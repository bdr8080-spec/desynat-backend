<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

use App\Services\UserFirebaseService;
use App\Helpers\ApiResponse;

use Validator;



class ChatController extends Controller
{

    protected $firebase;

    public function __construct(FirebaseService $firebase,UserFirebaseService $UserFirebaseService)
    {
        $this->firebase = $firebase;
         $this->UserFirebaseService = $UserFirebaseService;
    }


  public function SendMessageInChats(Request $request){

        $validate = Validator::make($request->all(), [
            'unique_id' => 'required|exists:allproductchats,unique_id',
            // "message" => 'required',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

        if ($request->hasFile('image')) {
            $dir = "image";
            $upload = image_upload($request->image, $dir);

            $type="1";
            $message=$upload;

        }else{
            $type="0";
            $message=$request->message;
        }

       $request_data=(object)[
        "unique_id"=>$request->unique_id,
        "message"=>$message,
        "type"=>$type , // 0 message and 1 for Image 
        'by'=>$request->by,
       ];


    $data=$this->UserFirebaseService->userSendChatsMessage($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }





    public function send(Request $request)
    {

    try{

        $request->validate([
            'room' => 'required|string',
            'sender_id' => 'required|string',
            'type' => 'required|in:0,1', // o text and 1 image
            'message' => 'required|string',

        ]);

        $message = [
            'id' => $request->sender_id,
            'message' => $request->message,
            'type'=>$request->type,
            'read_status'=>$request->read_status??0,
            'timestamp' => now()->timestamp,

        ];

        $msgId = $this->firebase->sendMessage($request->room, $message);

        return response()->json(['message_id' => $msgId]);

    }  catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Failed Code.',
            'error'   => $e->getMessage(),
        ], 500);
    }


    }

    public function fetch(Request $request)
    {
        $request->validate([
            'room' => 'required|string',
        ]);

        $messages = $this->firebase->getMessages($request->room);


        return response()->json(['messages' => $messages]);
    }

}