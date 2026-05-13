<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;

use App\Services\SellerOrderService;
use App\Services\SellerNotificationService;

use Validator;

use Auth;


class SellerChatController extends Controller
{

    public function __construct(SellerOrderService $SellerOrderService, SellerNotificationService $SellerNotificationService){
        $this->SellerOrderService=$SellerOrderService;
        $this->SellerNotificationService=$SellerNotificationService;
    }

    


    public function All_chats(Request $request){

    
        // $seller_details=Auth::guard('seller')->user()->id;

        $seller_details=sellerAndStaffId();


       $request_data=(object) [
        'seller_id'=>$seller_details,
        "filters"=>$request->filters
       ];

       $data= $this->SellerOrderService->SellerAllChatdata($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

        $all_chats=$data['data'];

        return view('dealer.chatmgt.chatlist',compact('all_chats'));
        
    }


    public function single_chat_room(Request $request, $id){
    
        // $seller_details=Auth::guard('seller')->user()->id;

       $seller_details=sellerAndStaffId();

       $request_data=(object) [
        'seller_id'=>$seller_details,
        "unique_id"=>$id
       ];

       $data= $this->SellerOrderService->SellerSingleChatdata($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

        $single_chats=$data['data'];

        return view('dealer.chatmgt.chatinfo',compact('single_chats'));
            
    }





    public function singleChatsRecords(Request $request){

        $validate = Validator::make($request->all(), [
        'unique_id' => 'required|exists:allproductchats,unique_id', // 1 Normal Order  2 custom Order 
        ]);
            
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }


        //  $seller_details=Auth::guard('seller')->user()->id;


   $seller_details=sellerAndStaffId();


       $request_data=(object) [
        'seller_id'=>$seller_details,
        "unique_id"=>$request->unique_id
       ];

       $data= $this->SellerOrderService->SellerSingleChatdata($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);   
    
}

    public function Modify_custom_order_price(Request $request){
        
          $validate = Validator::make($request->all(), [
            'unique_id' => 'required|exists:allproductchats,unique_id',
            "price"=>"required",
            'quantity' => 'required',
            // "shipping"=>'required',
            // "tax"=>'required',
            "total_amount"=>"required",
        ],[
        'unique_id.required' => __('seller_messages.unique_id_required'),
        'unique_id.exists' => __('seller_messages.unique_id_exists'),
        'price.required' => __('seller_messages.price_required'),
        'quantity.required' => __('seller_messages.quantity_required'),
        'total_amount.required' => __('seller_messages.total_amount_required'),
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
       }

    //    $seller_details=Auth::guard('seller')->user()->id;

       $seller_details=sellerAndStaffId();
       
       $request_data=(object) [
        'seller_id'=>$seller_details,
        "unique_id"=>$request->unique_id,
        "price"=>$request->price,
        'quantity' => $request->quantity,
        "shipping"=>$request->shipping,
        "tax"=>$request->tax,
        "total_amount"=>$request->total_amount,
        "action"=>$request->action??null
       ];

       $data= $this->SellerOrderService->Modifysinglechatsrecords($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
        
    }

   public function loadChat(Request $request)
{
    
    $lastId = $request->last_id;

       $request_data=(object) [
        "unique_id"=>$request->unique_id,
        "lastId"=>$lastId
           ];

       $data= $this->SellerOrderService->GetChatDataUsingChatRoomId($request_data);
       
       $messages=$data['data'];

    return response()->json([
        'status' => 'success',
        'data' => $messages
        
        // ->map(function ($chat) {
            // return [
                // 'id'      => $chat->id,
                // 'by'      => $chat->by,
                // 'message' => $chat->message,
                // 'image'   => $chat->image_url,
                // 'time'    => formatChatTime($chat->times)
            // ];
        // })
    ]);
}

    public function mark_all_chat_msg_as_read(Request $request)
    {
        try {

            $seller_details=Auth::guard('seller')->user()->id;

            $chatData = (object)[
                'user_id'   => $seller_details,
                'unique_id' => $request->unique_id,
            ];

            $data = $this->SellerOrderService->mark_all_chat_msg_as_read($chatData);


            return response()->json([
                'status'    => 'success',
                'message' => $data['message'],
                'data' => $data
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to send message',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function chat_unread_count(Request $request)
    {
        try {

            $seller_details=Auth::guard('seller')->user()->id;

            $chatData = (object)[
                'receiver_id'   => $seller_details,
                'receiver_type' => 3,
            ];

            $data = $this->SellerNotificationService->GetNotificationCountSeller($chatData);


            return response()->json([
                'status'    => 'success',
                'message' => $data['message'],
                'data'    => $data['data'] 
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to send message',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    


}