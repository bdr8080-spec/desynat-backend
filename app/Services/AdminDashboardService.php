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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Hash;

class AdminDashboardService
{

   public function GetDashboardData($request_data)
    {
        try {

            $applyFilters = function ($query) use ($request_data) {

                if (!empty($request_data->country_id)) {
                    $query->where('country_id', $request_data->country_id);
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

            // user
            $total_users = $applyFilters(User::query())->count();
            $total_active_users = $applyFilters(User::where('status', 1))->count();
            $total_inactive_users = $applyFilters(User::where('status', 0))->count();

            // affiliate
            $total_affiliate_users = $applyFilters(AffilatedUser::query())->count();
            $total_active_affiliate_users = $applyFilters(AffilatedUser::where('status', 1))->count();
            $total_inactive_affiliate_users = $applyFilters(AffilatedUser::where('status', 0))->count();

            // seller
            $total_sellers = $applyFilters(seller::query())->count();
            $total_active_sellers = $applyFilters(seller::where('is_block', 0))->count();
            $total_inactive_sellers = $applyFilters(seller::where('is_block', 1))->count();

            // driver
            $total_delivery_boy = $applyFilters(DeliveryBoy::query())->count();
            $total_active_delivery_boy = $applyFilters(DeliveryBoy::where('status', 1))->count();
            $total_inactive_delivery_boy = $applyFilters(DeliveryBoy::where('status', 0))->count();

            // tickes
            $total_tickets = $applyFilters(Ticket::query())->count();
            $total_resolved_tickets = $applyFilters(Ticket::where('status', 1))->count();
            $total_unresolved_tickets = $applyFilters(Ticket::where('status', 0))->count();

            //orders
            $total_orders = $applyFilters(orderdetail::query())->count();
            $total_ongoing_orders = $applyFilters(orderdetail::whereIn('delivery_status', [1, 2, '2.1', '2.2', 6, 7]))->count();
            $total_completed_orders = $applyFilters(orderdetail::where('delivery_status', 3))->count();
            $total_returned_orders = $applyFilters(orderdetail::where('delivery_status', 5))->count();

            //revenue
            $total_order_revenue = number_format(
                $applyFilters(orderdetail::where('delivery_status', 3))
                    ->sum(\DB::raw('COALESCE(amount,0) + COALESCE(tax,0) + COALESCE(shipping_fees,0)')),
                2,
                '.',
                ''
            );

            $total_subscription_plan_revenue = number_format(
                $applyFilters(SellerSubcriptionPlanBuy::where('payment_status', 1))
                    ->sum('amount'),
                2,
                '.',
                ''
            );

            $total_affiliate_orders_revenue = number_format(
                $applyFilters(
                    orderdetail::where('delivery_status', 3)
                        ->whereNotNull('affiliate_id') 
                        ->where('affiliate_id', '!=', '') 
                )
                ->sum(\DB::raw('COALESCE(amount,0) + COALESCE(tax,0) + COALESCE(shipping_fees,0)')),
                2,
                '.',
                ''
            );


            $total_banner_revenue = number_format(
                $applyFilters(
                    sellerBanner::where('added_by', 0)
                        ->where('payment_status', 1)
                )->sum('price'),
                2,
                '.',
                ''
            );

            $total_online_users = $applyFilters(User::where('is_login', 1))->count();
            $total_website_visitor_users = $applyFilters(User::where('is_visit_website', 1))->count();
            $total_app_visitor_users = $applyFilters(User::where('is_visit_app', 1))->count();

            return [
                'status' => 'success',
                'message' => 'Dashboard data fetched successfully',
                'data' => [
                    'total_users' => $total_users,
                    'total_active_users' => $total_active_users,
                    'total_inactive_users' => $total_inactive_users,

                    'total_affiliate_users' => $total_affiliate_users,
                    'total_active_affiliate_users' => $total_active_affiliate_users,
                    'total_inactive_affiliate_users' => $total_inactive_affiliate_users,

                    'total_sellers' => $total_sellers,
                    'total_active_sellers' => $total_active_sellers,
                    'total_inactive_sellers' => $total_inactive_sellers,

                    'total_delivery_boy' => $total_delivery_boy,
                    'total_active_delivery_boy' => $total_active_delivery_boy,
                    'total_inactive_delivery_boy' => $total_inactive_delivery_boy,

                    'total_tickets' => $total_tickets,
                    'total_resolved_tickets' => $total_resolved_tickets,
                    'total_unresolved_tickets' => $total_unresolved_tickets,

                    'total_orders' => $total_orders,
                    'total_ongoing_orders' => $total_ongoing_orders,
                    'total_completed_orders' => $total_completed_orders,
                    'total_returned_orders' => $total_returned_orders,

                    'total_order_revenue' => $total_order_revenue,
                    'total_subscription_plan_revenue' => $total_subscription_plan_revenue,
                    'total_affiliate_orders_revenue' => $total_affiliate_orders_revenue,
                    'total_banner_revenue' => $total_banner_revenue,

                    'total_online_users' => $total_online_users,
                    'total_website_visitor_users' => $total_website_visitor_users,
                    'total_app_visitor_users' => $total_app_visitor_users,




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
    