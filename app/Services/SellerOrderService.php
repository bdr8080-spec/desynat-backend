<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\{User,sellerBanner,Banner,Order,orderdetail};

use App\Models\{product,ProductVariant,allproductchats};


use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;


class SellerOrderService
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



public function SellerGetOrders($request){

try{
    

   $all_Order= orderdetail::with('user_details','order.user_details','order.delivery_details', 'product_details','variation_details.color','variation_details.size')->where('seller_id',$request->seller_id)
   ->whereHas('order', function($query) use ($request) {
    $query->where('order_type',$request->type);

   });

   $all_Order_data=clone($all_Order);
   $past_order=clone($all_Order);

   
   if($request->tabs==1){

    if (!empty($request->search)) {
    $search = $request->search;

    $all_Order_data=$all_Order_data->where(function ($q) use ($search) {
        $q->whereHas('product_details', function ($p) use ($search) {
            $p->where('name', 'LIKE', "%$search%");
        })
        ->orWhereHas('order', function ($o) use ($search) {
            $o->where('order_id', 'LIKE', "%$search%");
        });
    });
}

if (!empty($request->from_date) && !empty($request->to_date)) {
  $all_Order_data=$all_Order_data->whereBetween('created_at', [
          $request->from_date . ' 00:00:00',
        $request->to_date . ' 23:59:59'
    ]);
}
   }

   $all_Order_data=$all_Order_data->get(); // All Orders


   $ongoing_order = clone($all_Order) // Ongoing order check
    ->where('delivery_status', '!=', '3')
    ->where( function($q3){
       $q3->whereNotIn('payment_status',['3','2']);
    })
    ->whereHas('order', function ($query) {
        $query->where(function ($q) {
            $q->where('payment_method', '3')
              ->orWhere(function ($q2) {
                  $q2->whereNotIn('payment_method',['3','2'])
                     ->where('payment_status', '1');
              });
        });
    });

   if($request->tabs==2){

    if (!empty($request->search)) {
    $search = $request->search;

    $ongoing_order=$ongoing_order->where(function ($q) use ($search) {
        $q->whereHas('product_details', function ($p) use ($search) {
            $p->where('name', 'LIKE', "%$search%");
        })
        ->orWhereHas('order', function ($o) use ($search) {
            $o->where('order_id', 'LIKE', "%$search%");
        });
    });
}

if (!empty($request->from_date) && !empty($request->to_date)) {
  $ongoing_order=$ongoing_order->whereBetween('created_at', [
          $request->from_date . ' 00:00:00',
        $request->to_date . ' 23:59:59'
    ]);
}
   }

 $ongoing_order=$ongoing_order->get();


    // Past Order Code 
    
   if($request->tabs==3){

    if (!empty($request->search)) {
    $search = $request->search;

    $past_order=$past_order->where(function ($q) use ($search) {
        $q->whereHas('product_details', function ($p) use ($search) {
            $p->where('name', 'LIKE', "%$search%");
        })
        ->orWhereHas('order', function ($o) use ($search) {
            $o->where('order_id', 'LIKE', "%$search%");
        });
    });
}

if (!empty($request->from_date) && !empty($request->to_date)) {
  $past_order=$past_order->whereBetween('created_at', [
          $request->from_date . ' 00:00:00',
        $request->to_date . ' 23:59:59'
    ]);
}
   }

   
$past_order = $past_order
    ->where(function ($query) {
        $query->whereIn('payment_status', [2, 3])
              ->orWhere('delivery_status', 3);
    })
    ->get();
    

$response['All_order']=$all_Order_data; // All Orders
$response['ongoing_order'] =$ongoing_order;
$response['past_order']=$past_order;




     return [
            'status'  => 'success',
            'message' => 'All Orders fetch Successfully',
            'data'    => $response
        ];
        

    }catch (\Exception $e) {
    return ['status'=>'error','message'=>$e->getMessage(),'data'=>$e->getMessage()];
    }



    
}



