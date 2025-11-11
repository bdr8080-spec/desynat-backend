<?php
namespace App\Services;

use App\Models\seller;
use App\Models\sellerStoreInformation;
use App\Models\sellerDocument;
use App\Models\Bankdetails;
use App\Models\Plan;

use App\Models\SellerSubcriptionPlanBuy;

use Carbon\carbon;



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
          'otp'=>$otp,
          'lang'=>$request->lang??null
        ];

       $check=  seller::create($record);

        if($check){
            return ['status'=>'success','message'=>"OTP sent succesfully",'data'=>$check];            
        }


    }


    public function verify_otp($request){

    $get_user_details=  seller::where('id',$request->user_id)->first();

    if($get_user_details->otp==$request->otp){
        $get_user_details->update(['otp_verify'=>'1']);

        $get_user_details->accessToken = $get_user_details->createToken('seller')->plainTextToken;
            
        return ['status'=>'success','message'=>"seller Otp verify Successfully",'data'=>$get_user_details];            
    
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
        'country_code' => $request->country_code,
        "store_phone"=>$request->store_phone ,
        'store_mail_id'=>$request->store_mail_id ,
        'bio'=>$request->bio,
        'let'=>$request->let,
        'long'=>$request->long
      ];

     $store_information=sellerStoreInformation::Updateorcreate($match,$data_insert);
  
      if($store_information){
      // $get_seller_details=  seller::where('id',$request->user_id)->first();

      seller::where('id',$request->user_id)->update(['store_information'=>'1']); // update store information


          return ['status'=>'success','message'=>"Store information Save succesfully",'data'=>$store_information];            

        }else{
          return ['status'=>'error','message'=>"Otp is invalid",'data'=>(object)[]];                
        }
  
      }


      public function store_document_and_bank_details($request){

        
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
          'account_type' => strVal($request->account_type),
          'iban' => $request->iban ,
          'swift'=>$request->swift ,
          "bank_name"=>$request->bank_name ,
          'account_holder_name'=>$request->account_holder_name ,
          'upload_proof'=>$request->upload_proof
        ];
  
       $store_information=Bankdetails::Updateorcreate($match,$bank_data);
    
        if($store_information){

          seller::where('id',$request->user_id)->update(['bank_information'=>'1']); // update store information
  
            return ['status'=>'success','message'=>"Document and Bank details Save succesfully",'data'=>$store_information];            
  
          }else{
            return ['status'=>'error','message'=>"Otp is invalid",'data'=>(object)[]];                
          }
    
        }

        public function seller_review($request){ 

         $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details')->where('id',$request->user_id)->first();
        
          if($seller_details){

                return ['status'=>'success','message'=>"seller Information fetch successfully",'data'=>$seller_details];            
        
              }else{
                return ['status'=>'error','message'=>"Seller Details is invalid",'data'=>(object)[]];                
              }
        
              }

            public function seller_store_submit_request($request){ 

              $seller_details=seller::where('id',$request->user_id)->first();
              
                if($seller_details){

                  if($seller_details->store_information!=='1'){
                    return ['status'=>'error','message'=>"Please submit Store information",'data'=>(object)[]];                
                  }

                  if($seller_details->bank_information!=='1'){
                    return ['status'=>'error','message'=>"Please submit Bank and store document information",'data'=>(object)[]];                                    
                  }

                  $seller_details->update(['admin_verify'=>'1']); // update store information

                  return ['status'=>'success','message'=>"seller Store Request Submit",'data'=>$seller_details];            
              
                    }else{
                      return ['status'=>'error','message'=>"Otp is invalid",'data'=>(object)[]];                
                    }
              
                    }
       



    public function loginCheck($request){

        // $get_user_details=  seller::where('email',$request->email_mobile)->orWhere('mobile',$request->email_mobile)->where('otp_verify','1')->first();


        if($request->type=='0'){

          $get_user_details=  seller::with('subcription_plan')->where('country_code',$request->country_code)->Where('mobile',$request->email_mobile)->where('otp_verify','1')->first();
  
        }else{
          $get_user_details=  seller::with('subcription_plan')->where('email',$request->email_mobile)->where('otp_verify','1')->first();
  
        }

        
        if($get_user_details){

          if($get_user_details->admin_verify=='3'){
            return ['status'=>'error','message'=>"Your Account is reject By Admin",'data'=>(object)[]];                
          }
          
          // if($get_user_details->admin_verify=='0' || $get_user_details->admin_verify=='1'){
          //   return ['status'=>'success','message'=>"Your Profile is Under Review",'data'=>$get_user_details];                
          // }
          

            if(Hash::check($request->password,$get_user_details->password,)){
                // $get_user_details->accessToken = $get_user_details->createToken('seller')->plainTextToken;   
                
                $get_user_details->accessToken = $get_user_details->createToken('seller-token', ['seller'])->plainTextToken;

                if(count($get_user_details->subcription_plan) > 0){
                  $get_user_details->subcription_plan_check ='1';
                }else{
                  $get_user_details->subcription_plan_check ='0';
                }


                // $user->createToken('seller-token', ['seller'])->plainTextToken;

                return ['status'=>'success','message'=>"Seller Login Successfully",'data'=>$get_user_details];                            
            }else{
                return ['status'=>'error','message'=>"Seller Password Is wrong",'data'=>(object)[]];                
            }
        
          }else{
            return ['status'=>'error','message'=>"Seller is Not Existed",'data'=>(object)[]];                
          }
    
        }
        

        public function mobile_or_email_forgot_password($request){

            if($request->type=='0'){ // when i use Mobile No
                $get_user_details=  seller::where('country_code',$request->country_code)->Where('mobile',$request->mobile)->where('otp_verify','1')->first();

            }else{
                $get_user_details=  seller::where('email',$request->email)->where('otp_verify','1')->first();
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
    
                $get_user_details->accessToken ='';            
                return ['status'=>'success','message'=>"Forgot Password Otp Send Successfully",'data'=>$get_user_details];            
            
              }else{
                return ['status'=>'error','message'=>"Seller is Not Existed",'data'=>(object)[]];                
              }
        
            }

            public function create_password($request){

                $get_user_details=  seller::where('id',$request->id)->where('otp_verify','1')->first();
    
                if($get_user_details){
              
                    $get_user_details->update(['password'=>hash::make($request->password)]);
                    
                    $get_user_details->accessToken ='';            
                    return ['status'=>'success','message'=>"Forgot Password Password Change Successfully",'data'=>$get_user_details];            
                
                  }else{
                    return ['status'=>'error','message'=>"seller is Not Existed",'data'=>(object)[]];                
                  }
            
                }

            public function resendOtp($request){

            if($request->type=='0'){ // when i use Mobile No
                $get_user_details=  seller::where('country_code',$request->country_code)->Where('mobile',$request->email_mobile)->first();

            }else{
                $get_user_details=  seller::where('email',$request->email_mobile)->first();
            }
            
            if($get_user_details){

    
                $otp= config('services.otp');

                $get_user_details->update(['otp'=>$otp]);
    
                $get_user_details->accessToken ='';            
                return ['status'=>'success','message'=>"Otp Send Successfully",'data'=>$get_user_details];            
            
              }else{
                return ['status'=>'error','message'=>"Seller is Not Existed",'data'=>(object)[]];                
              }
        
            }


            public function seller_allPlan($request){

              if(!isset($request->country_id)){
                return ['status'=>'error','message'=>"seller Store Information Not Found ",'data'=>(object)[]];               
              }
              

              $data= Plan::where('country_id',$request->country_id)->get();


              if($data->isNotEmpty()){
                return ['status'=>'success','message'=>"All Plans fetch Successfully",'data'=>$data];            
                }else{
                  return ['status'=>'error','message'=>"No Plan Found",'data'=>(object)[]];                
                }

              }


            public function seller_single_allPlan($request){


              $data= Plan::where('id',$request->plan_id)->first();

              if($data){
            
                  return ['status'=>'success','message'=>"single Plans fetch Successfully",'data'=>$data];            
              
                }else{
                  return ['status'=>'error','message'=>"No Plan Found",'data'=>(object)[]];                
                }
          
              }


              public function create_Subcription_Order($request){

                // convert start and exprire date from the  table
                $plan_data= Plan::where('id',$request->plan_id)->first();

                
                $currentDateTime = Carbon::now();

                if($plan_data){

                if($plan_data->duration_type=='1'){ //month code

                  $newDateTime = Carbon::now()->addMonth($plan_data->duration);

                }else{  // year code
                  $newDateTime = Carbon::now()->addYear($plan_data->duration);                   
                }

                }


                $check_plan= SellerSubcriptionPlanBuy::where('seller_id',$request->seller_id)->where('status','1')->where('payment_status','1')->first(); // check seller Plan

                if($check_plan){
                 return ['status'=>'error','message'=>"seller Already Have Active Plan",'data'=>(object)[]]; 
                }



                $array_data=[
                  'transaction_id'=>$request->transaction_id,
                  'seller_id'=>$request->seller_id,
                  'plan_id' =>$request->plan_id,
                  'status' =>'0',
                  'payment_status'=>$request->payment_status,
                  'plan_start_date'=>$currentDateTime??null,
                  'plan_end_date'=>$newDateTime??null,
                  'payment_method'=>$request->payment_method,
                  'amount' =>$plan_data->price
                  ];


                $data= SellerSubcriptionPlanBuy::create($array_data);
  
                if($data){
              
                    return ['status'=>'success','message'=>"Subcription Order Create Successfully",'data'=>$data];            
                
                  }else{
                    return ['status'=>'error','message'=>"error found",'data'=>(object)[]];                
                  }
            
                }
  

              public function complete_Subcription_Order($request){

                if($request->payment_status=='1'){
                  $msg="Subcription Plan Buy Successfully";
                  $status='1';
                 }else{
                  $msg="Subcription Plan Payment Rejected";
                  $status='2';
                 }

                $array_data=[
                'transaction_id'=>$request->transaction_id,
                'payment_status'=>$request->payment_status,
                'status'=>$status,
                'online_transaction_id'=>$request->online_transaction_id
                ];

                $data= SellerSubcriptionPlanBuy::where('transaction_id',$request->transaction_id)->first();
  
              
                if($data){

                  $seller_id=$data->seller_id;

                 $check_plan= SellerSubcriptionPlanBuy::where('seller_id',$seller_id)->where('status','1')->where('payment_status','1')->first(); // check seller Plan

                 if($check_plan){
                  return ['status'=>'error','message'=>"seller Already Have Active Plan",'data'=>(object)[]]; 
                 }

                  if($data->payment_status!=='0'){
                    return ['status'=>'error','message'=>"Payment is Already Paid or cancelled",'data'=>(object)[]];                
                  }
                  
                 $data->update($array_data);

                 
                 return ['status'=>'success','message'=>$msg,'data'=>$data];            
                
                  }else{
                    return ['status'=>'error','message'=>"error found",'data'=>(object)[]];                
                  }
            
                }
              

            
        

    
    






}
    