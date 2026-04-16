<?php
namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Hash;

class AdminAuthService
{


    public function verify_otp($request){

        $get_user_details=  Admin::where('id',$request->admin_id)->first();

        if($get_user_details->otp==$request->otp){
            $get_user_details->update(['otp_verify'=>'1']);
                
            return ['status'=>'success','message'=>"Otp Verified Successfully",'data'=>$get_user_details];            
        
        }else{
            return ['status'=>'error','message'=>"Otp is invalid",'data'=>(object)[]];                
        }

    }


    public function loginCheck($request){

        $get_user_details=  Admin::where('email',$request->email)->first();

        if($get_user_details){

            if(Hash::check($request->password,$get_user_details->password,)){
                 $updateData = [];
                    if (isset($request->device_type)) {
                        $updateData['device_type'] = $request->device_type;
                    }
                    if (isset($request->fcm_token)) {
                        $updateData['fcm_token'] = $request->fcm_token;
                    }
                    if (!empty($updateData)) {
                        $get_user_details->update($updateData);
                    }
                $get_user_details->accessToken = $get_user_details->createToken('admin')->plainTextToken;            
                return ['status'=>'success','message'=>"Admin Login Successfully",'data'=>$get_user_details];                            
            }else{
                return ['status'=>'error','message'=>"Please enter correct password",'data'=>(object)[]];                
            }
    
        }else{
        return ['status'=>'error','message'=>"Admin does not exist",'data'=>(object)[]];                
        }

    }
        

    public function email_forgot_password($request){

        $get_user_details=  Admin::where('email',$request->email)->first();

        if($get_user_details){

            $otp= config('services.otp');

            $get_user_details->update(['otp'=>$otp]);

            $get_user_details->accessToken ='';            
            return ['status'=>'success','message'=>"Forgot Password Otp Send Successfully",'data'=>$get_user_details];            
        
        }else{
        return ['status'=>'error','message'=>"Admin does not exist",'data'=>(object)[]];                
        }

    }

    public function create_password($request){

        $get_user_details=  Admin::where('id',$request->id)->where('otp_verify','1')->first();

        if($get_user_details){
        
            $get_user_details->update(['password'=>hash::make($request->password)]);
            
            $get_user_details->accessToken =''; 
            $get_user_details->otp =''; 
            $get_user_details->otp_verify ='0';              
            return ['status'=>'success','message'=>"Password Updated Successfully",'data'=>$get_user_details];            
        
        }else{
        return ['status'=>'error','message'=>"Admin does not exist",'data'=>(object)[]];                
        }

    }

    public function logout($admin)
    {
        try {
            $admin->currentAccessToken()->delete();

            return ['status' => 'success', 'message' => 'Admin logged out successfully'];

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
            return ['status'=>'success','message'=>"Otp Send Successfully",'data'=>$get_user_details];            
        
        }else{
        return ['status'=>'error','message'=>"Admin does not exist",'data'=>(object)[]];                
        }

    }

    public function AccountSetting($request_data)
    {
        try {
            $admin = Admin::find($request_data->user_id);

            if (!$admin) {
                return [
                    'status' => 'error',
                    'message' => 'User not found',
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
                        'message' => 'Email already assigned to another co-admin',
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
                    'message' => 'Mobile number already assigned to another co-admin',
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
                'message' => 'Account settings updated successfully',
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
                    'message' => 'Admin not found',
                    'data' => (object)[]
                ];
            }

            if (!Hash::check($request_data->old_password, $admin->password)) {
                return [
                    'status' => 'error',
                    'message' => 'Old password is incorrect',
                    'data' => (object)[]
                ];
            }

            if (Hash::check($request_data->new_password, $admin->password)) {
                return [
                    'status' => 'error',
                    'message' => 'Old password should not be used as new password',
                    'data' => (object)[]
                ];
            }

            $admin->password = Hash::make($request_data->new_password);
            $admin->save();

            return [
                'status' => 'success',
                'message' => 'Password updated successfully',
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
    

            
        

    
    






}
    