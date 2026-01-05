<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\{User,sellerBanner,Banner,sellerStoreInformation};


class SellerOrderService
{

public function SellerGetOrders($request){

    try{

    // $order_id="Bann".time().Rand(0000000000,999999999999);
    $order_id = substr(time() . rand(100, 999), 0, 9);
    
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




}