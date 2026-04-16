<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\AdminAuthService;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

use Validator;

class AuthController extends Controller
{

    public function __construct(AdminAuthService $AdminAuthService){

        $this->AdminAuthService=$AdminAuthService;

    }


    public function admin_verify_otp(Request $req){

          $validate = Validator::make($req->all(), [
              'admin_id' => 'required|exists:admins,id',
              'otp' => 'required',
              ]);
          
         if($validate->fails()){
          return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
         }
  
          $data= $this->AdminAuthService->verify_otp($req);

          if(isset($data['status']) && $data['status']=='error' ){
              return ApiResponse::generateResponse('error', $data['message'],'',400);
          }
  
          return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
      }


      public function admin_login(Request $req){
        //print_r('123');die;
        //dd($req->all());

        $validate = Validator::make($req->all(), [
            'email' => 'required',
            'password' => 'required',     
               ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

        $data= $this->AdminAuthService->loginCheck($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],'',400);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function admin_forgot_password(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'email' => 'required|email',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = $this->AdminAuthService->email_forgot_password($req);

        if (isset($data['status']) && $data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], '', 400);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
    }



    public function admin_create_password(Request $req){

        $validate = Validator::make($req->all(), [
            'id'=>'required|exists:admins,id',
            'password' => 'required',
            'confirm_password'=>"required|same:password"
               ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
       }

        $data= $this->AdminAuthService->create_password($req);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],'',400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function admin_logout(Request $req)
    {
        try {
            $admin = Auth::user();
           // dd($admin_id);

            if (!$admin) {
                return ApiResponse::generateResponse('error', 'Unauthorized access', '', 401);
            }
            $data = $this->AdminAuthService->logout($admin);

            if ($data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], '', 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], (object)[], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong', $e->getMessage(), 500);
        }
    }

    public function resend_otp(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'email' => 'required|email',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = $this->AdminAuthService->resendOtp($req);

        if (isset($data['status']) && $data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], '', 400);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
    }

    public function account_setting(Request $req){

          $validate = Validator::make($req->all(), [
              'profile_pic' => 'required',
              'full_name' => 'required',
              'country_code' => 'required',
              'mobile' => 'required',
              'email' => 'required',
              ]);
          
         if($validate->fails()){
          return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
         }

         $admin = Auth::user()->id;
         //dd($admin);

         $request_data = (object)[
                'user_id'              => $admin,
                'profile_pic' => $req->profile_pic,
                'full_name'        => $req->full_name,
                'country_code'      => $req->country_code,
                'mobile'      => $req->mobile,
                'email'      => $req->email,
            ];
  
          $data= $this->AdminAuthService->AccountSetting($request_data);

          if(isset($data['status']) && $data['status']=='error' ){
              return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
          }
  
          return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
      }

      public function update_password(Request $req){

          $validate = Validator::make($req->all(), [
              'old_password' => 'required',
              'new_password' => 'required',
              'confirm_password' => 'required|same:new_password',
              ]);
          
         if($validate->fails()){
          return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
         }

         $admin = Auth::user()->id;
         //dd($admin);

         $request_data = (object)[
                'user_id'              => $admin,
                'old_password' => $req->old_password,
                'new_password'        => $req->new_password,
                'confirm_password'      => $req->confirm_password,
            ];
  
          $data= $this->AdminAuthService->UpdatePassword($request_data);

          if(isset($data['status']) && $data['status']=='error' ){
              return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
          }
  
          return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
      }

    

    


      






}
