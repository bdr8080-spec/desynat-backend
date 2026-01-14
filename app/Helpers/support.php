<?php


use App\Models\{UserGiftCards,UserWallet,Order,Addtocart,orderdetail,OrderDeliveryAddress};
use App\Models\Zone;
use App\Models\DeliveryBoy;
use App\Models\SellerSubcriptionPlanBuy;
use App\Models\Plan;
use Carbon\Carbon;


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
        
            Addtocart::where([
                'product_id' => $val->product_id,
                'variants_id' => $val->variants_id,
                'user_id'     => $userId
            ])->delete();
        
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



//     function formatChatTime($timestamp)
// {
//     // Convert Firebase timestamp to DateTime
//     $chatTime = new DateTime($timestamp);
//     $now = new DateTime();

//     // Difference
//     $diff = $now->diff($chatTime);
//     $daysAgo = (int)$diff->days;

//     // Same day
//     if ($daysAgo === 0) {
//         return $chatTime->format('d M Y, h:i A');
//     }

//     // Yesterday
//     if ($daysAgo === 1) {
//         return '1 day ago';
//     }

//     // Older
//     return $daysAgo . ' days ago';
// }

function formatChatTime($timestamp)
{
    // Convert to DateTime
    $chatTime = new DateTime($timestamp);
    $now = new DateTime();

    // Calculate difference
    $diff = $now->diff($chatTime);
    $daysAgo = (int)$diff->days;

    // Format time only
    $time = $chatTime->format('h:i A');

    if ($daysAgo === 0 && $now->format('Y-m-d') === $chatTime->format('Y-m-d')) {
        // Today
        return "Today $time";
    }

    if ($daysAgo === 1 || ($daysAgo === 0 && $diff->invert === 1 && $now->format('d') != $chatTime->format('d'))) {
        // Yesterday
        return "Yesterday $time";
    }

    // Older
    return "$daysAgo Days ago, $time";
}
