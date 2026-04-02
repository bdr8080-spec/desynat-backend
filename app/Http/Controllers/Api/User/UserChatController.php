<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\UserFirebaseService;
use App\Services\GoogletranslateService;
use App\Helpers\ApiResponse;

use Validator;


class UserChatController extends Controller
{

    public function __construct(UserFirebaseService $UserFirebaseService,GoogletranslateService $GoogletranslateService)
    {
        $this->UserFirebaseService = $UserFirebaseService;
        $this->GoogletranslateService = $GoogletranslateService;
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
            //"delivery_address"=>'required',
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


  public function userAllChats(Request $request){


       $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
        "filters"=>$request->filters,
       ];


    $data=$this->UserFirebaseService->userGetAllChatsRecords($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);



    }
    


  public function userSinglechats(Request $request){

        $validate = Validator::make($request->all(), [
            'unique_id' => 'required|exists:allproductchats,unique_id',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
        "unique_id"=>$request->unique_id
       ];

    $data=$this->UserFirebaseService->userGetSingleChatsRecords($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


  public function SendMessageInChats(Request $request){

        $validate = Validator::make($request->all(), [
            'unique_id' => 'required|exists:allproductchats,unique_id',
            "message" => 'required',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

          $TextInArbic='';

        if ($request->type=='0') {
            $message=$request->message;
            
            $TextInArbic= $this->GoogletranslateService->translate($message,'ar');
        }

        

       $request_data=(object)[
        "unique_id"=>$request->unique_id,
        "message"=>$request->message,
        "type"=>strval($request->type), // 0 message and 1 for Image 
        "messageAr" => $TextInArbic,
        'by'=>$request->by,
       ];


    $data=$this->UserFirebaseService->userSendChatsMessage($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function UserNormalChatWithSeller(Request $request){

        $validate = Validator::make($request->all(), [
            'seller_id' => 'required',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
        'seller_id' => $request->seller_id ,
       ];


    $data=$this->UserFirebaseService->CreateNormalChatFirebase($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }



public function CustomOrderCreateOrder(Request $request){

        $validate = Validator::make($request->all(), [
            'unique_id' => 'required|exists:allproductchats,unique_id',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
        'unique_id' => $request->unique_id ,
        'giftcard_id'=>$request->giftcard_id??null,
        'giftcard_amount'=>$request->giftcard_amount??null,
        'Payment_method'=>$request->Payment_method
       ];


    $data=$this->UserFirebaseService->CustomCreateOrder($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

}




public function customAcceptRejectOrder(Request $request){

        $validate = Validator::make($request->all(), [
            'unique_id' => 'required|exists:allproductchats,unique_id',
            "status" => 'required|in:4,5'
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
        'unique_id' => $request->unique_id ,
        'status'=>$request->status,
       ];

    $data=$this->UserFirebaseService->UserCustomOrderAcceptAndReject($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

}





}