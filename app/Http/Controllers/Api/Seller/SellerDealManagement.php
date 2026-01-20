<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;

use Validator;


use App\Services\SellerDealManagentService;


class SellerDealManagement extends Controller
{

    public function __construct(SellerDealManagentService $SellerDealManagentService){
        $this->SellerDealManagentService=$SellerDealManagentService;
    }

    public function view_deals(Request $request){

        $seller_details=$request->user()->id;

          $request_data=(object )[
            'seller_id'=>$seller_details,
        ];

    $data= $this->SellerDealManagentService->seller_ViewDeal($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
          return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

}


     public function viewsingledeals(Request $request){

          $validate = Validator::make($request->all(), [
            'deal_id' => 'required|exists:deals,id',
        ]);

        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        $seller_details=$request->user()->id;

          $request_data=(object )[
            'seller_id'=>$seller_details,
            "deal_id"=>$request->deal_id,
            "search"=>$request->search??null
        ];

         $data= $this->SellerDealManagentService->SingleDealView($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
          return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


     public function AddProductSinDeals(Request $request){

          $validate = Validator::make($request->all(), [
            'deal_id' => 'required|exists:deals,id',
            "product_ids"=>'required|array'
        ]);

        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        $seller_details=$request->user()->id;

          $request_data=(object )[
            'seller_id'=>$seller_details,
            "deal_id"=>$request->deal_id,
            "product_ids"=>$request->product_ids??null
        ];

         $data= $this->SellerDealManagentService->SellerAddProductsInDeals($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }






}