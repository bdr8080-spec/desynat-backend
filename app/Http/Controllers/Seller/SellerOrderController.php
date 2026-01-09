<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Services\SellerOrderService;

class SellerOrderController extends Controller
{

    public function __construct(SellerOrderService $SellerOrderService){
        $this->SellerOrderService=$SellerOrderService;
    }

    

    public function order_management(Request $Request){

          $seller_details=Auth::guard('seller')->user()->id;


       $request_data=(object) [
        'seller_id'=>$seller_details,
        "type" =>'1',
        "tabs"=>$request->tabs??null,
        "from_date"=>$request->from_date??null,
        "to_date" =>$request->to_date??null,
       ];


        $normal_data= $this->SellerOrderService->SellerGetOrders($request_data);
        $normal= $normal_data['data'];

        $request_data1=(object) [
        'seller_id'=>$seller_details,
        "type" =>'2',
        "tabs"=>$request->tabs??null,
        "from_date"=>$request->from_date??null,
        "to_date" =>$request->to_date??null,
       ];

       $custom_data= $this->SellerOrderService->SellerGetOrders($request_data1);
       $custom= $custom_data['data'];       

       dump($custom);

        return View('dealer.orderManagement.allOrder',compact('normal','custom'));
    }

     public function single_order_View(Request $Request){   

        return View('dealer.orderManagement.singleorder');
   
    }

    





}