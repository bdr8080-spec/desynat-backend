<?php

namespace App\Http\Controllers\Api\DeliveryBoy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\NotificationManagementService;


use Validator;

class NotificationController extends Controller
{

    public function __construct(NotificationManagementService $NotificationManagementService){

        $this->NotificationManagementService=$NotificationManagementService;

    }


    public function get_notifications_list(Request $request)
    {

        try {
            $receiverId = auth()->id();
            //dd($senderId);

            $request_data = (object)[
                'receiver_id'    => $receiverId,
                'receiver_type'      => '5',
                'limit'      => $request->limit??10,
            ];

            $data = $this->NotificationManagementService->GetMyNotificationList($request_data);

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

            $data = $this->NotificationManagementService->markNotificationsAsRead($request_data);

            if ($data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: '.$e->getMessage(), [], 500);
        }
    }

    public function driver_mark_all_notification_as_read(Request $request)
    {

        try {
            $receiverId = auth()->id();

            $request_data = (object)[
                'receiver_id' => $receiverId,
                'receiver_type' => '5',
            ];

            $data = $this->NotificationManagementService->driverMarkAllNotificationsAsRead($request_data);

            if ($data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: '.$e->getMessage(), [], 500);
        }
    }

    public function get_notifications_count(Request $request)
    {

        try {
            $receiverId = auth()->id();
            //dd($senderId);

            $request_data = (object)[
                'receiver_id'    => $receiverId,
                'receiver_type'      => '5',
            ];

            $data = $this->NotificationManagementService->GetDriverNotificationCount($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }














    

    


      






}
