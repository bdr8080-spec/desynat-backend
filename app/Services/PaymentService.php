<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\seller;
use App\Models\sellerBanner;
use App\Models\size;
use App\Models\color;
use App\Models\ProductVariant;
use Carbon\Carbon;

use App\Models\{UserGiftCards,GiftCard,UserWallet,Reason,UserWalletHistory};
use App\Models\{Promocode,userAddress,country,all_countrie,allproductchats};
use App\Models\{Order,OrderDeliveryAddress,orderdetail,Addtocart,productRatings,product};
use DB;
use App\Models\WithdrawRequest;
use App\Models\sellerStoreInformation;
use App\Models\SellerSubcriptionPlanBuy;


class PaymentService
{

     
    public function getOrderPaymentData($request)
    {
        try {
            $query = orderdetail::with([
                'variation_details',
                'product_details.seller_details',
                'user_details.country_info',
                'order.promocode_details',
                'order.giftCard_details',
            ])
            ->where('payment_status', '1'); 

            if (!empty($request->search)) {
                $query->where(function ($sub) use ($request) {
                    // Search order_id
                    $sub->whereHas('order', function ($o) use ($request) {
                        $o->where('order_id', 'like', '%' . $request->search . '%');
                    });

                    $sub->orWhereHas('product_details.seller_details', function ($seller) use ($request) {
                        $seller->where('first_name', 'like', '%' . $request->search . '%')
                            ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    });

                    $sub->orWhereHas('user_details', function ($user) use ($request) {
                        $user->where('full_name', 'like', '%' . $request->search . '%');
                    });
                });
            }

            if (!empty($request->country_id)) {
                $query->whereHas('user_details.country_info', function ($country) use ($request) {
                    $country->where('id', $request->country_id);
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            $totalQuery = clone $query;

            $total_revenue = round(
                $totalQuery->sum(
                    DB::raw('COALESCE(amount,0) + COALESCE(shipping_fees,0) + COALESCE(tax,0)')
                ),
                2
            );
            $total_custom_order_revenue = round(
                (clone $query)
                    ->where('order_type', '2')
                    ->sum(DB::raw('COALESCE(amount,0) + COALESCE(shipping_fees,0) + COALESCE(tax,0)')),
                2
            );
            $total_commission = round(
                (clone $query)->sum('affiliate_admin_commission'),
                2
            );

            $query->orderBy('id', 'desc');

            if (!empty($request->limit)) {
                $orders = $query->paginate($request->limit);
                $collection = $orders->getCollection();
            } else {
                $orders = $query->get();
                $collection = $orders;
            }

            $collection->transform(function ($item) {
            $actualPrice = $item->variation_details->actual_price ?? 0;
            $amount = $item->amount ?? 0;
            $shipping = $item->shipping_fees ?? 0;
            $tax = $item->tax ?? 0;

            $item->total_discount = round((float)$actualPrice - (float)$amount, 2);
            $item->total_paid_amount = round(
                (float)$amount + (float)$shipping + (float)$tax,
                2
            );

            return $item;
        });

            if ($collection->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.order_not_found'),
                    'data' => (object)[],
                    'total_revenue' => 0,
                    'total_custom_order_revenue' => 0,
                    'total_commission' => 0,
                ];
            }

            return [
                'status' => 'success',
                'message' => 'All order details fetched successfully',
                'total_revenue' => $total_revenue,
                'total_custom_order_revenue' => $total_custom_order_revenue,
                'total_commission' => $total_commission,
                'data' => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch order details: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getPlanPaymentData($request)
    {
        try {

            $query = SellerSubcriptionPlanBuy::with([
                'plan_info',
                'seller_details.store_info.country_info',
            ])
            ->where('payment_status', '1');    

            if (!empty($request->search)) {
                $query->where(function ($sub) use ($request) {
                    // Search transaction_id
                    $sub->where('transaction_id', 'like', '%' . $request->search . '%');

                    // Search seller first_name or last_name
                    $sub->orWhereHas('seller_details', function ($seller) use ($request) {
                        $seller->where('first_name', 'like', '%' . $request->search . '%')
                            ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    });

                    // Search plan name
                    $sub->orWhereHas('plan_info', function ($plan) use ($request) {
                        $plan->where('plan_name_english', $request->search);
                    });
                });
            }

            if (!empty($request->country_id)) {
                $query->whereHas('seller_details.store_info.country_info', function ($country) use ($request) {
                    $country->where('id', $request->country_id);
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            $totalQuery = clone $query;
            $total_revenue = round($totalQuery->sum('amount'), 2);

            $query->orderBy('id', 'desc');

            if (!empty($request->limit)) {
                $orders = $query->paginate($request->limit);
                $collection = $orders->getCollection();
            } else {
                $orders = $query->get();
                $collection = $orders;
            }

            if ($collection->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_data_found'),
                    'data' => (object)[],
                    'total_revenue' => 0,
                ];
            }

            return [
                'status' => 'success',
                'message' => 'All plan payment details fetched successfully',
                'total_revenue' => $total_revenue,
                'data' => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch plan payment details: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getGiftCardPaymentData($request)
    {
        try {

            $query = UserGiftCards::with([
                'gift_details',
                'user_details.country_info',
            ])
            ->where('payment_status', '1');    

            if (!empty($request->search)) {
                $query->where(function ($sub) use ($request) {
                    // Search order_id (exact match or partial match depending on requirement)
                    $sub->where('order_id', 'like', '%' . $request->search . '%');

                    // Search transaction_id
                    $sub->orWhere('transaction_id', 'like', '%' . $request->search . '%');

                    // Search user full name
                    $sub->orWhereHas('user_details', function ($user) use ($request) {
                        $user->where('full_name', 'like', '%' . $request->search . '%');
                    });

                    // Search gift name (exact match)
                    $sub->orWhereHas('gift_details', function ($gift) use ($request) {
                        $gift->where('name_english', 'like', '%' . $request->search . '%');
                    });
                });
            }
            if (!empty($request->country_id)) {
                $query->whereHas('user_details.country_info', function ($country) use ($request) {
                    $country->where('id', $request->country_id);
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            $total_revenue = round((clone $query)->sum('amount'), 2);

            $query->orderBy('id', 'desc');
            if (!empty($request->limit)) {
                $orders = $query->paginate($request->limit);
                $collection = $orders->getCollection();
            } else {
                $orders = $query->get();
                $collection = $orders;
            }

            if ($collection->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_data_found'),
                    'data' => (object)[],
                    'total_revenue' => 0,
                ];
            }

            return [
                'status' => 'success',
                'message' => 'All gift card payment details fetched successfully',
                'total_revenue' => $total_revenue,
                'data' => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch gift card payment details: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getBannerPaymentData($request)
    {
        try {

            $query = sellerBanner::with([
                'seller_details.store_info.country_info',
            ])
            ->where('payment_status', '1')
            ->where('added_by', '0')
            ->where('Admin_verify', '1');   

            if (!empty($request->search)) {
                $query->where(function ($sub) use ($request) {
                    // Search order_id (exact match or partial match depending on requirement)
                    $sub->where('order_id', 'like', '%' . $request->search . '%');

                    // Search transaction_id
                    $sub->orWhere('transaction_id', 'like', '%' . $request->search . '%');

                    // Search seller  name
                    $sub->orWhereHas('seller_details', function ($seller) use ($request) {
                        $seller->where('first_name', 'like', '%' . $request->search . '%')
                            ->orWhere('last_name', 'like', '%' . $request->search . '%');
                    });

                });
            }
            if (!empty($request->country_id)) {
                $query->whereHas('seller_details.store_info.country_info', function ($country) use ($request) {
                    $country->where('id', $request->country_id);
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            $total_revenue = round((clone $query)->sum('price'), 2);

            $query->orderBy('id', 'desc');
            if (!empty($request->limit)) {
                $orders = $query->paginate($request->limit);
                $collection = $orders->getCollection();
            } else {
                $orders = $query->get();
                $collection = $orders;
            }

            if ($collection->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_data_found'),
                    'data' => (object)[],
                    'total_revenue' => 0,
                ];
            }

            return [
                'status' => 'success',
                'message' => 'All banner payment details fetched successfully',
                'total_revenue' => $total_revenue,
                'data' => $orders
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch banner payment details: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }




































}