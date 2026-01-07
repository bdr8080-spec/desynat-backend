<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\UserFirebaseService;
use App\Helpers\ApiResponse;

use Validator;


class ChatController extends Controller
{

    public function __construct(UserFirebaseService $UserFirebaseService)
    {
        $this->UserFirebaseService = $UserFirebaseService;
    }


    public function create_Custom_order(Request $request){

        $validate = Validator::make($request->all(), [
            'product_id' => 'required',
            'variation_id' => 'required',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
        'product_id' => $request->product_id ,
        'variation_id' => $request->variation_id,
       ];


    $data=$this->UserFirebaseService->CreatecustomOrder($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);



    }




    public function send_custom_order_request(Request $request){

        $validate = Validator::make($request->all(), [
            'unique_id' => 'required|exists:allproductchats,unique_id',
            'quantity' => 'required',
            "custom_details"=>'required',
            "delivery_address"=>'required',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
        'unique_id' => $request->unique_id ,
        'quantity' => $request->quantity,
        'custom_details' => $request->custom_details,
        "delivery_address"=>$request->delivery_address
       ];


    $data=$this->UserFirebaseService->sendCustomOrderRequest($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);



    }
    







}