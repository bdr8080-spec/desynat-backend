<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

use App\Models\{product,ProductVariant,allproductchats,
      userAddress,OrderDeliveryAddress,Order,orderdetail};

use DB;

class UserFirebaseService
{
    protected Database $database;

    public function __construct()
    {
        $factory = (new Factory)
    ->withServiceAccount(storage_path('desynat-firebase-adminsdk-fbsvc-511856a90e.json'))
    ->withDatabaseUri('https://desynat-default-rtdb.firebaseio.com');


        // $factory = (new Factory)
        //     ->withServiceAccount(storage_path('ichrono-firebase-adminsdk-fbsvc-bc66e0b097.json'));

        $this->database = $factory->createDatabase();
    }


    public function CreatecustomOrder($request){

     $product_details=ProductVariant::with('product_details')->where('product_id',$request->product_id)
        ->where('id',$request->variation_id)
        ->first();

        if(!$product_details){
              return [
                'status'  => 'error',
                'message' => 'product id is invalid',
                'data'    => (object)[]
            ];
        }

    $unique_id='chat'. rand(00000,99999);    

    $match=[
    "type"=>"2", //1 Normal 2 order Cutom Order Request
    "user_id"=> $request->user_id,
    "seller_id" =>$product_details->product_details->seller_id,
    "product_id"=>$request->product_id ,
    "variation_id"=>$request->variation_id ,
    ];

    $request_data=[
    "unique_id"=>$unique_id,
    "type"=>"2", //1 Normal 2 order Cutom Order Request
    "user_id"=> $request->user_id,
    "seller_id" =>$product_details->product_details->seller_id,
    "product_id"=>$request->product_id ,
    "variation_id"=>$request->variation_id ,
    "product_request"=>"0",
    "action"=>"0"
    ];


$check_chatRecord=allproductchats::with('product_variation.product_details')->where($match)->first();

if(!$check_chatRecord){
  $check_record=allproductchats::UpdateOrCreate($match,$request_data);

$check_chatRecord=allproductchats::with('product_variation.product_details')->where('id',$check_record->id)->first();
    
}

    return [
        'status'  => 'success',
        'message' => 'Chat request send Successfully',
        'data'    => $check_chatRecord
    ];

    }


 public function sendCustomOrderRequest($request){

    $check_chatRecord=allproductchats::with('product_variation.product_details')->where('unique_id',$request->unique_id)->first();

        if(!$check_chatRecord){
              return [
                'status'  => 'error',
                'message' => 'product id is invalid',
                'data'    => (object)[]
            ];
        }

    $product_details=ProductVariant::with('product_details')->where('product_id',$check_chatRecord->product_id)
        ->where('id',$check_chatRecord->variation_id)
        ->first();

    // when User already request This Order 
    if($check_chatRecord->product_request=="1" && $check_chatRecord->action=="0" ){
        return [
            'status'  => 'success',
            'message' => 'user send Custom Order in Progress',
            'data'    => $check_chatRecord
        ];  
    }
    
    $price=intVal($product_details->final_price) * intVal($request->quantity);
    $shipping=0;
    $tax=0;
    $total_amount=$price+$shipping+$tax;

    $request_data=[
    "price"=>$product_details->final_price,
    "quantity"=>$request->quantity,
    "custom_details"=>$request->custom_details,
    "delivery_address"=>$request->delivery_address,
    "shipping"=> $shipping,
    "tax"=>$tax,
    "total_amount"=>$total_amount,
    "product_request"=>"1",
    "action"=>"0",
    ];
    
    $update_request=$check_chatRecord->update($request_data);
    
    return [
        'status'  => 'success',
        'message' => 'Order request send Successfully',
        'data'    => $check_chatRecord
    ];

    }

    



 public function userGetAllChatsRecords($request){

    $check_chatRecord=allproductchats::with('product_variation.product_details','user_details','seller_details','order_create_status')->where('user_id',$request->user_id)->orderBy('id','desc')->get();

   if($check_chatRecord->isNotEmpty()){

foreach ($check_chatRecord as $key => $val) {

    $firbase_chat = $this->getMessages($val->unique_id);

    if (!empty($firbase_chat)) {
        // Ensure array order
        $lastMessage = end($firbase_chat);

        // $val->message_type = $lastMessage['type'] ?? null;
         $val->message_type = StrVal($lastMessage['type']) ?? null;

        $val->last_chat = $lastMessage['message'] ?? null;
        $val->last_chat_time = $lastMessage['times'] ? formatChatTime($lastMessage['times']) : null;
        $val->last_chat_by = $lastMessage['by'] ?? null;
        
    } else {
        $val->message_type=null;
        $val->last_chat = null;
        $val->last_chat_time = null;
        $val->last_chat_by = null;
    }
}

     
    return [
        'status'  => 'success',
        'message' => 'All Chat records fetch Successfully',
        'data'    => $check_chatRecord
    ];
        }else{

    return [
        'status'  => 'success',
        'message' => 'All Chat records fetch Successfully',
        'data'    => []
    ];

}
    }




