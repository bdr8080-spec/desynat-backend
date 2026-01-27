<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Services\UserOrderService;

use Validator;

use App\Helpers\ApiResponse;
use Illuminate\Validation\Rule;


class UserWalletController extends Controller
{

public function __construct(UserOrderService $UserOrderService){
    $this->UserOrderService=$UserOrderService;
}


  public function AddMoneyInWallet(Request $request){

      $validate = Validator::make($request->all(), [
                'amount' => 'required|integer',
                "payment_method"=>'required|in:1'
            ]);

        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
        }

      $user_id= $request->user()->id;

        $request_data=(object)[
        'user_id'=>$user_id,
        'amount'=>$request->amount,
        "payment_method"=>$request->payment_method,
        ];

        $data=$this->UserOrderService->AddMoneyFromTheUserSide($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    }




  public function completeAddMoneyInWallet(Request $request){

      $validate = Validator::make($request->all(), [
                'unique_id' => 'required|exists:user_wallet_histories,unique_id',
                "payment_status"=>'required|in:1,2,3'
            ]);

        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
        }

        $request_data=(object)[
        'unique_id'=>$request->unique_id,
        "payment_status"=>$request->payment_status,
        "transaction_id"=>$request->transaction_id??null
        ];

        $data=$this->UserOrderService->CompleteAddMoneyPayment($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    }


    


  public function walletHistory(Request $request){

      $user_id= $request->user()->id;

        $request_data=(object)[
        'user_id'=>$user_id,
        ];
        
        $data=$this->UserOrderService->UserWalletHistory($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    }







}