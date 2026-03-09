<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use Validator;

use Illuminate\Validation\Rule;

use App\Services\UserAffilatedAuthService;
use App\Services\UserOrderService;


class UserAffilatedControlller extends Controller
{

    public function __construct(UserAffilatedAuthService $UserAffilatedAuthService, UserOrderService $UserOrderService)
    {
        $this->UserAffilatedAuthService = $UserAffilatedAuthService;
        $this->UserOrderService = $UserOrderService;
    }


    public function CreateAffilatedAccount(Request $request){

        $user = $request->user()->id;

        $validate = Validator::make($request->all(), [
                'profile_image' => 'required',
                'full_name' => 'required',
                'country_code' => 'required',
                "mobile" =>"required",
                 'email' => [
                    'required',
                    'email',
                ],
                "password"=>"required",
                "confirm_password"=>"required|same:password",
                "document1"=>"required",
                "document2"=>"required",
                "accept" =>"required|In:1"
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

    

     $request_data=(object) [
    'user_id'=>$user,
    "profile_image"=>$request->profile_image,
    'full_name'=>$request->full_name??null,
    'country_code'=>$request->country_code??null,
    'mobile'=>$request->mobile??null,
    'email'=>$request->email??null,
    'password'=>$request->password??null,
    'document1'=>$request->document1??null,
    'document2'=>$request->document2??null,

    'let'=>$request->let??null,
    'long'=>$request->long??null,
    "device_type"=>$request->device_type??null,
    'lang'=>$request->lang??null
    ];

  $data=$this->UserAffilatedAuthService->RegisterAffilatedUser($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }


    public function AffilatedVerifyotp(Request $request){
    
        $validate = Validator::make($request->all(), [
                'id' => 'required|exists:affilated_users,id',
                'otp' => 'required',
                "type"=>"required|in:0,1"
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $user = $request->user()->id;


     $request_data=(object) [
    'user_id'=>$user,
    "affilated_id"=>$request->id,
    'otp'=>$request->otp,
    "type"=>$request->type
    ];

  $data=$this->UserAffilatedAuthService->AffilatedVerifyotp($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function affilatedAddAddress(Request $request){
    
        $validate = Validator::make($request->all(), [
                'country' => 'required',
                'locations' => 'required',
                'address1' => 'required',
                "address2" =>"required",
                // "pincode" =>"required",
                // "town"=>"required",
                // "state"=>"required",
                // "city"=>"required",
                "let"=>"required",
                "long" =>"required"
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $affilated_user = $request->user()->id;

     $request_data=(object) [
    'affilated_user'=>$affilated_user,
    "country"=>$request->country,
    'locations'=>$request->locations,
    'address1'=>$request->address1,
    'address2'=>$request->address2,
    'pincode'=>$request->pincode??null,
    'town'=>$request->town??null,
    'state'=>$request->state??null,
    'city'=>$request->city??null,
    'let'=>$request->let??null,
    'long'=>$request->long??null
    ];

  $data=$this->UserAffilatedAuthService->affilatedAddAddress($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }

public function affilatedAddBankDetails(Request $request){
    
        $validate = Validator::make($request->all(), [
                'bank_name' => 'required',
                'account_holder_name' => 'required',
                'account_no' => 'required',
                "confirm_account_no" =>"required|same:account_no",
                "iban" =>"required",
                "swift"=>"required",
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $affilated_user = $request->user()->id;

     $request_data=(object) [
    'affilated_user'=>$affilated_user,
    "bank_name"=>$request->bank_name,
    'account_holder_name'=>$request->account_holder_name,
    'account_no'=>$request->account_no,
    'iban'=>$request->iban,
    'swift'=>$request->swift,
    ];

  $data=$this->UserAffilatedAuthService->affilatedAddAddBankDetails($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }

    
    public function affiliatedLogin(Request $req){

        $validate = Validator::make($req->all(), [
            'email_mobile' => 'required',
            'password' => 'required',   
            "type"=>"required|in:0,1"  
            ]);

        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       if($req->type=='0'){

        $validate = Validator::make($req->all(), [
            'email_mobile' => 'required',
            'password' => 'required',   
            "type"=>"required:in:0,1",
            "country_code"=>"required" 
               ]);
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }
       }


        $data= $this->UserAffilatedAuthService->AffilatedloginCheck($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function affiliate_forgot_password(Request $req){

        $validate = Validator::make($req->all(), [
            'type'=>"required|In:0,1", //  0 mobile and 1 email
               ]);

       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       // when i use forgot password with Mobile
       if($req->type=='0'){
        $validate = Validator::make($req->all(), [
            'country_code'=>"required",
            'mobile'=>"required"
        ]);

       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       }

    // when i use forgot password with Email
        if($req->type=='1'){
        $validate = Validator::make($req->all(), [
            'email'=>"required",
        ]);

        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        }
        
        $data= $this->UserAffilatedAuthService->Affilate_mobile_or_email_forgot_password($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }



    public function resend_otp(Request $req){

        $validate = Validator::make($req->all(), [
            'email_mobile' => 'required',
            'type'=>'required|in:0,1' // -0 mobule 1 email
           
               ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       if($req->type=='0'){

        $validate = Validator::make($req->all(), [
            'email_mobile' => 'required',
            "type"=>"required:in:0,1",
            "country_code"=>"required" 
               ]);
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }
       }


        $data= $this->UserAffilatedAuthService->resendOtp($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }





    public function affiliate_create_password(Request $req){

        $validate = Validator::make($req->all(), [
            'id'=>'required|exists:affilated_users,id',
            'password' => 'required',
            'confirm_password'=>"required|same:password"
               ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

        $data= $this->UserAffilatedAuthService->affiliate_create_password($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }




    public function affiliateloginwithotp(Request $req){

        $validate = Validator::make($req->all(), [
            'type'=>"required|In:0,1", //  0 mobile and 1 email
               ]);

       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       // when i use forgot password with Mobile
       if($req->type=='0'){
        $validate = Validator::make($req->all(), [
            'country_code'=>"required",
            'mobile'=>"required"
        ]);

       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       }

    // when i use forgot password with Email
        if($req->type=='1'){
        $validate = Validator::make($req->all(), [
            'email'=>"required",
        ]);

        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        }
        
        $data= $this->UserAffilatedAuthService->Affilate_mobile_or_email_forgot_password($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', 'otp send successfully',$data['data'], 200);

    }



    public function affilatedDashboard(Request $req){

         return ApiResponse::generateResponse('success', 'Affiliated User details fetch successfully',$req->user(), 200);

    }


    public function uploadReverifydocument(Request $request){

        $user = $request->user()->id;

        $validate = Validator::make($request->all(), [
               "document1"=>"required",
                "document2"=>"required",
            ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $request_data=(object) [
    'user_id'=>$user,
    'document1'=>$request->document1??null,
    'document2'=>$request->document2??null,
    ];

  $data=$this->UserAffilatedAuthService->uploadReverifydocument($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}

public function update_affiliate_document(Request $request){

        $user = $request->user()->id;

        $validate = Validator::make($request->all(), [
               "document1"=>"required",
                "document2"=>"required",
            ]);
            
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        $request_data=(object) [
        'user_id'=>$user,
        'document1'=>$request->document1??null,
        'document2'=>$request->document2??null,
        ];

    $data=$this->UserAffilatedAuthService->updateReverifydocument($request_data);
        
        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
        }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}

public function update_affiliate_bank_details(Request $request){
    
        $validate = Validator::make($request->all(), [
                'bank_details_id' => 'required|exists:bankdetails,id',
                'bank_name' => 'required',
                'account_holder_name' => 'required',
                'account_no' => 'required',
                "confirm_account_no" =>"required|same:account_no",
                "iban" =>"required",
                "swift"=>"required",
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $affilated_user = $request->user()->id;

     $request_data=(object) [
        'bank_details_id'=>$request->bank_details_id,
    'affilated_user'=>$affilated_user,
    "bank_name"=>$request->bank_name,
    'account_holder_name'=>$request->account_holder_name,
    'account_no'=>$request->account_no,
    'iban'=>$request->iban,
    'swift'=>$request->swift,
    ];

  $data=$this->UserAffilatedAuthService->updateBankDetails($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}

public function add_affiliate_bank_details(Request $request){
    
        $validate = Validator::make($request->all(), [
                'bank_name' => 'required',
                'account_holder_name' => 'required',
                'account_no' => 'required',
                "confirm_account_no" =>"required|same:account_no",
                "iban" =>"required",
                "swift"=>"required",
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $affilated_user = $request->user()->id;

     $request_data=(object) [
    'affilated_user'=>$affilated_user,
    "bank_name"=>$request->bank_name,
    'account_holder_name'=>$request->account_holder_name,
    'account_no'=>$request->account_no,
    'iban'=>$request->iban,
    'swift'=>$request->swift,
    ];

  $data=$this->UserAffilatedAuthService->addBankDetails($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}

public function update_affiliate_address(Request $request)
{
    $validate = Validator::make($request->all(), [
        'country'   => 'required',
        'locations' => 'required',
        'address1'  => 'required',
        'address2'  => 'required',
        'let'       => 'required',
        'long'      => 'required',
    ]);

    if ($validate->fails()) {
        return ApiResponse::generateResponse(
            'error',
            $validate->errors()->first(),
            $validate->errors()->first(),
            422
        );
    }

    $affilated_user = $request->user()->id;

    $request_data = (object) [
        'affilated_user' => $affilated_user,
        'country'        => $request->country,
        'locations'      => $request->locations,
        'address1'       => $request->address1,
        'address2'       => $request->address2,
        'pincode'        => $request->pincode ?? null,
        'town'           => $request->town ?? null,
        'state'          => $request->state ?? null,
        'city'           => $request->city ?? null,
        'let'            => $request->let ?? null,
        'long'           => $request->long ?? null,
    ];

    $data = $this->UserAffilatedAuthService->updateAddress($request_data);

    if (isset($data['status']) && $data['status'] === 'error') {
        return ApiResponse::generateResponse(
            'error',
            $data['message'],
            $data['data'],
            422
        );
    }

    return ApiResponse::generateResponse(
        'success',
        $data['message'],
        $data['data'],
        200
    );
}

public function update_affiliate_profile(Request $request)
{
    $validate = Validator::make($request->all(), [
        'profile_image'   => 'required',
        'full_name' => 'required',
        'country_code'  => 'required',
        'mobile'  => 'required',
        'email'       => 'required',
        'document1'       => 'required',
        'document2'       => 'required',

    ]);

    if ($validate->fails()) {
        return ApiResponse::generateResponse(
            'error',
            $validate->errors()->first(),
            $validate->errors()->first(),
            422
        );
    }

    $affilated_user = $request->user()->id;

    $request_data = (object) [
        'affilated_user' => $affilated_user,
        'profile_image'        => $request->profile_image,
        'full_name'      => $request->full_name,
        'country_code'       => $request->country_code,
        'mobile'       => $request->mobile,
        'email'        => $request->email,
        'document1'        => $request->document1,
        'document2'        => $request->document2,
    ];

    $data = $this->UserAffilatedAuthService->updateProfile($request_data);

    if (isset($data['status']) && $data['status'] === 'error') {
        return ApiResponse::generateResponse(
            'error',
            $data['message'],
            $data['data'],
            422
        );
    }

    return ApiResponse::generateResponse(
        'success',
        $data['message'],
        $data['data'],
        200
    );
}

public function get_affiliate_profile(Request $request)
{

    $affilated_user = $request->user()->id;

    $request_data = (object) [
        'user_id' => $affilated_user,
    ];

    $data = $this->UserAffilatedAuthService->getProfile($request_data);

    if (isset($data['status']) && $data['status'] === 'error') {
        return ApiResponse::generateResponse(
            'error',
            $data['message'],
            $data['data'],
            422
        );
    }

    return ApiResponse::generateResponse(
        'success',
        $data['message'],
        $data['data'],
        200
    );
}

public function update_affiliate_password(Request $reqest)
{
    $validate = Validator::make($reqest->all(), [
        'old_password' => 'required',
        'password'         => 'required',
        'confirm_password' => 'required|same:password',
    ]);

    if ($validate->fails()) {
        return ApiResponse::generateResponse(
            'error',
            $validate->errors()->first(),
            (object) $validate->errors(),
            422
        );
    }

    $affilated_user = $reqest->user()->id;

    $request_data = (object) [
        'user_id' => $affilated_user,
        'password' => $reqest->password,
        "old_password"=>$reqest->old_password

    ];

    $data = $this->UserAffilatedAuthService->updatePassword($request_data);

    if (isset($data['status']) && $data['status'] === 'error') {
        return ApiResponse::generateResponse(
            'error',
            $data['message'],
            (object) [],
            400
        );
    }

    return ApiResponse::generateResponse(
        'success',
        $data['message'],
        $data['data'],
        200
    );
}

public function delete_affiliate_bank_account(Request $request){
    
        $validate = Validator::make($request->all(), [
                'bank_details_id' => 'required|exists:bankdetails,id',
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $affilated_user = $request->user()->id;
    // dd($affilated_user);

     $request_data=(object) [
        'bank_details_id'=>$request->bank_details_id,
    'affilated_user'=>$affilated_user,
    ];

  $data=$this->UserAffilatedAuthService->deleteBankAccount($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}



public function default_affiliate_bank_details(Request $request){
    
        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:bankdetails,id',
            ]);

    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $affilated_user = $request->user()->id;

     $request_data=(object) [
    'affilated_user'=>$affilated_user,
    'id'=>$request->id,
    ];

  $data=$this->UserAffilatedAuthService->default_affiliate_bank_details($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }





public function affiliate_remove_affilate_product(Request $request){
    
        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:affiliate_products,id',
            ]);

    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $affilated_user = $request->user()->id;

     $request_data=(object) [
    'affilated_user'=>$affilated_user,
    'id'=>$request->id,
    ];

  $data=$this->UserAffilatedAuthService->affiliate_remove_product($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }


     public function affiliate_all_order(Request $request){

            try{    
        //     $validate = Validator::make($request->all(), [
        //         'order_type'=>'required|in:1,2',
        //         ]);
            
        //    if($validate->fails()){
        //     return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        //    }
    
             $user_id= $request->user()->id;

    
               $request_data=(object)[
                'user_id'=>$user_id,
                'search'=>$request->search,
                'filter'=>$request->filter,
                "order_type"=>$request->order_type
                ];
        
                $data=$this->UserOrderService->AffiliateAllOrderDetailsNew($request_data);
        
                if(isset($data['status']) && $data['status']=='error' ){
                    return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
                }
        
                return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
        
        
            } catch (\Exception $e) {
                return [
                    'status' => 'error',
                    'message' => 'Failed to update seller status: ' . $e->getMessage(),
                    'data' => []
                ];
            }
            
            }

public function affiliate_single_order_details(Request $request){

        try{

            $validate = Validator::make($request->all(), [
                'order_id'=>'required',
                // "orderdetails_id"=>'required|exists:orderdetails,id'

                ]);
            
           if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }
    
         $user_id= $request->user()->id;

           $request_data=(object)[
            'user_id'=>$user_id,
            'order_id'=>$request->order_id,
            'orderdetails_id'=>$request->orderdetails_id
            ];
    
            if(isset($request->orderdetails_id)){

            $data=$this->UserOrderService->singleOrderDetailsNew($request_data);
            }else{

                $data=$this->UserOrderService->singleOrderDetails($request_data);
            }

    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }
    
            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
        
        }

public function affiliate_submit_withdraw_request(Request $request){

        try{

            $validate = Validator::make($request->all(), [
                'amount'=>'required',
                 "bankdetails_id"=>'required|exists:bankdetails,id'

                ]);
            
           if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }
    
         $user_id= $request->user()->id;

           $request_data=(object)[
            'user_id'=>$user_id,
            'amount'=>$request->amount,
            'bankdetails_id'=>$request->bankdetails_id
            ];
    

            $data=$this->UserOrderService->submitWithdrawRequest($request_data);

    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }
    
            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
        
        }

public function affiliate_all_withdraw_request(Request $request)
{
    try {
        $validate = Validator::make($request->all(), [
            'req_type' => 'required|in:0,1', // 0-pending,1-accepted/credited
        ]);
        
        if ($validate->fails()) {
            return ApiResponse::generateResponse(
                'error',
                $validate->errors()->first(),
                $validate->errors()->first(),
                422
            );
        }

        $user_id = $request->user()->id;

        $request_data = (object)[
            'user_id' => $user_id,
            'req_type' => $request->req_type,
            'search' => $request->search??null,
        ];

        $data = $this->UserOrderService->getAllWithdrawRequest($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], $data['data'], 422);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to fetch withdraw requests: ' . $e->getMessage(),
            'data' => []
        ];
    }
}



     

}