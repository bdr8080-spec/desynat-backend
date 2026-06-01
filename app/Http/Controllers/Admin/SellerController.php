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
use App\Services\StoryManagementService;
 
class SellerController extends Controller
{
    public function __construct(SellerManagementService $SellerManagementService, CountryService $CountryService, StoryManagementService $StoryManagementService)
    {
        $this->SellerManagementService = $SellerManagementService;
        $this->CountryService = $CountryService;
        $this->StoryManagementService = $StoryManagementService;
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

    public function sellerInfo(Request $request,$id){
        $data = $this->SellerManagementService->getSellerDetailsById($id)['data'];
       // dd($data);
        return view('admin.seller-management.seller-info',compact('data'));
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

        $sellers = collect();

        if ($paginator && is_object($paginator) && method_exists($paginator, 'items')) {
            $sellers = collect($paginator->items());
        }

        $fileName = 'new_sellers_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($sellers, $locale) {

            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS (EN / AR)
            ========================= */
            $headersEn = [
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
            ];

            $headersAr = [
                'الرقم',
                'تاريخ الانضمام',
                'رابط الصورة',
                'الاسم الأول',
                'الاسم الأخير',
                'رقم الجوال',
                'البريد الإلكتروني',
                'الدولة',
                'اسم المتجر',
                'عنوان المتجر',
                'بريد المتجر',
                'السيرة الذاتية',
                'الحالة'
            ];

            $csvHeaders = $locale == 'ar' ? $headersAr : $headersEn;

            fputcsv($file, $csvHeaders);

            /* =========================
            DATA ROWS
            ========================= */
            foreach ($sellers as $index => $seller) {

                // -------------------------
                // COUNTRY (EN / AR)
                // -------------------------
                $country = $locale == 'ar' ? 'غير متوفر' : 'N/A';

                if (!empty($seller['store_info']['country'])) {
                    $countryModel = \App\Models\country::find($seller['store_info']['country']);

                    if ($countryModel) {
                        $country = $locale == 'ar'
                            ? ($countryModel->name_ar ?? 'غير متوفر')
                            : ($countryModel->name ?? 'N/A');
                    }
                }

                // -------------------------
                // N/A TRANSLATION
                // -------------------------
                $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

                // -------------------------
                // MOBILE
                // -------------------------
                $mobile = '="' . ($seller['country_code'] . $seller['mobile']) . '"';

                // -------------------------
                // DATE
                // -------------------------
                $joiningDate = $seller['created_at']
                    ? "\t" . formatDateTimeByLocale($seller['created_at'])
                    : '-';

                // -------------------------
                // STATUS (EN / AR)
                // -------------------------
                $status = $locale == 'ar' ? 'قيد الانتظار' : 'Pending';

                if (($seller['admin_verify'] ?? 0) == 2) {
                    $status = $locale == 'ar' ? 'مقبول' : 'Approved';
                } elseif (($seller['admin_verify'] ?? 0) == 3) {
                    $status = $locale == 'ar' ? 'مرفوض' : 'Rejected';
                }

                // -------------------------
                // CSV ROW
                // -------------------------
                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $seller['profile_pic'] ?? $na,
                    $seller['first_name'] ?? $na,
                    $seller['last_name'] ?? $na,
                    $mobile,
                    $seller['email'] ?? $na,
                    $country,
                    $seller['store_info']['store_name'] ?? $na,
                    $seller['store_info']['store_address'] ?? $na,
                    $seller['store_info']['store_mail_id'] ?? $na,
                    $seller['store_info']['bio'] ?? $na,
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

        $locale = app()->getLocale();

        return response()->stream(function () use ($sellers, $locale) {

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
            ];

            $headersAr = [
                'الرقم',
                'تاريخ الانضمام',
                'رابط الصورة',
                'الاسم الأول',
                'الاسم الأخير',
                'رقم الجوال',
                'البريد الإلكتروني',
                'الدولة',
                'اسم المتجر',
                'عنوان المتجر',
                'بريد المتجر',
                'السيرة الذاتية',
                'الخطة الحالية',
                'الطلبات المكتملة',
                'الطلبات الملغاة',
                'إجمالي الأرباح',
                'العمولة المدفوعة',
                'التقييم',
                'الحالة'
            ];

            $csvHeaders = $locale == 'ar' ? $headersAr : $headersEn;

            fputcsv($file, $csvHeaders);

            /* =========================
            DATA ROWS
            ========================= */
            foreach ($sellers as $index => $seller) {

                $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

                /* -------- COUNTRY -------- */
                $country = $na;
                if (!empty($seller['store_info']['country'])) {
                    $countryModel = \App\Models\country::find($seller['store_info']['country']);
                    if ($countryModel) {
                        $country = $locale == 'ar'
                            ? ($countryModel->name_ar ?? $na)
                            : ($countryModel->name ?? $na);
                    }
                }

                /* -------- PLAN -------- */
                $planName = $na;
                if (!empty($seller['subcription_plan'][0]['plan_id'])) {
                    $plan = \App\Models\Plan::find($seller['subcription_plan'][0]['plan_id']);

                    if ($plan) {
                        $planName = $locale == 'ar'
                            ? ($plan->plan_name_ar ?? $plan->plan_name_english ?? $na)
                            : ($plan->plan_name_english ?? $na);
                    }
                }

                /* -------- MOBILE -------- */
                $mobile = '="' . ($seller['country_code'] . $seller['mobile']) . '"';

                /* -------- DATE -------- */
                $joiningDate = $seller['created_at']
                    ? "\t" . formatDateTimeByLocale($seller['created_at'])
                    : '-';

                /* -------- BIO SAFE -------- */
                $bio = $seller['store_info']['bio'] ?? $na;
                $bio = str_replace(["\r", "\n"], ' ', $bio);

                /* -------- STATUS -------- */
                $status = ($seller['is_block'] == 0)
                    ? ($locale == 'ar' ? 'نشط' : 'Active')
                    : ($locale == 'ar' ? 'غير نشط' : 'Inactive');

                /* -------- ROW -------- */
                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $seller['profile_pic'] ?? $na,
                    $seller['first_name'] ?? $na,
                    $seller['last_name'] ?? $na,
                    $mobile,
                    $seller['email'] ?? $na,
                    $country,
                    $seller['store_info']['store_name'] ?? $na,
                    $seller['store_info']['store_address'] ?? $na,
                    $seller['store_info']['store_mail_id'] ?? $na,
                    $bio,
                    $planName,
                    $seller['total_completed_orders'] ?? 0,
                    $seller['total_cancelled_orders'] ?? 0,
                    $seller['total_earning'] ?? 0,
                    $seller['commission_paid'] ?? 0,
                    $seller['average_product_rating'] ?? 0,
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

        $sellers = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'rejected_sellers_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($sellers, $locale) {

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
            ];

            $headersAr = [
                'الرقم',
                'تاريخ الانضمام',
                'رابط الصورة',
                'الاسم الأول',
                'الاسم الأخير',
                'رقم الجوال',
                'البريد الإلكتروني',
                'الدولة',
                'اسم المتجر',
                'عنوان المتجر',
                'بريد المتجر',
                'السيرة الذاتية',
                'سبب الرفض'
            ];

            $csvHeaders = $locale == 'ar' ? $headersAr : $headersEn;

            fputcsv($file, $csvHeaders);

            /* =========================
            DATA ROWS
            ========================= */
            foreach ($sellers as $index => $seller) {

                $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

                /* -------- COUNTRY -------- */
                $country = $na;

                if (!empty($seller['store_info']['country'])) {
                    $countryModel = \App\Models\Country::find($seller['store_info']['country']);

                    if ($countryModel) {
                        $country = $locale == 'ar'
                            ? ($countryModel->name_ar ?? $na)
                            : ($countryModel->name ?? $na);
                    }
                }

                /* -------- MOBILE -------- */
                $mobile = '="' . ($seller['country_code'] . $seller['mobile']) . '"';

                /* -------- DATE -------- */
                $joiningDate = $seller['created_at']
                    ? "\t" . formatDateTimeByLocale($seller['created_at'])
                    : '-';

                /* -------- BIO -------- */
                $bio = $seller['store_info']['bio'] ?? $na;
                $bio = str_replace(["\r", "\n"], ' ', $bio);

                /* -------- REJECT REASON -------- */
                $rejectReason = $seller['reject_reason'] ?? $na;
                $rejectReason = str_replace(["\r", "\n"], ' ', $rejectReason);

                /* -------- ROW -------- */
                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $seller['profile_pic'] ?? $na,
                    $seller['first_name'] ?? $na,
                    $seller['last_name'] ?? $na,
                    $mobile,
                    $seller['email'] ?? $na,
                    $country,
                    $seller['store_info']['store_name'] ?? $na,
                    $seller['store_info']['store_address'] ?? $na,
                    $seller['store_info']['store_mail_id'] ?? $na,
                    $bio,
                    $rejectReason,
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function deleteReel(Request $request,$id)
    {

        $request_data=(object )[
            'reel_id'=>$id,
        ];

            $result = $this->StoryManagementService->deleteSellerReel($request_data);

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

    public function deleteStory(Request $request,$id)
    {

        $request_data=(object )[
            'story_id'=>$id,
        ];

            $result = $this->StoryManagementService->deleteSellerStory($request_data);

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




}