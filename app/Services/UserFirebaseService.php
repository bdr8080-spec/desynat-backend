<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

use App\Models\{product,ProductVariant,allproductchats};

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
    "price"=>$price,
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