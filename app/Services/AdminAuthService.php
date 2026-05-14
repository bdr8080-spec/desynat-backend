<?php
namespace App\Services;

use App\Models\Admin;
use App\Models\AdminPermission;
use App\Models\AdminModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubAdminCredentialsMail;
use App\Mail\SubAdminWelcomeMail;
use App\Mail\AdminOtpMail;

class AdminAuthService
{


    public function verify_otp($request){

        $get_user_details=  Admin::where('id',$request->admin_id)->first();

        if($get_user_details->otp==$request->otp){
            $get_user_details->update(['otp_verify'=>'1']);
                
            return ['status'=>'success','message' => __('Service_messages.otp_verified_successfully'),'data'=>$get_user_details];            
        
        }else{
            return ['status'=>'error','message' => __('Service_messages.otp_invalid'),'data'=>(object)[]];                
        }

    }


    public function loginCheck($request){
        
        try{

        $get_user_details=  Admin::where('email',$request->email)->where('status','1')->first();

        if($get_user_details){

            if(Hash::check($request->password,$get_user_details->password,)){
                 $updateData = [];
                    if (isset($request->device_type)) {
                        $updateData['device_type'] = $request->device_type;
                    }
                    if (isset($request->fcm_token)) {
                        $updateData['fcm_token'] = $request->fcm_token;
                    }
                    if (isset($request->lang)) {
                        $updateData['lang'] = $request->lang;
                    }
                    if (!empty($updateData)) {
                        $get_user_details->update($updateData);
                    }
                $get_user_details->accessToken = $get_user_details->createToken('admin')->plainTextToken;  
                
                return ['status'=>'success','message' =>__('Service_messages.admin_login_successfully'),'data'=>$get_user_details];                            
            }else{
                return ['status'=>'error','message' => __('Service_messages.wrong_password'),'data'=>(object)[]];                
            }
    
        }else{
        return ['status'=>'error','message' => __('Service_messages.account_not_exist_or_blocked'),'data'=>(object)[]];                
        }

        } catch (\Exception $e) {
            \Log::error('Notification Error: ' . $e->getMessage());
            return false;
        }

    }
        

    public function email_forgot_password($request){

        $get_user_details=  Admin::where('email',$request->email)->first();

        if($get_user_details){

            $otp= config('services.otp');

            $get_user_details->update(['otp'=>$otp]);
            Mail::to($get_user_details->email)->send(new AdminOtpMail($get_user_details, $otp));

            $get_user_details->accessToken ='';            
            return ['status'=>'success','message' => __('Service_messages.forgot_password_otp_sent_successfully'),'data'=>$get_user_details];            
        
        }else{
        return ['status'=>'error','message' => __('Service_messages.account_not_exist'),'data'=>(object)[]];                
        }

    }

    public function create_password($request){

        $get_user_details=  Admin::where('id',$request->id)->where('otp_verify','1')->first();

        if($get_user_details){
        
            $get_user_details->update(['password'=>hash::make($request->password)]);
            
            $get_user_details->accessToken =''; 
            $get_user_details->otp =''; 
            $get_user_details->otp_verify ='0';              
            return ['status'=>'success','message' => __('Service_messages.password_updated_successfully'),'data'=>$get_user_details];            
        
        }else{
        return ['status'=>'error','message' => __('Service_messages.account_not_exist'),'data'=>(object)[]];                
        }

    }

    public function logout($admin)
    {
        try {
            $admin->currentAccessToken()->delete();

            return ['status' => 'success', 'message' => __('Service_messages.admin_logged_out_successfully')];

        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Logout failed: ' . $e->getMessage()];
        }
    }

    public function resendOtp($request){

        $get_user_details=  Admin::where('email',$request->email)->first();

        if($get_user_details){

            $otp= config('services.otp');

            $get_user_details->update(['otp'=>$otp]);

            $get_user_details->accessToken ='';            
            return ['status'=>'success','message' => __('Service_messages.otp_send_successfully'),'data'=>$get_user_details];            
        
        }else{
        return ['status'=>'error','message' => __('Service_messages.account_not_exist'),'data'=>(object)[]];                
        }

    }

