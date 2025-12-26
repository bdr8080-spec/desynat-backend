<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\{User,sellerBanner,Banner,sellerStoreInformation};


class SellerBannerService
{

public function SellerAddBanner($request){

    try{

    $order_id="Bann".time().Rand(0000000000,999999999999);
    
     $request_data=[
        'order_id'=>$order_id,
        'seller_id'=>$request->seller_id,
        'banner_position'=>$request->banner_position,
        'category'=>$request->category,
        'subcatgory'=>$request->subcatgory,
        'start_date'=>$request->start_date,
        'end_date'=>$request->end_date,
        'total_days'=>$request->total_days,
        'upload_banner'=>$request->upload_banner,
        'price'=>$request->price
       ];

       

   $createBanner=sellerBanner::Create($request_data);

   if($createBanner){
    
      return [
            'status'  => 'success',
            'message' => 'Banner create Successfully',
            'data'    => $createBanner
        ];

   }


    }catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];
    }
}




public function SellerbannerPayment($request){

    try{
   
   $checkBanner=sellerBanner::where('order_id',$request->order_id)->first();

   if($checkBanner){

    if($checkBanner->Admin_verify=='0'){
         return [
            'status'  => 'error',
            'message' => 'Wait for The Admin verify Your Banner',
            'data'    => $checkBanner
        ];
    }

    if($checkBanner->Admin_verify=='2'){
         return [
            'status'  => 'error',
            'message' => 'Banner Rejected By Admin',
            'data'    => $checkBanner
        ];
    }
    
     if($checkBanner->payment_status!=='0'){
         return [
            'status'  => 'error',
            'message' => 'Banner Payment is Already Paid or cancelled',
            'data'    => $checkBanner
        ];
    }

  $checkBanner->update(['payment_status'=>$request->payment_status,'transaction_id'=>$request->transaction_id]);

  if($request->payment_status=='1'){
        $msg="Banner Payment Paid Successfully";
    }elseif($request->payment_status=='2'){
        $msg="Banner Payment Cancelled";
    }else{
        $msg="Banner Payment Cancelled";     
    }
    
      return [
            'status'  => 'success',
            'message' => $msg,
            'data'    => $checkBanner
        ];


   }


    }catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];
    }
}





public function SellerAllbanner($request){

try{

$checkBanner=sellerBanner::with('category_details','subcategory_details')->where('seller_id',$request->seller_id);

if($request->search){
  $checkBanner=$checkBanner->where('order_id','Like','%'.$request->search.'%');
}

if (isset($request->from) && isset($request->to)  ) {

      $checkBanner = $checkBanner
                ->whereDate('created_at', '>' , $request->from)
                ->whereDate('created_at', '<' , $request->to);


}


if ($request->banner_filter) {
    
    switch ($request->banner_filter) {

        case '1':
            // Active
            $checkBanner = $checkBanner
                ->where('Admin_verify', '1')
                ->where('payment_status', '1');
            break;

        case '2':
            // Confirmed
            $checkBanner = $checkBanner
                ->where('Admin_verify', '1');
            break;

        case '3':
            // Pending
            $checkBanner = $checkBanner
                ->where('Admin_verify', '0');
                // ->where('payment_status', '0');
            break;

        case '4':
            // Expired
            $checkBanner = $checkBanner
                ->where('Admin_verify', '1')
                ->where('payment_status', '3');
            break;

        case '5':
            // Rejected
            $checkBanner = $checkBanner
                ->where('Admin_verify', '2');
            break;

        default:
            // No filter
            break;
    }
}




$checkBanner=$checkBanner->orderBy('id','desc')->get();

 return [
            'status'  => 'success',
            'message' => "All Bannner fetch Successfully",
            'data'    => $checkBanner
        ];



}catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];
    }
}




public function BannerPriceDetails($request){

try{


   $store_details= sellerStoreInformation::where('seller_id',$request->seller_id)->first();

    if($store_details){
        $country_id=$store_details->country;
    }else{
        return ['status'=>'error','message'=>"Seller Store information Not Found",'data'=>[]];

    }

    $checkBanner=Banner::where('type',$request->type)->where('country_id',$country_id)->get();
    if($checkBanner->isEmpty()){
        return ['status'=>'error','message'=>"No Price Found",'data'=>[]];

    }

 return [
            'status'  => 'success',
            'message' => "All Banner Price fetch Successfully",
            'data'    => $checkBanner
        ];


}catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];
    }
}





public function singleBannerDetails($request){

try{

$checkBanner=sellerBanner::with('category_details','subcategory_details')->where('id',$request->id)->first();


 return [
            'status'  => 'success',
            'message' => "single Bannner fetch Successfully",
            'data'    => $checkBanner
        ];



}catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];
    }
}





}