public function SellerSingleOrdersdata($request){

try{

   $singleOrder= orderdetail::with('order.user_details','order.delivery_details', 'product_details.category','product_details.subcategory','product_details.brand','UserRatingReviewProvide','variation_details.color','variation_details.size','exchange_new_size_data')->where('id',$request->id)->first();
   
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

// delivery Status code
public function updateSingleOrderStatus($request){

try{

   $singleOrder= orderdetail::with('order.user_details','order.delivery_details', 'product_details.category','product_details.subcategory','product_details.brand','UserRatingReviewProvide','variation_details.color','variation_details.size')->where('id',$request->id)->first();
   
   if($singleOrder){

    $singleOrder->update(['delivery_status'=> $request->status]);
    
     return [
            'status'  => 'success',
            'message' => 'Status Update Successfully',
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


// exchnage and return Status code

public function updateOrderExchangeReturnStatus($request){

try{

   $singleOrder= orderdetail::with('order.user_details','order.delivery_details', 'product_details.category','product_details.subcategory','product_details.brand','UserRatingReviewProvide','variation_details.color','variation_details.size')->where('id',$request->id)->first();
   
   if($singleOrder){

    $data=['r_e_approve'=> $request->status];

    if($request->status=='1'){

        // If Seller Accept return Code Then  Create A new order With return/ Exchange Follow 

    $cart_data=[
        "order_id"=>$singleOrder->order_id,
        "r_e_type"=> $singleOrder->return_type,
        'p_orderdetails_id'=> $singleOrder->id,
        "user_id"=>$singleOrder->user_id,
        "seller_id"=>$singleOrder->seller_id,
        "product_id"=>$singleOrder->product_id,
        "variants_id"=>$singleOrder->variants_id,
        "quantity"=>$singleOrder->quantity,
        "amount"=>$singleOrder->amount,
        "tax"=> $singleOrder->tax ,
        "shipping_fees"=>$singleOrder->shipping_fees,
        "giftcard_id"=>$singleOrder->giftcard_id,
        "giftcard_amount"=>$singleOrder->giftcard_amount,
        "promocode_value"=>$singleOrder->promocode_value,
        "exchange_new_size"=>$singleOrder->exchange_new_size,
        "exchange_old_size"=>$singleOrder->exchange_old_size,
        "payment_status"=>$singleOrder->payment_status,
    ];
    orderdetail::create($cart_data);
    
        // $data['is_picked']='0';
        // $data['assign_date']=null;
        // $data['assign_status']='0';
        // $data['delivery_boy_id']=null;
        // $data['delivery_status']='0';
    }

    $singleOrder->update($data);
    
     return [
            'status'  => 'success',
            'message' => 'Status Update Successfully',
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


public function SellerAllChatdata($request){

try{


  $check_chatRecord=allproductchats::with('product_variation.product_details','user_details','seller_details','order_create_status')->where('seller_id',$request->seller_id)->get();

   if($check_chatRecord->isNotEmpty()){
    
    foreach ($check_chatRecord as $key => $val) {

    $firbase_chat = $this->getMessages($val->unique_id);

    if (!empty($firbase_chat)) {
        // Ensure array order
        $lastMessage = end($firbase_chat);

        $val->message_type = $lastMessage['type'] ?? null;
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
            'message' => ' No records Found ',
            'data'    => []
        ];
   }


    }catch (\Exception $e) {
    return ['status'=>'error','message'=>$e->getMessage(),'data'=>$e->getMessage()];
    }



    
}



public function SellerSingleChatdata($request){

try{

    $check_chatRecord=allproductchats::with('product_variation.product_details', 'product_variation.size','product_variation.color', 'user_details','seller_details','delivery_details','order_create_status')->where('unique_id',$request->unique_id)->first();

   if($check_chatRecord){

    $chatRoom_id=$check_chatRecord->unique_id;

    $firbase_chat= $this->getMessages($chatRoom_id);

     foreach($firbase_chat as $key=>$val){
        $messageId= $key;
        
        $data=[
            "read"=>1
        ];

        $this->updateMessage($check_chatRecord->unique_id,$messageId,$data);
     }



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
            'message' => ' No records Found ',
            'data'    => []
        ];
   }


    }catch (\Exception $e) {
    return ['status'=>'error','message'=>$e->getMessage(),'data'=>$e->getMessage()];
    }    
}



public function Modifysinglechatsrecords($request){

try{

    $check_chatRecord=allproductchats::with('product_variation.product_details')->where('unique_id',$request->unique_id)->first();

   if($check_chatRecord){

    $request_data=[
        'seller_id'=>$request->seller_id,
        "unique_id"=>$request->unique_id,
        "price"=>$request->price,
        'quantity' => $request->quantity,
        "shipping"=>$request->shipping,
        "tax"=>$request->tax,
        "total_amount"=>$request->total_amount,
        "action"=>'2'
       ];
       
    $check_chatRecord->update($request_data);


     return [
            'status'  => 'success',
            'message' => 'Modify Order chat Successfully',
            'data'    => $check_chatRecord
        ];
        
    }else{

    return [
            'status'  => 'success',
            'message' => ' No records Found ',
            'data'    => []
        ];
   }


    }catch (\Exception $e) {
    return ['status'=>'error','message'=>$e->getMessage(),'data'=>$e->getMessage()];
    }    
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