<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;


class ChatController extends Controller
{

    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
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