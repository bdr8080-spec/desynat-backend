<?php
namespace App\Services;

use App\Models\User;

use App\Models\{UserGiftCards,GiftCard,UserWallet};
use App\Models\{Promocode,userAddress,country,all_countrie};

use App\Models\{Order,OrderDeliveryAddress,orderdetail,Addtocart};

use DB;
use Illuminate\Http\Request;


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
                'order_details.variation_details.size'
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
                'order_details.variation_details.size'
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
                'order_details.variation_details.size'
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
                'order_details.variation_details.size'
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
                'order_details.variation_details.size'
            )
            ->where('id', $request->id)->get();

            return ['status'=>'success','message'=>"Order Details fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch order details: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }




}
