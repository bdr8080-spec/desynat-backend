<?php
namespace App\Services;

use App\Models\seller;
use App\Models\sellerStoreInformation;
use App\Models\sellerDocument;
use App\Models\Bankdetails;
use App\Models\Plan;

use App\Models\SellerSubcriptionPlanBuy;
use Illuminate\Support\Facades\DB;

use Carbon\carbon;
use App\Services\TwilioService;



use Hash;

class SellerAuthService
{

   public function __construct(TwilioService $TwilioService){

        $this->TwilioService=$TwilioService;

    }

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

        $phone = $request->country_code . $request->mobile;
        $message = "Your verification Code Is $otp";
        $this->TwilioService->sendOtp($phone, $message);

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
                  $updateData = [];
                  if (!empty($request->fcm_token)) {
                      $updateData['fcm_token'] = $request->fcm_token;
                  }
                  if (!empty($request->device_type)) {
                      $updateData['device_type'] = $request->device_type;
                  }
                  if (!empty($updateData)) {
                      $seller_details->update($updateData);
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
          $get_user_details=  seller::with(['subcription_plan','Role_Action.sellermenu',
           'Role_Action' => function ($q) {
            $q->orderBy('menu_id', 'asc');
        }
          
          ])->where('country_code',$request->country_code)->Where('mobile',$request->email_mobile)->where('otp_verify','1')->first();  
        }else{
          $get_user_details=  seller::with(['subcription_plan','Role_Action.sellermenu',
           'Role_Action' => function ($q) {
            $q->orderBy('menu_id', 'asc');
        },
          
          ])->where('email',$request->email_mobile)->where('otp_verify','1')->first();
        }
        

