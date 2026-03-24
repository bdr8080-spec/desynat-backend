<?php

namespace App\Http\Controllers\Seller;

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














    

    


      






}
