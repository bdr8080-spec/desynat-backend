<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\{User,sellerBanner,Banner,Order,orderdetail};


class SellerOrderService
{

public function SellerGetOrders($request){

try{


   $all_Order= orderdetail::with('order.user_details','order.delivery_details', 'product_details')->where('seller_id',$request->seller_id)
   ->whereHas('order', function($query) use ($request) {
    $query->where('order_type',$request->type);
   });



   $response['All_order']=clone($all_Order)->get(); // All Orders
  
   $response['ongoing_order'] = clone($all_Order) // Ongoing order check
    ->where('delivery_status', '!=', '3')
    ->whereHas('order', function ($query) {
        $query->where(function ($q) {
            $q->where('payment_method', '3')
              ->orWhere(function ($q2) {
                  $q2->where('payment_method', '!=', '3')
                     ->where('payment_status', '1');
              });
        });
    })
   ->get();

   $response['past_order']=clone($all_Order)->whereIn('delivery_status',['3'])->orWhere('payment_status','2')
   ->get();

   if($response['All_order']->isNotEmpty()){

     return [
            'status'  => 'success',
            'message' => 'All Orders fetch Successfully',
            'data'    => $response
        ];
   }else{

    return [
            'status'  => 'success',
            'message' => 'All Orders fetch Successfully',
            'data'    => []
        ];
   }


    }catch (\Exception $e) {
    return ['status'=>'error','message'=>$e->getMessage(),'data'=>$e->getMessage()];
    }



    
}



public function SellerSingleOrdersdata($request){

try{


   $singleOrder= orderdetail::with('order.user_details','order.delivery_details', 'product_details')->where('id',$request->id)->first();

   if($singleOrder){
    
     return [
            'status'  => 'success',
            'message' => 'Single Orders fetch Successfully',
            'data'    => $singleOrder
        ];
        
    }else{

    return [
            'status'  => 'error',
            'message' => ' Orders  id is inValid ',
            'data'    => (object)[]
        ];
   }


    }catch (\Exception $e) {
    return ['status'=>'error','message'=>$e->getMessage(),'data'=>$e->getMessage()];
    }



    
}




}