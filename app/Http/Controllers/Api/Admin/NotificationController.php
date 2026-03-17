<?php

namespace App\Http\Controllers\Api\Admin;

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

    public function send_notification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_english'   => 'required',
            'title_arabic'   => 'required',

            'description_english'   => 'required',
            'description_arabic'   => 'required',
            
            'user_id' => 'nullable|array',
            'user_id.*' => 'string',

            'seller_id' => 'nullable|array',
            'seller_id.*' => 'string',

            'affiliate_id' => 'nullable|array',
            'affiliate_id.*' => 'string',

            'driver_id' => 'nullable|array',
            'driver_id.*' => 'string',

            'sender_type' => 'required|in:1,2,3,4,5',
        ]);

        if ($validator->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validator->errors()->first(), 400);
        }

        if (!$request->user_id && !$request->seller_id && !$request->affiliate_id) {
            return ApiResponse::generateResponse('error', 'Please provide at least one receiver', [], 400);
        }

        try {
            $senderId = auth()->id();
            //dd($senderId);

            $request_data = (object)[
                'sender_id'    => $senderId,
                'user_id'      => $request->user_id,
                'seller_id'    => $request->seller_id,
                'affiliate_id' => $request->affiliate_id,
                'driver_id' => $request->driver_id,
                'description_english'      => $request->description_english,
                'description_arabic'      => $request->description_arabic,
                'title_english'      => $request->title_english,
                'title_arabic'      => $request->title_arabic,
                'sender_type'      => $request->sender_type,
            ];

            $data = $this->NotificationManagementService->SendNotification($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_send_notifications_list(Request $request)
    {

        try {
            $senderId = auth()->id();
            //dd($senderId);

            $request_data = (object)[
                'sender_id'    => $senderId,
                'sender_type'      => '1',
                'search'      => $request->search??null,
                'from_date'      => $request->from_date??null,
                'to_date'      => $request->to_date??null,
                'limit'      => $request->limit??10,
            ];

            $data = $this->NotificationManagementService->GetSendNotificationList($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_my_notifications_list(Request $request)
    {

        try {
            $receiverId = auth()->id();
            //dd($senderId);

            $request_data = (object)[
                'receiver_id'    => $receiverId,
                'receiver_type'      => '1',
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














    

    


      






}
