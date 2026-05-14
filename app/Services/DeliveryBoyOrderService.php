<?php
namespace App\Services;

use App\Models\User;
use App\Models\DeliveryBoy;
use App\Models\Reason;
use App\Models\OrderRecordDetail;
use App\Models\{UserGiftCards,GiftCard,UserWallet};
use App\Models\{Promocode,userAddress,country,all_countrie};

use App\Models\{Order,OrderDeliveryAddress,orderdetail,Addtocart};

use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DeliveryBoyOrderService
{
   

    public function AllOrders($request)
    {
        try {
            $limit = isset($request->limit) ? (int) $request->limit : 10;

            $orders = Order::with(
                'delivery_details',
                'order_details.product_details.seller_details.store_info'
            )
            ->where('delivery_boy_id', $request->delivery_boy_id)
            ->when($request->search, function ($q) use ($request) {
                $q->where('order_id', 'like', '%' . $request->search . '%');
            })

            ->when(!empty($request->filter), function ($q) use ($request) {
                $q->where('delivery_status', $request->filter);
            })
            ->orderBy('id', 'desc')
            ->paginate($limit);

            // Calculate distance for each order
            $orders->getCollection()->transform(function ($order) {

                // User delivery location
                $userLat  = $order->delivery_details->latitude ?? null;
                $userLong = $order->delivery_details->longitude ?? null;

                // Default distance
                $order->distance = null;

                $storeInfo = $order->order_details
                    ->first()
                    ?->product_details
                    ?->seller_details
                    ?->store_info;

                if ($userLat && $userLong && $storeInfo) {

                    $storeLat  = $storeInfo->let;
                    $storeLong = $storeInfo->long;

                    // Distance calculation
                    $order->distance = round(
                        calculateDistance($userLat, $userLong, $storeLat, $storeLong)
                    );
                }


                return $order;
            });

            return [
                'status'  => 'success',
                'message' => 'All Orders fetched Successfully',
                'data'    => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch all orders: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }


    public function NewOrders($request)
    {
        try {
            $limit = isset($request->limit) ? (int) $request->limit : 10;

            $today = Carbon::today()->toDateString();

            $orders = orderdetail::with(
                'order.delivery_details',
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'variation_details.color',
                'variation_details.size',
                'product_details.seller_details.store_info'
            )
            ->where('delivery_boy_id', $request->delivery_boy_id)
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('order_details', function ($query) use ($request) {
                    $query->where('order_id', 'like', '%' . $request->search . '%');
                });
            })

            ->whereNotNull('assign_date')
            // ->whereDate('assign_date', $today)

            // ->whereNotIn('delivery_status', ['4', '6', '7', '8'])
            ->whereIn('delivery_status', ['1','2'])
            ->where('is_picked', '0')

            ->orderBy('assign_date', 'desc')
            ->paginate($limit);

            $orders->getCollection()->transform(function ($order) {

                $order->distance = null;

                $userLat  = $order->delivery_details->latitude ?? null;
                $userLong = $order->delivery_details->longitude ?? null;

                $storeInfo = $order->order_details
                    ->first()
                    ?->product_details
                    ?->seller_details
                    ?->store_info;

                if ($userLat && $userLong && $storeInfo) {
                    $order->distance = round(
                        calculateDistance(
                            $userLat,
                            $userLong,
                            $storeInfo->let ?? null,
                            $storeInfo->long ?? null
                        )
                    );
                }

                return $order;
            });

            return [
                'status'  => 'success',
                'message' => 'New Orders fetched Successfully',
                'data'    => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch new orders: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }

    public function OngoingOrders($request)
    {
        try {
            $limit = isset($request->limit) ? (int) $request->limit : 10;

            $orders = Order::with(
                'delivery_details',
                'order_details.product_details.seller_details.store_info'
            )
            ->where('delivery_boy_id', $request->delivery_boy_id)
            ->where('delivery_status', '2')
            ->where('is_picked', 1)
            ->when($request->search, function ($q) use ($request) {
                $q->where('order_id', 'like', '%' . $request->search . '%');
            })

            // ->when(!empty($request->filter), function ($q) use ($request) {
            //     $q->where('delivery_status', $request->filter);
            // })
            ->orderBy('id', 'desc')
            ->paginate($limit);

            // Calculate distance for each order
            $orders->getCollection()->transform(function ($order) {

                // User delivery location
                $userLat  = $order->delivery_details->latitude ?? null;
                $userLong = $order->delivery_details->longitude ?? null;

                // Default distance
                $order->distance = null;

                $storeInfo = $order->order_details
                    ->first()
                    ?->product_details
                    ?->seller_details
                    ?->store_info;

                if ($userLat && $userLong && $storeInfo) {

                    $storeLat  = $storeInfo->let;
                    $storeLong = $storeInfo->long;

                    // Distance calculation
                    $order->distance = round(
                        calculateDistance($userLat, $userLong, $storeLat, $storeLong)
                    );
                }


                return $order;
            });

            return [
                'status'  => 'success',
                'message' => 'Ongoing Orders fetched Successfully',
                'data'    => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch ongoing orders: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }

    public function CompletedOrders($request)
    {
        try {
            $limit = isset($request->limit) ? (int) $request->limit : 10;

            $orders = Order::with(
                'delivery_details',
                'order_details.product_details.seller_details.store_info'
            )
            ->where('delivery_boy_id', $request->delivery_boy_id)
            ->where('delivery_status', '3')
            ->where('is_picked', 1)
            ->when($request->search, function ($q) use ($request) {
                $q->where('order_id', 'like', '%' . $request->search . '%');
            })

            // ->when(!empty($request->filter), function ($q) use ($request) {
            //     $q->where('delivery_status', $request->filter);
            // })
            ->orderBy('id', 'desc')
            ->paginate($limit);

            // Calculate distance for each order
            $orders->getCollection()->transform(function ($order) {

                // User delivery location
                $userLat  = $order->delivery_details->latitude ?? null;
                $userLong = $order->delivery_details->longitude ?? null;

                // Default distance
                $order->distance = null;

                $storeInfo = $order->order_details
                    ->first()
                    ?->product_details
                    ?->seller_details
                    ?->store_info;

                if ($userLat && $userLong && $storeInfo) {

                    $storeLat  = $storeInfo->let;
                    $storeLong = $storeInfo->long;

                    // Distance calculation
                    $order->distance = round(
                        calculateDistance($userLat, $userLong, $storeLat, $storeLong)
                    );
                }


                return $order;
            });

            return [
                'status'  => 'success',
                'message' => 'Completed Orders fetched Successfully',
                'data'    => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch completed orders: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }

    public function OrderDetails($request)
    {
        try {

            $order = Order::with(
                'promocode_details',
                'giftCard_details',
                'delivery_details',
                'order_details.product_details.brand',
                'order_details.product_details.category',
                'order_details.product_details.subcategory',
                'order_details.product_details.seller_details',
                'order_details.variation_details.color',
                'order_details.variation_details.size',
                'order_details.product_details.seller_details.store_info'
            )
            ->where('id', $request->id)
            ->first();

            if ($order) {
                // User delivery location
                $userLat  = $order->delivery_details->latitude ?? null;
                $userLong = $order->delivery_details->longitude ?? null;

                $order->distance = null;

                $storeInfo = $order->order_details
                    ->first()
                    ?->product_details
                    ?->seller_details
                    ?->store_info;

                if ($userLat && $userLong && $storeInfo) {
                    $order->distance = round(
                        calculateDistance(
                            (float)$userLat,
                            (float)$userLong,
                            (float)$storeInfo->let,
                            (float)$storeInfo->long
                        )
                    );
                }
            }

            return [
                'status'  => 'success',
                'message' => 'Order Details fetched Successfully',
                'data'    => $order
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch order details: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }



    public function UpdateDeliveryStatusNew($request)
    {
        DB::beginTransaction();

        try {
            $orderDetail = orderdetail::find($request->id);
            $order = Order::find($orderDetail->order_id);

            if (!$orderDetail) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.no_data_found'),
                    'data' => []
                ];
            }

            $status =  $request->delivery_status;
           // dd($status);

            $orderDetail->delivery_status = $status;

            if ($status == 3) {
                $orderDetail->payment_status = '1'; 
                CreateNotification([
                    'sender_id' => 1,
                    'sender_type' => 1,

                    'receiver_id' => $orderDetail->user_id,
                    'receiver_type' => 2,

                    'title_english' => 'Order Status',
                    'title_arabic' => 'حالة الطلب',

                    'description_english' => "Your order with order id: {$order->order_id} is delivered",
                    'description_arabic' => "تم توصيل طلبك برقم الطلب: {$order->order_id}",

                    'notification_type' => 'order_delivered'
                ]);
            }

            if ($status == 8) {
                // $orderDetail->payment_status = '0'; 
                $orderDetail->not_delivered_reason = $request->reason ?? null;
                CreateNotification([
                    'sender_id' => 1,
                    'sender_type' => 1,

                    'receiver_id' => $orderDetail->user_id,
                    'receiver_type' => 2,

                    'title_english' => 'Order Status',
                    'title_arabic' => 'حالة الطلب',

                    'description_english' => "Your order with order id: {$order->order_id} failed to be delivered, Reason: {$request->reason}",
                    'description_arabic' => "فشل توصيل طلبك برقم الطلب: {$order->order_id}، السبب: {$request->reason}",

                    'notification_type' => 'order_not_delivered'
                ]);
            }

            $orderDetail->save();

            if ($status == 3) {
                $order = Order::find($orderDetail->order_id);
                //dd($order);

                if ($order) {
                    $order->delivery_status = '3';
                    $order->payment_status  = '1';
                    $order->save();
                }
            }

            if ($status == 8) {
                $nextDeliveryDate = now()->addDay();
                OrderRecordDetail::create([
                    'order_id'           => $orderDetail->order_id,
                    'orderdetails_id'    => $orderDetail->id,
                    'driver_id'    => $orderDetail->delivery_boy_id,
                    'type'    => '1',
                    'not_delivered_date' => now(),
                    'next_delivery_date' => $nextDeliveryDate,
                ]);
                CreateNotification([
                    'sender_id' => 1,
                    'sender_type' => 1,

                    'receiver_id' => $orderDetail->user_id,
                    'receiver_type' => 2,

                    'title_english' => 'Order Status',
                    'title_arabic' => 'حالة الطلب',

                    'description_english' => "Your order with order id: {$order->order_id} will be delivered on {$nextDeliveryDate->format('d M Y')}",
                    'description_arabic' => "سيتم توصيل طلبك برقم الطلب: {$order->order_id} بتاريخ {$nextDeliveryDate->format('d M Y')}",

                    'notification_type' => 'order_next_delivery_date'
                ]);
            }

            DB::commit();

            switch ($status) {
                case '3':
                    $message = __('Service_messages.delivery_status_updated_to_delivered');
                    break;
                case '7':
                    $message = __('Service_messages.delivery_status_updated_to_picked');
                    break;
                case '8':
                    $message = __('Service_messages.delivery_status_updated_to_not_delivered');
                    break;
                default:
                    $message = __('Service_messages.delivery_status_updated_successfully');
            }

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $orderDetail
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Failed to update status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    public function PickOrder($request)
    {
        try {
            $data = Order::find($request->id);
            $driver = DeliveryBoy::find($data->delivery_boy_id);
            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Order not found',
                    'data' => []
                ];
            }

            $data->delivery_status = '7';
            $data->save();
            CreateNotification([
                'sender_id' => 1,
                'sender_type' => 1,

                'receiver_id' => $data->user_id,
                'receiver_type' => 2,

                'title_english' => 'Order Status',
                'title_arabic' => 'حالة الطلب',

                'description_english' => "Your order with order id: {$data->order_id} is picked by our delivery boy {$driver->full_name_english}",
                'description_arabic' => "تم استلام طلبك برقم الطلب: {$data->order_id} بواسطة مندوب التوصيل {$driver->full_name_arabic}",

                'notification_type' => 'order_picked'
            ]);

            return [
                'status' => 'success',
                'message' => __('Service_messages.order_picked_successfully'),
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getReason($request)
    {
        try {

            $query = Reason::where('type', $request->type)->where('status',1);

            $query->orderBy('id', 'desc');

            $reason_details = $query->get();

            if ($reason_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_data_found'),
                    'data' =>  []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Reasons fetched successfully',
                'data' => $reason_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch brands: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function AllOrdersNew($request)
    {
        try {
            $limit = isset($request->limit) ? (int) $request->limit : 10;

            $orders = orderdetail::with(
                'order.delivery_details',
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'variation_details.color',
                'variation_details.size',
                'product_details.seller_details.store_info',
                'order.user_details',
                'exchange_order_details'
            )
            ->where('delivery_boy_id', $request->delivery_boy_id)
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    // Search in order_id
                    $query->whereHas('order', function ($q2) use ($request) {
                        $q2->where('order_id', 'like', '%' . $request->search . '%');
                    })
                    // Search in seller name
                    ->orWhereHas('product_details.seller_details', function ($q3) use ($request) {
                        $q3->where('first_name', 'like', '%' . $request->search . '%')
                           ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    })
                    // Search in store name
                    ->orWhereHas('product_details.seller_details.store_info', function ($q4) use ($request) {
                        $q4->where('store_name', 'like', '%' . $request->search . '%');
                    })
                    // Search in user name
                    ->orWhereHas('order.user_details', function ($q5) use ($request) {
                        $q5->where('full_name', 'like', '%' . $request->search . '%');
                    });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($limit);

            // Calculate distance for each order
            $orders->getCollection()->transform(function ($order) {

            $userLat  = $order->order->delivery_details->latitude ?? null;
            //dd($userLat);
            $userLong = $order->order->delivery_details->longitude ?? null;

            $order->distance = null;

            $storeInfo = $order->product_details
                ?->seller_details
                ?->store_info;

            if ($userLat && $userLong && $storeInfo) {
                $order->distance = round(
                    calculateDistance(
                        $userLat,
                        $userLong,
                        $storeInfo->let,
                        $storeInfo->long
                    )
                );
            }

            return $order;
        });

            return [
                'status'  => 'success',
                'message' => 'All Orders fetched Successfully',
                'data'    => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch all orders: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }

    public function NewOrdersNew($request)
    {
        try {
            $limit = isset($request->limit) ? (int) $request->limit : 10;

            $today = Carbon::today()->toDateString();

            $orders = orderdetail::with(
                'order.delivery_details',
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'variation_details.color',
                'variation_details.size',
                'product_details.seller_details.store_info',
                'order.user_details',
            )
            ->where('delivery_boy_id', $request->delivery_boy_id)
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    // Search in order_id
                    $query->whereHas('order', function ($q2) use ($request) {
                        $q2->where('order_id', 'like', '%' . $request->search . '%');
                    })
                    // Search in seller name
                    ->orWhereHas('product_details.seller_details', function ($q3) use ($request) {
                        $q3->where('first_name', 'like', '%' . $request->search . '%')
                           ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    })
                    // Search in store name
                    ->orWhereHas('product_details.seller_details.store_info', function ($q4) use ($request) {
                        $q4->where('store_name', 'like', '%' . $request->search . '%');
                    })
                    // Search in user name
                    ->orWhereHas('order.user_details', function ($q5) use ($request) {
                        $q5->where('full_name', 'like', '%' . $request->search . '%');
                    });
                });
            })

            ->when(!empty($request->filter), function ($q) use ($request) {
                $q->where('delivery_status', $request->filter);
            })

            ->whereNotNull('assign_date')
            // ->whereDate('assign_date', $today)

            // ->whereNotIn('delivery_status', ['4', '6', '7', '8'])
            ->whereIn('delivery_status', ['1','2'])
            ->where('is_picked', '0')

            ->orderBy('assign_date', 'desc')
            ->paginate($limit);

            $orders->getCollection()->transform(function ($order) {

            $userLat  = $order->order->delivery_details->latitude ?? null;
            //dd($userLat);
            $userLong = $order->order->delivery_details->longitude ?? null;

            $order->distance = null;

            $storeInfo = $order->product_details
                ?->seller_details
                ?->store_info;

            if ($userLat && $userLong && $storeInfo) {
                $order->distance = round(
                    calculateDistance(
                        $userLat,
                        $userLong,
                        $storeInfo->let,
                        $storeInfo->long
                    )
                );
            }

            return $order;
        });

            return [
                'status'  => 'success',
                'message' => 'New Orders fetched Successfully',
                'data'    => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch new orders: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }

    public function OngoingOrdersNew($request)
    {
        try {
            $limit = isset($request->limit) ? (int) $request->limit : 10;

            $orders = orderdetail::with(
                'order.delivery_details',
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'variation_details.color',
                'variation_details.size',
                'product_details.seller_details.store_info',
                'order.user_details',
            )
            ->where('delivery_boy_id', $request->delivery_boy_id)
            ->whereIN('delivery_status', ['2','7'])
            ->where('is_picked', 1)
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    // Search in order_id
                    $query->whereHas('order', function ($q2) use ($request) {
                        $q2->where('order_id', 'like', '%' . $request->search . '%');
                    })
                    // Search in seller name
                    ->orWhereHas('product_details.seller_details', function ($q3) use ($request) {
                        $q3->where('first_name', 'like', '%' . $request->search . '%')
                           ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    })
                    // Search in store name
                    ->orWhereHas('product_details.seller_details.store_info', function ($q4) use ($request) {
                        $q4->where('store_name', 'like', '%' . $request->search . '%');
                    })
                    // Search in user name
                    ->orWhereHas('order.user_details', function ($q5) use ($request) {
                        $q5->where('full_name', 'like', '%' . $request->search . '%');
                    });
                });
            })

            ->when(!empty($request->filter), function ($q) use ($request) {
                $q->where('delivery_status', $request->filter);
            })
            ->orderBy('id', 'desc')
            ->paginate($limit);

            // Calculate distance for each order
             $orders->getCollection()->transform(function ($order) {

            $userLat  = $order->order->delivery_details->latitude ?? null;
            //dd($userLat);
            $userLong = $order->order->delivery_details->longitude ?? null;

            $order->distance = null;

            $storeInfo = $order->product_details
                ?->seller_details
                ?->store_info;

            if ($userLat && $userLong && $storeInfo) {
                $order->distance = round(
                    calculateDistance(
                        $userLat,
                        $userLong,
                        $storeInfo->let,
                        $storeInfo->long
                    )
                );
            }

            return $order;
        });

            return [
                'status'  => 'success',
                'message' => 'Ongoing Orders fetched Successfully',
                'data'    => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch ongoing orders: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }

    public function CompletedOrdersNew($request)
    {
        try {
            $limit = isset($request->limit) ? (int) $request->limit : 10;

            $orders = orderdetail::with(
                'order.delivery_details',
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'variation_details.color',
                'variation_details.size',
                'product_details.seller_details.store_info',
                'order.user_details',
            )
            ->where('delivery_boy_id', $request->delivery_boy_id)
            ->where('delivery_status', '3')
            ->where('is_picked', 1)
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    // Search in order_id
                    $query->whereHas('order', function ($q2) use ($request) {
                        $q2->where('order_id', 'like', '%' . $request->search . '%');
                    })
                    // Search in seller name
                    ->orWhereHas('product_details.seller_details', function ($q3) use ($request) {
                        $q3->where('first_name', 'like', '%' . $request->search . '%')
                           ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    })
                    // Search in store name
                    ->orWhereHas('product_details.seller_details.store_info', function ($q4) use ($request) {
                        $q4->where('store_name', 'like', '%' . $request->search . '%');
                    })
                    // Search in user name
                    ->orWhereHas('order.user_details', function ($q5) use ($request) {
                        $q5->where('full_name', 'like', '%' . $request->search . '%');
                    });
                });
            })

            ->when(!empty($request->filter), function ($q) use ($request) {
                $q->where('delivery_status', $request->filter);
            })
            ->orderBy('id', 'desc')
            ->paginate($limit);

            // Calculate distance for each order
            $orders->getCollection()->transform(function ($order) {

            $userLat  = $order->order->delivery_details->latitude ?? null;
            //dd($userLat);
            $userLong = $order->order->delivery_details->longitude ?? null;

            $order->distance = null;

            $storeInfo = $order->product_details
                ?->seller_details
                ?->store_info;

            if ($userLat && $userLong && $storeInfo) {
                $order->distance = round(
                    calculateDistance(
                        $userLat,
                        $userLong,
                        $storeInfo->let,
                        $storeInfo->long
                    )
                );
            }

            return $order;
        });

            return [
                'status'  => 'success',
                'message' => 'Completed Orders fetched Successfully',
                'data'    => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch completed orders: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }

    public function OrderDetailsNew($request)
    {
        try {

            $order = orderdetail::with(
                'order.delivery_details',
                'order.giftCard_details',
                'order.promocode_details',
                'product_details.brand',
                'product_details.category',
                'product_details.subcategory',
                'product_details.seller_details',
                'variation_details.color',
                'variation_details.size',
                'UserRatingReviewProvide',
                'order.user_details',
                'exchange_new_size_data',
                'exchange_order_details'
            )
            ->where('id', $request->id)
            ->first();

            if ($order) {
                // User delivery location
                 $userLat  = $order->order->delivery_details->latitude ?? null;
                //dd($userLat);
                $userLong = $order->order->delivery_details->longitude ?? null;

                $order->distance = null;

                $storeInfo = $order->product_details
                    ?->seller_details
                    ?->store_info;

                if ($userLat && $userLong && $storeInfo) {
                    $order->distance = round(
                        calculateDistance(
                            (float)$userLat,
                            (float)$userLong,
                            (float)$storeInfo->let,
                            (float)$storeInfo->long
                        )
                    );
                }
            }

            return [
                'status'  => 'success',
                'message' => 'Order Details fetched Successfully',
                'data'    => $order
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch order details: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }



    public function PickOrderNew($request)
    {
        try {
            $data = orderdetail::find($request->id);
            $driver = DeliveryBoy::find($data->delivery_boy_id);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Order not found',
                    'data' => []
                ];
            }

            $data->delivery_status = '7';
            $data->is_picked = '1';
            $data->save();
            CreateNotification([
                'sender_id' => 1,
                'sender_type' => 1,

                'receiver_id' => $data->user_id,
                'receiver_type' => 2,

                'title_english' => 'Order Status',
                'title_arabic' => 'حالة الطلب',

                'description_english' => "Your order with order id: {$data->order_id} is picked by our delivery boy {$driver->full_name_english}",
                'description_arabic' => "تم استلام طلبك برقم الطلب: {$data->order_id} بواسطة مندوب التوصيل {$driver->full_name_arabic}",

                'notification_type' => 'order_picked'
            ]);

            return [
                'status' => 'success',
                'message' => __('Service_messages.order_picked_successfully'),
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    



    public function ReturnOrderToStoreOnExchnage($request)
    {
        try {
            $data = orderdetail::find($request->id);
            $driver = DeliveryBoy::find($data->delivery_boy_id);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Order not found',
                    'data' => []
                ];
            }

            if($data->p_orderdetails_id=='null'){
               return [
                    'status' => 'error',
                    'message' => __('Service_messages.exchange_not_found'),
                    'data' => []
                ];


            }


            $data->returntostore = '1';
            $data->save();
            CreateNotification([
                'sender_id' => 1,
                'sender_type' => 1,

                'receiver_id' => $data->user_id,
                'receiver_type' => 2,

                'title_english' => 'Order Status',
                'title_arabic' => 'حالة الطلب',

                'description_english' => "Your order with order id: {$data->order_id} is returned to store by our delivery boy {$driver->full_name_english}",
                'description_arabic' => "تم إرجاع طلبك برقم الطلب: {$data->order_id} إلى المتجر بواسطة مندوب التوصيل {$driver->full_name_arabic}",

                'notification_type' => 'order_returned_to_store'
            ]);

            return [
                'status' => 'success',
                'message' => __('Service_messages.order_returned_to_store_successfully'),
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }









}