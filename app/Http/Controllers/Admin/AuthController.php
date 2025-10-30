<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminAuthService;
use App\Models\Admin;
use Validator;
 
class AuthController extends Controller
{

    public function __construct(AdminAuthService $AdminAuthService){

        $this->AdminAuthService=$AdminAuthService;

    }

    public function adminLogin(Request $request){
        if($request->isMethod('get')){
        return view('admin.auth.login');
        }else{
 
        }
    }
 
    public function forgotPassword(Request $request){
           if($request->isMethod('get')){
        return view('admin.auth.forgot-password');
        }else{
 
        }
 
    }
 
 
    public function changePassword(Request $request){
           if($request->isMethod('get')){
        return view('admin.auth.reset-password');
        }else{
 
        }
   
    }
 
     public function optVerify(Request $request){
           if($request->isMethod('get')){
        return view('admin.auth.otp-verify');
        }else{
 
        }
    }
}