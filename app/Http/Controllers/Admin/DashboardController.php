<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Validator;
use App\Services\AdminDashboardService;
use Symfony\Component\HttpFoundation\StreamedResponse;
 
class DashboardController extends Controller
{

    public function __construct(AdminDashboardService $AdminDashboardService){

        $this->AdminDashboardService=$AdminDashboardService;

    }


    public function dashboard(Request $request){
        // $admin = Auth::guard('admin')->user();
        // $adminId = $admin->id;
        $request_data = (object)[
                'from_date' => $request->from_date??null,
                'to_date' => $request->to_date??null,
                'country_id' => $request->country_id??null,
                'filter' => $request->filter??null,
            ];
  
          $data= $this->AdminDashboardService->GetDashboardData($request_data)['data'];
        return view('admin.dashboard.index',compact('data'));
    }


    public function export_dashboard_data(Request $request)
    {
        $request_data = (object)[
            'from_date'  => $request->from_date ?? null,
            'to_date'    => $request->to_date ?? null,
            'country_id' => $request->country_id ?? null,
            'filter'     => $request->filter ?? null,
        ];

        $data = $this->AdminDashboardService->GetDashboardData($request_data)['data'];

        $fileName = 'dashboard_export_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Total Users',
                'Active Users',
                'Inactive Users',

                'Total Affiliate Users',
                'Active Affiliate Users',
                'Inactive Affiliate Users',

                'Total Sellers',
                'Active Sellers',
                'Inactive Sellers',

                'Total Delivery Boys',
                'Active Delivery Boys',
                'Inactive Delivery Boys',

                'Total Tickets',
                'Resolved Tickets',
                'Unresolved Tickets',

                'Total Orders',
                'Ongoing Orders',
                'Completed Orders',
                'Returned Orders',
                'Cancelled Orders',

                'Total Revenue(KD)',
                'Order Revenue(KD)',
                'Subscription Revenue(KD)',
                'Affiliate Revenue(KD)',
                'Banner Revenue(KD)',

                'Online Users',
                'App Visitors',
                'Website Visitors',
            ]);

            fputcsv($file, [
                $data['total_users'],
                $data['total_active_users'],
                $data['total_inactive_users'],

                $data['total_affiliate_users'],
                $data['total_active_affiliate_users'],
                $data['total_inactive_affiliate_users'],

                $data['total_sellers'],
                $data['total_active_sellers'],
                $data['total_inactive_sellers'],

                $data['total_delivery_boy'],
                $data['total_active_delivery_boy'],
                $data['total_inactive_delivery_boy'],

                $data['total_tickets'],
                $data['total_resolved_tickets'],
                $data['total_unresolved_tickets'],

                $data['total_orders'],
                $data['total_ongoing_orders'],
                $data['total_completed_orders'],
                $data['total_returned_orders'],
                $data['total_cancelled_orders'],

                $data['total_revenue'],
                $data['total_order_revenue'],
                $data['total_subscription_plan_revenue'],
                $data['total_affiliate_orders_revenue'],
                $data['total_banner_revenue'],

                $data['total_online_users'],
                $data['total_app_visitor_users'],
                $data['total_website_visitor_users'],
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }




}