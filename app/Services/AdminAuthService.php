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
    

            
        

    
    






}
    