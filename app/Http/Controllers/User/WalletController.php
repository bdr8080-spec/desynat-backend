<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserOrderService;
use App\Helpers\ApiResponse;
use App\Http\Controllers\CommonController;

use Session;

use Validator;

class WalletController extends Controller
{
 
    public function __construct(UserOrderService $UserOrderService)
    {
        $this->UserOrderService = $UserOrderService;
    }

    public function myWallet(Request $request){ 

         $user=  $request->user();

        $data = (object)[
            'user_id' => $user->id,
        ];

        $walletData = $this->UserOrderService->UserWalletHistory($data)['data'];
         //dd($walletData);

        return view('user.mywallet.wallet',compact('walletData'));

    }

    public function addWalletMoney(Request $request){ 

        $user=  $request->user();

        if($request->isMethod('get')){
        $data = (object)[
            'user_id' => $user->id,
        ];
        $walletData = $this->UserOrderService->AddMoneyFromTheUserSide($data)['data'];

        if($request->payment=='yes'){
        $msg="Payment Paid Successfully";
        $status='success';

        Session::flash('message', $msg);
        Session::flash('status', $status);
         return redirect()->route('user.addWalletMoney');

        }elseif($request->payment=='no'){

        $msg="Payment Cancalled";
        $status='error';

        Session::flash('message', $msg);
        Session::flash('status', $status);
         return redirect()->route('user.addWalletMoney');
        }


         //dd($chatData);
        return view('user.mywallet.addmoney',compact('walletData'));
    }

    if($request->isMethod('post')){

          $validate = Validator::make($request->all(), [
                'amount' => 'required|integer',
                "payment_method"=>'required|in:1'
            ]);

        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
        }
        
        $request_data=(object)[
        'user_id'=>$user->id,
        'amount'=>$request->amount,
        "payment_method"=>$request->payment_method,
        ];

        $data=$this->UserOrderService->AddMoneyFromTheUserSide($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
   

    }



    }


    
    public function redeemgiftCardinUser(Request $request){ 

        try {
   
        $validate = Validator::make($request->all(), [
                'giftCardNo' => 'required|min:16|max:16',
                "giftCardPin"=>'required'
            ]);

        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
        }

      $user_id= $request->user()->id;

        $request_data=(object)[
        'user_id'=>$user_id,
        'giftCardNo'=>$request->giftCardNo,
        "giftCardPin"=>$request->giftCardPin,
        ];

        $data=$this->UserOrderService->RedeemGiftCardMoneyToWallet($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
   

        
        } catch (\Exception $e) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to send message',
                'error'   => $e->getMessage()
            ], 500);
        }

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