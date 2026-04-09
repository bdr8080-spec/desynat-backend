<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\seller;
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

class PaymentService
{

    public function getOrderPaymentData($request)
    {
        try {
            $query = orderdetail::with([
                'product_details.seller_details',
                'user_details',
                'order.promocode_details',
                'order.giftCard_details',
            ])

            // 🔹 Main filter on Order
            ->whereHas('order', function ($q) use ($request) {

                $q->where('payment_status', '1');

                // 🔍 Search (order_id)
                $q->when(!empty($request->search), function ($query) use ($request) {
                    $query->where('order_id', 'like', '%' . $request->search . '%');
                });
            })

            // 🔍 Search on Seller (first_name + last_name)
            ->when(!empty($request->search), function ($q) use ($request) {
                $q->orWhereHas('product_details.seller_details', function ($seller) use ($request) {
                    $seller->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                });
            })

            // 🔍 Search on User (full_name)
            ->when(!empty($request->search), function ($q) use ($request) {
                $q->orWhereHas('user_details', function ($user) use ($request) {
                    $user->where('full_name', 'like', '%' . $request->search . '%');
                });
            })

            // 📅 Date Filters
            ->when(!empty($request->from_date) && !empty($request->to_date), function ($q) use ($request) {
                $q->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            })
            ->when(!empty($request->from_date) && empty($request->to_date), function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when(empty($request->from_date) && !empty($request->to_date), function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            })

            ->orderBy('id', 'desc');

            // ✅ Pagination (if limit exists)
            if (!empty($request->limit)) {
                $orders = $query->paginate($request->limit);
            } else {
                $orders = $query->get();
            }

            if ($orders->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Orders found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'All order details fetched successfully',
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





































}