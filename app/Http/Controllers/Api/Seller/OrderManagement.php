<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\ApiResponse;

use App\Services\SellerOrderService;

use Validator;

class OrderManagement extends Controller
{

       public function __construct(SellerOrderService $SellerOrderService){
        $this->SellerOrderService=$SellerOrderService;
    }

    
    public function all_orders(Request $request){

          $seller_details=$request->user()->id;

            $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2', // 1 Normal Order  2 custom Order 
            ]);
            
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $request_data=(object) [
        'seller_id'=>$seller_details,
        "type" =>$request->type,
        "tabs"=>$request->tabs??null,
        "from_date"=>$request->from_date??null,
        "to_date" =>$request->to_date??null,
       ];


       $data= $this->SellerOrderService->SellerGetOrders($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);    
    }


    public function single_orders_data(Request $request){

          $seller_details=$request->user()->id;

            $validate = Validator::make($request->all(), [
            'id' => 'required|exists:orderdetails,id', // 1 Normal Order  2 custom Order 
            ]);
            
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $request_data=(object) [
        'seller_id'=>$seller_details,
        "id" =>$request->id,

       ];


       $data= $this->SellerOrderService->SellerSingleOrdersdata($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
        
    }







}