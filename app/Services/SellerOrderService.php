<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\{User,sellerBanner,Banner,Order,orderdetail,OrderDeliveryAddress};

use App\Models\{product,ProductVariant,allproductchats};


use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Illuminate\Support\Facades\DB;


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
    

   $all_Order= orderdetail::with('user_details','order.user_details','order.delivery_details', 'product_details','variation_details.color','variation_details.size','chatRoomrecords','exchange_order_details')->where('seller_id',$request->seller_id)
   ->whereHas('order', function($query) use ($request) {
    $query->where('order_type',$request->type);

   });

   $all_Order_data=clone($all_Order);
   $past_order=clone($all_Order);
    $ongoing_order=   clone($all_Order);

   
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

// apply filter Code /
  if (!empty($request->filters)) {
    switch ($request->filters) {
        case '1':
        // $all_Order_data = $all_Order_data->where('delivery_status', '2.1');
        break;
        case '2':
        // $all_Order_data = $all_Order_data->where('delivery_status', '2.1');
        break;


    case '3':
        $all_Order_data = $all_Order_data->where('delivery_status', '2.1');
        break;

    case '4':
        $all_Order_data = $all_Order_data->where('p_orderdetails_id', '!=', '0');
        break;
}

  }

   }

   $all_Order_data=$all_Order_data
   ->orderBy('id','desc')
   ->get(); // All Orders


   $ongoing_order = $ongoing_order // Ongoing order check
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


// apply filter Code /
  if (!empty($request->filters)) {
    switch ($request->filters) {
        case '1':
        // $all_Order_data = $all_Order_data->where('delivery_status', '2.1');
        break;
        case '2':
        // $all_Order_data = $all_Order_data->where('delivery_status', '2.1');
        break;


    case '3':
        $ongoing_order = $ongoing_order->where('delivery_status', '2.1');
        break;

    case '4':
        $ongoing_order = $ongoing_order->where('p_orderdetails_id', '!=', '0');
        break;
}

  }

   }

 $ongoing_order=$ongoing_order->orderBy('id','desc')
   ->get();


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



// apply filter Code /
  if (!empty($request->filters)) {
    switch ($request->filters) {
        case '1':
        // $all_Order_data = $all_Order_data->where('delivery_status', '2.1');
        break;
        case '2':
        // $all_Order_data = $all_Order_data->where('delivery_status', '2.1');
        break;


    case '3':
        $past_order = $past_order->where('delivery_status', '2.1');
        break;

    case '4':
        $past_order = $past_order->where('p_orderdetails_id', '!=', '0');
        break;
}

  }

   }

   
