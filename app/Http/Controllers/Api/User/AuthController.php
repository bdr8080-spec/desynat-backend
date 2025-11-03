<?php


namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\UserAuthService;
use App\Models\User;

use Validator;

class AuthController extends Controller
{

    public function __construct(UserAuthService $UserAuthService){

        $this->UserAuthService=$UserAuthService;

    }

    public function register(Request $req){

      $check_user_already=User::where('email',$req->email)->where('otp_verify','0')->first();

      if($check_user_already){
        $check_user_already->delete();
      }


        $validate = Validator::make($req->all(), [
            // "profile_image"=>"required",
            'full_name' => 'required',
            'country_code' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

        $data= $this->UserAuthService->register($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function verify_otp(Request $req){

          $validate = Validator::make($req->all(), [
              'user_id' => 'required|exists:users,id',
              'otp' => 'required',
              'type' => 'required:in:0,1,2', // 0 register 1 login 2 forgot password
              ]);
          
         if($validate->fails()){
          return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
         }
  
          $data= $this->UserAuthService->verify_otp($req);

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




        $data= $this->UserAuthService->loginCheck($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function login_by_mobile_or_email(Request $req){

        $validate = Validator::make($req->all(), [
            'email_mobile' => 'required',
            "type"=>"required:in:0,1",
               ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }


       if($req->type=='0'){
        
        $validate = Validator::make($req->all(), [
            'email_mobile' => 'required',
            "type"=>"required:in:0,1",
            "country_code"=>"required" 
               ]);
        if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
        }
       }


        $data= $this->UserAuthService->login_by_mobile_or_email($req);

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
        return ApiResponse::generateResponse('error', $validate->errors()->first() ,$validate->errors()->first(),422);
       }

       if($req->type=='0'){

        $validate = Validator::make($req->all(), [
            'email_mobile' => 'required',
            "type"=>"required:in:0,1",
            "country_code"=>"required" 
               ]);
        if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
        }
       }


        $data= $this->UserAuthService->resend_otp_by_mobile_or_email($req);

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
        
        $data= $this->UserAuthService->mobile_or_email_forgot_password($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function create_password(Request $req){

        $validate = Validator::make($req->all(), [
            'id'=>'required|exists:users,id',
            'password' => 'required',
            'confirm_password'=>"required|same:password"
               ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

        $data= $this->UserAuthService->create_password($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    

    


      






}