<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;

use Auth;

use Validator;

use App\Services\SellerOrderService;

class SellerOrderController extends Controller
{

    public function __construct(SellerOrderService $SellerOrderService){
        $this->SellerOrderService=$SellerOrderService;
    }

    

    public function order_management(Request $request){

        $seller_details=Auth::guard('seller')->user()->id;

       $request_data=(object) [
        'seller_id'=>$seller_details,
        "type" =>"1",
         "tabs"=>$request->tabs??null,
      
       ];

       if($request->type==1){
        $request_data->tabs=$request->tabs??null;
        $request_data->search=$request->search??null;
        $request_data->from_date=$request->from_date??null;
        $request_data->to_date=$request->to_date??null;
        $request_data->filters=$request->filters??null;
      }

        $normal_data= $this->SellerOrderService->SellerGetOrders($request_data);
        $normal= $normal_data['data'];


        $request_data1=(object) [
        'seller_id'=>$seller_details,
        "type" =>"2",
        "tabs"=>$request->tabs??null,
        // "search"=>$request->search,
        // "from_date"=>$request->from_date??null,
        // "to_date" =>$request->to_date??null,
        // "filters"=> $request->filters??null
       ];


        if($request->type==2){
        $request_data1->tabs=$request->tabs??null;
        $request_data1->search=$request->search??null;
        $request_data1->from_date=$request->from_date??null;
        $request_data1->to_date=$request->to_date??null;
        $request_data1->filters=$request->filters??null;
      }


       $custom_data= $this->SellerOrderService->SellerGetOrders($request_data1);
       $custom= $custom_data['data'];  

        return View('dealer.orderManagement.allOrder',compact('normal','custom'));
    }

     public function single_order_View(Request $Request, $id){   

    $seller_details=Auth::guard('seller')->user()->id;

    $request_data=(object) [
        'seller_id'=>$seller_details,
        "id" =>$id,
       ];

    $data= $this->SellerOrderService->SellerSingleOrdersdata($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    $order_details=  $data['data'];    
    
    return View('dealer.orderManagement.singleorder',compact('order_details'));
    
    }


    public function updateSingleOrderStatus(Request $request){

        $seller_details=Auth::guard('seller')->user()->id;


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


    public function updateOrderExchangeReturnStatus(Request $request){


        $seller_details=Auth::guard('seller')->user()->id;

        $validate = Validator::make($request->all(), [
        'id' => 'required|exists:orderdetails,id', // 
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