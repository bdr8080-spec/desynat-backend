<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\size;
use App\Models\color;
use App\Models\ProductVariant;
use Carbon\Carbon;

use App\Models\{UserGiftCards,GiftCard,UserWallet,Reason};
use App\Models\{Promocode,userAddress,country,all_countrie,allproductchats};
use App\Models\{Order,OrderDeliveryAddress,orderdetail,Addtocart,productRatings,product};

use Hash;

use App\Models\{AffilatedUser,AffilatedUserAddress,Bankdetails};

use DB;

class UserAffilatedAuthService
{


function RegisterAffilatedUser($request){

try{

  $user_id=$request->user_id;
      // $otp="123456";

  $checkUserAffilatedStatus=  AffilatedUser::where('user_id',$user_id)->first();

  if($checkUserAffilatedStatus){
    if($checkUserAffilatedStatus->otp_verify=='1'){
        return [
            'status' => 'error',
            'message' => 'This User Already Apply Affilated Account',
            'data' => (object)[]
        ];
    }
  }

// check emails and Mobile not register By Another User 

$checkmail=AffilatedUser::where('email',$request->email)->where('user_id','!=',$user_id)->where('otp_verify','1')->first();
if($checkmail){
   return [
            'status' => 'error',
            'message' => 'This Email is Already Register By Another User',
            'data' => (object)[]
        ];
}

$checkphone=AffilatedUser::where(['country_code'=>$request->country_code,'mobile'=>$request->mobile])->where('user_id','!=',$user_id)->where('otp_verify','1')->first();
if($checkphone){
   return [
            'status' => 'error',
            'message' => 'This Mobile No is Already Register By Another User',
            'data' => (object)[]
        ];
}



  AffilatedUser::where('user_id',$user_id)->delete(); // delete Affilated user when otp is not verified
  
    $otp= config('services.otp');

     $insert_Data=[
    'user_id'=>$user_id,
    "profile_image"=>$request->profile_image,
    'full_name'=>$request->full_name??null,
    'country_code'=>$request->country_code??null,
    'mobile'=>$request->mobile??null,
    'email'=>$request->email??null,
    'password'=>Hash::make($request->password)??null,
    'password_old'=>$request->password,
    'document1'=>$request->document1??null,
    'document2'=>$request->document2??null,
    'otp'=>$otp,
    'let'=>$request->let??null,
    'long'=>$request->long??null,
    "device_type"=>$request->device_type??0,
    'otp'=>$otp,
    ];

      $check=  AffilatedUser::UpdateOrCreate($insert_Data);

        if($check){
            return ['status'=>'success','message'=>"OTP sent succesfully",'data'=>$check];            
        }

         } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update Affliated status: ' . $e->getMessage(),
            'data' => $e->getMessage()
        ];
    }


    }


    



    public function AffilatedVerifyotp($request){

    $get_user_details=  AffilatedUser::where('id',$request->affilated_id)->first();

    if($get_user_details->otp==$request->otp){
        $get_user_details->update(['otp_verify'=>'1']);

        if($request->type=='1'){
        $get_user_details->affiliated_accessToken = $get_user_details->createToken('affilated-token', ['AffilatedUser'])->plainTextToken;   
      
      }else{
        $get_user_details->affiliated_accessToken ='';  
      }  
        
        return ['status'=>'success','message'=>"Otp Verified Successfully",'data'=>$get_user_details];            
    
      }else{
        return ['status'=>'error','message'=>"Invalid OTP",'data'=>(object)[]];                
      }

    }



function affilatedAddAddress($request){

try{


  $request_data=[
    'affiliate_id'=>$request->affilated_user,
    "country"=>$request->country,
    'locations'=>$request->locations,
    'address1'=>$request->address1,
    'address2'=>$request->address2,
    'pincode'=>$request->pincode,
    'town'=>$request->town,
    'state'=>$request->state,
    'city'=>$request->city,
    'let'=>$request->let??null,
    'long'=>$request->long??null
    ];

    $check=  AffilatedUserAddress::UpdateOrCreate($request_data);

    if($check){
    $affilated_user= AffilatedUser::where('id',$request->affilated_user)->update(['address_update_status'=>'1']);
     return ['status'=>'success','message'=>"Address Save succesfully",'data'=>$check];            
    }
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update Affliated status: ' . $e->getMessage(),
            'data' => $e->getMessage()
        ];
    }


    }

    

