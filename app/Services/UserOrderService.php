<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\size;
use App\Models\color;
use App\Models\ProductVariant;


use App\Models\{UserGiftCards,GiftCard,UserWallet,Reason};
use App\Models\{Promocode,userAddress,country,all_countrie,allproductchats};

use App\Models\{Order,OrderDeliveryAddress,orderdetail,Addtocart,productRatings,product};

use DB;

use Carbon\Carbon;

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

    if($request->search){
    $get_promo_codes=Promocode::where('name_english',$request->search)->first();
    }else{
        $get_promo_codes=Promocode::where('id',$request->promo_id)->first();
    }

    // dd($get_promo_codes);



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
    $discount_Value=$amount* $discount_percentage/100;
  
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
            'message' => 'Failed to apply promo code: ' . $e->getMessage(),
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
$checkDataInCart =Addtocart::with('product.seller_details')->where('user_id',$userId)->get();
if($checkDataInCart->isEmpty()){
    return [
        'status' => 'error',
        'message' => 'Add to Cart Is Empty',
        'data' => []
    ];
}

// Add To Card Count product 
$AddToCardCount= $checkDataInCart->count();

// equal divide GiftCard   
$giftcard= $request->giftcard_id;
if($giftcard){
$giftcard_amount= $request->giftcard_amount;
$giftCardAmountDivide= number_format($giftcard_amount/$AddToCardCount,2);
}else{
$giftCardAmountDivide=null;
}

// Check promoCode Value 
$promoCodeId =$request->promocode_id;
$promoCodevalue =$request->promocode_value;
// $chekpromoCode= Promocode::where('id',$promoCodeId)->first();

if(isset($promoCodevalue)){

    $promocode_value= $promoCodevalue;
    $PrmocodeCardAmountDivide= number_format($promocode_value/$AddToCardCount,2);
}else{
      $PrmocodeCardAmountDivide=null;
}



foreach($checkDataInCart as $key=>$val){

    $cart_data=[
        "order_id"=>$order_id,
        "user_id"=>$val->user_id,
        "seller_id"=>$val->product->seller_details->id,
        "product_id"=>$val->product_id,
        "variants_id"=>$val->variants_id,
        "quantity"=>$val->quantity,
        "amount"=>$val->amount,
        "tax"=> $val->tax ,
        "shipping_fees"=>$val->shipping_fees,
        "giftcard_id"=>$giftcard,
        "giftcard_amount"=>$giftCardAmountDivide,

        "promocode_id"=>$promoCodeId,
        "promocode_value"=>$PrmocodeCardAmountDivide,
    ];
    orderdetail::create($cart_data);
}

DB::commit();
   
return ['status'=>'success','message'=>"Order Create Successfully",'data'=>$createOrder];

        
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to create order: ' . $e->getMessage(),
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
        'message' => "Gift card is not valid",
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


$userid=$checkOrder->user_id; // User Id

