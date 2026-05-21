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

        $users = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'new_affiliates_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($users, $locale) {

            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS EN / AR
            ========================= */
            $headersEn = [
                'Sr No',
                'Joining Date',
                'Image URL',
                'Name',
                'Mobile Number',
                'Email',
                'Country',
                'Address',
            ];

            $headersAr = [
                'الرقم',
                'تاريخ الانضمام',
                'رابط الصورة',
                'الاسم',
                'رقم الجوال',
                'البريد الإلكتروني',
                'الدولة',
                'العنوان',
            ];

            $csvHeaders = $locale == 'ar' ? $headersAr : $headersEn;

            fputcsv($file, $csvHeaders);

            /* =========================
            DATA ROWS
            ========================= */
            foreach ($users as $index => $user) {

                $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

                /* -------- MOBILE -------- */
                $mobile = '="' . ($user['country_code'] . $user['mobile']) . '"';

                /* -------- DATE -------- */
                $joiningDate = '="' . \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') . '"';

                /* -------- ADDRESS -------- */
                $address = ($user['address_details']['address1'] ?? '') . ' ' .
                        ($user['address_details']['address2'] ?? '') . ' ' .
                        ($user['address_details']['town'] ?? '') . ' ' .
                        ($user['address_details']['city'] ?? '') . ' ' .
                        ($user['address_details']['pincode'] ?? '') . ' ' .
                        ($user['address_details']['state'] ?? '');

                $address = trim(str_replace(["\r", "\n"], ' ', $address));

                $address = $address ?: $na;

                /* -------- COUNTRY -------- */
                $country = $user['country_details'] ?? null;

                if ($country) {
                    $country = $locale == 'ar'
                        ? ($country['name_ar'] ?? $na)
                        : ($country['name'] ?? $na);
                } else {
                    $country = $na;
                }

                /* -------- ROW -------- */
                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $user['profile_image'] ?? $na,
                    $user['full_name'] ?? $na,
                    $mobile,
                    $user['email'] ?? $na,
                    $country,
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

        $users = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'approved_affiliates_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($users, $locale) {

            $file = fopen('php://output', 'w');

            // Excel UTF-8 BOM
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS EN / AR
            ========================= */
            $headersEn = [
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
            ];

            $headersAr = [
                'الرقم',
                'تاريخ الانضمام',
                'رابط الصورة',
                'الاسم',
                'رقم الجوال',
                'البريد الإلكتروني',
                'الدولة',
                'العنوان',
                'إجمالي الطلبات',
                'إجمالي الأرباح',
            ];

            $csvHeaders = $locale == 'ar' ? $headersAr : $headersEn;

            fputcsv($file, $csvHeaders);

            /* =========================
            DATA ROWS
            ========================= */
            foreach ($users as $index => $user) {

                $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

                /* -------- MOBILE -------- */
                $mobile = '="' . ($user['country_code'] . $user['mobile']) . '"';

                /* -------- DATE -------- */
                $joiningDate = '="' . \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') . '"';

                /* -------- ADDRESS -------- */
                $address = ($user['address_details']['address1'] ?? '') . ' ' .
                        ($user['address_details']['address2'] ?? '') . ' ' .
                        ($user['address_details']['town'] ?? '') . ' ' .
                        ($user['address_details']['city'] ?? '') . ' ' .
                        ($user['address_details']['pincode'] ?? '') . ' ' .
                        ($user['address_details']['state'] ?? '');

                $address = trim(str_replace(["\r", "\n"], ' ', $address));
                $address = $address ?: $na;

                /* -------- COUNTRY -------- */
                $country = $user['country_details'] ?? null;

                if ($country) {
                    $country = $locale == 'ar'
                        ? ($country['name_ar'] ?? $na)
                        : ($country['name'] ?? $na);
                } else {
                    $country = $na;
                }

                /* -------- ROW -------- */
                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $user['profile_image'] ?? $na,
                    $user['full_name'] ?? $na,
                    $mobile,
                    $user['email'] ?? $na,
                    $country,
                    $address,
                    $user['total_orders'] ?? 0,
                    $user['total_earning'] ?? 0,
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_rejected_affiliate_data(Request $request)
    {
        $response = $this->AffiliatedUserManagementService->getRejectedAffiliatedUers($request);

        $data = $response['data'] ?? collect();

        $users = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'rejected_affiliates_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($users, $locale) {

            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS EN / AR
            ========================= */
            $headersEn = [
                'Sr No',
                'Joining Date',
                'Image URL',
                'Name',
                'Mobile Number',
                'Email',
                'Country',
                'Address',
                'Reject Reason',
            ];

            $headersAr = [
                'الرقم',
                'تاريخ الانضمام',
                'رابط الصورة',
                'الاسم',
                'رقم الجوال',
                'البريد الإلكتروني',
                'الدولة',
                'العنوان',
                'سبب الرفض',
            ];

            $csvHeaders = $locale == 'ar' ? $headersAr : $headersEn;

            fputcsv($file, $csvHeaders);

            /* =========================
            DATA ROWS
            ========================= */
            foreach ($users as $index => $user) {

                $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

                /* -------- MOBILE -------- */
                $mobile = '="' . ($user['country_code'] . $user['mobile']) . '"';

                /* -------- DATE -------- */
                $joiningDate = '="' . \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y') . '"';

                /* -------- ADDRESS -------- */
                $address = ($user['address_details']['address1'] ?? '') . ' ' .
                        ($user['address_details']['address2'] ?? '') . ' ' .
                        ($user['address_details']['town'] ?? '') . ' ' .
                        ($user['address_details']['city'] ?? '') . ' ' .
                        ($user['address_details']['pincode'] ?? '') . ' ' .
                        ($user['address_details']['state'] ?? '');

                $address = trim(str_replace(["\r", "\n"], ' ', $address));
                $address = $address ?: $na;

                /* -------- COUNTRY -------- */
                $country = $user['country_details'] ?? null;

                if ($country) {
                    $country = $locale == 'ar'
                        ? ($country['name_ar'] ?? $na)
                        : ($country['name'] ?? $na);
                } else {
                    $country = $na;
                }

                /* -------- REJECT REASON -------- */
                $rejectReason = $user['reject_reason'] ?? $na;
                $rejectReason = str_replace(["\r", "\n"], ' ', $rejectReason);

                /* -------- ROW -------- */
                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $user['profile_image'] ?? $na,
                    $user['full_name'] ?? $na,
                    $mobile,
                    $user['email'] ?? $na,
                    $country,
                    $address,
                    $rejectReason,
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }





    



}