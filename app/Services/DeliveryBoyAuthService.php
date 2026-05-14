<?php
namespace App\Services;

use App\Models\DeliveryBoy;

use Carbon\carbon;
use Illuminate\Support\Facades\DB;
use App\Services\TwilioService;



use Hash;

class DeliveryBoyAuthService
{

    public function __construct(TwilioService $TwilioService){

        $this->TwilioService=$TwilioService;

    }


    public function loginCheck($request){

        if($request->type=='0'){

          $get_user_details=  DeliveryBoy::where('country_code',$request->country_code)->Where('mobile',$request->email_mobile)->where('document_information',1)->first();
  
        }else{
          $get_user_details=  DeliveryBoy::where('email',$request->email_mobile)->where('document_information',1)->first();
  
        }

        
        if($get_user_details){

            if($get_user_details->status=='0'){
                return ['status'=>'error','message'=>"Your Account is blocked By Admin",'data'=>(object)[]];                
            }

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
                
                $get_user_details->accessToken = $get_user_details->createToken('delivery-boy-token', ['delivery-boy'])->plainTextToken;

                return ['status'=>'success','message'=>"Login Successfully",'data'=>$get_user_details];                            
            }else{
                return ['status'=>'error','message'=>"Please Enter Correct Password",'data'=>(object)[]];                
            }
        
        }else{
        return ['status'=>'error','message'=>"Account Does Not Existed",'data'=>(object)[]];                
        }
    
    }
        

    public function mobile_or_email_forgot_password($request){

        if($request->type=='0'){ 
            $get_user_details=  DeliveryBoy::where('country_code',$request->country_code)->Where('mobile',$request->mobile)->first();

        }else{
            $get_user_details=  DeliveryBoy::where('email',$request->email)->first();
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
            return ['status'=>'success','message'=>"OTP Sent Successfully",'data'=>$get_user_details];            
        
            }else{
            return ['status'=>'error','message'=>"Account Does Not Existed",'data'=>(object)[]];                
        }
    
    }

    public function verify_otp($request){

        $get_user_details=  DeliveryBoy::where('id',$request->user_id)->first();

        if($get_user_details->otp==$request->otp){
            $get_user_details->update(['otp_verify'=>'1']);

            $get_user_details->accessToken = $get_user_details->createToken('delivery-boy')->plainTextToken;
                
            return ['status'=>'success','message'=>"OTP Verify Successfully",'data'=>$get_user_details];            
        
        }else{
            return ['status'=>'error','message'=>"Invalid OTP",'data'=>(object)[]];                
        }

    }

    public function resendOtp($request){

        if($request->type=='0'){ // when i use Mobile No
            $get_user_details=  DeliveryBoy::where('country_code',$request->country_code)->Where('mobile',$request->email_mobile)->first();

        }else{
            $get_user_details=  DeliveryBoy::where('email',$request->email_mobile)->first();
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
        return ['status'=>'success','message'=>"OTP Resent Successfully",'data'=>$get_user_details];            
    
        }else{
        return ['status'=>'error','message'=>"Account Does Not Existed",'data'=>(object)[]];                
        }

    }

    public function create_password($request){

        $get_user_details=  DeliveryBoy::where('id',$request->user_id)->where('otp_verify','1')->first();

        if($get_user_details){
        
        // $get_user_details->update(['password'=>hash::make($request->password)]);
        $get_user_details->update([
            'password' => Hash::make($request->password),  // hashed
            'unhashed_password' => $request->password      // plain text
        ]);
        
        $get_user_details->accessToken ='';            
        return ['status'=>'success','message'=>"Password Changed Successfully",'data'=>$get_user_details];            
    
        }else{
        return ['status'=>'error','message'=>"Account Does Not Existed",'data'=>(object)[]];                
        }

    }

     public function DeleteAccount($request_data)
   {
      try {

          DB::beginTransaction();

          $data = DeliveryBoy::find($request_data->user_id);

          if (!$data) {
              return [
                  'status' => 'error',
                  'message' => 'User not found',
                  'data' => []
              ];
          }

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
    