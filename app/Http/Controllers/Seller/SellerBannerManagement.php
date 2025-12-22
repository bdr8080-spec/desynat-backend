<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Services\SellerBannerService;

use Validator;

use App\Helpers\ApiResponse;

use Auth;

use Session;
use App\Models\Category;

class SellerBannerManagement extends Controller
{

    public function __construct(SellerBannerService $SellerBannerService){
        $this->SellerBannerService=$SellerBannerService;
    }


    public function show_banner(Request $request){


    $seller_details=Auth::guard('seller')->user()->id;

    $request_data=(object) [
    'seller_id'=>$seller_details,
    'search'=>$request->search??null
    ];

    $data= $this->SellerBannerService->SellerAllbanner($request_data);


    // Online Payment received 
      // when i get data from Paymwnt gateway
        if($request->payment=='yes'){
        $msg="Payment Paid Successfully";
        $status='success';

        Session::flash('message', $msg);
        Session::flash('status', $status);
         return redirect()->route('seller.show_banner');

        }elseif($request->payment=='no'){

        $msg="Payment Cancalled";
        $status='error';

        Session::flash('message', $msg);
        Session::flash('status', $status);
         return redirect()->route('seller.show_banner');
        }

    $banners=$data['data'];

      return view('dealer.bannermgt.banner',compact('banners'));


    }

    public function show_single_banner(Request $request , $id){

    $request_data=(object) [
    'id'=>$id
    ];

    $single_banner= $this->SellerBannerService->singleBannerDetails($request_data);

    $single_banner=$single_banner['data'];

    return view('dealer.bannermgt.banner-details',compact("single_banner"));

    }



public function seller_banner_price(Request $request){


   $seller_details=Auth::guard('seller')->user()->id;

     $request_data=(object) [
    'seller_id'=>$seller_details,
    'country_id'=>$request->country_id??null,
    "type"=>$request->type
    ];

    $data=$this->SellerBannerService->BannerPriceDetails($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}


    public function add_banner(Request $request){

        if($request->isMethod('get')){

            $category=Category::all();


           return view('dealer.bannermgt.add-banner',compact('category'));

        }

        $seller_details=Auth::guard('seller')->user()->id;

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
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
       }


         $dir="banner";
         if($request->upload_banner){
            $upload_banner=doc_upload($request->upload_banner,$dir);  // chart Image
         }


       $request_data=(object) [
        'seller_id'=>$seller_details,
        'banner_position'=>$request->banner_position,
        'category'=>$request->category,
        'subcatgory'=>$request->subcatgory,


        'start_date'=>$request->start_date,
        'end_date'=>$request->end_date,
        'total_days'=>$request->total_days,
        'upload_banner'=>$upload_banner,
        'price'=>$request->price,

       ];

       $data= $this->SellerBannerService->SellerAddBanner($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


}