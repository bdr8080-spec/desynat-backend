<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Validator;
use Illuminate\Support\Facades\Hash;
 
class AuthController extends Controller
{

    
    public function adminLogin(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.auth.login');
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => 'Please Enter Email Id',
                'email.email' => 'Please Enter a Valid Email Id',
                'password.required' => 'Please Enter Password'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $admin = Admin::where('email', $request->email)->first();
            if (!$admin) {
                return response()->json(['errors' => ['email' => ['Email is not registered']]], 422);
            }

            if (!Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['errors' => ['password' => ['Password is Incorrect']]], 422);
            }

            return response()->json(['success' => true]);
        }
    }


    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout(); 

        return redirect()->route('adminLogin');
    }
 
    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.auth.forgot-password');
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:admins,email',
            ], [
                'email.exists' => 'Email not found in admin records.'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $admin = Admin::where('email', $request->email)->first();
            $otp= config('services.otp');
            $admin->otp = $otp;
            $admin->save();

            session(['admin_email' => $admin->email]);

            return response()->json(['success' => true]);
        }
    }

 
     public function optVerify(Request $request)
    {
        if($request->isMethod('get')){
            return view('admin.auth.otp-verify', ['email' => session('admin_email')]);
        } else {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|digits:6',
                'email' => 'required|email|exists:admins,email'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $admin = Admin::where('email', $request->email)->first();

            if($admin->otp !== $request->otp){
                return response()->json(['errors' => ['otp' => ['Invalid OTP']]], 422);
            }

            $admin->otp = null;
            $admin->otp_verify = 1;
            $admin->save();
            session(['reset_email' => $admin->email]);

            return response()->json(['success' => true]);
        }
    }

    public function resendOtp(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();
        if($admin){
            $otp= config('services.otp');
            $admin->otp = $otp; 
            $admin->otp_verify = 0;
            $admin->save();
            session(['reset_email' => $admin->email]);
            return response()->json(['success' => true]);
        }
        return response()->json(['errors' => ['email' => ['Admin not found']]], 422);
    }

    public function changePassword(Request $request)
    {
        if ($request->isMethod('get')) {
            $email = session('reset_email'); 
            return view('admin.auth.reset-password', compact('email'));
        }

        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
        ]);

        if ($request->password !== $request->confirm_password) {
            return response()->json([
                'success' => false,
                'errors' => ['confirm_password' => ['Password and confirm password do not match']]
            ], 422);
        }

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => ['Email not found']]
            ], 422);
        }

        $admin->password = Hash::make($request->password);
        $admin->otp = null;
        $admin->save();

        $request->session()->forget('reset_email');

        return response()->json(['success' => true]);
    }

}