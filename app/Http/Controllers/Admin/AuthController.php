<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\country;
use App\Helpers\ApiResponse;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Services\OrderManagementService;
use App\Services\CountryService;
use App\Services\AdminAuthService;
use App\Http\Controllers\CommonController;
 
class AuthController extends Controller
{
    public function __construct(OrderManagementService $OrderManagementService, CountryService $CountryService, AdminAuthService $AdminAuthService)
    {
        $this->OrderManagementService = $OrderManagementService;
        $this->CountryService = $CountryService;
        $this->AdminAuthService = $AdminAuthService;
    }

    
    // public function adminLogin(Request $request)
    // {
    //     if ($request->isMethod('get')) {
    //         return view('admin.auth.login');
    //     } else {
    //         $validator = Validator::make($request->all(), [
    //             'email' => 'required|email',
    //             'password' => 'required',
    //         ], [
    //             'email.required' => 'Please Enter Email Id',
    //             'email.email' => 'Please Enter a Valid Email Id',
    //             'password.required' => 'Please Enter Password'
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['errors' => $validator->errors()], 422);
    //         }

    //         $admin = Admin::where('email', $request->email)->first();
    //         if (!$admin) {
    //             return response()->json(['errors' => ['email' => ['Email is not registered']]], 422);
    //         }

    //         if ($admin->status == '0') {
    //             return response()->json(['errors' => ['email' => ['Your Account Is Blocked']]], 422);
    //         }


    //         if (!Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
    //             return response()->json(['errors' => ['password' => ['Password is Incorrect']]], 422);
    //         }

    //         return response()->json(['success' => true]);
    //     }
    // }

    public function adminLogin(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.auth.login');
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Please Enter Email Id',
            'email.email' => 'Please Enter a Valid Email Id',
            'password.required' => 'Please Enter Password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return response()->json([
                'type' => 'auth',
                'message' => 'Email is not registered'
            ], 422);
        }

        if ($admin->status == '0') {
            return response()->json([
                'type' => 'auth',
                'message' => 'Your Account Is Blocked'
            ], 422);
        }

        if (!Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return response()->json([
                'type' => 'auth',
                'message' => 'Password is Incorrect'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login Successful'
        ]);
    }


    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout(); 

        return redirect()->route('adminLogin');
    }
 
    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.auth.forgot-password');
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:admins,email',
            ], [
                'email.required' => 'Please Enter Email Id',
                'email.email' => 'Please Enter a Valid Email Id',
                'email.exists' => 'Email not found in admin records.'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $admin = Admin::where('email', $request->email)->first();
            $otp= config('services.otp');
            $admin->otp = $otp;
            $admin->save();

            session(['admin_email' => $admin->email]);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully.'
            ]);
        }
    }

 
     public function optVerify(Request $request)
    {
        if($request->isMethod('get')){
            return view('admin.auth.otp-verify', ['email' => session('admin_email')]);
        } else {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|digits:6',
                'email' => 'required|email|exists:admins,email'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $admin = Admin::where('email', $request->email)->first();

            if($admin->otp !== $request->otp){
                return response()->json(['errors' => ['otp' => ['Invalid OTP']]], 422);
            }

            $admin->otp = null;
            $admin->otp_verify = 1;
            $admin->save();
            session(['reset_email' => $admin->email]);

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully.'
            ]);
        }
    }

    public function resendOtp(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();
        if($admin){
            $otp= config('services.otp');
            $admin->otp = $otp; 
            $admin->otp_verify = 0;
            $admin->save();
            session(['reset_email' => $admin->email]);
            return response()->json([
                'success' => true,
                'message' => 'OTP resent successfully.'
            ]);
        }
        return response()->json(['errors' => ['email' => ['Admin not found']]], 422);
    }

    public function changePassword(Request $request)
    {
        if ($request->isMethod('get')) {
            $email = session('reset_email'); 
            return view('admin.auth.reset-password', compact('email'));
        }

       $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
        ], [
            'password.required' => 'Please Enter Password',
            'confirm_password.required' => 'Please Enter Confirm Password',
        ]);

        if ($request->password !== $request->confirm_password) {
            return response()->json([
                'success' => false,
                'errors' => ['confirm_password' => ['Password and confirm password do not match']]
            ], 422);
        }

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => ['Email not found']]
            ], 422);
        }

        $admin->password = Hash::make($request->password);
        $admin->otp = null;
        $admin->save();

        $request->session()->forget('reset_email');

        return response()->json(['success' => true]);
    }

    public function accountSetting(Request $request)
    {
        $country= country::all();
        $admin = Auth::guard('admin')->user();
        $user_id = $admin->id;
            $request_data = (object)[
                'user_id' => $user_id,
            ];
        $data = $this->AdminAuthService->GetProfile($request_data)['data'];
        //dd($data);
      return view('admin.account-setting.index',compact('country','data'));
    }

    public function update_account(Request $request)
    {
       // dd($request->all());

        $validate = Validator::make($request->all(), [
            'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'full_name'    => 'required',
            'country_code' => 'required',
            'mobile'       => 'required',
            'email'        => 'required|email',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation error',
                'errors'  => $validate->errors()
            ], 422);
        }


        $admin = Auth::guard('admin')->user();
        $user_id = $admin->id;

        $imageUrl = $admin->profile_pic??null;

        if ($request->hasFile('image')) {

            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true);

            if ($uploadResultArray['status'] === 'error') {
                return response()->json([
                    'status'  => 'error',
                    'message' => $uploadResultArray['message']
                ], 400);
            }

            $imageUrl = $uploadResultArray['data']['url'];
        }


        $request_data = (object)[
            'user_id'       => $user_id,
            'profile_pic'   => $imageUrl,
            'full_name'     => $request->full_name,
            'country_code'  => $request->country_code,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
        ];


        $data = $this->AdminAuthService->AccountSetting($request_data);


        if (isset($data['status']) && $data['status'] == 'error') {
            return response()->json([
                'status'  => 'error',
                'message' => $data['message'],
                'data'    => $data['data'] ?? null
            ], 400);
        }

        return response()->json([
            'status'  => 'success',
            'message' => $data['message'],
            'data'    => $data['data'] ?? null
        ], 200);
    }

    public function update_password(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/'
            ],
            'confirm_password' => 'required|same:new_password',
        ], [
            'new_password.regex' => 'Password must be at least 8 characters long and include 1 uppercase letter, 1 number, and 1 special character.',
            'confirm_password.same' => 'Confirm password must match new password.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validate->errors()
            ], 422);
        }

        $admin = Auth::guard('admin')->user();

        $request_data = (object)[
            'old_password' => $request->old_password,
            'new_password' => $request->new_password,
            'user_id' => $admin->id,
        ];

        $data = $this->AdminAuthService->UpdatePassword($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $data['message']
        ], 200);
    }

    public function subAdminManagement(Request $request)
    {
      $countries = $this->CountryService->getCountries($request)['data'];
      $request_data = (object)[
            'country_id' => $request->country_id??null,
            'from_date' => $request->from_date??null,
            'to_date' => $request->to_date??null,
            'status' => $request->status??null,
        ];
        //dd($request_data);
      $subAdmins = $this->AdminAuthService->GetSubAdmins($request_data)['data'];
      //dd($subAdmins);
      return view('admin.sub-admin.index',compact('subAdmins','countries'));
    }

    public function add_subadmin(Request $request)
    {
        $country= country::all();
      $modules = $this->AdminAuthService->GetAdminPanelModules($request)['data'];
      //dd($modules);
      return view('admin.sub-admin.add-subadmin',compact('modules','country'));
    }

    public function edit_subadmin(Request $request, $id)
    {   $country= country::all();
        $modules = $this->AdminAuthService->GetAdminPanelModules($request)['data'];
         $data = Admin::with('permission_details') 
                     ->findOrFail($id);
         //dd($subadmin);
      return view('admin.sub-admin.edit-subadmin',compact('modules','country','data'));
    }

    public function addSubadmin(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
              'full_name' => 'required',
              'full_name_ar' => 'required',
              'country_code' => 'required',
              'mobile' => 'required',
              'email' => 'required',
              'country_id' => 'required|exists:countries,id',
              'password' => [
                    'required',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/'
                ],
              'confirm_password' => 'required|same:password',
              'modules' => 'required|array',
              'modules.*.module_id' => 'required|exists:admin_modules,id',
              'modules.*.can_view' => 'required|in:0,1',
              'modules.*.can_action' => 'required|in:0,1',
        ], [
            'password.regex' => 'Password must be at least 8 characters long and include 1 uppercase letter, 1 number, and 1 special character.',
            'confirm_password.same' => 'Confirm password must match new password.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validate->errors()
            ], 422);
        }

        

        if ($request->hasFile('image')) {

            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true);

            if ($uploadResultArray['status'] === 'error') {
                return response()->json([
                    'status'  => 'error',
                    'message' => $uploadResultArray['message']
                ], 400);
            }

            $imageUrl = $uploadResultArray['data']['url'];
        }

        $request_data = (object)[
            'profile_pic' => $imageUrl??null,
            'full_name' => $request->full_name,
            'full_name_ar' => $request->full_name_ar,
            'country_code' => $request->country_code,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'country_id' => $request->country_id,
            'password' => $request->password,
            'modules' => $request->modules,
        ];

        $data = $this->AdminAuthService->AddSubAdmin($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $data['message']
        ], 200);
    }

    public function updateSubadmin(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id'=>'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
              'full_name' => 'required',
              'full_name_ar' => 'required',
              'country_code' => 'required',
              'mobile' => 'required',
              'email' => 'required',
              'country_id' => 'required|exists:countries,id',
              'password' => [
                    'required',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/'
                ],
              'confirm_password' => 'required|same:password',
              'modules' => 'required|array',
              'modules.*.module_id' => 'required|exists:admin_modules,id',
              'modules.*.can_view' => 'required|in:0,1',
              'modules.*.can_action' => 'required|in:0,1',
        ], [
            'password.regex' => 'Password must be at least 8 characters long and include 1 uppercase letter, 1 number, and 1 special character.',
            'confirm_password.same' => 'Confirm password must match new password.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validate->errors()
            ], 422);
        }

         $admin = Admin::where('id',$request->id)->first();
         $imageUrl = $admin->profile_pic??null;

        if ($request->hasFile('image')) {

            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true);

            if ($uploadResultArray['status'] === 'error') {
                return response()->json([
                    'status'  => 'error',
                    'message' => $uploadResultArray['message']
                ], 400);
            }

            $imageUrl = $uploadResultArray['data']['url'];
        }

        $request_data = (object)[
            'id' => $request->id,
            'profile_pic' => $imageUrl??null,
            'full_name' => $request->full_name,
            'full_name_ar' => $request->full_name_ar,
            'country_code' => $request->country_code,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'country_id' => $request->country_id,
            'password' => $request->password,
            'modules' => $request->modules,
        ];

        $data = $this->AdminAuthService->UpdateSubAdmin($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $data['message']
        ], 200);
    }

    public function refundManagement(Request $request)
    {
        $request_data = (object)[
            'limit' => $request->limit??null,
            'country_name' => $request->country_name??null,
            'from_date' => $request->from_date??null,
            'to_date' => $request->to_date??null,
            'search' => $request->search??null,
        ];
        $refundData = $this->OrderManagementService->RefundOrders($request_data);
        //dd($refundData);
        $countries = $this->CountryService->getUserAllCountries($request)['data'];
      return view('admin.refund-management.index',compact('refundData','countries'));
    }

    public function sendCredentials(Request $request)
    {

        $request_data = (object)[
            'id' => $request->id,
        ];

        $data = $this->AdminAuthService->SendSubAdminCredentials($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $data['message']
        ], 200);
    }

    public function deleteSubAdmin(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();
        $auth_id = $admin->id;
        $request_data = (object)[
            'id' => $id,
            'auth_id'=>$auth_id,
        ];

        $data = $this->AdminAuthService->DeleteSubAdminWeb($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $data['message']
        ], 200);
    }

    public function updateSubAdminStatus(Request $request, $id)
    {

        $request_data = (object)[
            'id' => $id,
        ];

        $data = $this->AdminAuthService->UpdateSubAdminStatus($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $data['message']
        ], 200);
    }

    public function export_refund_data(Request $request)
    {
        $request_data = (object)[
            'limit' => $request->limit ?? null,
            'country_name' => $request->country_name ?? null,
            'from_date' => $request->from_date ?? null,
            'to_date' => $request->to_date ?? null,
            'search' => $request->search ?? null,
        ];

        $response = $this->OrderManagementService->RefundOrders($request_data);

        $data = $response['data'] ?? collect();

        $refunds = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'refund_orders_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($refunds) {

            $file = fopen('php://output', 'w');

            // UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'Sr No',
                'Transaction ID',
                'Order ID',
                'Order Date & Time',
                'Cancellation Date & Time',
                'Seller Name',
                'User Name',
                'User Country',
                'Reason',
                'Amount(KD)',
                'Status'
            ]);

            foreach ($refunds as $index => $data) {

                $transactionId = '="' . ($data->order->transaction_id ?? 'N/A') . '"';
                $orderId = $data->order->order_id ?? 'N/A';

                $sellerName = trim(
                    ($data->product_details->seller_details->first_name ?? '') . ' ' .
                    ($data->product_details->seller_details->last_name ?? '')
                ) ?: 'N/A';

                $userName = $data->user_details->full_name ?? 'N/A';

                $country = $data->user_details->country_info->name ?? 'N/A';

                $orderDate = $data->created_at
                    ? $data->created_at->format('jS F Y | g:i A')
                    : '-';

                $cancelDate = $data->updated_at
                    ? $data->updated_at->format('jS F Y | g:i A')
                    : '-';

                $reason = $data->cancel_reason ?? 'N/A';

                $amount = ($data->amount ?? 0);

                $status = 'Pending';

                fputcsv($file, [
                    $index + 1,
                    $transactionId,
                    $orderId,
                    $orderDate,
                    $cancelDate,
                    $sellerName,
                    $userName,
                    $country,
                    $reason,
                    $amount,
                    $status
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

}