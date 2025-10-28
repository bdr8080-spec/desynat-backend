<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\AdminAuthService;
use App\Models\Admin;

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

    

    


      






}