 public function userGetSingleChatsRecords($request){

    $check_chatRecord=allproductchats::with('product_variation.product_details', 'product_variation.size','product_variation.color','user_details','seller_details','delivery_details','order_create_status')->where('unique_id',$request->unique_id)->first();

   if($check_chatRecord){

     $firbase_chat= $this->getMessages($check_chatRecord->unique_id);

    //  Update Chat Read Status 

    

     $response['record']=$check_chatRecord;
     $response['firbase_chat']=$firbase_chat;
     
     
    return [
        'status'  => 'success',
        'message' => 'Single Chat records fetch Successfully',
        'data'    => $response
    ];
        }else{

    return [
        'status'  => 'success',
        'message' => 'Single Chat records fetch Successfully',
        'data'    => []
    ];

}
    }

    


 public function userSendChatsMessage($request){
    
    $check_chatRecord=allproductchats::with('product_variation.product_details')->where('unique_id',$request->unique_id)->first();

   if(!$check_chatRecord){
    return [
        'status'  => 'success',
        'message' => 'Chat romm Is Not found',
        'data'    => (object)[]
    ];
        }
        
     $request_data=[
        'user_id'=>$check_chatRecord->user_id,
        "unique_id"=>$request->unique_id,
        "message"=>$request->message,
        "type"=>$request->type , // 0 message and 1 for Image 
        'by'=>$request->by ,
         "times"=>Now(),
         "read"=>0 // 0 un read and 1 read 
       ];


       $room=$request->unique_id;
       $message=$request_data;

         $newMessageRef = $this->database
                ->getReference("chats/{$room}")
                ->push(); // this generates the key, but doesn't write data yet

            $msgId = $newMessageRef->getKey();

            // Step 2: Add the generated key as 'id' in your message array
            $message['id'] = $msgId;

            // Step 3: Write the message data using the generated key
            $newMessageRef->set($message);

            
    return [
        'status'  => 'success',
        'message' => 'Chat message send successfully',
        'data'    => $request_data,
        "msg_id" => $msgId
    ];

}


