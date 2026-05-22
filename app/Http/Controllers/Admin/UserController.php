<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\UserManagementService;
use App\Services\CountryService;

 
class UserController extends Controller
{

    public function __construct(UserManagementService $UserManagementService, CountryService $CountryService)
    {
        $this->UserManagementService = $UserManagementService;
        $this->CountryService = $CountryService;
    }


    public function userManagement(Request $request){
        $countries = $this->CountryService->getUserAllCountries()['data'];
        $users = $this->UserManagementService->getUsers($request)['data'];
       // dd($users);
        return view('admin.user-management.index',compact('countries','users'));
    }

    public function blockUnblockUser($userId)
    {
        $result = $this->UserManagementService->blockUnblockUser($userId);

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

    public function addUserWalletAmount(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|min:1'
        ]);

        $userId = $request->user_id;
        $amount = $request->amount;

        $result = $this->UserManagementService->addUserWalletAmount($userId, $amount);

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


    public function export_user_data(Request $request)
    {
        $users = $this->UserManagementService->getUsers($request)['data'];

        $fileName = 'users_export_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        $callback = function () use ($users, $locale) {

            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS EN / AR
            ========================= */
            $headersEn = [
                'SR No',
                'Joining Date',
                'Name',
                'Image URL',
                'Phone Number',
                'Country',
                'Email',
                'Completed Orders',
                'Cancelled Orders',
                'Wallet Balance (KD)',
                'Status'
            ];

            $headersAr = [
                'الرقم',
                'تاريخ الانضمام',
                'الاسم',
                'رابط الصورة',
                'رقم الهاتف',
                'الدولة',
                'البريد الإلكتروني',
                'الطلبات المكتملة',
                'الطلبات الملغاة',
                'رصيد المحفظة (دينار)',
                'الحالة'
            ];

            $csvHeaders = $locale == 'ar' ? $headersAr : $headersEn;

            fputcsv($file, $csvHeaders);

            /* =========================
            DATA ROWS
            ========================= */
            foreach ($users as $index => $user) {

                $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

                /* -------- WALLET -------- */
                $wallet = $user->wallet_info->amount ?? 0;

                /* -------- COUNTRY -------- */
                $country = $user->country_info ?? null;

                if ($country) {
                    $country = $locale == 'ar'
                        ? ($country->name_ar ?? $na)
                        : ($country->name ?? $na);
                } else {
                    $country = $na;
                }

                /* -------- STATUS -------- */
                $status = $user->status == 1
                    ? ($locale == 'ar' ? 'نشط' : 'Active')
                    : ($locale == 'ar' ? 'غير نشط' : 'Inactive');

                /* -------- PHONE -------- */
                $mobile = '="' . ($user->country_code . $user->mobile) . '"';

                /* -------- DATE -------- */
                $joiningDate = $user->created_at
                    ? "\t" . formatDateTimeByLocale($user->created_at)
                    : '-';

                

                /* -------- ROW -------- */
                fputcsv($file, [
                    $index + 1,
                    $joiningDate,
                    $user->full_name ?? $na,
                    $user->profile_image ?? '',
                    $mobile,
                    $country,
                    $user->email ?? $na,
                    $user->total_completed_orders,
                    $user->total_cancelled_orders,
                    $wallet,
                    $status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    



}