$OrderPayAmount=round($checkOrder->total_amount);  // Orer Pay Amount

 // when i Received Payment in Cod
    if($checkOrder->payment_method=='3'){

        $checkOrder->update(['payment_status'=>'0','delivery_status'=>'2']);

        $this->AddtocartRemoveData($checkOrder->id);

        OrderGiftCardConditionCheck($checkOrder->id); // order inside Giftcard Check 


         $msg="COD Order Place Successfully";  

        // return ['status'=>'success','message'=>"COD Order Place Successfully",'data'=>$checkOrder];
    }elseif($checkOrder->payment_method=='2'){ // wallet Payment Code 
   
       $request_data=(object)[
            'user_id'=>$userid,
            ];

        // Get User Wallet Balance 
       $userBalance= $this->userBalanceget($request_data);

       if($userBalance['data']['balance'] < round($OrderPayAmount)){
        // check Wallet AMount 
        return [
            'status' => 'error',
            'message' => "Wallet Amount Is Low Please recharge Your Wallet",
            'data' => []
        ];
       }

       //    Cut Amount From The Wallet Amount 
        $this->UserBalancePayOrder($userid,$OrderPayAmount);

        $this->AddtocartRemoveData($checkOrder->id);

        OrderGiftCardConditionCheck($checkOrder->id); // order inside Giftcard Check 

        $checkOrder->update(['wallet_amount'=>$OrderPayAmount]); // add Wallet Amount in Table

        $this->Order_detailsPaidStatusChange($checkOrder->id,$request->payment_status); // order details complete order


         $checkOrder->update(['payment_status'=>$request->payment_status,'delivery_status'=>'2']);


         $msg="Order Place Successfully";  

    //    return ['status'=>'success','message'=>"Order Place Successfully",'data'=>$checkOrder];

    }elseif($checkOrder->payment_method=='1'){

        $checkOrder->update(['payment_status'=>$request->payment_status,'delivery_status'=>'2']);

        if($request->payment_status=='1'){
        $msg="Order Payment Paid Successfully";

        $this->AddtocartRemoveData($checkOrder->id);

         OrderGiftCardConditionCheck($checkOrder->id); // order inside Giftcard Check 

        $this->Order_detailsPaidStatusChange($checkOrder->id,$request->payment_status); // order details complete order

        }
        
    }else{

        $msg="Order Payment Cancelled";        
        

    }

    DB::commit();


    return ['status'=>'success','message'=>$msg,'data'=>$checkOrder];

    
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

    
 public function AllOrderDetailsNew($request){

try{

     $orders = OrderDetail::with([
        'order.delivery_details',
        'product_details.brand',
        'product_details.category',
        'product_details.subcategory',
        'product_details.seller_details',
        'variation_details.color',
        'variation_details.size'
    ])
    ->whereHas('order', function ($q) use ($request) {

        if(isset($request->order_type)){
          $q->where('order_type', $request->order_type);
        }
        
        // User filter
        $q->where('user_id', $request->user_id);

        // Payment logic
        $q->where(function ($query) {
            $query->where('payment_method', '3') // COD
                  ->orWhere(function ($sub) {
                      $sub->whereIn('payment_method', ['1', '2'])
                          ->where('payment_status', '!=', '0'); // Paid
                  });
        });

        // Search filter
        if (!empty($request->search)) {
            $q->where('order_id', 'like', '%' . $request->search . '%');
        }
    });

/*
|--------------------------------------------------------------------------
| OrderDetail status filters
|--------------------------------------------------------------------------
*/
if (!empty($request->filter)) {
    $orders->where(function ($query) use ($request) {

        switch ($request->filter) {

            case '2': // Ongoing
                $query->whereIn('delivery_status', ['1', '2'])
                ->whereIn('payment_status',['0','1']);
                break;

            case '3': // Delivered
                $query->where('delivery_status', '3')
                ->where('return_type','0');

                break;

            case '4': // Cancelled
                $query->whereIn('payment_status', ['3','2']); // adjust if needed
                break;

            case '5': // Returned / Failed
                $query->where('delivery_status', '3')
                      ->where('return_type', '1');
                break;
        }
    });
}

$orders = $orders->orderBy('id', 'desc')->get();


    return ['status'=>'success','message'=>"All Order details fetch Successfully",'data'=>$orders];

    
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


      public function Order_detailsPaidStatusChange($orderid,$paymentstatus){
        $checkOrder = orderdetail::where('order_id', $orderid)->update(['payment_status'=>$paymentstatus]);
        
    }

 // User singleOrderDetails
 public function singleOrderDetailsNew($request){

    try{


         $checkOrder = OrderDetail::with([
        'order.delivery_details',
        'order.giftCard_details',
        'order.promocode_details',
        
        'product_details.brand',
        'product_details.category',
        'product_details.subcategory',
        'product_details.seller_details',
        'product_details.store',
        'variation_details.color',
        'variation_details.size',
        'UserRatingReviewProvide'
    ])
    ->where('order_id', $request->order_id)
    ->where('id',$request->orderdetails_id)
    
    ->first();

    if($checkOrder){

       $checkOrder->allOtherOrderVarient = OrderDetail::with([   
        'product_details.brand',
        'product_details.category',
        'product_details.subcategory',
        'product_details.store',
        'variation_details.color',
        'variation_details.size',
    ]) 
     ->where('order_id', $request->order_id)
     ->whereNOT('id',$request->orderdetails_id)
    ->get();


        if($checkOrder->order->order_type=='2'){
            $checkOrder->ChatroomRecordtable=allproductchats::where('unique_id',$checkOrder->order->unique_id)->first();
        }else{
             $checkOrder->ChatroomRecordtable=(object)[];
        }


    }else{

         return [
            'status' => 'error',
            'message' => 'product id is Wrong',
            'data' => []
        ];
    }


    return ['status'=>'success','message'=>"single Order details fetch Successfully",'data'=>$checkOrder];
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }


 // User singleOrderDetails New
 public function singleOrderDetails($request){

    try{


    $checkOrder=Order::with(
        'promocode_details',
        'giftCard_details',
        'delivery_details',
        'order_details.product_details.brand',
        'order_details.product_details.category',
        'order_details.product_details.subcategory',
        'order_details.product_details.seller_details',
        'order_details.UserRatingReviewProvide',

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


 // User Wallet Wallet

 public function userBalanceget($request){

    try{

    $userBalance=UserWallet::where('user_id',$request->user_id)->first();

    if($userBalance){
        $response['balance']=round($userBalance->amount);
    }else{
         $response['balance']=0;
    }

    return ['status'=>'success','message'=>"User Wallet Balance fetch Successfully",'data'=>$response];

    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }



 public function UserBalancePayOrder($user_id,$amount=null){

    try{

    $userBalance=UserWallet::where('user_id',$user_id)->first();

    if($userBalance){
        $balance=round($userBalance->amount)-$amount;
        
        $userBalance->update(['amount'=>$balance]);
        
    }
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    }


 public function cancelledSingleProduct($request){

    try{

    $checkOrder=Order::where('id',$request->order_id)->first();

    if(!$checkOrder){
        return ['status'=>'error','message'=>"No Order id Found",'data'=>(object)[]];
    }

    if($checkOrder->payment_status!=='1' && $checkOrder->payment_method!=='3'){
       return ['status'=>'error','message'=>"This Order Payment is Not Paid",'data'=>(object)[]];
    }

    // check delivery status
    if($checkOrder->delivery_status!=='1' && $checkOrder->delivery_status!=='2' ){
       return ['status'=>'error','message'=>"Delivery is Already proceeed  You Can't Cancel order ",'data'=>(object)[]];
    }

    // if The Payment is Paid By Cod Then cancelled Order Or Process refund process 
    if($checkOrder->payment_method=='3'){

        $new_array=[
        'payment_status'=>'2',
        'delivery_status'=>'1'];
        
        if(isset($request->cancel_reason)){
            $new_array['cancel_reason']= $request->cancel_reason;
        }

        $checkOrder->update($new_array);    

         $new_array1=[
        'payment_status'=>'2',
         ];
        
        if(isset($request->cancel_reason)){
            $new_array1['cancel_reason']= $request->cancel_reason;
        }

      orderdetail::where('order_id',$request->order_id)->update($new_array1);



    }else{


    $new_array=[
    'payment_status'=>'3',
    'delivery_status'=>'1'];

    if(isset($request->cancel_reason)){
        $new_array['cancel_reason']= $request->cancel_reason;
    }
    
    $checkOrder->update($new_array);

         $new_array1=[
        'payment_status'=>'3',
         ];
        
        if(isset($request->cancel_reason)){
            $new_array1['cancel_reason']= $request->cancel_reason;
        }

    orderdetail::where('order_id',$request->order_id)->update($new_array1);

    }
    








    return ['status'=>'success','message'=>"Order cancelled Successfully",'data'=>$checkOrder];
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }



 public function cancelledSingleProductNew($request){

    try{


    DB::beginTransaction();

    // $checkOrder=Order::where('id',$request->order_id)->first();

    $AllOrderCheck=orderdetail::where('order_id',$request->order_id)->whereIn('payment_status',['0','1'])->count();

    $checkOrder=orderdetail::with('order')->where('order_id',$request->order_id)->where('id',$request->orderdetails_id)->first();

    if(!$checkOrder){
        return ['status'=>'error','message'=>"No Order id Found",'data'=>(object)[]];
    }

    if($checkOrder->order->payment_status!=='1' && $checkOrder->order->payment_method!=='3'){
       return ['status'=>'error','message'=>"This Order Payment is Not Paid",'data'=>(object)[]];
    }

     if($checkOrder->delivery_status!=='1' && $checkOrder->delivery_status!=='2' && $checkOrder->delivery_status!=='2.1' ){
       return ['status'=>'error','message'=>"Delivery is Already proceeed  You Can't Cancel order ",'data'=>(object)[]];
    }

    // if The Payment is Paid By Cod Then cancelled Order Or Process refund process 
    if($checkOrder->order->payment_method=='3'){

        $new_array=[
        'payment_status'=>'2',
        'delivery_status'=>'1'];
        
        if(isset($request->cancel_reason)){
            $new_array['cancel_reason']= $request->cancel_reason;
        }

        $checkOrder->update($new_array);    

    }else{


    $new_array=[
    'payment_status'=>'3',
    'delivery_status'=>'1'];

    if(isset($request->cancel_reason)){
        $new_array['cancel_reason']= $request->cancel_reason;
    }
    
    $checkOrder->update($new_array);

    }

    // Cancel Order In Order Table if i have 1 varient

    if($AllOrderCheck ==1){

        $checkOrderTable=Order::where('id',$request->order_id)->first();

          if($checkOrderTable->payment_method=='3'){

        $new_array2=[
            'payment_status'=>'2',
            'delivery_status'=>'1'

        ];
    }else{
        $new_array2=[
            'payment_status'=>'3',
            'delivery_status'=>'1'
        ];
    }
      
    if(isset($request->cancel_reason)){
        $new_array2['cancel_reason']= $request->cancel_reason;
    }

    $checkOrderTable->update($new_array2);    
    
    }

    DB::commit();

    return ['status'=>'success','message'=>"Order cancelled Successfully",'data'=>$checkOrder];
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }



    

 public function getRejectReasonDetails($request){

    try{

    $checkReason=Reason::where('type',$request->type)->get();

    if($checkReason->isEmpty()){
        return ['status'=>'error','message'=>"No Reason Found",'data'=>[]];
    }

    return ['status'=>'success','message'=>"reason fetch Successfully",'data'=>$checkReason];
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }



 public function returnProductAfterdelivery($request){

    try{

    $checkOrder=orderdetail::with('order_details','product_details')->where('order_id',$request->order_id)->where('id',$request->orderdetails_id)->first();

    
    if(!$checkOrder){
        return ['status'=>'error','message'=>"No Order details Not Found",'data'=>(object)[]];
    }

    if($checkOrder->payment_status!=='1'){
       return ['status'=>'error','message'=>"This Order Payment is Not Paid",'data'=>(object)[]];
    }
    // check order is Alredy in return and exchange state 

     if($checkOrder->return_type!=='0'){
       return ['status'=>'error','message'=>"Product Is Already in Return and Exchange State",'data'=>(object)[]];
     }
     
    
    // check delivery status
    if($checkOrder->delivery_status!=='3'){
       return ['status'=>'error','message'=>"Product Is Not delivered Now Wait for product Delivered",'data'=>(object)[]];
    }
    
    if($checkOrder->product_details->product_return=='0'){
       return ['status'=>'error','message'=>"Product return is Not Availble",'data'=>(object)[]];     
    }

    // Check Product Return days Availbility

    if($checkOrder->product_details->product_return=='1'){
    
    $return_days= intVal($checkOrder->product_details->return_days);

    $productOrderDate = $checkOrder->created_at;

    // Add return days
    $returnLastDate = $productOrderDate->copy()->addDays($return_days);

    $today = now();

    // Check if today is greater than return date
    if ($today->greaterThan($returnLastDate)) {
               
        return ['status'=>'error','message'=>"Product return Period Is Over",'data'=>(object)[]];     

    }

    }

    $checkOrder->update(['return_type'=>'1','return_reason'=> $request->return_reason,'return_image'=>$request->return_image]);    

    return ['status'=>'success','message'=>"Product return Request Send Successfully",'data'=>$checkOrder];
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }

    // exchnageProductAfterdelivery


// product exchange Code 

 public function exchnageProductAfterdelivery($request){

    try{

    $checkOrder=orderdetail::with('order_details','product_details')->where('order_id',$request->order_id)->where('id',$request->orderdetails_id)->first();

    
    if(!$checkOrder){
        return ['status'=>'error','message'=>"No Order details Not Found",'data'=>(object)[]];
    }

    if($checkOrder->payment_status!=='1' ){
       return ['status'=>'error','message'=>"This Order Payment is Not Paid",'data'=>(object)[]];
    }
    // check order is Alredy in return and exchange state 

     if($checkOrder->return_type!=='0'){
       return ['status'=>'error','message'=>"Product Is Already in Return and Exchange State",'data'=>(object)[]];
     }
     
    
    // check delivery status
    if($checkOrder->delivery_status!=='3'){
       return ['status'=>'error','message'=>"Product Is Not delivered Now Wait for product Delivered",'data'=>(object)[]];
    }
    
    if($checkOrder->product_details->product_exchangable=='0'){
       return ['status'=>'error','message'=>"Product return is Not Availble",'data'=>(object)[]];     
    }

    // Check Product product_exchangable days Availbility

    if($checkOrder->product_details->product_exchangable=='1'){
    
    $return_days= intVal($checkOrder->exchangable_days);

    $productOrderDate = $checkOrder->created_at;

    // Add return days
    $returnLastDate = $productOrderDate->copy()->addDays($return_days);

    $today = now();

    // Check if today is greater than return date
    if ($today->greaterThan($returnLastDate)) {
               
        return ['status'=>'error','message'=>"Product Exchange Period Is Over",'data'=>(object)[]];     

    }

    }

    $checkOrder->update(['return_type'=>'2','exchange_reason'=> $request->exchange_reason,'exchange_new_size'=>$request->new_size]);    

    return ['status'=>'success','message'=>"Product Exchange Request Send Successfully",'data'=>$checkOrder];
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }

    


 public function ReturnAndExchnageProductAfterdelivery($request){

    try{

    $checkOrder=orderdetail::with('order_details','product_details')->where('order_id',$request->order_id)->where('id',$request->orderdetails_id)->first();

    
    if(!$checkOrder){
        return ['status'=>'error','message'=>"No Order details Not Found",'data'=>(object)[]];
    }

    if($checkOrder->payment_status=='2'){
       return ['status'=>'error','message'=>"Order is Cancelled or rejected",'data'=>(object)[]];
    }

    // if($checkOrder->payment_status!=='1'){
    //    return ['status'=>'error','message'=>"This Order Payment is Not Paid",'data'=>(object)[]];
    // }
    // check order is Alredy in return and exchange state 

     if($checkOrder->return_type!=='0'){
       return ['status'=>'error','message'=>"Product Is Already in Return and Exchange State",'data'=>(object)[]];
     }
     
    
    // check delivery status
    if($checkOrder->delivery_status!=='3'){
       return ['status'=>'error','message'=>"Product Is Not delivered Now Wait for product Delivered",'data'=>(object)[]];
    }
    

    // check if The Product is return State 
     if($request->type=='1'){

         if($checkOrder->product_details->product_return=='0'){
       return ['status'=>'error','message'=>"Product return is Not Availble",'data'=>(object)[]];     
    }

    // Check Product Return days Availbility

    if($checkOrder->product_details->product_return=='1'){
    
    $return_days= intVal($checkOrder->product_details->return_days);

    $productOrderDate = $checkOrder->created_at;

    // Add return days
    $returnLastDate = $productOrderDate->copy()->addDays($return_days);

    $today = now();

    // Check if today is greater than return date
    if ($today->greaterThan($returnLastDate)) {
               
        return ['status'=>'error','message'=>"Product return Period Is Over",'data'=>(object)[]];     

    }

    }

    $checkOrder->update(['return_type'=>'1','return_reason'=> $request->return_reason,'return_image'=>$request->return_image]);    

    $msg="Product return Request Send Successfully";


     }


    // check Type Code for exchnage 
    if($request->type=='2'){

    if($checkOrder->product_details->product_exchangable=='0'){
       return ['status'=>'error','message'=>"Product return is Not Availble",'data'=>(object)[]];     
    }

    // Check Product product_exchangable days Availbility
    if($checkOrder->product_details->product_exchangable=='1'){
    
    $return_days= intVal($checkOrder->product_details->exchangable_days);

    $productOrderDate = $checkOrder->created_at;

    // Add return days
    $returnLastDate = $productOrderDate->copy()->addDays($return_days);

    $today = now();

    // Check if today is greater than return date
    if ($today->greaterThan($returnLastDate)) {
               
        return ['status'=>'error','message'=>"Product Exchange Period Is Over",'data'=>(object)[]];     

    }

    }

    $checkOrder->update(['return_type'=>'2','exchange_reason'=> $request->exchange_reason,'exchange_new_size'=>$request->new_size]);    

    $msg="Product Exchange Request Send Successfully";

}

    return ['status'=>'success','message'=>$msg,'data'=>$checkOrder];
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }


 public function ProductReviewAndRating($request){
    
    try{

    $checkOrder=orderdetail::with('order_details','product_details')->where('order_id',$request->order_id)->where('id',$request->orderdetails_id)->first();

    if(!$checkOrder){
        return ['status'=>'error','message'=>"No Order details Not Found",'data'=>(object)[]];
    }

    if($checkOrder->payment_status!=='1' ){
       return ['status'=>'error','message'=>"This Order Payment is Not Paid",'data'=>(object)[]];
    }
    // check order is Alredy in return and exchange state 

    //  if($checkOrder->return_type!=='0'){
    //    return ['status'=>'error','message'=>"Product Is Already in Return and Exchange State",'data'=>(object)[]];
    //  }
     
    
    // check delivery status
    if($checkOrder->delivery_status!=='3'){
       return ['status'=>'error','message'=>"Product Is Not delivered Now Wait for product Delivered",'data'=>(object)[]];
    }


    $product_id=$checkOrder->product_id;
    $product_details=product::where('id',$product_id)->first();
    $store_id= $product_details->store_id;
    

    $match=[
    'user_id'=>$request->user_id,
    "order_id"=>$request->order_id,
    "orderdetails_id"=>$request->orderdetails_id,
    ];


    $check_review=productRatings::where($match)->first();

    if($check_review){
        return [
            'status' => 'error',
            'message' => "This product Already Have review",
            'data' => (object)[]
        ];

    }

    $requestData=[
    'user_id'=>$request->user_id,
    "order_id"=>$request->order_id,
    "orderdetails_id"=>$request->orderdetails_id,
    "product_id"=>$product_id,
    "product_rating"=>$request->product_rating??null,
    "product_review"=>$request->product_review??null,
    "product_image"=>json_encode($request->product_image)??null,
    "store_id"=>$store_id,
    "store_rating"=>$request->store_rating??null,
    "store_review"=>$request->store_review??null,
    "store_image"=>json_encode($request->store_image)??null,
    ];




   $create_review=productRatings::UpdateOrCreate($match,$requestData);

    if($create_review){
        return ['status'=>'success','message'=>"Product Review Save Successfully",'data'=>$create_review];
    }

    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }

    public function getSizesExceptProvided($request)
    {
        try {
           // dd($request);
            $productId = $request->product_id;
            $sizeId    = $request->size_id;
            $colorId   = $request->color_id; 

            if (!$productId || !$sizeId || !$colorId) {
                return [
                    'status'  => 'error',
                    'message' => 'Product ID, Size ID, and Color ID are required',
                    'data'    => []
                ];
            }

            $sizeIds = ProductVariant::where('product_id', $productId)
                ->where('color_id', $colorId)
                ->where('size_id', '!=', $sizeId)
                ->pluck('size_id')
                ->unique()
                ->toArray();

            $sizes = Size::whereIn('id', $sizeIds)
                ->select('id', 'name')
                ->orderBy('name')
                ->get();

            if ($sizes->isEmpty()) {
                return [
                    'status'  => 'success',
                    'message' => 'No sizes found',
                    'data'    => (object)[]
                ];
            }

            return [
                'status'  => 'success',
                'message' => 'Sizes fetched successfully',
                'data'    => $sizes
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch sizes: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }






}