<?php
namespace App\Services;

use App\Models\User;
use App\Models\DeliveryBoy;
use App\Models\SellerSubcriptionPlanBuy;
use App\Models\Plan;
use App\Models\OrderRecordDetail;
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
                    'message' => __('Service_messages.order_not_found'),
                    'data' => []
                ];
            }

            $checkDeliveryAddressCountryCode = $checkOrder->delivery_details->country_code;
            //dd($checkDeliveryAddressCountryCode);

            if ($checkDeliveryAddressCountryCode!== '+965') {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.order_address_outside_kuwait'),
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
                    'status' => 'success',
                    'message' => __('Service_messages.no_delivery_boy_found_for_zone'),
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

    public function assignDriver($request)
    {
        try {
            // Find driver
            $driver = DeliveryBoy::find($request->driver_id);
            if (!$driver) {
                return [
                    'status' => 'error',
                    'message' => 'No Delivery Boy Found',
                    'data' => []
                ];
            }

            // Find order
            $order = Order::find($request->order_id);
            if (!$order) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.order_not_found'),
                    'data' => []
                ];
            }

            if ($order->assign_status == 1 && $order->delivery_boy_id == $driver->id) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.driver_already_assigned_to_order'),
                    'data' => []
                ];
            }

            DB::beginTransaction();

            $order->update([
                'delivery_boy_id' => $driver->id,
                'assign_status'   => 1,
                'assign_date'     => Carbon::now()
            ]);

            $order->order_details()->update([
                'delivery_boy_id' => $driver->id,
                'assign_status'   => 1,
                'assign_date'     => Carbon::now()
            ]);

             $notificationTitle = 'Delivery Boy Assigned';
            $notificationTitleAr = 'تم تعيين مندوب التوصيل';

            $notificationBody  = "Delivery Boy {$driver->full_name_english} is assigned to deliver your order #{$order->order_id}";
            $notificationBodyAr = "تم تعيين مندوب التوصيل {$driver->full_name_arabic} لتوصيل طلبك رقم #{$order->order_id}";

            $notificationTitle1 = 'New Order Assigned';
            $notificationTitle1Ar = 'تم تعيين طلب جديد';

            $notificationBody1  = "New order assigned to you with order id: {$order->order_id}";
            $notificationBody1Ar = "تم تعيين طلب جديد لك برقم الطلب: {$order->order_id}";

            CreateNotification([
                'sender_id' => 1,
                'sender_type' => 1,
                'receiver_id' => $order->user_id,
                'receiver_type' => 2,
                'title_english' => $notificationTitle,
                'title_arabic' => $notificationTitleAr,
                'description_english' => $notificationBody,
                'description_arabic' => $notificationBodyAr,
                'notification_type' => 'order_driver_assigned'
            ]);

            CreateNotification([
                'sender_id' => 1,
                'sender_type' => 1,
                'receiver_id' => $driver->id,
                'receiver_type' => 5,
                'title_english' => $notificationTitle1,
                'title_arabic' => $notificationTitle1Ar,
                'description_english' => $notificationBody1,
                'description_arabic' => $notificationBody1Ar,
                'notification_type' => 'new_order_assign_to_driver'
            ]);

            DB::commit();

            return [
                'status' => 'success',
                'message' => __('Service_messages.driver_assigned_successfully'),
                'data' => [
                    'order'        => $order,
                    'orderdetails' => $order->order_details, 
                    'driver'       => $driver
                ]
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Failed to assign delivery boy: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function ActiveOrdersNew($request){

        try{
            $limit = (int)($request->input('limit'));

            DB::beginTransaction();

            $checkOrder = orderdetail::with([
                'order.delivery_details',
                'order.giftCard_details',
                'order.promocode_details',
                
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'product_details.store',
                'variation_details.color',
                'variation_details.size',
                'UserRatingReviewProvide',
                'driver_details.zone_info'
            ])
            ->whereIn('delivery_status', ['1', '2', '2.1','2.2','7'])
            ->whereIn('payment_status', ['0', '1'])
            ->where('return_type', '0');

            
            if ($request->search) {
                $checkOrder->where(function ($query) use ($request) {
                    // Search in order_id
                    $query->whereHas('order', function ($q) use ($request) {
                        $q->where('order_id', 'like', '%' . $request->search . '%');
                    })
                    // Search in seller's first_name or last_name
                    ->orWhereHas('product_details.seller_details', function ($q) use ($request) {
                        $q->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    });
                });
            }

            if ($request->country_name) {
                $checkOrder->whereHas('order.delivery_details', function ($q) use ($request) {
                    $q->where('country_name', 'like', '%' . $request->country_name . '%');
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereBetween('created_at', [
                        $request->from_date . ' 00:00:00',
                        $request->to_date . ' 23:59:59'
                    ]);
                });

            } elseif (!empty($request->from_date)) {

                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereDate('created_at', '>=', $request->from_date);
                });

            } elseif (!empty($request->to_date)) {

                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereDate('created_at', '<=', $request->to_date);
                });
            }


            $checkOrder = $checkOrder->orderBy('id', 'desc')->paginate($limit);

            $checkOrder->getCollection()->transform(function ($order) {

                $seller_id = $order->product_details->seller_id ?? null;
                //dd($seller_id);
                $amount_with_charges =
                    ($order->amount ?? 0) +
                    ($order->tax ?? 0) +
                    ($order->order->shipping_fees ?? 0) +
                    ($order->order->promocode_value ?? 0) +
                    ($order->order->giftcard_amount ?? 0);

                 $order->amount_with_charges = round($amount_with_charges, 2);

                $order->admin_commission = calculateAndSaveCommission(
                    $order->id,
                    $seller_id,
                    $amount_with_charges
                );

                $order->seller_id = $seller_id;

                return $order;
            });

            DB::commit();

            return ['status'=>'success','message'=>"Active Orders fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch active orders: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }

    public function ReturnExchangeOrdersNew($request){

        try{
            $limit = (int)($request->input('limit'));

            DB::beginTransaction();

             $checkOrder = orderdetail::with([
                'order.delivery_details',
                'order.giftCard_details',
                'order.promocode_details',
                
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'product_details.store',
                'variation_details.color',
                'variation_details.size',
                'UserRatingReviewProvide',
                'driver_details.zone_info'
            ])
            ->where('return_type', '!=', '0')
            ->where('r_e_approve', '1');
            
            if ($request->search) {
                $checkOrder->where(function ($query) use ($request) {
                    // Search in order_id
                    $query->whereHas('order', function ($q) use ($request) {
                        $q->where('order_id', 'like', '%' . $request->search . '%');
                    })
                    // Search in seller's first_name or last_name
                    ->orWhereHas('product_details.seller_details', function ($q) use ($request) {
                        $q->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    });
                });
            }

            if ($request->country_name) {
                $checkOrder->whereHas('order.delivery_details', function ($q) use ($request) {
                    $q->where('country_name', 'like', '%' . $request->country_name . '%');
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereBetween('created_at', [
                        $request->from_date . ' 00:00:00',
                        $request->to_date . ' 23:59:59'
                    ]);
                });

            } elseif (!empty($request->from_date)) {

                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereDate('created_at', '>=', $request->from_date);
                });

            } elseif (!empty($request->to_date)) {

                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereDate('created_at', '<=', $request->to_date);
                });
            }

            $checkOrder = $checkOrder->orderBy('id', 'desc')->paginate($limit);

             $checkOrder->getCollection()->transform(function ($order) {

                $seller_id = $order->product_details->seller_id ?? null;
                //dd($seller_id);
                $amount_with_charges =
                    ($order->amount ?? 0) +
                    ($order->tax ?? 0) +
                    ($order->order->shipping_fees ?? 0) +
                    ($order->order->promocode_value ?? 0) +
                    ($order->order->giftcard_amount ?? 0);

                 $order->amount_with_charges = round($amount_with_charges, 2);

                $order->admin_commission = calculateAndSaveCommission(
                    $order->id,
                    $seller_id,
                    $amount_with_charges
                );

                $order->seller_id = $seller_id;

                return $order;
            });

            DB::commit();

            return ['status'=>'success','message'=>"Return Orders fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch return orders: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }

    public function CompletedOrdersNew($request){

        try{
            $limit = (int)($request->input('limit'));

            DB::beginTransaction();

             $checkOrder = orderdetail::with([
                'order.delivery_details',
                'order.giftCard_details',
                'order.promocode_details',
                
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'product_details.store',
                'variation_details.color',
                'variation_details.size',
                'UserRatingReviewProvide',
                'driver_details.zone_info'
            ])
            ->where('delivery_status', '3')
            //->where('return_type', '0')
            ->where('payment_status', '1');
            
            if ($request->search) {
                $checkOrder->where(function ($query) use ($request) {
                    // Search in order_id
                    $query->whereHas('order', function ($q) use ($request) {
                        $q->where('order_id', 'like', '%' . $request->search . '%');
                    })
                    // Search in seller's first_name or last_name
                    ->orWhereHas('product_details.seller_details', function ($q) use ($request) {
                        $q->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    });
                });
            }

            if ($request->country_name) {
                $checkOrder->whereHas('order.delivery_details', function ($q) use ($request) {
                    $q->where('country_name', 'like', '%' . $request->country_name . '%');
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereBetween('created_at', [
                        $request->from_date . ' 00:00:00',
                        $request->to_date . ' 23:59:59'
                    ]);
                });

            } elseif (!empty($request->from_date)) {

                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereDate('created_at', '>=', $request->from_date);
                });

            } elseif (!empty($request->to_date)) {

                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereDate('created_at', '<=', $request->to_date);
                });
            }

            $checkOrder = $checkOrder->orderBy('id', 'desc')->paginate($limit);

             $checkOrder->getCollection()->transform(function ($order) {

                $seller_id = $order->product_details->seller_id ?? null;
                //dd($seller_id);
                $amount_with_charges =
                    ($order->amount ?? 0) +
                    ($order->tax ?? 0) +
                    ($order->order->shipping_fees ?? 0) +
                    ($order->order->promocode_value ?? 0) +
                    ($order->order->giftcard_amount ?? 0);

                 $order->amount_with_charges = round($amount_with_charges, 2);

                $order->admin_commission = calculateAndSaveCommission(
                    $order->id,
                    $seller_id,
                    $amount_with_charges
                );

                $order->seller_id = $seller_id;

                return $order;
            });

            DB::commit();

            return ['status'=>'success','message'=>"Completed Orders fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch completed orders: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }

    public function CancelledOrdersNew($request){

        try{
            $limit = (int)($request->input('limit'));

            DB::beginTransaction();

             $checkOrder = orderdetail::with([
                'order.delivery_details',
                'order.giftCard_details',
                'order.promocode_details',
                
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'product_details.store',
                'variation_details.color',
                'variation_details.size',
                'UserRatingReviewProvide',
                'driver_details.zone_info'
            ])
            ->whereIn('payment_status', ['2', '3'])
            ->where('return_type', '0');

            
            if ($request->search) {
                $checkOrder->where(function ($query) use ($request) {
                    // Search in order_id
                    $query->whereHas('order', function ($q) use ($request) {
                        $q->where('order_id', 'like', '%' . $request->search . '%');
                    })
                    // Search in seller's first_name or last_name
                    ->orWhereHas('product_details.seller_details', function ($q) use ($request) {
                        $q->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    });
                });
            }

            if ($request->country_name) {
                $checkOrder->whereHas('order.delivery_details', function ($q) use ($request) {
                    $q->where('country_name', 'like', '%' . $request->country_name . '%');
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereBetween('created_at', [
                        $request->from_date . ' 00:00:00',
                        $request->to_date . ' 23:59:59'
                    ]);
                });

            } elseif (!empty($request->from_date)) {

                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereDate('created_at', '>=', $request->from_date);
                });

            } elseif (!empty($request->to_date)) {

                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereDate('created_at', '<=', $request->to_date);
                });
            }

            $checkOrder = $checkOrder->orderBy('id', 'desc')->paginate($limit);

             $checkOrder->getCollection()->transform(function ($order) {

                $seller_id = $order->product_details->seller_id ?? null;
                //dd($seller_id);
                $amount_with_charges =
                    ($order->amount ?? 0) +
                    ($order->tax ?? 0) +
                    ($order->order->shipping_fees ?? 0) +
                    ($order->order->promocode_value ?? 0) +
                    ($order->order->giftcard_amount ?? 0);

                 $order->amount_with_charges = round($amount_with_charges, 2);

                $order->admin_commission = calculateAndSaveCommission(
                    $order->id,
                    $seller_id,
                    $amount_with_charges
                );

                $order->seller_id = $seller_id;

                return $order;
            });

            DB::commit();

            return ['status'=>'success','message'=>"Cancelled Orders fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch cancelled orders: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }

    public function SingleOrderDetailNew($request){

        try{

            DB::beginTransaction();

             $checkOrder = orderdetail::with([
                'order.delivery_details',
                'order.giftCard_details',
                'order.promocode_details',
                
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'product_details.store',
                'variation_details.color',
                'variation_details.size',
                'UserRatingReviewProvide',
                'driver_details.zone_info',
                'exchange_order_details'
            ])
            ->where('id', $request->id)->first();

            $seller_id = $checkOrder->product_details->seller_id ?? null;
            $amount_with_charges =
                ($checkOrder->amount ?? 0) +
                ($checkOrder->tax ?? 0) +
                ($checkOrder->order->shipping_fees ?? 0) +
                ($checkOrder->order->promocode_value ?? 0) +
                ($checkOrder->order->giftcard_amount ?? 0);

            $checkOrder->amount_with_charges = round($amount_with_charges, 2);

            // Calculate & save commission
            $checkOrder->admin_commission = calculateAndSaveCommission(
                $checkOrder->id,
                $seller_id,
                $checkOrder->amount_with_charges
            );

            $checkOrder->seller_id = $seller_id;

            DB::commit();

            return ['status'=>'success','message'=>"Order Details fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch order details: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }

    public function getDriversListToAssignNew($request){

        try{

            $checkOrder = orderdetail::with( 'order.delivery_details')->where('id', $request->order_id)->first();

            if (!$checkOrder) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.order_not_found'),
                    'data' => []
                ];
            }

            $checkDeliveryAddressCountryCode = $checkOrder->order->delivery_details->country_code;
            //dd($checkDeliveryAddressCountryCode);

            if ($checkDeliveryAddressCountryCode!== '+965') {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.order_address_outside_kuwait'),
                    'data' => []
                ];
            }

            $UserAddressLat = $checkOrder->order->delivery_details->latitude;
            $UserAddressLong = $checkOrder->order->delivery_details->longitude;
            //dd($UserAddressLong);

            $deliveryBoyIds = getregionFromCoordinates($UserAddressLat, $UserAddressLong);
            //dd($deliveryBoyIds);

            if (!$deliveryBoyIds) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_delivery_boy_found_for_zone'),
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

    public function assignDriverNew($request)
    {
        try {
            // Find driver
            $driver = DeliveryBoy::find($request->driver_id);
            if (!$driver) {
                return [
                    'status' => 'error',
                    'message' => 'No Delivery Boy Found',
                    'data' => []
                ];
            }

            // Find order
            $order = orderdetail::find($request->order_id);
            if (!$order) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.order_not_found'),
                    'data' => []
                ];
            }

            if ($order->assign_status == 1 && $order->delivery_boy_id == $driver->id) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.driver_already_assigned_to_order'),
                    'data' => []
                ];
            }

            DB::beginTransaction();

            $order->update([
                'delivery_boy_id' => $driver->id,
                'assign_status'   => 1,
                'assign_date'     => Carbon::now()
            ]);

             OrderRecordDetail::create([
                'order_id'        => $order->order_id,
                'orderdetails_id' => $order->id,
                'type'            => '2',
                'driver_id'       => $driver->id,
                'assign_date'     => Carbon::now()
            ]);

            DB::commit();

             $notificationTitle = 'Delivery Boy Assigned';
            $notificationTitleAr = 'تم تعيين مندوب التوصيل';

            $notificationBody  = "Delivery Boy {$driver->full_name_english} is assigned to deliver your order #{$order->order_id}";
            $notificationBodyAr = "تم تعيين مندوب التوصيل {$driver->full_name_arabic} لتوصيل طلبك رقم #{$order->order_id}";

            $notificationTitle1 = 'New Order Assigned';
            $notificationTitle1Ar = 'تم تعيين طلب جديد';

            $notificationBody1  = "New order assigned to you with order id: {$order->order_id}";
            $notificationBody1Ar = "تم تعيين طلب جديد لك برقم الطلب: {$order->order_id}";

            CreateNotification([
                'sender_id' => 1,
                'sender_type' => 1,
                'receiver_id' => $order->user_id,
                'receiver_type' => 2,
                'title_english' => $notificationTitle,
                'title_arabic' => $notificationTitleAr,
                'description_english' => $notificationBody,
                'description_arabic' => $notificationBodyAr,
                'notification_type' => 'order_driver_assigned'
            ]);

            CreateNotification([
                'sender_id' => 1,
                'sender_type' => 1,
                'receiver_id' => $driver->id,
                'receiver_type' => 5,
                'title_english' => $notificationTitle1,
                'title_arabic' => $notificationTitle1Ar,
                'description_english' => $notificationBody1,
                'description_arabic' => $notificationBody1Ar,
                'notification_type' => 'new_order_assign_to_driver'
            ]);

            return [
                'status' => 'success',
                'message' => __('Service_messages.driver_assigned_successfully'),
                'data' => [
                    'order'        => $order,
                    'driver'       => $driver
                ]
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Failed to assign delivery boy: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function RefundOrders($request){

        try{
            $limit = (int)($request->limit);

            DB::beginTransaction();

            $checkOrder = orderdetail::with([
                'order.delivery_details',
                'order.giftCard_details',
                'order.promocode_details',
                
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'product_details.store.country_info',
                'variation_details.color',
                'variation_details.size',
                'user_details.country_info',
                'UserRatingReviewProvide',
                'driver_details.zone_info'
            ])
            ->where('payment_status', '3');

            
            if ($request->search) {
                $checkOrder->where(function ($query) use ($request) {
                    // Search in order_id
                    $query->whereHas('order', function ($q) use ($request) {
                        $q->where('order_id', 'like', '%' . $request->search . '%');
                    })
                    // Search in seller's first_name or last_name
                    ->orWhereHas('product_details.seller_details', function ($q) use ($request) {
                        $q->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    });
                });
            }

            if ($request->country_name) {
                $checkOrder->whereHas('order.delivery_details', function ($q) use ($request) {
                    $q->where('country_name', 'like', '%' . $request->country_name . '%');
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereBetween('created_at', [
                        $request->from_date . ' 00:00:00',
                        $request->to_date . ' 23:59:59'
                    ]);
                });

            } elseif (!empty($request->from_date)) {

                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereDate('created_at', '>=', $request->from_date);
                });

            } elseif (!empty($request->to_date)) {

                $checkOrder->whereHas('order', function ($q) use ($request) {
                    $q->whereDate('created_at', '<=', $request->to_date);
                });
            }


            if (!empty($request->filter) && is_array($request->filter)) {

                $filters = $request->filter;

                $checkOrder->where(function ($query) use ($filters) {

                    // 1 = Not Delivered
                    if (in_array("1", $filters) || in_array(1, $filters)) {

                        $query->orWhere('delivery_status', '8');

                    }

                    // 2 = Return
                    if (in_array("2", $filters) || in_array(2, $filters)) {

                        $query->orWhere('return_type', '1');

                    }

                    // 3 = Exchange
                    if (in_array("3", $filters) || in_array(3, $filters)) {

                        $query->orWhere('payment_status', '3');

                    }

                });
            }

            $checkOrder = $checkOrder->orderBy('id', 'desc')->paginate($limit);

            DB::commit();

            return ['status'=>'success','message'=>"Refund Orders fetched Successfully",'data'=>$checkOrder];

        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch active orders: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }






}