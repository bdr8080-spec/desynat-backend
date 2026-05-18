<?php

use App\Models\{UserGiftCards,UserWallet,Order,Addtocart,orderdetail,OrderDeliveryAddress,allproductchats};
use App\Models\Zone;
use App\Models\DeliveryBoy;
use App\Models\SellerSubcriptionPlanBuy;
use App\Models\Plan;
use Carbon\Carbon;
use App\Models\Notification;


use Laravel\Sanctum\PersonalAccessToken;


// Function to calculate the distance using the Haversine formula
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    // if (
    //     !is_numeric($lat1) || !is_numeric($lon1) ||
    //     !is_numeric($lat2) || !is_numeric($lon2)
    // ) {
    //     return null;
    // }
    // Radius of the Earth in kilometers
    $earthRadius = 6371;
    
    // Convert degrees to radians
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    // Difference in coordinates
    $dLat = $lat2 - $lat1;
    $dLon = $lon2 - $lon1;

    // Haversine formula
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos($lat1) * cos($lat2) *
         sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    // Distance in kilometers
    $distance = $earthRadius * $c;


    return $distance; // Distance in kilometers
}



  function userBalanceget($request){

    try{


    $userBalance=UserWallet::where('user_id',$request->user_id)->first();

    if($userBalance){
        $response['balance']=round($userBalance->amount);
    }else{
         $response['balance']=0;
    }

    return ['status'=>'success','message'=>"User Wallet Balance fetch Successfully",'data'=>$response];

    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    }




function UserBalancePayOrder($user_id,$amount=null){

    try{

    $userBalance=UserWallet::where('user_id',$user_id)->first();


    if($userBalance){
        $balance=round($userBalance->amount)-$amount;
        
        $userBalance->update(['amount'=>$balance]);
        
    }
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }



function OrderGiftCardConditionCheck($orderid,$amount=null){

    try{

    $userOrder=Order::where('id',$orderid)->first();

    if($userOrder){

        if($userOrder->giftcard_id!==''){
        $userGiftCard=UserGiftCards::where('id',$userOrder->giftcard_id)->first();
        if($userGiftCard){
            $userGiftCard->update(['giftCardUse'=>'1']);
        }
        }
        
    }
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    }

    function getregionFromCoordinates($lat, $lng)
    {
        //dd(123);
        // Retrieve regions with markers from the database
        $zones = Zone::where('status', '1')->get(['id', 'coordinates'])->toArray();
        //dd($zones);
 
        // Check if the point is in any polygon
        $foundZoneId = null;
        foreach ($zones as $zone) {
            $coordinates = $zone['coordinates']; // Use coordinates directly as array
            if (isPointInPolygon($lat, $lng, $coordinates)) {
                $foundZoneId = $zone['id'];
 
                break;
            }
        }
         //dd($foundZoneId);
 
       if ($foundZoneId !== null) {
            $deliveryBoyIds = DeliveryBoy::where('zone_id', $foundZoneId)
                ->orderBy('id', 'desc')    
                ->pluck('id')                
                ->toArray();               

            return $deliveryBoyIds;       
        } else {
            return [];
        }

    }

    function isPointInPolygon($lat, $lng, $polygon)
    {
        $vertices_x = array_column($polygon, 'lat');
        $vertices_y = array_column($polygon, 'lng');
        $points_polygon = count($polygon);
 
        $i = $j = $c = 0;
        for ($i = 0, $j = $points_polygon - 1; $i < $points_polygon; $j = $i++) {
            if (((($vertices_y[$i] <= $lng) && ($lng < $vertices_y[$j])) || (($vertices_y[$j] <= $lng) && ($lng < $vertices_y[$i]))) &&
                ($lat < ($vertices_x[$j] - $vertices_x[$i]) * ($lng - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i])
            ) {
                $c = !$c;
            }
        }
        return $c;
    }
 



    // delete Data from Add to cart
 function AddtocartRemoveData($orderid){

        $checkOrder = Order::with('order_details.product_details')->where('id', $orderid)->first();

        $userId = $checkOrder->user_id;  // ← correct source of user_id
        
        foreach ($checkOrder->order_details as $key => $val) {
        
           $addtoCardData= Addtocart::where([
                'product_id' => $val->product_id,
                'variants_id' => $val->variants_id,
                'user_id'     => $userId
            ])->first();


            if($addtoCardData->unique_id!==''){
            allproductchats::where('unique_id',$addtoCardData->unique_id)->update(['product_buy_status'=>'1']);
            }

            $addtoCardData->delete();
                    
        }

        
    }

         function Order_detailsPaidStatusChange($orderid,$paymentstatus){
        $checkOrder = orderdetail::where('order_id', $orderid)->update(['payment_status'=>$paymentstatus]);
        
    }

    function calculateAndSaveCommission($orderDetailId, $seller_id, $amount)
    {
        $adminCommission = null;

        $subscription = SellerSubcriptionPlanBuy::where('seller_id', $seller_id)
            ->where('status', '1')
            ->where('payment_status', '1')
            ->whereDate('plan_end_date', '>=', Carbon::today())
            ->first();
         
        //dd($subscription);

        if ($subscription) {
            $plan = Plan::where('id', $subscription->plan_id)
                ->where('status', '1')
                ->where('commission', '1')
                ->first();

            if ($plan && $plan->commission_percentage) {
                $adminCommission = round(
                    ($amount * $plan->commission_percentage) / 100,
                    2
                );
            }
        }

        orderdetail::where('id', $orderDetailId)->update([
            'seller_id' => $seller_id,
            'admin_commission' => $adminCommission
        ]);

        return $adminCommission;
    }




    // delete Data from Add to cart
 function delete_Order_Data($orderid){

    $order = Order::find($orderid);
    if ($order) {

    // Delete delivery address
    OrderDeliveryAddress::where('id', $order->delivery_address)->delete();

    // Delete order details
    OrderDetail::where('order_id', $orderid)->delete();

    // Delete order
    $order->delete();
    }


    }



    function formatChatTime($timestamp)
{
    // Convert Firebase timestamp to DateTime
    $chatTime = new DateTime($timestamp);
    $now = new DateTime();

    // Difference
    $diff = $now->diff($chatTime);
    $daysAgo = (int)$diff->days;

    // Same day
    if ($daysAgo === 0) {
        return $chatTime->format('d M Y, h:i A');
    }

    // Yesterday
    if ($daysAgo === 1) {
        return '1 day ago';
    }

    // Older
    return $daysAgo . ' days ago';
}

// function formatChatTime($timestamp)
// {
//     // Convert to DateTime
//     $chatTime = new DateTime($timestamp);
//     $now = new DateTime();

//     // Calculate difference
//     $diff = $now->diff($chatTime);
//     $daysAgo = (int)$diff->days;

//     // Format time only
//     $time = $chatTime->format('h:i A');

//     if ($daysAgo === 0 && $now->format('Y-m-d') === $chatTime->format('Y-m-d')) {
//         // Today
//         return "Today $time";
//     }

//     if ($daysAgo === 1 || ($daysAgo === 0 && $diff->invert === 1 && $now->format('d') != $chatTime->format('d'))) {
//         // Yesterday
//         return "Yesterday $time";
//     }

//     // Older
//     return "$daysAgo Days ago, $time";
// }




if (!function_exists('Seller_orderItemViewData')) {

    function Seller_orderItemViewData($orderDetail)
    {
        $order   = $orderDetail->order;
        $product = $orderDetail->product_details;
        $variant = $orderDetail->variation_details;

        $color = $variant->color ?? null;
        $size  = $variant->size ?? null;

        // Variant image handling
        if (is_array($variant->variant_image)) {
            $images = $variant->variant_image;
        } else {
            $images = json_decode($variant->variant_image ?? '[]', true);
        }

        $image = $images[0] ?? asset('user/assets/images/categorie1.png');

        // Order status text
        $statusText = match (true) {

            // Cancelled
            $orderDetail->payment_status == '2' ||
            $orderDetail->payment_status == '3'
            => 'Cancelled',

            // Shipped
            $orderDetail->delivery_status == '2.1' &&
            $orderDetail->return_type == '0'
            => 'Shipped',

            // On the way
            $orderDetail->delivery_status == '2.2' &&
            $orderDetail->return_type == '0'
            => 'On The Way',

            // Delivered
            $orderDetail->delivery_status == '3' &&
            $orderDetail->return_type == '0'
            => 'Delivered',

            // Exchange request
            $orderDetail->delivery_status == '3' &&
            $orderDetail->return_type == '2' && $orderDetail->r_e_approve == '0'
            => 'Exchange Request',

            $orderDetail->delivery_status == '3' &&
            $orderDetail->return_type == '2' && $orderDetail->r_e_approve == '1'
            => 'Exchange Request Accepted',

            $orderDetail->r_e_approve == '1' &&
            $orderDetail->return_type == '1' && $orderDetail->is_picked == "0"
            => 'Return Request Accepted',

            $orderDetail->r_e_approve == '1' &&
            $orderDetail->return_type == '1' &&  $orderDetail->is_picked == "1" &&  $orderDetail->delivery_status == "3" 
            => 'Return complete',

            $orderDetail->r_e_approve == '1' &&
            $orderDetail->return_type == '1' &&  $orderDetail->is_picked == "1"
            => 'Return Picked',


            $orderDetail->r_e_approve == '2' &&
            $orderDetail->return_type == '1'
            => 'Return Cancelled',

              // Return request
            $orderDetail->delivery_status == '3' &&
            $orderDetail->return_type == '1'
            => 'Return Request',

              // Delivered
            $orderDetail->delivery_status == '7'
            => 'On The Way',

            // Default
            default => 'Ongoing',
        };

        // Status colors
        [$statusColor, $bgColor] = match ($statusText) {

            'Delivered' => ['#28a745', '#28a7451A'],

            'Cancelled' => ['#E70000', '#E700001A'],

            'Exchange Request',
            'Return Request'
            => ['#FF5F1B', 'rgba(255, 95, 27, 0.1)'],

            default => ['#FF5F1B', '#79d69d1a'],
        };

        return compact(
            'order',
            'orderDetail',
            'product',
            'variant',
            'color',
            'size',
            'image',
            'statusText',
            'statusColor',
            'bgColor'
        );
    }


if (!function_exists('SellerChatproductRequestStatus')) {

    function SellerChatproductRequestStatus($val)
    {
        // Default response
        $data = [
            'text'  => '',
            'color' => '',
            'bg'    => '',
            'class' => 'yellow-bg',
        ];

        // Only for type = 2
        if ($val->type != '2') {
            return null;
        }

        // NEW
        if (
            $val->product_request == '0' ||
            ($val->product_request == '1' && $val->action == '0')
        ) {
            $data['text']  = __('seller_messages.new');
            $data['color'] = '#EA9413';
            $data['bg']    = '#EA94131A';
        }

        // QUOTATION SENT
        elseif (
            $val->product_request == '1' &&
            in_array($val->action, ['1', '2'])
        ) {
            $data['text']  =  __('seller_messages.quotation_sent');
            $data['color'] = '#172B85';
            $data['bg']    = '#172B851A';
        }

        // REQUEST REJECTED
        elseif (
            $val->product_request == '1' &&
            in_array($val->action, ['3', '4'])
        ) {
            $data['text']  =  __('seller_messages.request_rejected');
            $data['color'] = '#f31616ff';
            $data['bg']    = '#b3b3b3ff';
            $data['class'] = 'red-bg yellow-bg';
        }

        // QUOTATION ACCEPTED
        elseif (
            $val->product_request == '1' &&
            $val->action == '5' &&
            !isset($val->order_create_status)
        ) {
            $data['text']  = __('seller_messages.quotation_accepted');
            $data['color'] = '#17854C';
            $data['bg']    = '#17854C1A';
        }

        // PLACE ORDER
        elseif (
            $val->product_request == '1' &&
            $val->action == '5' &&
            isset( $val->order_create_status )
        ) {
            $data['text']  = __('seller_messages.place_order');
            $data['color'] = '#17854C';
            $data['bg']    = '#17854C1A';
            $data['class'] = 'red-bg yellow-bg';
        }

        return $data;
    }
}

    function sendPushNotification($userTokens, $title, $description, $notification_type, $sender_id, $receiver_id, $receiver_type)
    {
       // dd($userTokens);
        $accessToken = generateFirebaseAccessToken()['access_token'];
        //dd($accessToken);

        foreach ($userTokens as $device_token) {

            if (!$device_token) continue;

            $notification = [
                'message' => [
                    'token' => $device_token,
                    'notification' => [
                        'title' => (string)$title,
                        'body' => (string)$description,
                    ],
                    'data' => [
                        'receiver_id' => (string)$receiver_id,
                        'sender_id' => (string)$sender_id,
                        'type' => (string)$notification_type,
                        'receiver_type' => (string)$receiver_type
                    ]
                ]
            ];

            //dd($notification);

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://fcm.googleapis.com/v1/projects/desynat/messages:send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($notification),
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $accessToken,
                    'Content-Type: application/json',
                ],
            ]);

            curl_exec($curl);
            curl_close($curl);
        }
    }

    function generateFirebaseAccessToken()
    {
        $serviceAccountPath = storage_path('desynat-firebase-adminsdk-fbsvc-511856a90e.json');

        $client = new \Google_Client();
        $client->setAuthConfig($serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        return $client->fetchAccessTokenWithAssertion();
    }


function getUserIdWithToken($request){

     $user = null;

    if ($request->bearerToken()) {

        $token = PersonalAccessToken::findToken($request->bearerToken());

        if ($token) {
            $user = $token->tokenable;

            $user=$user->id;
        }
    }

    return $user;

    }



}