$past_order = $past_order
    ->where(function ($query1) {
        $query1->whereIn('payment_status', ["2", "3"])
              ->orWhere('delivery_status', "3");
    })
   ->orderBy('id','desc')
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

   $singleOrder= orderdetail::with('order.user_details','order.delivery_details', 'product_details.category','product_details.subcategory','product_details.brand','UserRatingReviewProvide','variation_details.color','variation_details.size','exchange_new_size_data','exchange_order_details','chatRoomrecords')->where('id',$request->id)->first();
   
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

       // If Seller Accept Exchnage Code Then  Create A new order With return/ Exchange Follow 

       if($singleOrder->return_type==2){
  
       $Createnew_data=[
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
        orderdetail::UpdateOrcreate($Createnew_data);

        $data['order_status']='exchange'; // when order Is exchange and create a new product 

    }else{
        
        $data['is_picked']='0';
        $data['assign_date']=null;
        $data['assign_status']='0';
        $data['delivery_boy_id']=null;
        $data['delivery_status']='1';

        $data['order_status']='return'; // for when Order is return 

    }
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

  $check_chatRecord=allproductchats::with('product_variation.product_details','user_details','seller_details','order_create_status')->where('seller_id',$request->seller_id);
  
    if(isset($request->filters) && $request->filters ){

        if($request->filters=='2'){ 
            $check_chatRecord=$check_chatRecord->where('product_request','1')->where('action','0');
        }elseif($request->filters=='3'){ // send 
            $check_chatRecord=$check_chatRecord->where('product_request','1')->whereIn('action',['1','2']);
        }elseif($request->filters=='4'){
            $check_chatRecord=$check_chatRecord->where('product_request','1')->whereIn('action',['5']);
        }elseif($request->filters=='5'){ // rejectced   
            $check_chatRecord=$check_chatRecord->where('product_request','1')->whereIn('action',['4']);
        }


    }
    
   $check_chatRecord=$check_chatRecord->orderBy('id','desc')->get();




   if($check_chatRecord->isNotEmpty()){
    
    foreach ($check_chatRecord as $key => $val) {

    $firbase_chat = $this->getMessages($val->unique_id);

    if (!empty($firbase_chat)) {
        // Ensure array order
        $lastMessage = end($firbase_chat);

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

    $check_chatRecord=allproductchats::with('product_variation.product_details', 'product_variation.size','product_variation.color', 'user_details','seller_details','delivery_details')->where('unique_id',$request->unique_id)->first();

   if($check_chatRecord){

    $chatRoom_id=$check_chatRecord->unique_id;
    $check_order=orderdetail::with('order.delivery_details')
      ->where('unique_id',$check_chatRecord->unique_id)
        ->orderCreateStatus()
        ->first();
    $check_chatRecord->order_create_status=$check_order;

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

    $action= isset($request->action)?$request->action:"2";


    $request_data=[
        'seller_id'=>$request->seller_id,
        "unique_id"=>$request->unique_id,
        "price"=>$request->price,
        'quantity' => $request->quantity,
        "shipping"=>$request->shipping,
        "tax"=>$request->tax,
        "total_amount"=>$request->total_amount,
        "product_request"=>'1',
        "action"=> $action
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


public function GetChatDataUsingChatRoomId($request){

try{

    $lastMessageId_data = $request->lastId ?? null;
    
    $chatRoom_id=$request->unique_id;

    $lastMessageId='';

    // $firbase_chat= $this->getMessages($chatRoom_id);
    $firbase_chat= $this->getMessagesAfter($chatRoom_id,$lastMessageId_data);

     foreach($firbase_chat as $key=>$val){
        $messageId= $key;
        
        $data=[
            "read"=>1
        ];

        $this->updateMessage($chatRoom_id,$messageId,$data);  
        $lastMessageId=$messageId;// last message id send
     }     

     if(empty($lastMessageId)){
        $lastMessageId=$lastMessageId_data;

     }

     $firbase_chat = (array) $firbase_chat;
     
     $response['firbase_chat']=$firbase_chat;
     $response['lastMessageId']=$lastMessageId;
     
     return [
            'status'  => 'success',
            'message' => 'Firebase Chat records fetch Successfully',
            'data'    => $response
        ];



    }catch (\Exception $e) {
    return ['status'=>'error','message'=>$e->getMessage(),'data'=>$e->getMessage()];
    }    
}


public function getMessagesAfter($chatRoomId, $lastMessageId = null)
{
    $ref = $this->database
        ->getReference("chats/{$chatRoomId}")
        ->orderByKey();

    if ($lastMessageId) {
        $ref = $ref->startAfter($lastMessageId);
    }

    return $ref->getValue();
}

// public function GetRefundOrders($request){

//         try{
//             $limit = isset($request->limit) ? (int)$request->limit : null;

//             DB::beginTransaction();

//             $checkOrder = orderdetail::with([
//                 'order.delivery_details',
//                 'order.giftCard_details',
//                 'order.promocode_details',
                
//                 'product_details.brand',
//                 'product_details.category',
//                 'product_details.subcategory',
//                 'product_details.seller_details',
//                 'product_details.store',
//                 'variation_details.color',
//                 'variation_details.size',
//                 'UserRatingReviewProvide',
//                 'driver_details.zone_info'
//             ])
//             ->where('payment_status', '3')
//             ->where('seller_id', $request->seller_id);

            
//             if ($request->search) {
//                 $checkOrder->where(function ($query) use ($request) {
//                     // Search in order_id
//                     $query->whereHas('order', function ($q) use ($request) {
//                         $q->where('order_id', 'like', '%' . $request->search . '%');
//                     })
//                     // Search in seller's first_name or last_name
//                     ->orWhereHas('product_details.seller_details', function ($q) use ($request) {
//                         $q->where('first_name', 'like', '%' . $request->search . '%')
//                         ->orWhere('last_name', 'like', '%' . $request->search . '%');
//                     });
//                 });
//             }

//             if ($request->country_name) {
//                 $checkOrder->whereHas('order.delivery_details', function ($q) use ($request) {
//                     $q->where('country_name', 'like', '%' . $request->country_name . '%');
//                 });
//             }

//             if (!empty($request->from_date) && !empty($request->to_date)) {
//                 $checkOrder->whereHas('order', function ($q) use ($request) {
//                     $q->whereBetween('created_at', [
//                         $request->from_date . ' 00:00:00',
//                         $request->to_date . ' 23:59:59'
//                     ]);
//                 });

//             } elseif (!empty($request->from_date)) {

//                 $checkOrder->whereHas('order', function ($q) use ($request) {
//                     $q->whereDate('created_at', '>=', $request->from_date);
//                 });

//             } elseif (!empty($request->to_date)) {

//                 $checkOrder->whereHas('order', function ($q) use ($request) {
//                     $q->whereDate('created_at', '<=', $request->to_date);
//                 });
//             }


//             $checkOrder = $checkOrder->orderBy('id', 'desc')->paginate($limit);

//             DB::commit();

//             return ['status'=>'success','message'=>"Refund Orders fetched Successfully",'data'=>$checkOrder];

        
//         } catch (\Exception $e) {
//             return [
//                 'status' => 'error',
//                 'message' => 'Failed to fetch active orders: ' . $e->getMessage(),
//                 'data' => []
//             ];
//         }

// }

public function GetRefundOrders($request)
{
    try {
        $limit = isset($request->limit) ? (int)$request->limit : null;

        DB::beginTransaction();

        $checkOrder = orderdetail::with([
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
            'UserRatingReviewProvide',
            'driver_details.zone_info'
        ])
        ->where('payment_status', '3')
        ->where('seller_id', $request->seller_id);

        // 🔍 Search filter
        if ($request->search) {
            $checkOrder->where(function ($query) use ($request) {
                $query->whereHas('order', function ($q) use ($request) {
                    $q->where('order_id', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('product_details.seller_details', function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->search . '%')
                      ->orWhere('last_name', 'like', '%' . $request->search . '%');
                });
            });
        }

        // 🌍 Country filter
        if ($request->country_name) {
            $checkOrder->whereHas('order.delivery_details', function ($q) use ($request) {
                $q->where('country_name', 'like', '%' . $request->country_name . '%');
            });
        }

        // 📅 Date filters
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $checkOrder->whereHas('order', function ($q) use ($request) {
                $q->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            });

        } elseif (!empty($request->from_date)) {

            $checkOrder->whereHas('order', function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            });

        } elseif (!empty($request->to_date)) {

            $checkOrder->whereHas('order', function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            });
        }

        // ✅ Clone query BEFORE pagination for total calculation
        $totalRefundQuery = clone $checkOrder;

        // 💰 Calculate total refunds (change 'amount' to your actual column)
        $total_refunds = $totalRefundQuery->sum('amount');

        // 📄 Paginate results
        $checkOrder = $checkOrder->orderBy('id', 'desc')->paginate($limit);

        DB::commit();

        return [
            'status' => 'success',
            'message' => "Refund Orders fetched Successfully",
            'data' => [
                'orders' => $checkOrder,
                'total_refunds' => $total_refunds
            ]
        ];

    } catch (\Exception $e) {
        DB::rollBack();

        return [
            'status' => 'error',
            'message' => 'Failed to fetch active orders: ' . $e->getMessage(),
            'data' => []
        ];
    }
}





}