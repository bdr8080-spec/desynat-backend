<?php

namespace App\Http\Controllers\Api\DeliveryBoy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

use App\Models\DeliveryBoy;

use App\Services\DeliveryBoyAuthService;
use Illuminate\Validation\Rule;


use Validator;

class AuthController extends Controller
{

    public function __construct(DeliveryBoyAuthService $DeliveryBoyAuthService){

        $this->DeliveryBoyAuthService=$DeliveryBoyAuthService;

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


        $data= $this->DeliveryBoyAuthService->resendOtp($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }



    public function verify_otp(Request $req){

        $validate = Validator::make($req->all(), [
            'user_id' => 'required|exists:delivery_boys,id',
            'otp' => 'required',
            ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

        $data= $this->DeliveryBoyAuthService->verify_otp($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function login(Request $req){

        $validate = Validator::make($req->all(), [
            'email_mobile' => 'required',
            'password' => 'required',   
            "type"=>"required|in:0,1"  //0 mobile,1-email
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


        $data= $this->DeliveryBoyAuthService->loginCheck($req);

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
        
        $data= $this->DeliveryBoyAuthService->mobile_or_email_forgot_password($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function create_password(Request $req){

        // $validate = Validator::make($req->all(), [
        //     'user_id'=>'required|exists:delivery_boys,id',
        //     'password' => 'required',
        //     'confirm_password'=>"required|same:password"
        //        ]);
        $validate = Validator::make($req->all(), [
            'user_id' => 'required|exists:delivery_boys,id',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ], [
            'confirm_password.same' => 'Password does not match', 
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

        $data= $this->DeliveryBoyAuthService->create_password($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function delete_account(Request $request){


         $user_id= $request->user()->id;

         $request_data = (object)[
                'user_id' => $user_id,
            ];
  
          $data= $this->DeliveryBoyAuthService->DeleteAccount($request_data);

          if(isset($data['status']) && $data['status']=='error' ){
              return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
          }
  
          return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
    }



    

    


    


    


}