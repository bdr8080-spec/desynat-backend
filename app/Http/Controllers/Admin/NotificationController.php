<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\NotificationManagementService;
use App\Services\UserManagementService;
use App\Services\AffiliatedUserManagementService;
use App\Services\SellerManagementService;
use App\Services\DeliveryBoyManagementService;
use Illuminate\Support\Facades\Auth;


use Validator;

class NotificationController extends Controller
{

    public function __construct(NotificationManagementService $NotificationManagementService,UserManagementService $UserManagementService,AffiliatedUserManagementService $AffiliatedUserManagementService,SellerManagementService $SellerManagementService,DeliveryBoyManagementService $DeliveryBoyManagementService){

        $this->NotificationManagementService=$NotificationManagementService;
        $this->UserManagementService=$UserManagementService;
        $this->AffiliatedUserManagementService=$AffiliatedUserManagementService;
        $this->SellerManagementService=$SellerManagementService;
        $this->DeliveryBoyManagementService=$DeliveryBoyManagementService;

    }

    public function notificationManagement(Request $request){

           $admin = Auth::guard('admin')->user();
           $receiverId = $admin->id;
           //dd($receiverId);
        $request_data = (object)[
                'receiver_id'    => $receiverId,
                'receiver_type'      => '1',
                'limit'      => $request->limit??10,
            ];

            $myNotifications = $this->NotificationManagementService->GetMyNotificationList($request_data)['data'];
            //dd($myNotifications);
        $request_data1 = (object)[
                'sender_id'    => $receiverId,
                'sender_type'      => '1',
                'from_date'      => $request->from_date??null,
                'to_date'      => $request->to_date??null,
            ];

            $sentNotifications = $this->NotificationManagementService->GetSendNotificationListWeb($request_data1)['data'];
           // dd($sentNotifications);
            foreach ($sentNotifications as &$notification) {
                $notification['created_at_formatted'] = \Carbon\Carbon::parse($notification['created_at'])->format('d/m/y \a\t h:i A');
            }

            if ($request->ajax()) {
                return response()->json(['sentNotifications' => $sentNotifications]);
            }
        return view('admin.notification.notification',compact('myNotifications','sentNotifications'));
    }

    public function sendNotification(Request $request){
        $users = $this->UserManagementService->getUsers($request)['data'];
        $affiliateUsers = $this->AffiliatedUserManagementService->getApprovedAffiliatedUers($request)['data'];
        $sellers = $this->SellerManagementService->getApprovedSellers($request)['data'];
        $deliveryBoys = $this->DeliveryBoyManagementService->getDeliveryBoys($request)['data'];
       // dd(123);
        return view('admin.notification.notification-send',compact('users','affiliateUsers','sellers','deliveryBoys'));
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
            $senderId = Auth::guard('admin')->user()->id;
            //sdd($senderId);

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
            //dd($request_data);

            $data = $this->NotificationManagementService->SendNotification($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
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

            $data = $this->NotificationManagementService->markAllNotificationsAsRead($request_data);

            if ($data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: '.$e->getMessage(), [], 500);
        }
    }














    

    


      






}