function affilatedAddAddBankDetails($request){

try{

  $request_data=[
    "type"=>"3",
    'user_id'=>$request->affilated_user,
    "bank_name"=>$request->bank_name,
    'account_holder_name'=>$request->account_holder_name,
    'account_no'=>$request->account_no,
    'iban'=>$request->iban,
    'swift'=>$request->swift,
    ];

    $check=  Bankdetails::UpdateOrCreate($request_data);

    if($check){
    $affilated_user= AffilatedUser::where('id',$request->affilated_user)->update(['bank_update_status'=>'1','admin_verify'=>'1']);


     return ['status'=>'success','message'=>"Bank details Submit succesfully",'data'=>$check];            
    }
    
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update Affliated status: ' . $e->getMessage(),
            'data' => $e->getMessage()
        ];
    }


    }



    public function AffilatedloginCheck($request){

        // $get_user_details=  seller::where('email',$request->email_mobile)->orWhere('mobile',$request->email_mobile)->where('otp_verify','1')->first();


        if($request->type=='0'){

          $get_user_details=  AffilatedUser::where('country_code',$request->country_code)->Where('mobile',$request->email_mobile)->where('otp_verify','1')->first();
  
        }else{
          $get_user_details=  AffilatedUser::where('email',$request->email_mobile)->where('otp_verify','1')->first();
  
        }

        if($get_user_details){

          if($get_user_details->admin_verify=='3'){
            return ['status'=>'error','message'=>"Your Account is reject By Admin Reason $get_user_details->reject_reason ",'data'=>(object)[]];                
          }

          if ($get_user_details->status == '0') {
            return ['status'=>'error','message'=>"Account is blocked by admin",'data'=>(object)[]];                
          }
        
          // if($get_user_details->admin_verify=='0' || $get_user_details->admin_verify=='1'){
          //   return ['status'=>'success','message'=>"Your Profile is Under Review",'data'=>$get_user_details];                
          // }
          

            if(Hash::check($request->password,$get_user_details->password,)){
                // $get_user_details->accessToken = $get_user_details->createToken('seller')->plainTextToken;   
                
                $get_user_details->affiliated_accessToken = $get_user_details->createToken('affilated-token', ['AffilatedUser'])->plainTextToken;

                // $user->createToken('seller-token', ['seller'])->plainTextToken;

                return ['status'=>'success','message'=>"Affiliate Login Successfully",'data'=>$get_user_details];                            
            }else{
                return ['status'=>'error','message'=>"Password Is wrong",'data'=>(object)[]];                
            }
        
          }else{
            return ['status'=>'error','message'=>"Affiliate User is Not Existed",'data'=>(object)[]];                
          }
    
        }    




        public function Affilate_mobile_or_email_forgot_password($request){

            if($request->type=='0'){ // when i use Mobile No
                $get_user_details=  AffilatedUser::where('country_code',$request->country_code)->Where('mobile',$request->mobile)->where('otp_verify','1')->first();

            }else{
                $get_user_details=  AffilatedUser::where('email',$request->email)->where('otp_verify','1')->first();
            }
            
            if($get_user_details){

              if($get_user_details->admin_verify=='3'){
                return ['status'=>'error','message'=>"Your Account is reject By Admin",'data'=>(object)[]];                
              }
    
              // if($get_user_details->admin_verify=='0' || $get_user_details->admin_verify=='1'){
              //   return ['status'=>'error','message'=>"Wait for Admin To Accept Your Store",'data'=>(object)[]];                
              // }
    
                $otp= config('services.otp');

                $get_user_details->update(['otp'=>$otp]);
    
                $get_user_details->affiliated_accessToken ='';            
                return ['status'=>'success','message'=>"Forgot Password Otp Send Successfully",'data'=>$get_user_details];            
            
              }else{
                return ['status'=>'error','message'=>"Affilated user is Not Existed",'data'=>(object)[]];                
              }
        
            }



            public function affiliate_create_password($request){

                $get_user_details=  AffilatedUser::where('id',$request->id)->where('otp_verify','1')->first();
    
                if($get_user_details){

               if (Hash::check($request->password, $get_user_details->password)) {
              
                return ['status'=>'error','message'=>"Old Password can not use as new password",'data'=>(object)[]];                 
                
               }
                    $get_user_details->update(['password'=>hash::make($request->password), 'password_old'=>$request->password,]);
                    
                    $get_user_details->affiliated_accessToken ='';            
                    return ['status'=>'success','message'=>"Forgot Password Password Change Successfully",'data'=>$get_user_details];            
                
                  }else{
                    return ['status'=>'error','message'=>"Affilated User is Not Existed",'data'=>(object)[]];                
                  }
            
                }



           public function resendOtp($request){

            if($request->type=='0'){ // when i use Mobile No
                $get_user_details=  AffilatedUser::where('country_code',$request->country_code)->Where('mobile',$request->email_mobile)->first();

            }else{
                $get_user_details=  AffilatedUser::where('email',$request->email_mobile)->first();
            }
            
            if($get_user_details){

    
                $otp= config('services.otp');

                $get_user_details->update(['otp'=>$otp]);
    
                $get_user_details->affiliated_accessToken ='';            
                return ['status'=>'success','message'=>"Otp Send Successfully",'data'=>$get_user_details];            
            
              }else{
                return ['status'=>'error','message'=>"Affiliated user is Not Existed",'data'=>(object)[]];                
              }
        
            }





function uploadReverifydocument($request){

try{


  $user_id=$request->user_id;
      // $otp="123456";

  $checkUserAffilatedStatus=  AffilatedUser::where('id',$user_id)->first();
  
     $insert_Data=[
    'document1'=>$request->document1??null,
    'document2'=>$request->document2??null,
    "admin_verify"=>"1"
    ];


    $checkUserAffilatedStatus->update($insert_Data);

    if($checkUserAffilatedStatus){
        return ['status'=>'success','message'=>"document Upload Successfully",'data'=>$checkUserAffilatedStatus];            
    }

    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update Affliated status: ' . $e->getMessage(),
            'data' => $e->getMessage()
        ];
    }


    }




}