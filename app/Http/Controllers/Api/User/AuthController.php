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
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $req->lang=$req->lang??null; // add language

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
          return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
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

       $req->lang=$req->lang??null; // add language
       
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
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
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
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

        $data= $this->UserAuthService->create_password($req);

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
  
          $data= $this->UserAuthService->DeleteAccount($request_data);

          if(isset($data['status']) && $data['status']=='error' ){
              return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
          }
  
          return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
    }


    

    public function socialSignup(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                // 'name' => 'required',
                // 'device_type' => 'required|integer|digits_between:1,2',
                // 'device_token' => 'required',
                'unique_id' => 'required',
                'socialType' => 'required|integer',
                // 'profile_image' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 403);
            }

            // Check if the user already exists based on unique_id (socialId)
            $isLogin = User::where('unique_id', $req->unique_id)->first();
            // If the user does not exist, create the user
            if (! $isLogin) {
                $userDetails = [
                    'full_name' => $req->full_name,
                    'email' => $req->email,
                    'device_token' => $req->device_token,
                    'device_type' => $req->device_type,
                    'fcm_token'=>$req->fcm_token,
                    'unique_id' => $req->unique_id,
                    'socialType' => $req->socialType,
                    'otp_verify' => 1,
                    'profile_image' => $req->profile_image ?: null,
                    'latitude' => $request->latitude ?? null,
                    'longitude' => $request->longitude ?? null,

                ];

                $newUser = User::create($userDetails);

                // Check if the user was successfully created
                if ($newUser) {
                    // After creating the new user, generate a token
                    $newUser->access_token = $newUser->createToken('user-token', ['user'])->plainTextToken;


                    return ApiResponse::generateResponse('success',  __('user_messages.login_success'), $newUser, 200);

  

                } else {
                    return ApiResponse::generateResponse('success', __('messages_Sorry_Unable_to_create_Profile'), '', 403);
                }
            }

            // If the user exists, generate a token for the existing user

            // Update the user's device details
            $updateDetails = [
                'email' => $req->email ?: 'null',
                'device_token' => $req->device_token,
                'device_type' => $req->device_type,
                 'fcm_token'=>$req->fcm_token,
                'social_type' => $req->socialType,
                'otp_verify' => 1,
                'latitude' => $request->latitude ?? null,
                'longitude' => $request->longitude ?? null,
                'profile_image' => $req->profile_image ?: null,
            ];

            // Update the user and return the response
            $isLogin->update($updateDetails);
            $isLogin->access_token = $isLogin->createToken('user-token', ['user'])->plainTextToken;

            return ApiResponse::generateResponse('success',  __('user_messages.login_success'), $isLogin, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
      






}