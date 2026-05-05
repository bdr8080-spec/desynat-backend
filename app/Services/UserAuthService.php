<?php
namespace App\Services;

use App\Models\{User,AffilatedUser};

use Hash;
use Illuminate\Support\Facades\DB;
use App\Services\TwilioService;

class UserAuthService
{

   public function __construct(TwilioService $TwilioService){

        $this->TwilioService=$TwilioService;

    }

    function register($request){

        $password_hash=Hash::make($request->password);

        // $otp="123456";

       $otp= config('services.otp');

        $record=[
            'profile_image'=>$request->profile_image,
            'full_name'=>$request->full_name,
            'country_code'=>$request->country_code,
            'mobile'=>$request->mobile,
            'email'=>$request->email,
            'password'=>$password_hash ,
            'otp'=>$otp,
            'lang' =>$request->lang
        ];

       $check=  User::create($record);

      $phone = $request->country_code . $request->mobile;
      $message = "Your verification Code Is $otp";
      if (preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
                    try {
                        $this->TwilioService->sendOtp($phone, $message);
                    } catch (\Exception $e) {
                        // ❌ silently skip (no return, no error)
                        // Optional: log for debugging
                        //\Log::warning('Twilio SMS skipped: ' . $e->getMessage());
                    }
                }

        if($check){
            return ['status'=>'success','message'=>"OTP sent succesfully",'data'=>$check];            
        }


    }


    public function verify_otp($request){

    $get_user_details=  User::where('id',$request->user_id)->first();

    if($get_user_details->otp==$request->otp){
        $get_user_details->update(['otp_verify'=>'1']);

        if($request->type=='1'){
        $get_user_details->accessToken = $get_user_details->createToken('user-token', ['user'])->plainTextToken;   
      
      }else{
        $get_user_details->accessToken ='';  
      }  
        
        return ['status'=>'success','message'=>"Otp Verified Successfully",'data'=>$get_user_details];            
    
      }else{
        return ['status'=>'error','message'=>"Invalid OTP",'data'=>(object)[]];                
      }

    }


