<?php
namespace App\Services;

use App\Models\User;
use App\Models\DeliveryBoy;
use App\Models\{UserGiftCards,GiftCard,UserWallet};
use App\Models\{Promocode,userAddress,country,all_countrie};

use App\Models\{Order,OrderDeliveryAddress,orderdetail,Addtocart};

use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;


class OrderManagementService
{
   
    public function ActiveOrders($request){

        try{
            $limit = (int)($request->input('limit'));

            DB::beginTransaction();

            $checkOrder = Order::with(
                'delivery_details',
                'order_details.product_details.brand',
                'order_details.product_details.category',
                'order_details.product_details.subcategory',
                'order_details.product_details.seller_details',
                'order_details.variation_details.color',
                'order_details.variation_details.size',
                'driver_details.zone_info'
            )
            ->whereIn('delivery_status', ['1', '2'])
            ->where(function ($query) {
                $query->where('payment_method', '3')
                    ->orWhere('payment_status', '1');
            });

            
            if($request->search){

                $checkOrder=  $checkOrder->where('order_id', 'like','%'.$request->search.'%'); 
            }

            if ($request->country_name) {
                $checkOrder = $checkOrder->whereHas('delivery_details', function ($query) use ($request) {
                    $query->where('country_name', 'like', '%' . $request->country_name . '%');
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $checkOrder->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $checkOrder->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $checkOrder->whereDate('created_at', '<=', $request->to_date);
            }

            $checkOrder = $checkOrder->orderBy('id', 'desc')->paginate($limit);

            return ['status'=>'success','message'=>"Active Orders fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch active orders: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }

    public function ReturnExchangeOrders($request){

        try{
            $limit = (int)($request->input('limit'));

            DB::beginTransaction();

            $checkOrder = Order::with(
                'delivery_details',
                'order_details.product_details.brand',
                'order_details.product_details.category',
                'order_details.product_details.subcategory',
                'order_details.product_details.seller_details',
                'order_details.variation_details.color',
                'order_details.variation_details.size',
                'driver_details.zone_info'
            )
            ->where('delivery_status', '5')
            ->where(function ($query) {
                $query->where('payment_method', '3')
                    ->orWhere('payment_status', '1');
            });
            
            if($request->search){

                $checkOrder=  $checkOrder->where('order_id', 'like','%'.$request->search.'%'); 
            }

            if ($request->country_name) {
                $checkOrder = $checkOrder->whereHas('delivery_details', function ($query) use ($request) {
                    $query->where('country_name', 'like', '%' . $request->country_name . '%');
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $checkOrder->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $checkOrder->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $checkOrder->whereDate('created_at', '<=', $request->to_date);
            }

            $checkOrder = $checkOrder->orderBy('id', 'desc')->paginate($limit);

            return ['status'=>'success','message'=>"Return Orders fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch return orders: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }

    public function CompletedOrders($request){

        try{
            $limit = (int)($request->input('limit'));

            DB::beginTransaction();

            $checkOrder = Order::with(
                'delivery_details',
                'order_details.product_details.brand',
                'order_details.product_details.category',
                'order_details.product_details.subcategory',
                'order_details.product_details.seller_details',
                'order_details.variation_details.color',
                'order_details.variation_details.size',
                'driver_details.zone_info'
            )
            ->where('delivery_status', '3')
            ->where(function ($query) {
                $query->where('payment_method', '3')
                    ->orWhere('payment_status', '1');
            });
            
            if($request->search){

                $checkOrder=  $checkOrder->where('order_id', 'like','%'.$request->search.'%'); 
            }

            if ($request->country_name) {
                $checkOrder = $checkOrder->whereHas('delivery_details', function ($query) use ($request) {
                    $query->where('country_name', 'like', '%' . $request->country_name . '%');
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $checkOrder->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $checkOrder->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $checkOrder->whereDate('created_at', '<=', $request->to_date);
            }

            $checkOrder = $checkOrder->orderBy('id', 'desc')->paginate($limit);

            return ['status'=>'success','message'=>"Completed Orders fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch completed orders: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }

    public function CancelledOrders($request){

        try{
            $limit = (int)($request->input('limit'));

            DB::beginTransaction();

            $checkOrder = Order::with(
                'delivery_details',
                'order_details.product_details.brand',
                'order_details.product_details.category',
                'order_details.product_details.subcategory',
                'order_details.product_details.seller_details',
                'order_details.variation_details.color',
                'order_details.variation_details.size',
                'driver_details.zone_info'
            )
            ->where('delivery_status', '4')
            ->where(function ($query) {
                $query->where('payment_method', '3')
                    ->orWhere('payment_status', '1');
            });
            
            if($request->search){

                $checkOrder=  $checkOrder->where('order_id', 'like','%'.$request->search.'%'); 
            }

            if ($request->country_name) {
                $checkOrder = $checkOrder->whereHas('delivery_details', function ($query) use ($request) {
                    $query->where('country_name', 'like', '%' . $request->country_name . '%');
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $checkOrder->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $checkOrder->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $checkOrder->whereDate('created_at', '<=', $request->to_date);
            }

            $checkOrder = $checkOrder->orderBy('id', 'desc')->paginate($limit);

            return ['status'=>'success','message'=>"Cancelled Orders fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch cancelled orders: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }

    public function SingleOrderDetail($request){

        try{

            DB::beginTransaction();

            $checkOrder = Order::with(
                'delivery_details',
                'order_details.product_details.brand',
                'order_details.product_details.category',
                'order_details.product_details.subcategory',
                'order_details.product_details.seller_details',
                'order_details.variation_details.color',
                'order_details.variation_details.size',
                'driver_details.zone_info'
            )
            ->where('id', $request->id)->first();

            return ['status'=>'success','message'=>"Order Details fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch order details: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }

    public function getDriversListToAssign($request){

        try{

            $checkOrder = Order::with( 'delivery_details')->where('id', $request->order_id)->first();

            if (!$checkOrder) {
                return [
                    'status' => 'error',
                    'message' => 'Order not found',
                    'data' => []
                ];
            }

            $checkDeliveryAddressCountryCode = $checkOrder->delivery_details->country_code;
            //dd($checkDeliveryAddressCountryCode);

            if ($checkDeliveryAddressCountryCode!== '+965') {
                return [
                    'status' => 'error',
                    'message' => 'Order Address Is Outside From Kuwait',
                    'data' => []
                ];
            }

            $UserAddressLat = $checkOrder->delivery_details->latitude;
            $UserAddressLong = $checkOrder->delivery_details->longitude;
            //dd($UserAddressLong);

            $deliveryBoyIds = getregionFromCoordinates($UserAddressLat, $UserAddressLong);
            //dd($deliveryBoyIds);

            if (!$deliveryBoyIds) {
                return [
                    'status' => 'error',
                    'message' => 'No Delivery Boy Found For User Address Zone',
                    'data' => []
                ];
            }

            $deliveryBoys = DeliveryBoy::whereIn('id', $deliveryBoyIds)
                ->orderBy('id', 'desc') 
                ->get();

            return [
                'status' => 'success',
                'message' => "Delivery Boys fetched successfully",
                'data' => $deliveryBoys
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch delivery boy: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }

    public function assignDriver($request){

        try{

            $checkdriver = DeliveryBoy::where('id', $request->driver_id)->first();

            if (!$checkdriver) {
                return [
                    'status' => 'error',
                    'message' => 'No Delivery Boy Found',
                    'data' => []
                ];
            }

             $order = Order::find($request->order_id);

            if (!$order) {
                return [
                    'status' => 'error',
                    'message' => 'Order not found',
                    'data' => []
                ];
            }

            if ($order->assign_status == 1 && $order->delivery_boy_id == $request->driver_id) {
                return [
                    'status' => 'error',
                    'message' => 'Driver already assigned to this order',
                    'data' => []
                ];
            }

            DB::beginTransaction();

            $order->update([
                'delivery_boy_id' => $checkdriver->id,
                'assign_status' => 1,
                'assign_date'     => Carbon::now()
            ]);

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Delivery Boy Assigned Successfully',
                'data' => [
                    'order_details' => $order,
                    'driver_details' => $checkdriver
                ]
            ];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to assign delivery boy: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }




}
