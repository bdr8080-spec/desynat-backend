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
        "search" =>$request->search??null,
        "filters" =>$request->filters??null
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


    public function updateSingleOrderStatus(Request $request){

          $seller_details=$request->user()->id;

            $validate = Validator::make($request->all(), [
            'id' => 'required|exists:orderdetails,id', // 1 Normal Order  2 custom Order 
            'status'=>'required'
        ]);
            
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $request_data=(object) [
        'seller_id'=>$seller_details,
        "id" =>$request->id,
        'status'=>$request->status
       ];


       $data= $this->SellerOrderService->updateSingleOrderStatus($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
        
    }



    public function AllChatsAndOrders(Request $request){

        $seller_details=$request->user()->id;

       $request_data=(object) [
        'seller_id'=>$seller_details,
        "filters"=>$request->filters??null
       ];

       $data= $this->SellerOrderService->SellerAllChatdata($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
        
    }



    public function singleChatsRecords(Request $request){

        $validate = Validator::make($request->all(), [
        'unique_id' => 'required|exists:allproductchats,unique_id', // 1 Normal Order  2 custom Order 
        ]);
            
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }


        $seller_details=$request->user()->id;

       $request_data=(object) [
        'seller_id'=>$seller_details,
        "unique_id"=>$request->unique_id
       ];

       $data= $this->SellerOrderService->SellerSingleChatdata($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
        
    }


    public function Modifysinglechatsrecords(Request $request){


          $validate = Validator::make($request->all(), [
            'unique_id' => 'required|exists:allproductchats,unique_id',
            "price"=>"required",
            'quantity' => 'required',
            //"shipping"=>'required',
            //"tax"=>'required',
            "total_amount"=>"required"
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

        $seller_details=$request->user()->id;

       $request_data=(object) [
        'seller_id'=>$seller_details,
        "unique_id"=>$request->unique_id,
        "price"=>$request->price,
        'quantity' => $request->quantity,
        "shipping"=>$request->shipping,
        "tax"=>$request->tax,
        "total_amount"=>$request->total_amount,

       ];

       $data= $this->SellerOrderService->Modifysinglechatsrecords($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
        
    }



    public function updateOrderExchangeReturnStatus(Request $request){

         $seller_details=$request->user()->id;

        $validate = Validator::make($request->all(), [
        'id' => 'required|exists:orderdetails,id', // 1 Normal Order  2 custom Order 
        'status'=>'required|in:0,1,2'
        ]);

       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $request_data=(object) [
        'seller_id'=>$seller_details,
        "id" =>$request->id,
        'status'=>$request->status
       ];

       $data= $this->SellerOrderService->updateOrderExchangeReturnStatus($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    

    }





}