    public function loginCheck($request){

      if($request->type=='0'){

        $get_user_details=  User::with('User_currency')->where('country_code',$request->country_code)->Where('mobile',$request->email_mobile)->where('otp_verify','1')->first();

      }else{

        $get_user_details=  User::with('User_currency')->where('email',$request->email_mobile)->where('otp_verify','1')->first();

      }

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
         
                 $get_user_details->update(['lang'=> $request->lang??null]);// update code in language 
                 $get_user_details->update(['is_login' => 1]);
                 $get_user_details->update(['is_visit_app' => 1]);
         
              // $get_user_details->accessToken = $get_user_details->createToken('user')->plainTextToken;   
              $get_user_details->accessToken = $get_user_details->createToken('user-token', ['user'])->plainTextToken;   
              
              $affilated_User=AffilatedUser::where('user_id',$get_user_details->id)->where('otp_verify','1')->first();

            
              if($affilated_User){

                $get_user_details->affiliated_userdetails= $affilated_User;
                $get_user_details->affiliated_accessToken = $affilated_User->createToken('affilated-token', ['AffilatedUser'])->plainTextToken;
              }else{
                $get_user_details->affiliated_userdetails= (object)[];
                $get_user_details->affiliated_accessToken ='';
              }

              
              
            return ['status'=>'success','message'=>"User Login Successfully",'data'=>$get_user_details];                            
            }else{
                return ['status'=>'error','message'=>"Please enter correct password",'data'=>(object)[]];                
            }
        
          }else{
            return ['status'=>'error','message'=>"Account does not exist",'data'=>(object)[]];                
          }
    
        }



    public function login_by_mobile_or_email($request){

      if($request->type=='0'){
        

        $get_user_details=  User::where('country_code',$request->country_code)->Where('mobile',$request->email_mobile)->where('otp_verify','1')->first();

      }else{
        $get_user_details=  User::where('email',$request->email_mobile)->where('otp_verify','1')->first();

      }

        // $get_user_details=  User::where('email',$request->email_mobile)->orWhere('mobile',$request->email_mobile)->where('otp_verify','1')->first();

        if($get_user_details){

           $otp= config('services.otp');

            $get_user_details->update(['otp'=>$otp]);
            $get_user_details->update(['is_login' => 1]);
            $get_user_details->update(['is_visit_app' => 1]);

            $get_user_details->accessToken ='';  

            $phone = $get_user_details->country_code . $get_user_details->mobile;
            $message = "Your verification Code Is $otp";
            if (preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
                    try {
                        $this->TwilioService->sendOtp($phone, $message);
                    } catch (\Exception $e) {
                        // ❌ silently skip (no return, no error)
                        // Optional: log for debugging
                        //\Log::warning('Twilio SMS skipped: ' . $e->getMessage());
                    }
                }

            return ['status'=>'success','message'=>"OTP sent to mobile number succesfully",'data'=>$get_user_details];            
        
          }else{
            return ['status'=>'error','message'=>"Account does not exist",'data'=>(object)[]];                
          }
    
        }

      public function resend_otp_by_mobile_or_email($request){


        if($request->type=='0'){

          $get_user_details=  User::where('country_code',$request->country_code)->Where('mobile',$request->email_mobile)->first();
  
        }else{
          $get_user_details=  User::where('email',$request->email_mobile)->first();

        }

        // $get_user_details=  User::where('email',$request->email_mobile)->orWhere('mobile',$request->email_mobile)->first();

        if($get_user_details){

           $otp= config('services.otp');

            $get_user_details->update(['otp'=>$otp]);

            $get_user_details->accessToken =''; 

            $phone = $get_user_details->country_code . $get_user_details->mobile;
            $message = "Your verification Code Is $otp";
            if (preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
                    try {
                        $this->TwilioService->sendOtp($phone, $message);
                    } catch (\Exception $e) {
                        // ❌ silently skip (no return, no error)
                        // Optional: log for debugging
                        //\Log::warning('Twilio SMS skipped: ' . $e->getMessage());
                    }
                }

            return ['status'=>'success','message'=>"OTP sent to mobile number succesfully ",'data'=>$get_user_details];            
        
          }else{
            return ['status'=>'error','message'=>"Account does not exist",'data'=>(object)[]];                
          }
    
        }

        

        public function mobile_or_email_forgot_password($request){

            if($request->type=='0'){ // when i use Mobile No
                $get_user_details=  User::where('country_code',$request->country_code)->Where('mobile',$request->mobile)->where('otp_verify','1')->first();

            }else{
                $get_user_details=  User::where('email',$request->email)->where('otp_verify','1')->first();

            }
    
            if($get_user_details){
    
                $otp= config('services.otp');

                $get_user_details->update(['otp'=>$otp]);
    
                $get_user_details->accessToken ='';
                
                $phone = $get_user_details->country_code . $get_user_details->mobile;
                $message = "Your verification Code Is $otp";
                if (preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
                    try {
                        $this->TwilioService->sendOtp($phone, $message);
                    } catch (\Exception $e) {
                        // ❌ silently skip (no return, no error)
                        // Optional: log for debugging
                        //\Log::warning('Twilio SMS skipped: ' . $e->getMessage());
                    }
                }
                
                return ['status'=>'success','message'=>"Forgot Password Otp Send Successfully",'data'=>$get_user_details];            
            
              }else{
                return ['status'=>'error','message'=>"Account does not exist",'data'=>(object)[]];                
              }
        
            }

            public function create_password($request){

                $get_user_details=  User::where('id',$request->id)->where('otp_verify','1')->first();
    
                if($get_user_details){


                    // ✅ Check if new password is same as old
                  if (Hash::check($request->password, $get_user_details->password)) {
                    return [
                        'status' => 'error',
                        'message' => 'New password cannot be the same as the old password',
                        'data' => (object)[],
                    ];
                }
              
                    $get_user_details->update(['password'=>hash::make($request->password)]);
                    
                    $get_user_details->accessToken ='';            
                    return ['status'=>'success','message'=>"Forgot Password change Successfully",'data'=>$get_user_details];            
                
                  }else{
                    return ['status'=>'error','message'=>"Account does not exist",'data'=>(object)[]];                
                  }
            
                }
    

            
   public function DeleteAccount($request_data)
  {
      try {

          DB::beginTransaction();

          $data = User::find($request_data->user_id);

          if (!$data) {
              return [
                  'status' => 'error',
                  'message' => 'User not found',
                  'data' => []
              ];
          }

          $data->accessToken = null;
          $data->save();

          $data->delete();

          DB::commit();

          return [
              'status' => 'success',
              'message' => 'Account deleted successfully',
              'data' => $data
          ];

      } catch (\Exception $e) {

          DB::rollBack();

          return [
              'status' => 'error',
              'message' => $e->getMessage(),
              'data' => []
          ];
      }
  }   

    
    






}
    