<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\sellerBanner;

use App\Helpers\ApiResponse;

use App\Services\SellerBannerService;

use Validator;

class SellerBannerController extends Controller
{
    
    public function __construct(SellerBannerService $SellerBannerService){
        $this->SellerBannerService=$SellerBannerService;
    }



    public function Add_Banner(Request $request){

          $seller_details=$request->user()->id;

          $validate = Validator::make($request->all(), [
            'banner_position' => 'required|in:1,2,3', // 1 homeTop 2 home Banner 3 category
            'category'        => 'nullable|required_if:banner_position,3|exists:categories,id',
            'subcatgory'      => 'nullable|required_if:banner_position,3|exists:sub_categories,id',

            "start_date"=>"required|date",
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days'=>'required|integer',
            "upload_banner"=>"required",
            'price'=>'required'

            ]);
            
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $request_data=(object) [
        'seller_id'=>$seller_details,
        'banner_position'=>$request->banner_position,
        'category'=>$request->category,
        'subcatgory'=>$request->subcatgory,


        'start_date'=>$request->start_date,
        'end_date'=>$request->end_date,
        'total_days'=>$request->total_days,
        'upload_banner'=>$request->upload_banner,
        'price'=>$request->price,

       ];


       $data= $this->SellerBannerService->SellerAddBanner($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }

     public function complete_banner_payment(Request $request){

         $validate = Validator::make($request->all(), [
            'order_id'=>"required|exists:seller_banners,order_id", // 0 Personal 1 Busness
            "payment_status"=>"required|in:0,1,2,3"
            ]);
            
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

         $request_data=(object) [
        'order_id'=>$request->order_id,
        'payment_status'=>$request->payment_status,
        'transaction_id'=>$request->transaction_id??null
       ];

    $data= $this->SellerBannerService->SellerbannerPayment($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
     }

public function all_banners(Request $request){

    $seller_details=$request->user()->id;

    $request_data=(object) [
    'seller_id'=>$seller_details,
    'search'=>$request->search??null
    ];

    $data= $this->SellerBannerService->SellerAllbanner($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    

     }





}