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
                    // sendPushNotification(
                    //     [$token],
                    //     $title_english,
                    //     $description_english,
                    //     $notification_type,
                    //     $sender_id,
                    //     $receiver['id'],
                    //     $receiver['type']
                    // );
                    sendPushNotificationNew(
                        [$token],
                        $title_english,
                        $description_english,

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

            $limit       = (int)($request_data->limit ?? 10); 
            $sender_id   = $request_data->sender_id;
            $sender_type = $request_data->sender_type;
            $search      = strtolower(trim($request_data->search ?? ''));

            $query = Notification::where('sender_id', $sender_id)
                ->where('sender_type', $sender_type);

            if (!empty($request_data->from_date) && !empty($request_data->to_date)) {

                $query->whereBetween('created_at', [
                    $request_data->from_date . ' 00:00:00',
                    $request_data->to_date . ' 23:59:59'
                ]);

            } elseif (!empty($request_data->from_date)) {

                $query->whereDate('created_at', '>=', $request_data->from_date);

            } elseif (!empty($request_data->to_date)) {

                $query->whereDate('created_at', '<=', $request_data->to_date);
            }

            $notifications = $query->orderBy('id', 'desc')->get();

            if ($notifications->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No notifications found',
                    'data' => (object)[]
                ];
            }

            //  Group notifications
            $grouped = $notifications->groupBy(function ($item) {
                return md5(
                    $item->title_english .
                    $item->description_english .
                    $item->sender_id .
                    $item->sender_type
                );
            });

            $finalData = [];

            foreach ($grouped as $group) {

                $first = $group->first();

                //  Collect receivers
                $receivers = collect($group)->map(function ($notification) {

                    if (!$notification->receiver_details) {
                        return null;
                    }

                    $receiver = $notification->receiver_details;

                    $receiver->receiver_type = $notification->receiver_type;
                    $receiver->receiver_id   = $notification->receiver_id;

                    return $receiver;

                })
                ->filter()
                ->values()
                ->all();

                //  Search filter
                if (!empty($search)) {

                    $matchFound = false;

                    foreach ($receivers as $receiver) {

                        $name = strtolower(
                            $receiver->full_name ??
                            $receiver->full_name_english ??
                            trim(($receiver->first_name ?? '') . ' ' . ($receiver->last_name ?? ''))
                        );

                        if (strpos($name, $search) !== false) {
                            $matchFound = true;
                            break;
                        }
                    }

                    $title = strtolower($first->title_english ?? '');

                    if (!$matchFound && strpos($title, $search) === false) {
                        continue;
                    }
                }

                $finalData[] = [
                    'id'                  => $first->id,
                    'sender_id'           => $first->sender_id,
                    'sender_type'         => $first->sender_type,
                    'title_english'       => $first->title_english,
                    'title_arabic'        => $first->title_arabic,
                    'description_english' => $first->description_english,
                    'description_arabic'  => $first->description_arabic,
                    'created_at'          => $first->created_at,
                    'total_receivers'     => max(count($receivers) - 1, 0),

                    'sender_details'      => $first->sender_details,
                    'receiver_details'    => $receivers,
                ];
            }

            // Pagination
            $page    = (int)request()->get('page', 1);
            $perPage = $limit;

            $pagedData = collect($finalData)
                ->forPage($page, $perPage)
                ->values();

            return [
                'status' => 'success',
                'message' => 'Notifications fetched successfully',
                'data' => [
                    'current_page' => $page,
                    'data'         => $pagedData,
                    'total'        => count($finalData),
                    'per_page'     => $perPage,
                    'last_page'    => ceil(count($finalData) / $perPage),
                ]
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to fetch notifications: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function GetSendNotificationListWeb($request_data)
    {
        try {

            $sender_id   = $request_data->sender_id;
            $sender_type = $request_data->sender_type;
            $search      = strtolower(trim($request_data->search ?? ''));

            $query = Notification::where('sender_id', $sender_id)
                ->where('sender_type', $sender_type);

            // Date filters
            if (!empty($request_data->from_date) && !empty($request_data->to_date)) {

                $query->whereBetween('created_at', [
                    $request_data->from_date . ' 00:00:00',
                    $request_data->to_date . ' 23:59:59'
                ]);

            } elseif (!empty($request_data->from_date)) {

                $query->whereDate('created_at', '>=', $request_data->from_date);

            } elseif (!empty($request_data->to_date)) {

                $query->whereDate('created_at', '<=', $request_data->to_date);
            }

            $notifications = $query->orderBy('id', 'desc')->get();

            if ($notifications->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No notifications found',
                    'data' => []
                ];
            }

            // Group notifications
            $grouped = $notifications->groupBy(function ($item) {
                return md5(
                    $item->title_english .
                    $item->description_english .
                    $item->sender_id .
                    $item->sender_type
                );
            });

            $finalData = [];

            foreach ($grouped as $group) {

                $first = $group->first();

                // Collect receivers
                // $receivers = collect($group)->map(function ($notification) {

                //     if (!$notification->receiver_details) {
                //         return null;
                //     }

                //     $receiver = $notification->receiver_details;

                //     $receiver->receiver_type = $notification->receiver_type;
                //     $receiver->receiver_id   = $notification->receiver_id;

                //     return $receiver;

                // })->filter()->values()->all();
                $receivers = collect($group)->map(function ($notification) {

                $fullName = $notification->receiver_details?->full_name
                            ?? $notification->receiver_details?->full_name_english
                            ?? trim(($notification->receiver_details?->first_name ?? '') . ' ' . ($notification->receiver_details?->last_name ?? ''))
                            ?? 'N/A';

                $typeName = match($notification->receiver_type) {
                    2 => 'user',
                    3 => 'seller',
                    4 => 'affilateduser',
                    5 => 'deliveryboy',
                    default => 'unknown',
                };

                return [
                    'receiver_id' => $notification->receiver_id,
                    'full_name'   => $fullName,
                    'type_name'   => $typeName,
                ];

            })->filter()->values()->all();

                // Search filter
                if (!empty($search)) {

                    $matchFound = false;

                    foreach ($receivers as $receiver) {

                        $name = strtolower(
                            $receiver->full_name ??
                            $receiver->full_name_english ??
                            trim(($receiver->first_name ?? '') . ' ' . ($receiver->last_name ?? ''))
                        );

                        if (strpos($name, $search) !== false) {
                            $matchFound = true;
                            break;
                        }
                    }

                    $title = strtolower($first->title_english ?? '');

                    if (!$matchFound && strpos($title, $search) === false) {
                        continue;
                    }
                }

                $finalData[] = [
                    'id'                  => $first->id,
                    'sender_id'           => $first->sender_id,
                    'sender_type'         => $first->sender_type,
                    'title_english'       => $first->title_english,
                    'title_arabic'        => $first->title_arabic,
                    'description_english' => $first->description_english,
                    'description_arabic'  => $first->description_arabic,
                    'created_at'          => $first->created_at,
                    'total_receivers'     => max(count($receivers) - 1, 0),

                    'sender_details'      => $first->sender_details,
                    'receiver_details'    => $receivers,
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Notifications fetched successfully',
                'data' => $finalData
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
        







    // user Code 

    

     public function getUserNotifications($request_data)
    {
        try {

        $limit       = (int)($request_data->limit ?? 10); 

           
            $AllNotification = Notification::where('receiver_type','2')
                ->where('receiver_id', $request_data->user_id )
                ->paginate($limit);
           
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


     public function CountgetUserNotifications($request_data)
    {
        try {

        $limit       = (int)($request_data->limit ?? 10); 

           
            $AllNotification = Notification::where('receiver_type','2')
                ->where('receiver_id', $request_data->user_id )
                ->where('is_read','0')
                ->count();
           
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

    public function getAffiliateUserNotifications($request_data)
    {
        try {
            $limit    = (int)($request_data->limit ?? 10); 
           
            $AllNotification = Notification::where('receiver_type','4')
                ->where('receiver_id', $request_data->user_id )
                ->paginate($limit);
           
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


    

       public function getAffiliateUserNotificationsCount($request_data)
    {
        try {
           
            $AllNotification = Notification::where('receiver_type','4')
                ->where('receiver_id', $request_data->user_id )
                  ->where('is_read','0')
                ->count();
           
            return [
                'status' => 'success',
                'message' => 'Notifications Count fetch successfully',
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



    public function ReadAffiliateUserNotification($request_data)
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

    public function GetDriverNotificationCount($request_data)
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

    public function GetSellerNotificationCount($request_data)
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

    public function GetAdminNotificationCount($request_data)
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
    

    



}
    