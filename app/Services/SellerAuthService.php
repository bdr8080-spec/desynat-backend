<?php
namespace App\Services;

use App\Models\seller;
use App\Models\sellerStoreInformation;
use App\Models\sellerDocument;
use App\Models\Bankdetails;

use Hash;

class SellerAuthService
{

    function register($request){

        $password_hash=Hash::make($request->password);

        // $otp="123456";

       $otp= config('services.otp');

        $record=[
          'profile_pic' => $request->profile_pic,
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'country_code' => $request->country_code,
          'mobile' => $request->mobile,
          'email' => $request->email,
          'password' => $password_hash,
          'accept_terms' => '1',
          'device_type' => $request->device_type,
          'device_token'=>$request->device_token,
          'otp'=>$otp
        ];

       $check=  seller::create($record);

        if($check){
            return ['status'=>'success','message'=>"User Account Create Successfully",'data'=>$check];            
        }


    }


    public function verify_otp($request){

    $get_user_details=  seller::where('id',$request->user_id)->first();

    if($get_user_details->otp==$request->otp){
        $get_user_details->update(['otp_verify'=>'1']);

        $get_user_details->accessToken = $get_user_details->createToken('seller')->plainTextToken;
            
        return ['status'=>'success','message'=>"seller Otp Login Successfully",'data'=>$get_user_details];            
    
      }else{
        return ['status'=>'error','message'=>"Otp is invalid",'data'=>(object)[]];                
      }

    }

    public function store_information_insert($request){

      $match=[
        'seller_id' => $request->user_id
      ];

      $data_insert=[
        'seller_id' => $request->user_id,
        'store_image' => $request->store_image ,
        'store_name' => $request->store_name ,
        'country'=>$request->country ,
        "store_address"=>$request->store_address ,
        'address_line1'=>$request->address_line1 ,
        'address_line2'=>$request->address_line2 ,
        "store_phone"=>$request->store_phone ,
        'store_mail_id'=>$request->store_mail_id ,
        'bio'=>$request->bio,
        'let'=>$request->let,
        'long'=>$request->long
      ];

     $store_information=sellerStoreInformation::Updateorcreate($match,$data_insert);
  
      if($store_information){
      // $get_seller_details=  seller::where('id',$request->user_id)->first();

          return ['status'=>'success','message'=>"seller Store Information Insert Successfully",'data'=>$store_information];            

        }else{
          return ['status'=>'error','message'=>"Otp is invalid",'data'=>(object)[]];                
        }
  
      }


      public function store_document_and_bank_details($request){

    // use App\Models\sellerDocument;
    // use App\Models\Bankdetails;

    sellerDocument::where('seller_id',$request->user_id)->update(['status'=>'0']);
    
    foreach($request->owner_document as $key=>$val){

      sellerDocument::create([
        'seller_id'=>$request->user_id,
        'document_type'=>'1',
        'document_path'=>$val,
        'status'=>'1'
      ]);
    }

    foreach($request->store_document as $key=>$val){

      sellerDocument::create([
        'seller_id'=>$request->user_id,
        'document_type'=>'2',
        'document_path'=>$val,
        'status'=>'1'
      ]);
    }

        $match=[
          'user_id' => $request->user_id
        ];
  
        $bank_data=[
          'user_id' => $request->user_id,
          'type'=> '1',
          'account_type' => $request->account_type ,
          'iban' => $request->iban ,
          'swift'=>$request->swift ,
          "bank_name"=>$request->bank_name ,
          'account_holder_name'=>$request->account_holder_name ,
          'upload_proof'=>$request->upload_proof
        ];
  
       $store_information=Bankdetails::Updateorcreate($match,$bank_data);
    
        if($store_information){
        // $get_seller_details=  seller::where('id',$request->user_id)->first();
  
            return ['status'=>'success','message'=>"seller Information Insert Successfully Wait for admin Verify",'data'=>$store_information];            
  
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
    