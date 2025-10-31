<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\country;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Storage;

class AuthController extends Controller
{
    //  
    public function userRegister(Request $request){
        if($request->isMethod('get')){
            $country =   country::all();
                  return view('user.auth.register', compact('country')); 
        }else{

     
            if ($request->has('email')) {
                    $user = User::where('email', $request->email)->first();

                    if ($user && $user->otp_verify == '0') {
                        $user->delete();
                    }
                }

                if ($request->has('mobile')) {
                    $user = User::where([['country_code', $request->country_code],['mobile', $request->mobile]])->first();

                    if ($user && $user->otp_verify == '0') {
                        $user->delete();
                    }
                }    


    
            $rules = [
                    'full_name' => 'required',
                    'country_code' => 'required',
                    'image'=> 'required',
                    'email' => 'required|email|unique:users,email',
                    'mobile' => 'required',
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                    'accept_terms' => 'required|in:1',
                ];

                $messages = [
                    'full_name.required' => 'Please Enter Full Name',
                    'country_code.required' => 'Please select your country code.',
                    'email.required' => 'Email address is required.',
                    'email.email' => 'Please enter a valid email address.',
                    'email.unique' => 'This email address is already registered.',
                    'mobile.required' => 'Mobile number is required.',
                    'password.required' => 'Password is required.',
                    'confirm_password.required' => 'Please confirm your password.',
                    'confirm_password.same' => 'Confirm password must match the password.',
                    'accept_terms.required' => 'You must accept the terms and conditions.',
                    'accept_terms.in' => 'You must agree to the terms and conditions to continue.',
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

               if($validator->fails()){
                   return response()->json([
                    'status'=>false,
                    'errors'=>$validator->errors()
                   ]);
               }

                 $path = 'user/prfoile';

                $image_path = $this->image_upload($request->image, $path);
    
                $otp= config('services.otp');

                $data = User::create([
                    'full_name'     => $request->full_name,
                    'country_code'  => $request->country_code,
                    'mobile'        => $request->mobile,
                    'email'         => $request->email,
                    'password'      => bcrypt($request->password),
                    'otp'           => $otp,
                    'profile_image'=>$image_path
                ]);

                $id  = Crypt::encryptString($data->id);

                return response()->json([
                    'status'=>true,
                    'message'=>'OTP send Successfully',
                    'id'=>$id
                   ]);

        }

    }


    public function userVerifyOtp(Request $request){
        if($request->isMethod('get')){
                  return view('user.auth.otpVerify'); 
        }else{
            
            $request->validate([
                'id' => 'required',
                'otp' => 'required',
            ]);

            try {
                $id = Crypt::decryptString($request->id);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid user reference.',
                ], 400);
            }


            $user = User::find($id);


            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found.',
                ], 404);
            }

        
            $otp = implode('',$request->otp);


            if ($user->otp == $otp) {
                    
                $user->otp_verify = 1;
                $user->otp = null;
                $user->save();


                if ($request->forget_password == 'one') {
                    return response()->json([
                        'status' => true,
                        'message' => 'OTP verified successfully.',
                        'redirect_url' => route('userCreatePassword', ['temp_user_id' => $request->id]),
                    ]);
                } else {
                    Auth::guard('web')->login($user);
                    return response()->json([
                        'status' => true,
                        'message' => 'OTP verified successfully.',
                        'redirect_url' => route('dashboard'),
                    ]);
                }
    
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP, please try again.',
                ], 422);
            }


        }
    }


        public function userLogin(Request $request)
        {
            if ($request->isMethod('get')) {
                $country = country::all();
                return view('user.auth.login', compact('country'));
            }

            $validator = Validator::make($request->all(), [
                'mobileOrEmail' => 'required',
                'password' => 'required|min:6',
            ], [
                'mobileOrEmail.required' => 'Please enter your mobile number or email address.',
                'password.required' => 'Please enter your password.',
                'password.min' => 'Password must be at least 6 characters long.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ]);
            }

            $loginField = filter_var($request->mobileOrEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

            if ($loginField === 'mobile') {
                $credentials = [
                    'country_code' => $request->country_code,
                    'mobile'       => $request->mobileOrEmail,
                    'password'     => $request->password,
                ];

                $user = User::where('mobile', $request->mobileOrEmail)
                            ->where('country_code', $request->country_code)
                            ->first();
            } else {
                $credentials = [
                    'email'    => $request->mobileOrEmail,
                    'password' => $request->password,
                ];

                $user = User::where('email', $request->mobileOrEmail)->first();
            }

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid ' . $loginField . ' or password.',
                ], 401);
            }

            if ($user->otp_verify == '0') {
                return response()->json([
                    'status' => false,
                    'message' => 'Please verify your ' . $loginField . ' with OTP to login.',
                ], 401);
            }

            if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();

                return response()->json([
                    'status' => true,
                    'message' => 'User logged in successfully.',
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Invalid ' . $loginField . ' or password.',
            ], 401);
        }




        public function userForgetPassword(Request $request){
               if ($request->isMethod('get')) {
                $country =   country::all();
                return view('user.auth.forgetPassword', compact('country'));
            }else{   
            
                if ($request->forgetPassword == '1') {
                    $rules['mobile'] = 'required|digits:10|exists:users,mobile';
                    $messages['mobile.required'] = 'Please enter your mobile number';
                    $messages['mobile.digits'] = 'Mobile number must be 10 digits';
                    $messages['mobile.exists'] = 'This mobile number is not registered';
                }

                if ($request->forgetPassword == '2') {
                    $rules['email'] = 'required|email|exists:users,email';
                    $messages['email.required'] = 'Please enter your email address';
                    $messages['email.email'] = 'Please enter a valid email address';
                    $messages['email.exists'] = 'This email is not registered';
                }

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'errors' => $validator->errors(),
                    ]);
                }


                if ($request->forgetPassword == '1') {
                        $user = User::where([
                            ['country_code',$request->country_code],
                            ['mobile',$request->mobile],
                        ])->first();
                    } else {
                        $user = User::where('email', $request->email)->first();
                    }


                $otp= config('services.otp');
         


                if ($user) {
                    $user->otp = $otp ;
                    $user->save();
                   $id = Crypt::encryptString($user->id);
                    return response()->json([
                        'status' => true,
                        'message' => 'OTP sent successfully',
                        'id' => $id,
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ],403);

     

            }
        }


        public function userCreatePassword(Request $request){
            if ($request->isMethod('get')) {
                return view('user.auth.createPassword');
            }else{


                $rules = [
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                ];

                $messages = [
                    'password.required' => 'Password is required',
                    'confirm_password.required' => 'Please confirm your password',
                    'confirm_password.same' => 'Confirm password must match the password',
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

               if($validator->fails()){
                   return response()->json([
                    'status'=>false,
                    'errors'=>$validator->errors()
                   ]);
               }

            try {
                $id = Crypt::decryptString($request->id);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid user reference.',
                ], 400);
            }

            $user = User::find($id);

            if ($user) {
                $user->update([
                    'password' => $request->password,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Password updated successfully.'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ]);
            
               
            }
        }


        public function loginWithOtp(Request $request){
                   if ($request->isMethod('get')) {
                        $country =   country::all();
                        return view('user.auth.loginWithOtp', compact('country'));
            }else{

              

                $rules = [
                    'mobile' => 'required|digits:10'
                ];

                $messages = [
                    'mobile.required' => 'Please enter your mobile number',
                    'mobile.digits' => 'Mobile number must be 10 digits',
                    // 'mobile.exists' => 'This mobile number is not registered',
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

               if($validator->fails()){
                   return response()->json([
                    'status'=>false,
                    'errors'=>$validator->errors()
                   ]);
               }

                   $user = User::where([
                            ['country_code',$request->country_code],
                            ['mobile',$request->mobile],
                        ])->first();

                $otp= config('services.otp');

                if ($user) {
                    $user->otp = $otp;
                    $user->save();
                    $id = Crypt::encryptString($user->id);
                    return response()->json([
                        'status' => true,
                        'message' => 'OTP sent successfully',
                        'id' => $id,
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'This mobile number is not registered'
                ],403);


            }
        }


    public function dashboard(){


        return view('user.auth.dashboard');
    }
}