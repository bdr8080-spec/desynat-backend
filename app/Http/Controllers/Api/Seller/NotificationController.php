<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\SellerNotificationService;


use Validator;

class NotificationController extends Controller
{

    public function __construct(SellerNotificationService $SellerNotificationService){

        $this->SellerNotificationService=$SellerNotificationService;

    }


    public function get_my_notifications_list(Request $request)
    {

        try {
            $receiverId = auth()->id();
           // dd($receiverId);

            $request_data = (object)[
                'receiver_id'    => $receiverId,
                'receiver_type'      => '3',
                'limit' =>$request->limit??10,
            ];

            $data = $this->SellerNotificationService->GetMyNotificationList($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function mark_notification_as_read(Request $request)
    {
        //dd(123);
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required|array',
            'notification_id.*' => 'required|integer|exists:notifications,id',
        ]);

        if ($validator->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validator->errors()->first(), 400);
        }

        try {

            $request_data = (object)[
                'notification_id' => $request->notification_id,
            ];

            $data = $this->SellerNotificationService->markNotificationsAsRead($request_data);

            if ($data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: '.$e->getMessage(), [], 500);
        }
    }

    public function mark_all_notification_as_read(Request $request)
    {
        //dd(123);
        $validator = Validator::make($request->all(), [
            'receiver_type' => 'required|in:1,2,3,4,5',
        ]);

        if ($validator->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validator->errors()->first(), 400);
        }

        try {

            $request_data = (object)[
                'receiver_type' => $request->receiver_type,
            ];

            $data = $this->SellerNotificationService->markAllNotificationsAsRead($request_data);

            if ($data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: '.$e->getMessage(), [], 500);
        }
    }

    public function get_seller_notifications_count(Request $request)
    {

        try {
            $receiverId = auth()->id();
            //dd($senderId);

            $request_data = (object)[
                'receiver_id'    => $receiverId,
                'receiver_type'      => '3',
            ];

            $data = $this->SellerNotificationService->GetNotificationCountSeller($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function notification_on_off(Request $request){

        try{

        $user_id= auth()->id();
       
       $request_data=(object)[
        'user_id'=>$user_id,
       ];

    $data=$this->SellerNotificationService->SellerNotificationOnOff($request_data);


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }catch(exception $e){
        return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
    }

}

    public function app_notification_on_off(Request $request){

        try{

        $user_id= auth()->id();
       
       $request_data=(object)[
        'user_id'=>$user_id,
       ];

    $data=$this->SellerNotificationService->SellerAppNotificationOnOff($request_data);


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }catch(exception $e){
        return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
    }

}

    public function mark_all_order_notification(Request $request)
    {

        try {
            $sellerId = auth()->id();
            //dd($senderId);

            $request_data = (object)[
                'receiver_id'    => $sellerId,
                'receiver_type'      => '3',
            ];

            $data = $this->SellerNotificationService->MarkAllOrderNotification($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function order_notification_unread_count(Request $request)
    {

        try {
            $sellerId = auth()->id();
            //dd($senderId);

            $request_data = (object)[
                'receiver_id'    => $sellerId,
                'receiver_type'      => '3',
            ];

            $data = $this->SellerNotificationService->OrderNotificationCount($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }














    

    


      






}
