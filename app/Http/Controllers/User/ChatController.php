<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserFirebaseService;
use App\Helpers\ApiResponse;
use App\Http\Controllers\CommonController;

use Validator;

class ChatController extends Controller
{
 
    public function __construct(UserFirebaseService $UserFirebaseService)
    {
        $this->UserFirebaseService = $UserFirebaseService;
    }

    public function allChats(Request $request){ 

         $user=  $request->user();

        $data = (object)[
            'user_id' => $user->id,
        ];

        $chatData = $this->UserFirebaseService->userGetAllChatsRecords($data)['data'];
         //dd($chatData);

        return view('user.chat.chatlists',compact('chatData'));

    }

    public function userChat(Request $request, $id){ 
        $user=  $request->user();

        $data = (object)[
            //'unique_id' => $user->id,
            'unique_id' => $id,
        ];

        $chatData = $this->UserFirebaseService->userGetSingleChatsRecords($data)['data'];
        //dd($chatData);

        return view('user.chat.userChat',compact('chatData'));

    }

    public function chatDetails(Request $request){ 

        return view('user.chat.detailsChat');

    }

    public function sendNormalMessage(Request $request)
{
    try {

        $userId   = auth()->id();
        $sellerId = $request->seller_id;
        $uniqueId = $request->unique_id;

        // 0 = text, 1 = image
        $type = $request->hasFile('image') ? 1 : 0;

        $message = null;

        if ($type === 1) {

            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true);

            if ($uploadResultArray['status'] === 'error') {
                return response()->json([
                    'status' => 'error',
                    'message' => $uploadResultArray['message']
                ], 422);
            }

            $message = $uploadResultArray['data']['url'];

        } else {
            $message = $request->message;
        }

        $chatData = (object)[
            'user_id'   => $userId,
            'seller_id' => $sellerId,
        ];

        $this->UserFirebaseService->CreateNormalChatFirebase($chatData);

        $this->UserFirebaseService->userSendChatsMessage((object)[
            'unique_id' => $uniqueId,
            'user_id'   => $userId,
            'seller_id' => $sellerId,
            'type'      => $type,
            'message'   => $message,
            'by'        => 'user',
        ]);

        return response()->json([
            'status'    => 'success',
            'type'      => $type,
            'message'   => $message,
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status'  => 'error',
            'message' => 'Failed to send message',
            'error'   => $e->getMessage()
        ], 500);
    }
}














}