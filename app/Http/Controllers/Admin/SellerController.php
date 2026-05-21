<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\seller;
use App\Models\country;
use Validator;
use App\Http\Controllers\CommonController;
use App\Services\SellerManagementService;
use App\Services\CountryService;
 
class SellerController extends Controller
{
    public function __construct(SellerManagementService $SellerManagementService, CountryService $CountryService)
    {
        $this->SellerManagementService = $SellerManagementService;
        $this->CountryService = $CountryService;
    }

    public function sellerManagement(Request $request){
        $countries = $this->CountryService->getCountries()['data'];
        $newSellers = $this->SellerManagementService->getNewSellers($request)['data'];
        $approvedSellers = $this->SellerManagementService->getApprovedSellers($request)['data'];
        //dd($approvedSellers);
        $rejectedSellers = $this->SellerManagementService->getRejectedSellers($request)['data'];
        //dd($newSellers);
        return view('admin.seller-management.index',compact('newSellers','countries','approvedSellers','rejectedSellers'));
    }

    public function blockUnblockSeller($sellerId)
    {
        $result = $this->SellerManagementService->blockUnblockSeller($sellerId);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }

    public function acceptSeller($sellerId)
    {
        $result = $this->SellerManagementService->acceptSeller($sellerId);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }

    public function rejectSeller(Request $request, $sellerId)
    {
        $rejectReason = $request->input('reject_reason');
        $rejectType = $request->input('reject_type');

        if (empty($rejectReason)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reject reason is required.'
            ], 400);
        }
        if (empty($rejectType)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reject type is required.'
            ], 400);
        }

        $result = $this->SellerManagementService->rejectSeller($sellerId, $rejectReason, $rejectType);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }

    public function export_new_seller_data(Request $request)
    {
        $response = $this->SellerManagementService->getNewSellers($request);

        $paginator = $response['data'] ?? null;

        // $sellers = collect($paginator->items() ?? []);
        //dd($sellers);
        $sellers = collect();

        if ($paginator && is_object($paginator) && method_exists($paginator, 'items')) {
            $sellers = collect($paginator->items());
        }

        $fileName = 'new_sellers_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($sellers) {

            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Sr No',
                'Joining Date',
                'Image Url',
                'First Name',
                'Last Name',
                'Mobile Number',
                'Email',
                'Country',
                'Store Name',
                'Store Address',
                'Store Email',
                'Bio',
                'Status'
            ]);

            foreach ($sellers as $index => $seller) {

                $country = 'N/A';
                if (!empty($seller['store_info']['country'])) {
                    $countryModel = \App\Models\country::find($seller['store_info']['country']);
                    $country = $countryModel->name ?? 'N/A';
                }

                $mobile = '="' . ($seller['country_code'] . $seller['mobile']) . '"';

                $joiningDate = '="' . \Carbon\Carbon::parse($seller['created_at'])->format('d-m-Y') . '"';

                $status = 'Pending';
                if (($seller['admin_verify'] ?? 0) == 2) {
                    $status = 'Approved';
                } elseif (($seller['admin_verify'] ?? 0) == 3) {
                    $status = 'Rejected';
                }

                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $seller['profile_pic'] ?? 'N/A',
                    $seller['first_name'] ?? 'N/A',
                    $seller['last_name'] ?? 'N/A',
                    $mobile,
                    $seller['email'] ?? 'N/A',
                    $country,
                    $seller['store_info']['store_name'] ?? 'N/A',
                    $seller['store_info']['store_address'] ?? 'N/A',
                    $seller['store_info']['store_mail_id'] ?? 'N/A',
                    $seller['store_info']['bio'] ?? 'N/A',
                    $status,
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_approved_seller_data(Request $request)
    {
        $response = $this->SellerManagementService->getApprovedSellers($request);

        $data = $response['data'] ?? collect();

        $sellers = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'approved_sellers_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($sellers) {

            $file = fopen('php://output', 'w');

            // Fix Excel UTF-8 encoding
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Sr No',
                'Joining Date',
                'Image URL',
                'First Name',
                'Last Name',
                'Mobile Number',
                'Email',
                'Country',
                'Store Name',
                'Store Address',
                'Store Email',
                'Bio',
                'Active Plan',
                'Completed Orders',
                'Cancelled Orders',
                'Total Earning',
                'Commission Paid',
                'Rating',
                'Status'
            ]);

            foreach ($sellers as $index => $seller) {

                // Country
                $country = 'N/A';
                if (!empty($seller['store_info']['country'])) {
                    $countryModel = \App\Models\country::find($seller['store_info']['country']);
                    $country = $countryModel->name ?? 'N/A';
                }

                // Plan
                $planName = 'N/A';
                if (!empty($seller['subcription_plan'][0]['plan_id'])) {
                    $plan = \App\Models\Plan::find($seller['subcription_plan'][0]['plan_id']);
                    $planName = $plan->plan_name_english ?? 'N/A';
                }

                // FIX: date safe for Excel
            $mobile = '="' . ($seller['country_code'] . $seller['mobile']) . '"';

                $joiningDate = '="' . \Carbon\Carbon::parse($seller['created_at'])->format('d-m-Y') . '"';

                // FIX: BIO (prevents row breaking issue)
                $bio = $seller['store_info']['bio'] ?? 'N/A';
                $bio = str_replace(["\r", "\n"], ' ', $bio);

                // Status
                $status = ($seller['is_block'] == 0) ? 'Active' : 'Inactive';

                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $seller['profile_pic'] ?? 'N/A',   // IMAGE URL KEPT
                    $seller['first_name'] ?? 'N/A',
                    $seller['last_name'] ?? 'N/A',
                    $mobile,
                    $seller['email'] ?? 'N/A',
                    $country,
                    $seller['store_info']['store_name'] ?? 'N/A',
                    $seller['store_info']['store_address'] ?? 'N/A',
                    $seller['store_info']['store_mail_id'] ?? 'N/A',
                    $bio,
                    $planName,
                    $seller['completed_orders'] ?? 0,
                    $seller['cancelled_orders'] ?? 0,
                    $seller['total_earning'] ?? 0,
                    $seller['commission_paid'] ?? 0,
                    $seller['rating'] ?? 0,
                    $status,
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_rejected_seller_data(Request $request)
    {
        $response = $this->SellerManagementService->getRejectedSellers($request);

        $data = $response['data'] ?? collect();

        // Handle paginator or collection
        $sellers = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'rejected_sellers_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($sellers) {

            $file = fopen('php://output', 'w');

            // Excel UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Sr No',
                'Joining Date',
                'Image URL',
                'First Name',
                'Last Name',
                'Mobile Number',
                'Email',
                'Country',
                'Store Name',
                'Store Address',
                'Store Email',
                'Bio',
                'Reject Reason'
            ]);

            foreach ($sellers as $index => $seller) {

                $country = 'N/A';
                if (!empty($seller['store_info']['country'])) {
                    $countryModel = \App\Models\Country::find($seller['store_info']['country']);
                    $country = $countryModel->name ?? 'N/A';
                }

                $mobile = '="' . ($seller['country_code'] . $seller['mobile']) . '"';

                $joiningDate = '="' . \Carbon\Carbon::parse($seller['created_at'])->format('d-m-Y') . '"';

                $bio = $seller['store_info']['bio'] ?? 'N/A';
                $bio = str_replace(["\r", "\n"], ' ', $bio);

                $rejectReason = $seller['reject_reason'] ?? 'N/A';

                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $seller['profile_pic'] ?? 'N/A',   // IMAGE URL KEPT
                    $seller['first_name'] ?? 'N/A',
                    $seller['last_name'] ?? 'N/A',
                    $mobile,
                    $seller['email'] ?? 'N/A',
                    $country,
                    $seller['store_info']['store_name'] ?? 'N/A',
                    $seller['store_info']['store_address'] ?? 'N/A',
                    $seller['store_info']['store_mail_id'] ?? 'N/A',
                    $bio,

                    $rejectReason,
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }




}