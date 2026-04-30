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
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($users) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'SR No',
                'Joining Date',
                'Name',
                'Image URL',
                'Phone Number',
                'Country',
                'Email',
                'Completed Orders',
                'Cancelled Orders',
                'Wallet Balance(KD)',
                'Status'
            ]);

            foreach ($users as $index => $user) {

                $wallet = $user->wallet_info->amount ?? 0;
                $country = $user->country_info->name ?? 'N/A';
                $status = $user->status == 1 ? 'Active' : 'Inactive';

                fputcsv($file, [
                    $index + 1,

                    '="' . \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') . '"',

                    $user->full_name ?? 'N/A',
                    $user->profile_image ?? '',

                    '="' . ($user->country_code . $user->mobile) . '"',

                    $country,
                    $user->email ?? 'N/A',

                    'N/A',
                    'N/A',

                    $wallet,
                    $status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    



}