    public function CreateNormalChatFirebase($request){

    $unique_id='chat'. rand(00000,99999);    

    $match=[
    "type"=>"1", //1 Normal 2 order Cutom Order Request
    "user_id"=> $request->user_id,
    "seller_id" =>$request->seller_id,
    ];

    $request_data=[
    "unique_id"=>$unique_id,
    "type"=>"1", //1 Normal 2 order Cutom Order Request
    "user_id"=> $request->user_id,
    "seller_id" =>$request->seller_id,
    ];


    $check_chatRecord=allproductchats::with('product_variation.product_details')->where($match)->first();

    if(!$check_chatRecord){
    $check_record=allproductchats::UpdateOrCreate($match,$request_data);

    $check_chatRecord=allproductchats::with('product_variation.product_details')->where('id',$check_record->id)->first();
        
    }

    return [
        'status'  => 'success',
        'message' => 'Normal Chat request send Successfully',
        'data'    => $check_chatRecord
    ];

    }

    
 // User Create order Custom order 
 public function CustomCreateOrder($request_data){

    try{
        //dd($request_data);

        DB::beginTransaction();

         $check_chatRecord=allproductchats::with('product_variation.product_details')->where('unique_id',$request_data->unique_id)->first();

        if(!$check_chatRecord){
        return [
            'status'  => 'error',
            'message' => 'records not Found',
            'data'    => (object)[]
        ];
        }
        
        if($check_chatRecord->product_request!=='1'){
        return [
            'status'  => 'error',
            'message' => "User didn't Request This Order This Is Normal Chat ",
            'data'    => (object)[]
        ];
        }

        if($check_chatRecord->action!=='1' &&  $check_chatRecord->action!=='2' && $check_chatRecord->action!=='5'){
        return [
            'status'  => 'error',
            'message' => "Seller didn't Accept Order Or Cancel This order",
            'data'    => (object)[]
        ];
        
        }

        $request=(object)[
            'unique_id' => $request_data->unique_id,
            'user_id'=>$check_chatRecord->user_id,
            'delivery_address'=>$check_chatRecord->delivery_address,
            "total_mrp"=>$check_chatRecord->price,
            "discount_mrp"=>0,
            'promocode_status'=>"no",
            "promocode_id"=>null,
            "promocode_value"=>null,
            'shipping_fees'=>$check_chatRecord->shipping,
            "tax"=>$check_chatRecord->tax,
            "total_amount"=>$check_chatRecord->total_amount,
            'giftcard_id'=>$request_data->giftcard_id??null,
            'giftcard_amount'=>$request_data->giftcard_amount??null,
            'Payment_method'=>$request_data->Payment_method
           ];


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
            "order_type"=>"2",
            'user_id'=>$userId,
            'delivery_address'=>$delivery_id->id,
            "total_mrp"=>$check_chatRecord->total_amount,
            "discount_mrp"=>$request->discount_mrp,
            'promocode_status'=>$request->promocode_status,
            "promocode_id"=>$request->promocode_id,
            "promocode_value"=>$request->promocode_value,
            'shipping_fees'=>$request->shipping_fees,
            "tax"=>$request->tax,
            "total_amount"=>$request->total_amount,
            "giftcard_id"=>$request->giftcard_id,
            "giftcard_amount"=>$request->giftcard_amount,
            "Payment_method"=>$request_data->Payment_method,
            'unique_id' => $request->unique_id
           ];

$createOrder=Order::create($request_data);

$order_id=$createOrder->id;

    $cart_data=[
        "order_id"=>$order_id,
        "user_id"=>$userId,
        "seller_id"=>$check_chatRecord->seller_id,
        "product_id"=>$check_chatRecord->product_id,
        "variants_id"=>$check_chatRecord->variation_id,
        "quantity"=>$check_chatRecord->quantity,
        "amount"=>$check_chatRecord->price,
        "tax"=> $check_chatRecord->tax ,
        "shipping_fees"=>$check_chatRecord->shipping,
        "giftcard_id"=>$request->giftcard_id,
        "giftcard_amount"=>$request->giftcard_amount,
        // "promocode_id"=>$promoCodeId,
        // "promocode_value"=>$PrmocodeCardAmountDivide,
        'unique_id' => $request->unique_id
    ];
    orderdetail::create($cart_data);

DB::commit();
   
return ['status'=>'success','message'=>"Custom Order Create Successfully",'data'=>$createOrder];

        
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to create order: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }


    public function UserCustomOrderAcceptAndReject($request){


    $match=[
    "unique_id"=> $request->unique_id,
    ];

    $check_chatRecord=allproductchats::with('product_variation.product_details')->where($match)->first();

    if($check_chatRecord){


     if($check_chatRecord->action!=='1' && $check_chatRecord->action!=='2'){

         return [
            'status'  => 'error',
            'message' => "Seller Process Already proceed",
            'data'    => (object)[]
        ];
     }

    $check_chatRecord->update(['action'=>$request->status]);
    $check_chatRecord=allproductchats::with('product_variation.product_details')->where('id',$check_chatRecord->id)->first();
    
}

    return [
        'status'  => 'success',
        'message' => 'Custom request Update Successfully',
        'data'    => $check_chatRecord
    ];

    }






    // public function sendMessage(string $room, array $message): string
    // {
    //     $newMessage = $this->database
    //         ->getReference("chats/{$room}")
    //         ->push($message);

    //     return $newMessage->getKey();
    // }

            public function sendMessage(string $room, array $message): string
        {
            // Step 1: Create a new reference and get its unique Firebase key
            $newMessageRef = $this->database
                ->getReference("chats/{$room}")
                ->push(); // this generates the key, but doesn't write data yet

            $msgId = $newMessageRef->getKey();

            // Step 2: Add the generated key as 'id' in your message array
            $message['id'] = $msgId;

            // Step 3: Write the message data using the generated key
            $newMessageRef->set($message);

            return $msgId;
        }


    public function getMessages(string $room): array
    {

        return $this->database
            ->getReference("chats/{$room}")
            ->orderByChild('timestamp')
            ->getValue() ?? [];
    }

    public function updateMessage(string $room, string $messageId, array $data): void
    {
        $this->database
            ->getReference("chats/{$room}/{$messageId}")
            ->update($data);
    }

     public function countUnreadMessages($room, $currentUserId)
    {
        $messages = $this->getMessages($room);
        $count = 0;

        foreach ($messages as $msg) {
            if (isset($msg['id']) && $msg['id'] != $currentUserId && (!isset($msg['read_status']) || $msg['read_status'] == 0)) {
                $count++;
            }
        }

        return $count;
    }




}