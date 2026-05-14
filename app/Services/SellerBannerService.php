<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\{User,sellerBanner,Banner,sellerStoreInformation};


class SellerBannerService
{

public function SellerAddBanner($request){

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
            'message' => __('service_messages.banner_created_successfully'),
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
            'message' => __('service_messages.wait_for_admin_to_verify_banner'),
            'data'    => $checkBanner
        ];
    }

    if($checkBanner->Admin_verify=='2'){
         return [
            'status'  => 'error',
            'message' => __('service_messages.banner_rejected_by_admin'),
            'data'    => $checkBanner
        ];
    }
    
     if($checkBanner->payment_status!=='0'){
         return [
            'status'  => 'error',
            'message' => __('service_messages.banner_payment_already_paid_or_cancelled'),
            'data'    => $checkBanner
        ];
    }

  $checkBanner->update(['payment_status'=>$request->payment_status,'transaction_id'=>$request->transaction_id]);

  if($request->payment_status=='1'){
        $msg = __('service_messages.banner_payment_paid_successfully');
        CreateNotification([
            'sender_id' => 1,
            'sender_type' => 1,

            'receiver_id' => $checkBanner->seller_id,
            'receiver_type' => 3,

            'title_english' => 'Banner',
            'title_arabic' => 'البانر',

            'description_english' => "Payment for banner is successful, Transaction id: #{$request->transaction_id}",
            'description_arabic' => "تمت عملية دفع البانر بنجاح، رقم المعاملة: #{$request->transaction_id}",

            'notification_type' => 'seller_banner_payment'
        ]);
    }elseif($request->payment_status=='2'){
        $msg = __('service_messages.banner_payment_cancelled');
        CreateNotification([
            'sender_id' => 1,
            'sender_type' => 1,

            'receiver_id' => $checkBanner->seller_id,
            'receiver_type' => 3,

            'title_english' => 'Banner',
            'title_arabic' => 'البانر',

            'description_english' => "Payment for banner is failed!",
            'description_arabic' => "فشلت عملية دفع البانر",

            'notification_type' => 'seller_banner_payment'
        ]);
    }else{
        $msg = __('service_messages.banner_payment_cancelled'); 
        CreateNotification([
            'sender_id' => 1,
            'sender_type' => 1,

            'receiver_id' => $checkBanner->seller_id,
            'receiver_type' => 3,

            'title_english' => 'Banner',
            'title_arabic' => 'البانر',

            'description_english' => "Payment for banner is failed!",
            'description_arabic' => "فشلت عملية دفع البانر",

            'notification_type' => 'seller_banner_payment'
        ]);  
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
                ->whereDate('start_date', '>=' , $request->from)
                ->whereDate('end_date', '<=' , $request->to);


}

if ($request->banner_filter) {

    switch ($request->banner_filter) {

        case '1':
            // Active
            $checkBanner = $checkBanner
                ->where('Admin_verify', '1')
                ->where('payment_status', '1')
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now());
            break;

            case '2':
            // Confirmed
            $checkBanner = $checkBanner
                ->where('Admin_verify', '1')
            ->whereIn('payment_status', ['0','1'])

                ->where(function ($q) {
                    
                    $q->where('payment_status', '1')

                     ->where(function ($q3) {
                                    // $q3->whereDate('start_date', '<=', now())
                                    $q3->WhereDate('end_date', '>=', now());
                     });

                });

                // ->where(function ($q) {
                //     $q->where('payment_status', '0') // fully confirmed, ignore dates
                //     ->orWhere(function ($q2) {
                //         $q2->where('payment_status', '1')
                //             ->where(function ($q3) {
                //                 $q3->whereDate('start_date', '<=', now())
                //                     ->WhereDate('end_date', '>=', now());
                //             });
                //     });
                // });
            break;

        case '3':
            // Pending
            $checkBanner = $checkBanner
                ->where('Admin_verify', '0');
            break;

        case '4':
            // Expired
            $checkBanner = $checkBanner
                ->where('Admin_verify', '1')
                ->where('payment_status', '1')
                ->whereDate('end_date', '<', now());
            break;

        case '5':
            // Rejected
            $checkBanner = $checkBanner
                ->whereIn('payment_status', ['2','3'])
                ->orWhere('Admin_verify','2');
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
        return ['status'=>'error','message' => __('service_messages.no_banner_found'),'data'=>[]];

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