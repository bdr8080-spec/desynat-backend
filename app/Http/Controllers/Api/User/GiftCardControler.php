<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use App\Models\{UserGiftCards,GiftCard};

use App\Services\UserGiftCardService;



use Validator;

class GiftCardControler extends Controller
{
    public function __construct(UserGiftCardService $UserGiftCardService){
        $this->UserGiftCardService=$UserGiftCardService;
    }

    public function gift_card_occasion(Request $request){

        $data=$this->UserGiftCardService->giftCard();

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
       


    }



    public function user_add_gift_card(Request $request){

    try{

        $validate = Validator::make($request->all(), [
            // "profile_image"=>"required",
            'gift_card_id' => 'required|exists:gift_cards,id',
            'amount' => 'required',
            'receiver_name' => 'required',
            'receiver_email' => 'required|email',
            'sender_name' => 'required',
            // 'sender_email' => 'required|email',
            'wish_message' => 'required',
            "country_code"=>"required",
            "mobile"=>"required"
            // 'notes' => 'required',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }


       $user_id= $request->user()->id;

       $request_data=(object)[
        'user_id'=>$user_id,
        'gift_card_id' => $request->gift_card_id ,
        'amount' => $request->amount,
        'receiver_name' => $request->receiver_name  ,
        'receiver_email' => $request->receiver_email  ,
        'sender_name' => $request->sender_name,  
        'sender_email' => $request->sender_email??null,
        'wish_message' => $request->wish_message,
        'notes' =>$request->notes??null  ,
        'country_code' =>$request->country_code??null  ,
        'mobile' =>$request->mobile??null  ,
       ];


        $data=$this->UserGiftCardService->AddgiftCard($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }
       
    }


    public function giftcard_complete_Payment(Request $request){

        try{
    
            $validate = Validator::make($request->all(), [
                // "profile_image"=>"required",
                'order_id' => 'required|exists:user_gift_cards,order_id',
                'payment_status'=>'required|in:1,2',// 1 paid 2 cancel
                'transaction_id'=>'required'
                ]);
            
           if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }
    
    
           $user_id= $request->user()->id;
    
           $request_data=(object)[
            'user_id'=>$user_id,
            'order_id' => $request->order_id,
            'payment_status' => $request->payment_status,
            'transaction_id'=>$request->transaction_id,
            "Payment_method"=>$request->Payment_method??null
            
           ];
    
    
            $data=$this->UserGiftCardService->complete_giftCard_Payment($request_data);
    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }
    
            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
           
    
    
        }


    public function view_gift_cards(Request $request){

        try{
    
            $user_id= $request->user()->id;
            $user_email= $request->user()->email;
    
           $request_data=(object)[
            'user_id'=>$user_id,
            'email' => $user_email,
            'search'=>$request->search
           ];
    
            $data=$this->UserGiftCardService->User_view_giftCard_details($request_data);
    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }
    
            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
           
    
    
        }



}