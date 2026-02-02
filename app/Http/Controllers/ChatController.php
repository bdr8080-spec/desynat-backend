<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

use App\Services\UserFirebaseService;
use App\Helpers\ApiResponse;

use Validator;

use App;


use App\Services\GoogletranslateService;


class ChatController extends Controller
{

    protected $firebase;

    public function __construct(FirebaseService $firebase,UserFirebaseService $UserFirebaseService,GoogletranslateService $GoogletranslateService)
    {
        $this->firebase = $firebase;
         $this->UserFirebaseService = $UserFirebaseService;
         $this->GoogletranslateService = $GoogletranslateService;
    }


  public function SendMessageInChats(Request $request){

        $validate = Validator::make($request->all(), [
            'unique_id' => 'required|exists:allproductchats,unique_id',
            // "message" => 'required',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $TextInArbic='';

        if ($request->hasFile('image')) {
            $dir = "image";
            $upload = image_upload($request->image, $dir);

            $type="1";
            $message=$upload;

        }else{
            $type="0";
            
              if(App::getLocale()=='en'){

                $message=$request->message;            
                $TextInArbic= $this->GoogletranslateService->translate($message,'ar');

              }else{
                $TextInArbic=$request->message;            
                $message= $this->GoogletranslateService->translate($TextInArbic,'en');
              }
        }

       $request_data=(object)[
        "unique_id"=>$request->unique_id,
        "message"=>$message,
        "messageAr" => $TextInArbic,
        "type"=>$type , // 0 message and 1 for Image 
        'by'=>$request->by,
       ];

    $data=$this->UserFirebaseService->userSendChatsMessage($request_data,'web');

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    $chat_data=$data['data'];
    $chat_data['msg_id']=$data['msg_id'];
    
    if($chat_data){
        $chat_data['times']=formatChatTime($chat_data['times']);
    }
    
    return ApiResponse::generateResponse('success', $data['message'],$chat_data, 200);

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