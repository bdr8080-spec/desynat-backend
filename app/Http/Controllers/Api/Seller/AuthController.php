<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

use App\Models\seller;

use App\Services\SellerAuthService;


use Validator;

class AuthController extends Controller
{

    public function __construct(SellerAuthService $SellerAuthService){

        $this->SellerAuthService=$SellerAuthService;

    }


    public function create_account(Request $request){

        $check_user_already=seller::where('email',$request->email)->where('otp_verify','0')->first();

        if($check_user_already){
          $check_user_already->delete();
        }

        $validate = Validator::make($request->all(), [
            'profile_pic' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'email' => 'required|email|unique:sellers,email',
            'mobile' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'accept_terms'=>"required|in:1"
        ]);


        if($validate->fails()){
            return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
           }

        $data=$this->SellerAuthService->register($request); // seller insert Code

        if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }

    public function resend_otp(Request $req){

        $validate = Validator::make($req->all(), [
            'email_mobile' => 'required',
               ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

        $data= $this->SellerAuthService->resendOtp($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }



    public function verify_otp(Request $req){

        $validate = Validator::make($req->all(), [
            'user_id' => 'required|exists:sellers,id',
            'otp' => 'required',
            'type' => 'required:in:0,1,2', // 0 register 1 login 2 forgot password
            ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

        $data= $this->SellerAuthService->verify_otp($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function store_information(Request $req){

        // $seller_id=$req->user()->id;

        $validate = Validator::make($req->all(), [
            'user_id' => 'required|exists:sellers,id',
            'store_image' => 'required',
            'store_name' => 'required',
            'country'=>"required",
            "store_address"=>"required",
            'address_line1'=>'required',
            'address_line2'=>'required',
            "store_phone"=>"required",
            'store_mail_id'=>'required',
            'bio'=>'required',
            'let'=>'required',
            'long'=>'required'
            
            ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

        $data= $this->SellerAuthService->store_information_insert($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function store_document_and_bank_details(Request $req){

        // $seller_id=$req->user()->id;

        $validate = Validator::make($req->all(), [
            'user_id' => 'required|exists:sellers,id',
            'owner_document' => 'required|array',
            'store_document' => 'required|array',
            'account_type'=>"required|in:0,1", // 0 Personal 1 Busness
            "iban"=>"required",
            'swift'=>'required',
            'bank_name'=>'required',
            "account_holder_name"=>"required",
            'upload_proof'=>'required'
            ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

        $data= $this->SellerAuthService->store_document_and_bank_details($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function seller_review(Request $req){

        $validate = Validator::make($req->all(), [
            'user_id' => 'required|exists:sellers,id',
            ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

        $data= $this->SellerAuthService->seller_review($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function seller_store_submit_request(Request $req){

        $validate = Validator::make($req->all(), [
            'user_id' => 'required|exists:sellers,id',
            ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

        $data= $this->SellerAuthService->seller_store_submit_request($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }




    public function login(Request $req){

        $validate = Validator::make($req->all(), [
            'email_mobile' => 'required',
            'password' => 'required',   
            "type"=>"required|in:0,1"  
            ]);

        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

       if($req->type=='0'){

        $validate = Validator::make($req->all(), [
            'email_mobile' => 'required',
            'password' => 'required',   
            "type"=>"required:in:0,1",
            "country_code"=>"required" 
               ]);
        if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
        }
       }


        $data= $this->SellerAuthService->loginCheck($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }



    public function forgot_password(Request $req){

        $validate = Validator::make($req->all(), [
            'type'=>"required|In:0,1", //  0 mobile and 1 email
               ]);

       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

       // when i use forgot password with Mobile
       if($req->type=='0'){
        $validate = Validator::make($req->all(), [
            'country_code'=>"required",
            'mobile'=>"required"
        ]);

       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

       }

    // when i use forgot password with Email
        if($req->type=='1'){
        $validate = Validator::make($req->all(), [
            'email'=>"required",
        ]);

        if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
        }

        }
        
        $data= $this->SellerAuthService->mobile_or_email_forgot_password($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function create_password(Request $req){

        $validate = Validator::make($req->all(), [
            'id'=>'required|exists:sellers,id',
            'password' => 'required',
            'confirm_password'=>"required|same:password"
               ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

        $data= $this->SellerAuthService->create_password($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }



    

    


    


    


}
