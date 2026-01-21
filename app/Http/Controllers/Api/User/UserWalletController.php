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






}