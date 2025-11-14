<?php
namespace App\Services;

use App\Models\DeliveryBoy;

use Carbon\carbon;



use Hash;

class DeliveryBoyAuthService
{


    public function loginCheck($request){

        if($request->type=='0'){

          $get_user_details=  DeliveryBoy::where('country_code',$request->country_code)->Where('mobile',$request->email_mobile)->first();
  
        }else{
          $get_user_details=  DeliveryBoy::where('email',$request->email_mobile)->first();
  
        }

        
        if($get_user_details){

            if(Hash::check($request->password,$get_user_details->password,)){  
                
                $get_user_details->accessToken = $get_user_details->createToken('delivery-boy-token', ['delivery-boy'])->plainTextToken;

                return ['status'=>'success','message'=>"Delivery Boy Login Successfully",'data'=>$get_user_details];                            
            }else{
                return ['status'=>'error','message'=>"Delivery Boy Password Is wrong",'data'=>(object)[]];                
            }
        
        }else{
        return ['status'=>'error','message'=>"Delivery Boy is Not Existed",'data'=>(object)[]];                
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
            return ['status'=>'success','message'=>"Forgot Password Otp Send Successfully",'data'=>$get_user_details];            
        
            }else{
            return ['status'=>'error','message'=>"Delivery Boy is Not Existed",'data'=>(object)[]];                
        }
    
    }

    public function verify_otp($request){

        $get_user_details=  DeliveryBoy::where('id',$request->user_id)->first();

        if($get_user_details->otp==$request->otp){
            $get_user_details->update(['otp_verify'=>'1']);

            $get_user_details->accessToken = $get_user_details->createToken('delivery-boy')->plainTextToken;
                
            return ['status'=>'success','message'=>"Delivery Boy Otp verify Successfully",'data'=>$get_user_details];            
        
        }else{
            return ['status'=>'error','message'=>"Otp is invalid",'data'=>(object)[]];                
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
        return ['status'=>'success','message'=>"Otp Resend Successfully",'data'=>$get_user_details];            
    
        }else{
        return ['status'=>'error','message'=>"Delivery Boy is Not Existed",'data'=>(object)[]];                
        }

    }

    public function create_password($request){

        $get_user_details=  DeliveryBoy::where('id',$request->user_id)->where('otp_verify','1')->first();

        if($get_user_details){
        
        $get_user_details->update(['password'=>hash::make($request->password)]);
        
        $get_user_details->accessToken ='';            
        return ['status'=>'success','message'=>"Password Changed Successfully",'data'=>$get_user_details];            
    
        }else{
        return ['status'=>'error','message'=>"Delivery Boy is Not Existed",'data'=>(object)[]];                
        }

    }

    


            
        

    
    






}
    