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


class NotificationManagementService
{
   
     public function sendNotification($request_data)
    {
        try {

            $sender_id = $request_data->sender_id;
            $description_english = $request_data->description_english;
            $description_arabic = $request_data->description_arabic;
            $sender_type = $request_data->sender_type;
            $title_english = $request_data->title_english ?? null;
            $title_arabic = $request_data->title_arabic ?? null;
            $notification_type = $request_data->notification_type ?? null;

            $receivers = [];

            if (!empty($request_data->user_id)) {
                foreach ($request_data->user_id as $id) {
                    $receivers[] = [
                        'id' => $id,
                        'type' => '2'
                    ];
                }
            }

            if (!empty($request_data->seller_id)) {
                foreach ($request_data->seller_id as $id) {
                    $receivers[] = [
                        'id' => $id,
                        'type' => '3' 
                    ];
                }
            }

            if (!empty($request_data->affiliate_id)) {
                foreach ($request_data->affiliate_id as $id) {
                    $receivers[] = [
                        'id' => $id,
                        'type' => '4' 
                    ];
                }
            }
            if (!empty($request_data->driver_id)) {
                foreach ($request_data->driver_id as $id) {
                    $receivers[] = [
                        'id' => $id,
                        'type' => '5' 
                    ];
                }
            }

            if (empty($receivers)) {
                return [
                    'status' => 'error',
                    'message' => 'No receivers provided',
                    'data' => (object)[]
                ];
            }

            $allNotifications = []; 

            foreach ($receivers as $receiver) {

                $notification = Notification::create([
                    'sender_id' => $sender_id,
                    'sender_type' => $sender_type,
                    'receiver_id' => $receiver['id'],
                    'receiver_type' => $receiver['type'],
                    'title_english' => $title_english,
                    'title_arabic' => $title_arabic,
                    'description_english' => $description_english,
                    'description_arabic' => $description_arabic,
                    'notification_type' => $notification_type
                ]);

                $allNotifications[] = $notification;

                $token = $this->getDeviceToken($receiver['id'], $receiver['type']);
               // dd($token);

                if($token) {
                    sendPushNotification(
                        [$token],
                        $title_english,
                        $description_english,
                        $notification_type,
                        $sender_id,
                        $receiver['id'],
                        $receiver['type']
                    );
                }
            }

            return [
                'status' => 'success',
                'message' => 'Notification sent successfully',
                'data' => $allNotifications
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to send notification: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }

    private function getDeviceToken($receiver_id, $receiver_type)
    { 
        $receiver_type = (int)$receiver_type;
        switch ($receiver_type) {
            case 2: // User
                return User::where('id', $receiver_id)->value('fcm_token');
            case 3: // seller
                return seller::where('id', $receiver_id)->value('fcm_token');
            case 4: // AffilatedUser
                return AffilatedUser::where('id', $receiver_id)->value('fcm_token');
            case 1: // Admin
                return Admin::where('id', $receiver_id)->value('fcm_token');
            case 5: // Driver
                return DeliveryBoy::where('id', $receiver_id)->value('fcm_token');
            default:
                return null;
        }
    }
    

    public function GetSendNotificationList($request_data)
    {
        try {
            $sender_id = $request_data->sender_id;
            $sender_type = $request_data->sender_type;

            $notifications = Notification::where('sender_id', $sender_id)
                ->where('sender_type', $sender_type)
                ->orderBy('id', 'desc')
                ->get();

            if ($notifications->isEmpty()) {
                return [
                    'status' => 'error',
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

    public function GetMyNotificationList($request_data)
    {
        try {
            $receiver_id = $request_data->receiver_id;
            $receiver_type = $request_data->receiver_type;

            $notifications = Notification::where('receiver_id', $receiver_id)
                ->where('receiver_type', $receiver_type)
                ->orderBy('id', 'desc')
                ->get();

            if ($notifications->isEmpty()) {
                return [
                    'status' => 'error',
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
                    'status' => 'error',
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
    





}
    