    public function AccountSetting($request_data)
    {
        try {
            $admin = Admin::find($request_data->user_id);

            if (!$admin) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.user_not_found'),
                    'data' => (object)[]
                ];
            }

            if (!empty($request_data->email)) {
                $emailExists = Admin::where('email', $request_data->email)
                    ->where('id', '!=', $request_data->user_id)
                    ->exists();

                if ($emailExists) {
                    return [
                        'status' => 'error',
                        'message' => __('Service_messages.email_already_assigned_coadmin'),
                        'data' => (object)[]
                    ];
                }
            }

            $mobileExists = Admin::where('mobile', $request_data->mobile)
                ->where('country_code', $request_data->country_code)
                ->where('id', '!=', $request_data->user_id)
                ->exists();

            if ($mobileExists) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.mobile_already_assigned_coadmin'),
                    'data' => (object)[]
                ];
            }

            $admin->profile_pic  = $request_data->profile_pic;
            $admin->full_name    = $request_data->full_name;
            $admin->country_code = $request_data->country_code;
            $admin->mobile       = $request_data->mobile;
            $admin->email       = $request_data->email;

            $admin->save();

            return [
                'status' => 'success',
                'message' => __('Service_messages.account_settings_updated_successfully'),
                'data' => $admin
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update account: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function UpdatePassword($request_data)
    {
        try {
            $admin = Admin::find($request_data->user_id);

            if (!$admin) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.user_not_found'),
                    'data' => (object)[]
                ];
            }

            if (!Hash::check($request_data->old_password, $admin->password)) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.old_password_incorrect'),
                    'data' => (object)[]
                ];
            }

            if (Hash::check($request_data->new_password, $admin->password)) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.new_password_same_old'),
                    'data' => (object)[]
                ];
            }

            $admin->password = Hash::make($request_data->new_password);
            $admin->unhashed_password = $request_data->new_password;
            $admin->save();

            return [
                'status' => 'success',
                'message' => __('Service_messages.password_updated_successfully'),
                'data' => $admin
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update password: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }
    

    public function AddSubAdmin($req)
    {
        DB::beginTransaction();

        try {

                $emailExists = Admin::where('email', $req->email)->first();
                if ($emailExists) {
                    return [
                        'status' => 'error',
                        'message' => __('Service_messages.email_already_registered'),
                        'data' => (object)[]
                    ];
                }

                $mobileExists = Admin::where('country_code', $req->country_code)
                    ->where('mobile', $req->mobile)
                    ->first();
                if ($mobileExists) {
                    return [
                        'status' => 'error',
                        'message' => __('Service_messages.mobile_already_registered'),
                        'data' => (object)[]
                    ];
                }

            $admin = Admin::create([
                'profile_pic' => $req->profile_pic??null,
                'full_name' => $req->full_name,
                'full_name_ar' => $req->full_name_ar,
                'country_code' => $req->country_code,
                'mobile' => $req->mobile,
                'email' => $req->email,
                'country_id' => $req->country_id,
                'password' => Hash::make($req->password),
                'unhashed_password' => $req->password,
                'type' => 2, 
            ]);

            $permissions = [];

            foreach ($req->modules as $module) {

                $permissions[] = [
                    'admin_id' => $admin->id,
                    'module_id' => $module['module_id'],

                    'can_view' => isset($module['can_view']) ? (int)$module['can_view'] : 0,
                    'can_action' => isset($module['can_action']) ? (int)$module['can_action'] : 0,

                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            AdminPermission::insert($permissions);

            DB::commit();
            Mail::to($admin->email)->send(new SubAdminWelcomeMail($admin));

            return [
                'status' => 'success',
                'message' => __('Service_messages.sub_admin_created_successfully'),
                'data' => $admin
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Something went wrong while creating sub admin',
                'data' => $e->getMessage()
            ];
        }
    }


    public function UpdateSubAdmin($req)
    {
        DB::beginTransaction();

        try {

            $admin = Admin::where('id', $req->id)->first();

            if (!$admin) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.user_not_found'),
                    'data' => []
                ];
            }

            $emailExists = Admin::where('email', $req->email)
                ->where('id', '!=', $req->id)
                ->first();

            if ($emailExists) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.email_already_registered'),
                    'data' => (object)[]
                ];
            }

            $mobileExists = Admin::where('country_code', $req->country_code)
                ->where('mobile', $req->mobile)
                ->where('id', '!=', $req->id)
                ->first();

            if ($mobileExists) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.mobile_already_registered'),
                    'data' => (object)[]
                ];
            }

            $admin->update([
                'profile_pic' => $req->profile_pic??null,
                'full_name' => $req->full_name,
                'full_name_ar' => $req->full_name_ar,
                'country_code' => $req->country_code,
                'mobile' => $req->mobile,
                'email' => $req->email,
                'country_id' => $req->country_id,
                'password' => Hash::make($req->password),
                'unhashed_password' => $req->password,
                'type' => 2,
            ]);

            AdminPermission::where('admin_id', $admin->id)->delete();
            $permissions = [];

            foreach ($req->modules as $module) {

                $permissions[] = [
                    'admin_id' => $admin->id,
                    'module_id' => $module['module_id'],

                    'can_view' => isset($module['can_view']) ? (int)$module['can_view'] : 0,
                    'can_action' => isset($module['can_action']) ? (int)$module['can_action'] : 0,

                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            AdminPermission::insert($permissions);

            DB::commit();

            return [
                'status' => 'success',
                'message' => __('Service_messages.sub_admin_updated_successfully'),
                'data' => $admin->fresh()
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Something went wrong while updating sub admin',
                'data' => $e->getMessage()
            ];
        }
    }


    public function DeleteSubAdmin($req)
    {
        DB::beginTransaction();

        try {

            $admin = Admin::where('id', $req->id)
                ->where('type', 2)
                ->first();

            if (!$admin) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.user_not_found'),
                    'data' => (object)[]
                ];
            }
             
            $id = Auth::user()->id;
            //dd($id);

            if ($id == $admin->id) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.cannot_delete_self'),
                    'data' => (object)[]
                ];
            }

            AdminPermission::where('admin_id', $admin->id)->delete();

            $admin->delete();

            DB::commit();

            return [
                'status' => 'success',
                'message' => __('Service_messages.sub_admin_deleted_successfully'),
                'data' => (object)[]
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => $e->getMessage()
            ];
        }
    }

    public function DeleteSubAdminWeb($req)
    {
        DB::beginTransaction();

        try {

            $admin = Admin::where('id', $req->id)
                ->where('type', 2)
                ->first();

            if (!$admin) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.user_not_found'),
                    'data' => (object)[]
                ];
            }
             
            $id = $req->auth_id;
            //dd($id);

            if ($id == $admin->id) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.cannot_delete_self'),
                    'data' => (object)[]
                ];
            }

            AdminPermission::where('admin_id', $admin->id)->delete();

            $admin->delete();

            DB::commit();

            return [
                'status' => 'success',
                'message' => __('Service_messages.sub_admin_deleted_successfully'),
                'data' => (object)[]
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => $e->getMessage()
            ];
        }
    }


    public function GetAdminPanelModules($req)
    {
        try {

            $modules = AdminModule::orderBy('id', 'asc')->get();

            return [
                'status' => 'success',
                'message' => __('Service_messages.modules_fetched_successfully'),
                'data' => $modules
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Something went wrong while fetching modules',
                'data' => $e->getMessage()
            ];
        }
    }


    public function GetSubAdmins($request_data)
    {
        try {

            $filteredQuery = Admin::query()
                ->where('type', '2');

            if (!empty($request_data->search)) {
                $filteredQuery->where('full_name', 'like', '%' . $request_data->search . '%');
            }

            if (!empty($request_data->country_id)) {
                $filteredQuery->where('country_id', $request_data->country_id);
            }

            if ($request_data->status !== null && $request_data->status !== '') {
                $filteredQuery->where('status', $request_data->status);
            }

            if (!empty($request_data->from_date) && !empty($request_data->to_date)) {
                $filteredQuery->whereBetween('created_at', [
                    $request_data->from_date . ' 00:00:00',
                    $request_data->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request_data->from_date)) {
                $filteredQuery->whereDate('created_at', '>=', $request_data->from_date);
            } elseif (!empty($request_data->to_date)) {
                $filteredQuery->whereDate('created_at', '<=', $request_data->to_date);
            }

            $total_count = (clone $filteredQuery)->count();

            $total_active_count = Admin::where('type', '2')
                ->where('status', '1')
                ->count();

            $total_inactive_count = Admin::where('type', '2')
                ->where('status', '0')
                ->count();

            $query = (clone $filteredQuery)
                ->with([
                    'country_info',
                    'permission_details.module_details'
                ])
                ->orderBy('id', 'desc');

            $result = new \stdClass();

            if (!empty($request_data->limit)) {
                $result->list = $query->paginate($request_data->limit);
            } else {
                $result->list = $query->get();
            }

            $result->total_count = $total_count;
            $result->total_active_count = $total_active_count;
            $result->total_inactive_count = $total_inactive_count;

            return [
                'status' => 'success',
                'message' => __('Service_messages.sub_admins_fetched_successfully'),
                'data' => $result
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Something went wrong while fetching sub admins',
                'data' => $e->getMessage()
            ];
        }
    }

    public function GetActiveSubAdmins($request_data)
    {
        try {

            $filteredBase = Admin::query()
                ->where('type', '2');

            if (!empty($request_data->search)) {
                $filteredBase->where('full_name', 'like', '%' . $request_data->search . '%');
            }

            if (!empty($request_data->country_id)) {
                $filteredBase->where('country_id', $request_data->country_id);
            }

            if (!empty($request_data->from_date) && !empty($request_data->to_date)) {
                $filteredBase->whereBetween('created_at', [
                    $request_data->from_date . ' 00:00:00',
                    $request_data->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request_data->from_date)) {
                $filteredBase->whereDate('created_at', '>=', $request_data->from_date);
            } elseif (!empty($request_data->to_date)) {
                $filteredBase->whereDate('created_at', '<=', $request_data->to_date);
            }


            $total_count = Admin::where('type', '2')->count();

            $total_inactive_count = Admin::where('type', '2')
                ->where('status', '0')
                ->count();

            $total_active_count = (clone $filteredBase)
                ->where('status', '1')
                ->count();

            $query = (clone $filteredBase)
                ->with([
                    'country_info',
                    'permission_details.module_details'
                ])
                ->where('status', '1')
                ->orderBy('id', 'desc');

            $result = new \stdClass();

            if (!empty($request_data->limit)) {
                $result->list = $query->paginate($request_data->limit);
            } else {
                $result->list = $query->get();
            }

            $result->total_count = $total_count;
            $result->total_active_count = $total_active_count;
            $result->total_inactive_count = $total_inactive_count;

            return [
                'status' => 'success',
                'message' => __('Service_messages.active_sub_admins_fetched_successfully'),
                'data' => $result
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Something went wrong while fetching active sub admins',
                'data' => $e->getMessage()
            ];
        }
    }

    public function GetInactiveSubAdmins($request_data)
    {
        try {

            $filteredBase = Admin::query()
                ->where('type', '2');

            if (!empty($request_data->search)) {
                $filteredBase->where('full_name', 'like', '%' . $request_data->search . '%');
            }

            if (!empty($request_data->country_id)) {
                $filteredBase->where('country_id', $request_data->country_id);
            }

            if (!empty($request_data->from_date) && !empty($request_data->to_date)) {
                $filteredBase->whereBetween('created_at', [
                    $request_data->from_date . ' 00:00:00',
                    $request_data->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request_data->from_date)) {
                $filteredBase->whereDate('created_at', '>=', $request_data->from_date);
            } elseif (!empty($request_data->to_date)) {
                $filteredBase->whereDate('created_at', '<=', $request_data->to_date);
            }

            $total_count = Admin::where('type', '2')->count();

            $total_active_count = Admin::where('type', '2')
                ->where('status', '1')
                ->count();

            $total_inactive_count_global = Admin::where('type', '2')
                ->where('status', '0')
                ->count();


            $total_inactive_count = (clone $filteredBase)
                ->where('status', '0')
                ->count();

            $query = (clone $filteredBase)
                ->with([
                    'country_info',
                    'permission_details.module_details'
                ])
                ->where('status', '0')
                ->orderBy('id', 'desc');

            $result = new \stdClass();

            if (!empty($request_data->limit)) {
                $result->list = $query->paginate($request_data->limit);
            } else {
                $result->list = $query->get();
            }

            $result->total_count = $total_count;
            $result->total_active_count = $total_active_count;
            $result->total_inactive_count = $total_inactive_count;

            return [
                'status' => 'success',
                'message' => __('Service_messages.inactive_sub_admins_fetched_successfully'),
                'data' => $result
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Something went wrong while fetching inactive sub admins',
                'data' => $e->getMessage()
            ];
        }
    }

    public function GetProfile($request_data)
    {
        try {

            $admin = Admin::with([
                    'country_info'
                ])
                ->where('id', $request_data->user_id)
                ->first();

            if (!$admin) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.profile_not_found'),
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Profile fetched successfully',
                'data' => $admin
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Something went wrong while fetching profile',
                'data' => $e->getMessage()
            ];
        }
    }


    public function SubAdminDetails($request_data)
    {
        try {

            $admin = Admin::with([
                    'country_info',
                    'permission_details.module_details'
                ])
                ->where('id', $request_data->id)
                ->where('type', '2')
                ->first();

            if (!$admin) {
                return [
                    'status' => 'error',
                    'message' => 'Sub admin not found',
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Sub admin details fetched successfully',
                'data' => $admin
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Something went wrong while fetching sub admin details',
                'data' => $e->getMessage()
            ];
        }
    }

    public function UpdateSubAdminStatus($request_data)
    {
        DB::beginTransaction();

        try {

            $admin = Admin::where('id', $request_data->id)
                ->where('type', '2')
                ->first();

            if (!$admin) {
                return [
                    'status' => 'error',
                    'message' => 'Sub admin not found',
                    'data' => []
                ];
            }

            $newStatus = $admin->status == 1 ? 0 : 1;

            $admin->update([
                'status' => $newStatus
            ]);

            DB::commit();

            return [
                'status' => 'success',
                'message' => $newStatus == 1
                    ? __('Service_messages.status_updated_to_active')
                    : __('Service_messages.status_updated_to_inactive'),
                'data' => $admin
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Something went wrong while updating status',
                'data' => $e->getMessage()
            ];
        }
    }



    public function SendSubAdminCredentials($request)
    {
        try {
            $admin = Admin::where('id', $request->id)
                        ->where('type', '2')
                        ->first();

            if (!$admin) {
                return [
                    'status' => 'error',
                    'message' => 'Sub Admin not found',
                    'data' => (object)[]
                ];
            }

            $plainPassword = $admin->unhashed_password;

            if (empty($plainPassword)) {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.password_not_available'),
                    'data' => (object)[]
                ];
            }

            Mail::to($admin->email)->send(new SubAdminCredentialsMail($admin, $plainPassword));

            return [
                'status' => 'success',
                'message' => __('Service_messages.credentials_sent_successfully'),
                'data' => $admin
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => $e->getMessage(), 
                'data' => (object)[]
            ];
        }
    }
    

            
        

    
    






}
    