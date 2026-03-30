<?php
namespace App\Services;


use App\Models\Content;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\User;
use App\Models\seller;
use App\Models\AffilatedUser;
use App\Models\DeliveryBoy;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Http;
use App\Helpers\support;


class SellerNotificationService
{
   

    public function GetMyNotificationList($request_data)
    {
        try {
            $receiver_id = $request_data->receiver_id;
            $receiver_type = $request_data->receiver_type;
            $limit         = isset($request_data->limit) ? (int) $request_data->limit : 10; // ensure integer

            $notifications = Notification::where('receiver_id', $receiver_id)
                ->where('receiver_type', $receiver_type)
                ->orderBy('id', 'desc')
                ->paginate($limit);

            if ($notifications->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No notifications found',
                    'data' => (object)[]
                ];
            }

            // Append receiver_details to each notification
            $notifications->map(function($notification) {
                $notification->receiver_details = $notification->receiver_details;
                $notification->sender_details = $notification->sender_details;
                return $notification;
            });

            return [
                'status' => 'success',
                'message' => 'Notifications fetched successfully',
                'data' => $notifications
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch notifications: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function markNotificationsAsRead($request_data)
    {
        try {
           // dd(123);
            $notification_ids = $request_data->notification_id;

            $updated = Notification::whereIn('id', $notification_ids)
                      ->update(['is_read' => '1']);

            if ($updated === 0) {
                return [
                    'status' => 'success',
                    'message' => 'No notifications found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Notifications marked as read successfully',
                'data' => [
                    'marked_notification_ids' => $notification_ids
                ]
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to mark notifications as read: '.$e->getMessage(),
                'data' => []
            ];
        }
    }

    public function markAllNotificationsAsRead($request_data)
    {
        try {

            $receiver_type = $request_data->receiver_type;

            $query = Notification::where('receiver_type', $receiver_type)
                ->where('is_read', '0');

            if (!$query->exists()) {
                return [
                    'status' => 'success',
                    'message' => 'No notifications found',
                    'data' => (object)[]
                ];
            }

            $query->update(['is_read' => '1']);

            $updatedNotifications = Notification::where('receiver_type', $receiver_type)
                ->where('is_read', '1')
                ->get();

            return [
                'status' => 'success',
                'message' => 'Notifications marked as read successfully',
                'data' => $updatedNotifications
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to mark notifications as read: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function driverMarkAllNotificationsAsRead($request_data)
    {
        try {

            $receiver_id   = $request_data->receiver_id;
            $receiver_type = $request_data->receiver_type;

            $query = Notification::where('receiver_id', $receiver_id)
                ->where('receiver_type', $receiver_type)
                ->where('is_read', '0');

            if (!$query->exists()) {
                return [
                    'status' => 'success',
                    'message' => 'No notifications found',
                    'data' => (object)[]
                ];
            }

            $query->update(['is_read' => '1']);

            $updatedNotifications = Notification::where('receiver_id', $receiver_id)
                ->where('receiver_type', $receiver_type)
                ->where('is_read', '1')
                ->get();

            return [
                'status' => 'success',
                'message' => 'Notifications marked as read successfully',
                'data' => $updatedNotifications
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to mark notifications as read: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function GetNotificationCountSeller($request_data)
    {
        try {
            $receiver_id = $request_data->receiver_id;
            $receiver_type = $request_data->receiver_type;

            $notificationCount = Notification::where('receiver_id', $receiver_id)
                ->where('receiver_type', $receiver_type)
                ->where('is_read', '0')
                ->count();

            return [
                'status' => 'success',
                'message' => 'Notification Count fetched successfully',
                'data' => $notificationCount
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch notifications: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }
        







    // user Code 

    

     public function getUserNotifications($request_data)
    {
        try {

           
            $AllNotification = Notification::where('receiver_type','2')
                ->where('receiver_id', $request_data->user_id )
                ->orderBy('id', 'desc')
                ->get();
           
            return [
                'status' => 'success',
                'message' => 'Notifications fetch successfully',
                'data' => $AllNotification
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to mark notifications as read: '.$e->getMessage(),
                'data' => []
            ];
        }
    }


    public function ReaduserNotification($request_data)
    {
        try {
           // dd(123);
            $notification_ids = $request_data->notification_id;

            $updated = Notification::where('id', $notification_ids)
                      ->update(['is_read' => '1']);

            return [
                'status' => 'success',
                'message' => 'Notifications marked as read successfully',
                'data' => $updated
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to mark notifications as read: '.$e->getMessage(),
                'data' => []
            ];
        }
    }


    

    



}
    