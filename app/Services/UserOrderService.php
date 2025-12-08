<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;


use App\Models\{UserGiftCards,GiftCard};
use App\Models\{Promocode,userAddress,country,all_countrie};

use App\Models\{Order,OrderDeliveryAddress,orderdetail,Addtocart};

use DB;

class UserOrderService
{

 // User_View_Promocode_list
 public function User_View_Promocode_list($request){

    try{


      $user_address_check=  userAddress::where('id',$request->delivery_address)->where('user_id',$request->user_id)->first();

      if(!$user_address_check){

        return [
            'status' => 'error',
            'message' => 'User and Address didn\'t Match',
            'data' => []
        ];
      }

      $getCountry_dial_code=$user_address_check->country_code;


      $getCountryId= country::where('dial_code',$getCountry_dial_code)->first();

      if(!$getCountryId){
        return [
            'status' => 'success',
            'message' => 'No promo Code found In',
            'data' => []
        ];
      }

     $get_all_promo_codes=Promocode::where('country_id',$getCountryId->id)
     ->wheredate('start_date','<=',now())
     ->wheredate('end_date','>=',now())
     ->where('status','1')->get();


    return ['status'=>'success','message'=>"All promcode fetch Successfully",'data'=>$get_all_promo_codes];


        
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }


    


 // User Apply PromoCode
 public function User_Apply_PromoCode($request){

    try{

     $amount=$request->amount;

    $get_promo_codes=Promocode::where('id',$request->promo_id)->first();

       if(!$get_promo_codes){

        return [
            'status' => 'error',
            'message' => 'Promo Code is Invalid',
            'data' => (object)[]
        ];
       }

       if($get_promo_codes->status=='0'){
        return [
            'status' => 'error',
            'message' => 'Promo Code is Not Active',
            'data' => (object)[]
        ];
       }
       
       if($get_promo_codes->min_order_value > $amount){
        return [
            'status' => 'error',
            'message' => 'This Promo Code is Not Apply on This Amount',
            'data' => (object)[]
        ];
       }

    //    check User Order how many order user create 

       if($get_promo_codes->applicable_for=='1'){   
        
        $orderCount=0;

        if($orderCount > 0 ){
            return [
                'status' => 'error',
                'message' => 'This Promo Code is Apply on Your First order Only',
                'data' => (object)[]
            ];
        }
       }


    //    calculate percentage of Amount 

    $discount_percentage=$get_promo_codes->discount_percent;
    $discount_Value=$amount/$discount_percentage;
    $original_discount=$discount_Value;
   
    // if The discount Value Greater Then backend discount Value  
    if($discount_Value > $get_promo_codes->upto_discount ){

        $discount_Value=$get_promo_codes->upto_discount;
    }

    $final_amount=$amount-$discount_Value;
    

    $response=[
        'discount_code'=>$get_promo_codes->name_english, 
        'amount'=>$amount, 
        'discount_percentage'=>$discount_percentage,
        'original_discount'=>round($original_discount),
        'Apply_discount_value'=>round($discount_Value),
        'final_amount'=>round($final_amount),
    ];

    return ['status'=>'success','message'=>"promocode Apply Successfully",'data'=>$response];

        
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }

 // User Create order
 public function User_Create_Order($request){

    try{

        DB::beginTransaction();

        $orderId="Order". rand('11111111111111','99999999999999999');

        $userId=$request->user_id;

        // Address Table data insert Into delivery Table inside    
      $user_address=userAddress::where('id',$request->delivery_address)->first();

      if($user_address){

        $address_data=[
            "user_id"=>$userId,
            "name"=>$user_address->name,
            "mobile"=>$user_address->mobile ,
            "country_code"=>$user_address->country_code ,
            "address"=>$user_address->address ,
            "house_no"=>$user_address->house_no ,
            "street_no"=>$user_address->street_no ,
            "postal_code"=>$user_address->postal_code  ,
            "city"=>$user_address->city ,
            "state"=>$user_address->state,
            "country_name"=>$user_address->country_name,
            "landmark"=>$user_address->landmark,
            "save_address_as"=>$user_address->save_address_as,
            "status"=>$user_address->status,
            "latitude"=>$user_address->latitude,
            "longitude"=>$user_address->longitude,
        ];

     $delivery_id=OrderDeliveryAddress::create($address_data);

      }

    //   Add Data in Order Table
        $request_data=[
            'order_id'=>$orderId,
            'user_id'=>$userId,
            'delivery_address'=>$delivery_id->id,
            "total_mrp"=>$request->total_mrp,
            "discount_mrp"=>$request->discount_mrp,
            'promocode_status'=>$request->promocode_status,
            "promocode_id"=>$request->promocode_id,
            "promocode_value"=>$request->promocode_value,
            'shipping_fees'=>$request->shipping_fees,
            "tax"=>$request->tax,
            "total_amount"=>$request->total_amount,
            "giftcard_id"=>$request->giftcard_id,
            "giftcard_amount"=>$request->giftcard_amount,
            "Payment_method"=>$request->Payment_method
           ];

// use App\Models\{Order,OrderDeliveryAddress,orderdetail};


$createOrder=Order::create($request_data);

$order_id=$createOrder->id;

// get Data From Add to cart and Insert  orderdetail Table
$checkDataInCart =Addtocart::where('user_id',$userId)->get();
if($checkDataInCart->isEmpty()){
    return [
        'status' => 'error',
        'message' => 'Add to Cart Is Empty',
        'data' => []
    ];
}

foreach($checkDataInCart as $key=>$val){

    $cart_data=[
        "order_id"=>$order_id,
        "user_id"=>$val->user_id,
        "product_id"=>$val->product_id,
        "variants_id"=>$val->variants_id,
        "quantity"=>$val->quantity,
        "amount"=>$val->amount
    ];
    orderdetail::create($cart_data);
}


DB::commit();
   
return ['status'=>'success','message'=>"Order Create Successfully",'data'=>$createOrder];

        
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }


 // User Apply gift Card In Order
 public function User_Apply_giftCardInOrder($request){

    try{

    // DB::beginTransaction();


$checkGiftCard=  UserGiftCards::where('giftCardNo',$request->giftCardNo)
 ->where('giftCardPin',$request->giftCardPin)
 ->where('payment_status','1')
 ->where('giftCardUse','0')
 ->first();

 if($checkGiftCard){

// $checkOrder=Order::where('order_id', $request->order_id)->first();

// if($checkOrder->total_amount <=  $checkGiftCard->amount){

    $response=[
        "id"=>$checkGiftCard->id,
        // "OrderAmount"=>$checkOrder->total_amount,
        "GiftCardAmount"=>$checkGiftCard->amount,
        // "total_amount"=>strVal($checkOrder->total_amount-$checkGiftCard->amount),


    ];

return ['status'=>'success','message'=>"Gift Card Apply Successfully",'data'=>$response];



// }else{
//     return [
//         'status' => 'error',
//         'message' => "Gift Card Amount Is Low",
//         'data' => []
//     ];
// }

 }else{
    return [
        'status' => 'error',
        'message' => "Gift Card Is used Or Invalid",
        'data' => []
    ];
 }








// DB::commit();
   
        
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }

 // User productOrderComplete
 public function productOrderComplete($request){

    try{

DB::beginTransaction();

$checkOrder=Order::where('order_id', $request->order_id)->first();

if($checkOrder->payment_status!=='0' ){
    return [
            'status' => 'error',
            'message' => "This Order Payment is done or cancelled",
            'data' => []
    ];
}

 // when i Received Payment in Cod
    if($checkOrder->payment_method=='3'){

        $checkOrder->update(['delivery_status'=>'2']);

        $this->AddtocartRemoveData($checkOrder->id);


        return ['status'=>'success','message'=>"COD Order Place Successfully",'data'=>$checkOrder];
    }

    if($checkOrder->payment_method=='2'){
        return [
            'status' => 'error',
            'message' => "Wallet Service Is Not Availble Now",
            'data' => []
    ];
        // return ['status'=>'success','message'=>"COD Order Place Successfully",'data'=>$checkOrder];
    }


    if($checkOrder->payment_method=='1'){

        $checkOrder->update(['payment_status'=>$request->payment_status,'delivery_status'=>'2']);

        if($request->payment_status=='1'){
        $msg="Order Payment Paid Successfully";

        $this->AddtocartRemoveData($checkOrder->id);

        }else{
            $msg="Order Payment Cancelled";        
        }

    DB::commit();

    return ['status'=>'success','message'=>$msg,'data'=>$checkOrder];

    }

    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }
    
    }


 // User AllOrderDetails
 public function AllOrderDetails($request){

    try{

    DB::beginTransaction();

    $checkOrder=Order::with(
        'delivery_details',
        'order_details.product_details.brand',
        'order_details.product_details.category',
        'order_details.product_details.subcategory',
        'order_details.product_details.seller_details',

    'order_details.variation_details.color','order_details.variation_details.size')->where('user_id', $request->user_id);
    
    if($request->filter){

        $checkOrder=  $checkOrder->where('order_id', 'like','%'.$request->search.'%'); // Onging
    }


    if($request->filter){

        switch ($request->filter) {
            case '1':

                break;
         
            case '2':
              $checkOrder=  $checkOrder->where('payment_status','1')->where('delivery_status','2'); // Onging

                break;
            case '3':

              $checkOrder=  $checkOrder->where('payment_status','1')->where('delivery_status','3'); // delivered

            break;
            case '4':
              $checkOrder=  $checkOrder->where('payment_status','2'); // cancelled
            break;
            case '5':
               $checkOrder= $checkOrder->where('payment_status','3')->where('delivery_status','4');
            break;
                
            default:
                # code...
                break;
        }
    }
    
  $checkOrder=$checkOrder->get();

    return ['status'=>'success','message'=>"All Order details fetch Successfully",'data'=>$checkOrder];

    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    }


    // delete Data from Add to cart
    public function AddtocartRemoveData($orderid){

        $checkOrder = Order::with('order_details.product_details')->where('id', $orderid)->first();

        $userId = $checkOrder->user_id;  // ← correct source of user_id
        
        foreach ($checkOrder->order_details as $key => $val) {
        
            Addtocart::where([
                'product_id' => $val->product_id,
                'variants_id' => $val->variants_id,
                'user_id'     => $userId
            ])->delete();
        
        }

        
    }

 // User singleOrderDetails
 public function singleOrderDetails($request){

    try{

    DB::beginTransaction();

    $checkOrder=Order::with(
        'delivery_details',
        'order_details.product_details.brand',
        'order_details.product_details.category',
        'order_details.product_details.subcategory',
        'order_details.product_details.seller_details',
    'order_details.variation_details.color','order_details.variation_details.size')
    ->where('order_id', $request->order_id)->first();

    return ['status'=>'success','message'=>"single Order details fetch Successfully",'data'=>$checkOrder];

    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }








}
