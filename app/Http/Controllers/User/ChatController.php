<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserFirebaseService;
use App\Helpers\ApiResponse;
use App\Http\Controllers\CommonController;
use App\Models\userAddress;

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
        $userAddress = userAddress::where('user_id', $user->id)
                              ->where('set_as_default', '1')
                              ->first();
       //dd($userAddress);

        return view('user.chat.userChat',compact('chatData','userAddress'));

    }

    public function chatDetails(Request $request){ 

        return view('user.chat.detailsChat');

    }

    public function customRequest(Request $request){ 

        return view('user.chat.custom-request');

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

    public function createCustomOrder(Request $request)
    {
        //dd($request->all());
        $user=  $request->user();

        try {
              $request_data = (object)[
                'product_id' => $request->product_id,
                'variation_id' => $request->variation_id,
                'user_id' => $user->id,
              ];

            $data = $this->UserFirebaseService->CreatecustomOrder($request_data);
            //dd($data);
            
            if ($data['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => $data['message'],
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $data['message'],
                    'data' => (object)[]
                ], 422); 
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendCustomOrderRequest(Request $request)
    {
        //dd($request->all());
        $user=  $request->user();

        try {
              $request_data = (object)[
                'unique_id' => $request->unique_id,
                'quantity' => $request->quantity,
                'custom_details' => $request->custom_details,
                'delivery_address' => $request->delivery_address,
                'quantity' => $request->quantity,
              ];

            $data = $this->UserFirebaseService->sendCustomOrderRequest($request_data);
            //dd($data);
            
            if ($data['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => $data['message'],
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $data['message'],
                    'data' => (object)[]
                ], 422); 
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }














}