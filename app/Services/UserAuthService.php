<?php
namespace App\Services;

use App\Models\User;

use Hash;

class UserAuthService
{

    function register($request){

        $password_hash=Hash::make($request->password);

        // $otp="123456";

       $otp= config('services.otp');

        $record=[
            'full_name'=>$request->full_name,
            'country_code'=>$request->country_code,
            'mobile'=>$request->mobile,
            'email'=>$request->email,
            'password'=>$password_hash ,
            'otp'=>$otp
        ];

       $check=  User::create($record);

        if($check){
            return ['status'=>'success','message'=>"User Account Create Successfully",'data'=>$check];            
        }


    }


    public function verify_otp($request){

    $get_user_details=  User::where('id',$request->user_id)->first();

    if($get_user_details->otp==$request->otp){
        $get_user_details->update(['otp_verify'=>'1']);

        $get_user_details->accessToken = $get_user_details->createToken('user')->plainTextToken;
            
        return ['status'=>'success','message'=>"User Login Successfully",'data'=>$get_user_details];            
    
      }else{
        return ['status'=>'error','message'=>"Otp is invalid",'data'=>(object)[]];                
      }

    }


    public function loginCheck($request){


        $get_user_details=  User::where('email',$request->email_mobile)->orWhere('mobile',$request->email_mobile)->where('otp_verify','1')->first();

        if($get_user_details){

            if(Hash::check($request->password,$get_user_details->password,)){
                $get_user_details->accessToken = $get_user_details->createToken('user')->plainTextToken;            
                return ['status'=>'success','message'=>"User Login Successfully",'data'=>$get_user_details];                            
            }else{
                return ['status'=>'error','message'=>"User Password Is wrong",'data'=>(object)[]];                
            }
        
          }else{
            return ['status'=>'error','message'=>"User is Not Existed",'data'=>(object)[]];                
          }
    
        }



    public function login_by_mobile_or_email($request){


        $get_user_details=  User::where('email',$request->email_mobile)->orWhere('mobile',$request->email_mobile)->where('otp_verify','1')->first();

        if($get_user_details){

           $otp= config('services.otp');

            $get_user_details->update(['otp'=>$otp]);

            $get_user_details->accessToken ='';            
            return ['status'=>'success','message'=>"User Login Otp Send Successfully",'data'=>$get_user_details];            
        
          }else{
            return ['status'=>'error','message'=>"User is Not Existed",'data'=>(object)[]];                
          }
    
        }

        

        public function mobile_or_email_forgot_password($request){

            if($request->type=='0'){ // when i use Mobile No
                $get_user_details=  User::where('country_code',$request->country_code)->orWhere('mobile',$request->mobile)->where('otp_verify','1')->first();

            }else{
                $get_user_details=  User::where('email',$request->email)->where('otp_verify','1')->first();

            }
    
            if($get_user_details){
    
                $otp= config('services.otp');

                $get_user_details->update(['otp'=>$otp]);
    
                $get_user_details->accessToken ='';            
                return ['status'=>'success','message'=>"Forgot Password Otp Send Successfully",'data'=>$get_user_details];            
            
              }else{
                return ['status'=>'error','message'=>"User is Not Existed",'data'=>(object)[]];                
              }
        
            }

            public function create_password($request){

                $get_user_details=  User::where('id',$request->id)->where('otp_verify','1')->first();
    
                if($get_user_details){
              
                    $get_user_details->update(['password'=>hash::make($request->password)]);
                    
                    $get_user_details->accessToken ='';            
                    return ['status'=>'success','message'=>"Forgot Password Otp Send Successfully",'data'=>$get_user_details];            
                
                  }else{
                    return ['status'=>'error','message'=>"User is Not Existed",'data'=>(object)[]];                
                  }
            
                }
    

            
        

    
    






}
    