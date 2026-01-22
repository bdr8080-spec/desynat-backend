<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;

use Validator;
use App\Services\SellerDealManagentService;

use Auth;


class WebDealManagement extends Controller
{

    public function __construct(SellerDealManagentService $SellerDealManagentService){
    $this->SellerDealManagentService=$SellerDealManagentService;
    }

    public function deal_management(Request $request){
        

    $seller_details=  Auth::guard('seller')->user()->id;

        $request_data=(object )[
        'seller_id'=>$seller_details,
        ];

        $data= $this->SellerDealManagentService->seller_ViewDeal($request_data);
        
        $deal_record=$data['data'];
        
        return view('dealer.dealMgt.deal',compact('deal_record'));
        
    }


    public function ViewsingleDealManagement(Request $request, $id){
        
        

          $seller_details=  Auth::guard('seller')->user()->id;

          $request_data=(object )[
            'seller_id'=>$seller_details,
            "deal_id"=>$id,
            "search"=>$request->search??null
        ];

         $data= $this->SellerDealManagentService->SingleDealView($request_data);

        $single_deal=$data['data'];
        

        return view('dealer.dealMgt.dealViewDealsProduct',compact('single_deal'));
        
    }

    public function singleDealManagement(Request $request, $id){
        
    $seller_details=  Auth::guard('seller')->user()->id;

        if($request->ismethod('get')){

        
          $request_data=(object )[
            'seller_id'=>$seller_details,
            "deal_id"=>$id,
            "search"=>$request->search??null
        ];

         $data= $this->SellerDealManagentService->SingleDealView($request_data);

        $single_deal=$data['data'];        
        return view('dealer.dealMgt.dealadd',compact('single_deal'));
    }


     if($request->ismethod('post')){

    // Add product In Deal Inside
         $request_data=(object )[
            'seller_id'=>$seller_details,
            "deal_id"=>$id,
            "product_ids"=>$request->product_ids??null
        ];

     $data= $this->SellerDealManagentService->SellerAddProductsInDeals($request_data);

     if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    }

    
    }

}