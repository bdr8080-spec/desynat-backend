<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;

use App\Services\SellerOrderService;

use Validator;

use Auth;


class SellerChatController extends Controller
{

    public function __construct(SellerOrderService $SellerOrderService){
        $this->SellerOrderService=$SellerOrderService;
    }

    


    public function All_chats(Request $request){

    
        $seller_details=Auth::guard('seller')->user()->id;


       $request_data=(object) [
        'seller_id'=>$seller_details,
       ];

       $data= $this->SellerOrderService->SellerAllChatdata($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

        $all_chats=$data['data'];

        return view('dealer.chatmgt.chatlist',compact('all_chats'));
        
    }



}