        if($get_user_details){
          
          if($get_user_details->admin_verify=='3'){
            return ['status'=>'error','message'=>"Your Account is reject By Admin",'data'=>(object)[]];                
          }
          
          // if($get_user_details->admin_verify=='0' || $get_user_details->admin_verify=='1'){
          //   return ['status'=>'success','message'=>"Your Profile is Under Review",'data'=>$get_user_details];                
          // }
          

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
                // $get_user_details->accessToken = $get_user_details->createToken('seller')->plainTextToken;   

                if($get_user_details->is_block==1){
                  return ['status'=>'error','message'=>"This Account is blocked",'data'=>(object)[]];                
                }

                
                // if seller is staff member Then generate a Extra Token
                if($get_user_details->type=='1'){

                $Staff_user_details=seller::where('id',$get_user_details->parent_id)->first();


                $get_user_details->accessToken = $Staff_user_details->createToken('seller-token', ['seller'])->plainTextToken;
              
              
                $get_user_details->staffaccessToken = $get_user_details->createToken('seller-token', ['seller'])->plainTextToken;

                }else{


                  $get_user_details->accessToken = $get_user_details->createToken('seller-token', ['seller'])->plainTextToken;

                  $get_user_details->staffaccessToken='';
                }


                if(count($get_user_details->subcription_plan) > 0){
                  $get_user_details->subcription_plan_check ='1';
                }else{
                  $get_user_details->subcription_plan_check ='0';
                }

                $get_user_details->lang=$request->lang??null; // add lanuage 


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

                 $phone = $get_user_details->country_code . $get_user_details->mobile;
                $message = "Your verification Code Is $otp";
                $this->TwilioService->sendOtp($phone, $message);

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
                
                 $phone = $get_user_details->country_code . $get_user_details->mobile;
                $message = "Your verification Code Is $otp";
                $this->TwilioService->sendOtp($phone, $message);
                
                return ['status'=>'success','message'=>"Otp Send Successfully",'data'=>$get_user_details];            
            
              }else{
                return ['status'=>'error','message'=>"Seller is Not Existed",'data'=>(object)[]];                
              }
        
            }


            public function seller_allPlan($request){

              if(!isset($request->country_id)){
                return ['status'=>'error','message'=>"seller Store Information Not Found ",'data'=>(object)[]];               
              }
              

              $data= Plan::where('country_id',$request->country_id)->where('status','1')->get();


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
                //dd($request->all());

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


                $check_plan= SellerSubcriptionPlanBuy::where('seller_id',$request->seller_id)->where('status','1')->where('payment_status','1')->where('is_expired','0')->first(); // check seller Plan

                if($check_plan){
                 return ['status'=>'error','message'=>"seller Already Have Active Plan",'data'=>(object)[]]; 
                }

                if ($plan_data->duration_type == '1') {
                    // Monthly
                    $amount = $plan_data->price * $plan_data->duration;
                } else {
                    // Yearly
                    if (!empty($plan_data->no_of_free_months) && $plan_data->no_of_free_months > 0) {
                        $paidMonths = 12 - $plan_data->no_of_free_months;
                        $amount = $paidMonths * $plan_data->price;
                    } else {
                        $amount = 12 * $plan_data->price;
                    }
                }

                $amount = round($amount, 2);



                $array_data=[
                  'transaction_id'=>$request->transaction_id,
                  'seller_id'=>$request->seller_id,
                  'plan_id' =>$request->plan_id,
                  'status' =>'0',
                  'payment_status'=>$request->payment_status,
                  'plan_start_date'=>$currentDateTime??null,
                  'plan_end_date'=>$newDateTime??null,
                  'payment_method'=>$request->payment_method,
                  'amount' =>$amount,
                  'product_type'       => $plan_data->product_type,
                  'no_of_products'     => $plan_data->no_of_products,
                  'no_of_highlights'   => $plan_data->no_of_highlights,
                  'no_of_employee'     => $plan_data->no_of_employee,
                  'no_of_videos'       => $plan_data->no_of_videos,
                  'stories'       => $plan_data->stories,
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

                 $check_plan= SellerSubcriptionPlanBuy::where('seller_id',$seller_id)->where('status','1')->where('is_expired','0')->where('payment_status','1')->first(); // check seller Plan

                 if($check_plan){
                  return ['status'=>'error','message'=>"seller Already Have Active Plan",'data'=>(object)[]]; 
                 }

                  if($data->payment_status!=='0'){
                    return ['status'=>'error','message'=>"Payment is Already Paid or cancelled",'data'=>(object)[]];                
                  }
                  
                 $data->update($array_data);
                 if($request->payment_status=='1'){
                  $desc="Subcription Plan Payment is Success,Transaction id: {$request->transaction_id}";
                 }else{
                  $desc="Subcription Plan Payment is failed";
                 }
                 CreateNotification([
                    'sender_id' => 1, 
                    'sender_type' => 1, 

                    'receiver_id' => $seller_id,
                    'receiver_type' => 3, 

                    'title_english' => 'Subscription Plan',
                    'description_english' => $desc,

                    'notification_type' => 'subscription_plan'
                ]);

                 
                 return ['status'=>'success','message'=>$msg,'data'=>$data];            
                
                  }else{
                    return ['status'=>'error','message'=>"error found",'data'=>(object)[]];                
                  }
            
                }



                public function seller_storeOnOff($request){


                 $store_information= sellerStoreInformation::where('seller_id', $request->seller_id)->first();
                  
      
                  if($store_information){

                    if($store_information->Store_Availability=='0'){
                      $status=1;
                      $message="Seller Store Store Availability On";
                      $desc = "Your store status has been updated to on duty";
                    }else{
                      $status=0;
                      $message="Seller Store Store Availability Off";
                      $desc = "Your store status has been updated to off duty";
                    }

                    $store_information->update(['Store_Availability'=>$status]);

                    CreateNotification([
                      'sender_id' => 1, 
                      'sender_type' => 1, 

                      'receiver_id' => $request->seller_id,
                      'receiver_type' => 3, 

                      'title_english' => 'Store Availability',
                      'description_english' => $desc,

                      'notification_type' => 'store_availability'
                  ]);

                    return ['status'=>'success','message'=>$message,'data'=>$store_information];            
                  
                    }else{
                      return ['status'=>'error','message'=>"Seller No Store Found",'data'=>(object)[]];                
                    }
              
                  }

  public function renew_Subscription_Order($request)
  {
      try {
          $plan_data = Plan::where('id', $request->plan_id)->first();
          if (!$plan_data) {
              return [
                  'status' => 'error',
                  'message' => 'Plan not found',
                  'data' => (object)[]
              ];
          }

          $currentDateTime = Carbon::now();

          // Calculate new end date based on duration type
          if ($plan_data->duration_type == '1') { // month
              $newEndDate = $currentDateTime->copy()->addMonths($plan_data->duration);
          } else { // year
              $newEndDate = $currentDateTime->copy()->addYears($plan_data->duration);
          }

          // Check existing active plan
          $activePlan = SellerSubcriptionPlanBuy::where('seller_id', $request->seller_id)
              ->where('status', '1')
              ->where('payment_status', '1')
              ->orderBy('id', 'desc')
              ->first();

          if ($activePlan && $activePlan->plan_end_date >= $currentDateTime) {
              return [
                  'status' => 'error',
                  'message' => 'Your active plan is not expired yet',
                  'data' => (object)[]
              ];
          }

          // Mark previous plan as expired if exists
          if ($activePlan) {
              $activePlan->update(['is_expired' => '1']);
          }

              if ($plan_data->duration_type == '1') {
                    // Monthly
                    $amount = $plan_data->price * $plan_data->duration;
                } else {
                    // Yearly
                    if (!empty($plan_data->no_of_free_months) && $plan_data->no_of_free_months > 0) {
                        $paidMonths = 12 - $plan_data->no_of_free_months;
                        $amount = $paidMonths * $plan_data->price;
                    } else {
                        $amount = 12 * $plan_data->price;
                    }
                }

                $amount = round($amount, 2);

          // Prepare new subscription record
          $array_data = [
              'transaction_id' => $request->transaction_id,
              'seller_id'      => $request->seller_id,
              'plan_id'        => $request->plan_id,
              'status'         => '0', 
              'payment_status' => $request->payment_status,
              'plan_start_date'=> $currentDateTime,
              'plan_end_date'  => $newEndDate,
              'payment_method' => $request->payment_method,
              'amount'         => $amount,
              'product_type'       => $plan_data->product_type,
              'no_of_products'     => $plan_data->no_of_products,
              'no_of_highlights'   => $plan_data->no_of_highlights,
              'no_of_employee'     => $plan_data->no_of_employee,
              'no_of_videos'       => $plan_data->no_of_videos,
              'stories'       => $plan_data->stories,
          ];

          $newSubscription = SellerSubcriptionPlanBuy::create($array_data);

          if ($newSubscription) {
              return [
                  'status' => 'success',
                  'message' => 'Renew Subscription Order Create Successfully',
                  'data' => $newSubscription
              ];
          } else {
              return [
                  'status' => 'error',
                  'message' => 'Failed to create subscription',
                  'data' => (object)[]
              ];
          }

      } catch (\Exception $e) {
          return [
              'status' => 'error',
              'message' => 'Something went wrong: ' . $e->getMessage(),
              'data' => (object)[]
          ];
      }
  }

  public function seller_myPlan($request){

              $limit = (int)($request->limit ?? 10);

              $data= SellerSubcriptionPlanBuy::with('plan_info')->where('seller_id',$request->seller_id)->where('payment_status','1')->paginate($limit);


              if($data->isNotEmpty()){
                return ['status'=>'success','message'=>"My Plans fetch Successfully",'data'=>$data];            
                }else{
                  return ['status'=>'error','message'=>"No Plan Found",'data'=>(object)[]];                
                }

              }


    public function UpdatePassword($request_data)
    {
        try {
            $data = seller::find($request_data->user_id);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Seller not found',
                    'data' => (object)[]
                ];
            }

            if (!Hash::check($request_data->old_password, $data->password)) {
                return [
                    'status' => 'error',
                    'message' => 'Old password is incorrect',
                    'data' => (object)[]
                ];
            }

            if (Hash::check($request_data->new_password, $data->password)) {
                return [
                    'status' => 'error',
                    'message' => 'New password should not be same as old password ',
                    'data' => (object)[]
                ];
            }

            $data->password = Hash::make($request_data->new_password);
           // $data->unhashed_password = $request_data->new_password;
            $data->save();

            return [
                'status' => 'success',
                'message' => 'Password updated successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update password: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


  public function DeleteAccount($request_data)
  {
      try {

          DB::beginTransaction();

          $seller = seller::find($request_data->user_id);

          if (!$seller) {
              return [
                  'status' => 'error',
                  'message' => 'Seller not found',
                  'data' => []
              ];
          }

          // $seller->accessToken = null;
          // $seller->save();

          // $seller->staffs()->update([
          //     'accessToken' => null
          // ]);

          $seller->staffs()->delete();

          $seller->delete();

          DB::commit();

          return [
              'status' => 'success',
              'message' => 'Account deleted successfully',
              'data' => $seller
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
    