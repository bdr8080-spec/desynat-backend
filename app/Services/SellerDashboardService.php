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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SellerDashboardService
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
                    orderdetail::where('payment_status', 1)
                        ->where('seller_id', $request_data->seller_id)
                )->sum(\DB::raw('COALESCE(amount,0) + COALESCE(tax,0) + COALESCE(shipping_fees,0)')),
                2,
                '.',
                ''
            );

            // product
            $total_products = $applyFilters(product::where('seller_id', $request_data->seller_id))->count();
            $total_active_products = $applyFilters(product::where('seller_id', $request_data->seller_id)->where('product_active_status', 1))->count();
            $total_inactive_products = $applyFilters(product::where('seller_id', $request_data->seller_id)->where('product_active_status', 0))->count();

            //orders
            $total_orders = $applyFilters(orderdetail::where('seller_id', $request_data->seller_id))->count();
            $total_new_orders = $applyFilters(orderdetail::where('seller_id', $request_data->seller_id)->where('delivery_status', 1))->count();
            $total_ongoing_orders = $applyFilters(orderdetail::where('seller_id', $request_data->seller_id)->whereIn('delivery_status', [2, '2.1', '2.2', 6, 7]))->count();
            $total_completed_orders = $applyFilters(orderdetail::where('seller_id', $request_data->seller_id)->where('delivery_status', 3))->count();
            $total_cancelled_orders = $applyFilters(orderdetail::where('seller_id', $request_data->seller_id)->where('payment_status', 2))->count();

            //staff
            $total_staff = $applyFilters(seller::where('type', 1)->where('parent_id', $request_data->seller_id))->count();
            $total_active_staff = $applyFilters(seller::where('type', 1)->where('parent_id', $request_data->seller_id))->where('is_block', 0)->count();
            $total_inactive_staff = $applyFilters(seller::where('type', 1)->where('parent_id', $request_data->seller_id))->where('is_block', 1)->count();

            //analytics
            $year = Carbon::now()->year;
            $fromAnalytics = !empty($request_data->from_date_analytics)
                ? Carbon::parse($request_data->from_date_analytics)->startOfDay()
                : Carbon::create($year, 1, 1)->startOfDay();

            $toAnalytics = !empty($request_data->to_date_analytics)
                ? Carbon::parse($request_data->to_date_analytics)->endOfDay()
                : Carbon::create($year, 12, 31)->endOfDay();

            $orderAnalytics = orderdetail::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as total_orders')
                )
                ->where('seller_id', $request_data->seller_id)
                ->whereBetween('created_at', [$fromAnalytics, $toAnalytics])
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month')
                ->get();

            $visitorAnalytics = SellerStoreVisitor::select(
                DB::raw('MONTH(created_at) as month'),

                // unique registered users
                DB::raw('COUNT(DISTINCT CASE WHEN user_id IS NOT NULL THEN user_id END) as registered_visitors'),

                // guest users (count all)
                DB::raw('SUM(CASE WHEN user_id IS NULL THEN 1 ELSE 0 END) as guest_visitors')
            )
            ->where('seller_id', $request_data->seller_id)
            ->whereBetween('created_at', [$fromAnalytics, $toAnalytics])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

            $months = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
                9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
            ];

            $order_chart = [];

            foreach ($months as $num => $name) {
                $order_chart[] = [
                    'month' => $name,
                    'orders' => $orderAnalytics->firstWhere('month', $num)->total_orders ?? 0
                ];
            }

            $visitor_chart = [];

            foreach ($months as $num => $name) {
                $data = $visitorAnalytics->firstWhere('month', $num);

                $visitor_chart[] = [
                    'month' => $name,
                    //'registered_visitors' => $data->registered_visitors ?? 0,
                    //'guest_visitors' => $data->guest_visitors ?? 0,
                    'total_visitors' => ($data->registered_visitors ?? 0) + ($data->guest_visitors ?? 0),
                ];
            }


            return [
                'status' => 'success',
                'message' => 'Dashboard data fetched successfully',
                'data' => [
                    'total_revenue' => $total_revenue,

                    'total_products' => $total_products,
                    'total_active_products' => $total_active_products,
                    'total_inactive_products' => $total_inactive_products,


                    'total_orders' => $total_orders,
                    'total_new_orders' => $total_new_orders,
                    'total_ongoing_orders' => $total_ongoing_orders,
                    'total_completed_orders' => $total_completed_orders,
                    'total_cancelled_orders' => $total_cancelled_orders,

                    'total_staff' => $total_staff,
                    'total_active_staff' => $total_active_staff,
                    'total_inactive_staff' => $total_inactive_staff,

                    'order_analytics' => $order_chart,
                    'visitor_analytics' => $visitor_chart,

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
    