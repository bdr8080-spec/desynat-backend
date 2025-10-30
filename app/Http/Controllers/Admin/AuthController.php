<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Validator;
 
class AuthController extends Controller
{

    
    public function adminLogin(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.auth.login');
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $admin = Auth::guard('admin')->user();
                $admin->otp = 123456;
                $admin->save();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['errors' => ['email' => ['Invalid credentials']]], 422);
            }
        }
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout(); 

        return redirect()->route('adminLogin');
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