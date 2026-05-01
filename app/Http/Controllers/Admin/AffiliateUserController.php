<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\AffiliatedUserManagementService;
use App\Services\CountryService;

 
class AffiliateUserController extends Controller
{

    public function __construct(AffiliatedUserManagementService $AffiliatedUserManagementService, CountryService $CountryService)
    {
        $this->AffiliatedUserManagementService = $AffiliatedUserManagementService;
        $this->CountryService = $CountryService;
    }

    public function affiliateUserManagement(Request $request){
        $countries = $this->CountryService->getCountries()['data'];
        $newUsers = $this->AffiliatedUserManagementService->getNewAffiliatedUers($request)['data'];
        //dd($newUsers);
        $approvedUsers = $this->AffiliatedUserManagementService->getApprovedAffiliatedUers($request)['data'];
        $rejectedUsers = $this->AffiliatedUserManagementService->getRejectedAffiliatedUers($request)['data'];
        return view('admin.affiliate-user-management.index',compact('countries','newUsers','approvedUsers','rejectedUsers'));
    }

    public function blockUnblockAffiliateUser($userId)
    {
        $result = $this->AffiliatedUserManagementService->blockUnblockAffiliateUser($userId);

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

    public function acceptAffiliateUser($userId)
    {
        $result = $this->AffiliatedUserManagementService->acceptAffiliateUser($userId);

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

    public function rejectAffiliateUser(Request $request, $userId)
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

        $result = $this->AffiliatedUserManagementService->rejectAffiliateUser($userId, $rejectReason, $rejectType);

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

    public function export_new_affiliate_data(Request $request)
    {
        $response = $this->AffiliatedUserManagementService->getNewAffiliatedUers($request);

        $data = $response['data'] ?? collect();

        // Handle paginator or collection
        $users = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'new_affiliates_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($users) {

            $file = fopen('php://output', 'w');

            // Excel UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Sr No',
                'Joining Date',
                'Image URL',
                'Name',
                'Mobile Number',
                'Email',
                'Country',
                'Address',
            ]);

            foreach ($users as $index => $user) {


                $mobile = '="' . ($user['country_code'] . $user['mobile']) . '"';

                $joiningDate = '="' . \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') . '"';

                $address = 
                    ($user['address_details']['address1'] ?? '') . ' ' .
                    ($user['address_details']['address2'] ?? '') . ' ' .
                    ($user['address_details']['town'] ?? '') . ' ' .
                    ($user['address_details']['city'] ?? '') . ' ' .
                    ($user['address_details']['pincode'] ?? '') . ' ' .
                    ($user['address_details']['state'] ?? '');

                $address = str_replace(["\r", "\n"], ' ', $address);
                $address = trim($address);

                // $rejectReason = $seller['reject_reason'] ?? 'N/A';

                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $user['profile_image'] ?? 'N/A',   
                    $user['full_name'] ?? 'N/A',
                    $mobile,
                    $user['email'] ?? 'N/A',
                    $user['country_details']['name'] ?? 'N/A',
                    $address,
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_approved_affiliate_data(Request $request)
    {
        $response = $this->AffiliatedUserManagementService->getApprovedAffiliatedUers($request);

        $data = $response['data'] ?? collect();

        // Handle paginator or collection
        $users = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'approved_affiliates_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($users) {

            $file = fopen('php://output', 'w');

            // Excel UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Sr No',
                'Joining Date',
                'Image URL',
                'Name',
                'Mobile Number',
                'Email',
                'Country',
                'Address',
                'Total Orders',
                'Total Earning',
            ]);

            foreach ($users as $index => $user) {


                $mobile = '="' . ($user['country_code'] . $user['mobile']) . '"';

                $joiningDate = '="' . \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') . '"';

                $address = 
                    ($user['address_details']['address1'] ?? '') . ' ' .
                    ($user['address_details']['address2'] ?? '') . ' ' .
                    ($user['address_details']['town'] ?? '') . ' ' .
                    ($user['address_details']['city'] ?? '') . ' ' .
                    ($user['address_details']['pincode'] ?? '') . ' ' .
                    ($user['address_details']['state'] ?? '');

                $address = str_replace(["\r", "\n"], ' ', $address);
                $address = trim($address);

                // $rejectReason = $seller['reject_reason'] ?? 'N/A';

                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $user['profile_image'] ?? 'N/A',   
                    $user['full_name'] ?? 'N/A',
                    $mobile,
                    $user['email'] ?? 'N/A',
                    $user['country_details']['name'] ?? 'N/A',
                    $address,
                    $user['total_orders'] ?? '0',
                    $user['total_earning'] ?? '0',
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_rejected_affiliate_data(Request $request)
    {
        $response = $this->AffiliatedUserManagementService->getRejectedAffiliatedUers($request);

        $data = $response['data'] ?? collect();

        // Handle paginator or collection
        $users = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'rejected_affiliates_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($users) {

            $file = fopen('php://output', 'w');

            // Excel UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Sr No',
                'Joining Date',
                'Image URL',
                'Name',
                'Mobile Number',
                'Email',
                'Country',
                'Address',
                'Reject Reason',
            ]);

            foreach ($users as $index => $user) {


                $mobile = '="' . ($user['country_code'] . $user['mobile']) . '"';

                $joiningDate = '="' . \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') . '"';

                $address = 
                    ($user['address_details']['address1'] ?? '') . ' ' .
                    ($user['address_details']['address2'] ?? '') . ' ' .
                    ($user['address_details']['town'] ?? '') . ' ' .
                    ($user['address_details']['city'] ?? '') . ' ' .
                    ($user['address_details']['pincode'] ?? '') . ' ' .
                    ($user['address_details']['state'] ?? '');

                $address = str_replace(["\r", "\n"], ' ', $address);
                $address = trim($address);

                $rejectReason = $user['reject_reason'] ?? 'N/A';

                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $user['profile_image'] ?? 'N/A',   
                    $user['full_name'] ?? 'N/A',
                    $mobile,
                    $user['email'] ?? 'N/A',
                    $user['country_details']['name'] ?? 'N/A',
                    $address,
                    $rejectReason,
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }





    



}