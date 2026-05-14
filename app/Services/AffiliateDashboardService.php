<?php
namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use App\Models\seller;
use App\Models\AffilatedUser;
use App\Models\DeliveryBoy;
use App\Models\Order;
use App\Models\orderdetail;
use App\Models\Ticket;
use App\Models\SellerSubcriptionPlanBuy;
use App\Models\sellerBanner;
use App\Models\product;
use App\Models\SellerStoreVisitor;
use App\Models\AffiliateProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AffiliateDashboardService
{

   public function GetDashboardData($request_data)
    {
        try {

            $applyFilters = function ($query) use ($request_data) {


                if (!empty($request_data->filter)) {
                    if ($request_data->filter == 1) {
                        $query->whereDate('created_at', Carbon::today());

                    } elseif ($request_data->filter == 2) {
                        $query->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ]);

                    } elseif ($request_data->filter == 3) {
                        $query->whereBetween('created_at', [
                            Carbon::now()->startOfMonth(),
                            Carbon::now()->endOfMonth()
                        ]);

                    } elseif ($request_data->filter == 4) {
                        $query->whereBetween('created_at', [
                            Carbon::now()->startOfYear(),
                            Carbon::now()->endOfYear()
                        ]);
                    }
                }

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

                return $query;
            };

            //revenuue
            $total_revenue = number_format(
                $applyFilters(
                    orderdetail::where('payment_status', '1')
                        ->where('affiliate_id', $request_data->user_id)
                )->sum(\DB::raw('COALESCE(amount,0) + COALESCE(tax,0) + COALESCE(shipping_fees,0)')),
                2,
                '.',
                ''
            );

            // product
            $total_products = $applyFilters(AffiliateProduct::where('affiliate_id', $request_data->user_id))->count();

            //orders
            $total_orders = $applyFilters(orderdetail::where('affiliate_id', $request_data->user_id))->count();
            $total_ongoing_orders = $applyFilters(
                                    orderdetail::where('affiliate_id', $request_data->user_id)
                                        ->whereIn('delivery_status', ['1', '2', '2.1', '2.2', '6', '7'])
                                        ->where('payment_status', '!=', '2')
                                )->count();
            $total_completed_orders = $applyFilters(
                                    orderdetail::where('affiliate_id', $request_data->user_id)
                                        ->where('delivery_status', '3')
                                        ->where('payment_status', '1')
                                )->count();
             $total_returned_orders = $applyFilters(orderdetail::where('affiliate_id', $request_data->user_id)->where('delivery_status', '5'))->count();
            $total_cancelled_orders = $applyFilters(orderdetail::where('affiliate_id', $request_data->user_id)->where('payment_status', '2'))->count();


            return [
                'status' => 'success',
                'message' => __('service_messages.affiliate_dashboard_data_fetched_successfully'),
                'data' => [
                    'total_revenue' => $total_revenue,

                    'total_products' => $total_products,


                    'total_orders' => $total_orders,
                    'total_ongoing_orders' => $total_ongoing_orders,
                    'total_completed_orders' => $total_completed_orders,
                    'total_returned_orders' => $total_returned_orders,
                    'total_cancelled_orders' => $total_cancelled_orders,

                ]
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch dashboard data: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    

            
        


}
    