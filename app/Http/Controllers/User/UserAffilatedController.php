<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{all_countrie,AffilatedUser };

use Illuminate\Support\Facades\Crypt;

use Illuminate\Validation\Rule;
use Auth;
use Validator;
use Session;

class UserAffilatedController extends Controller
{
    public function affiliate_startPage(){
        return View('affiliatedUser.startPage');
    }
    
    public function affiliate_login(Request $request){

         if ($request->isMethod('get')) {
                $country = all_countrie::all();
                return view('affiliatedUser.auth.affiliate_login', compact('country'));
            }

            $validator = Validator::make($request->all(), [
                'mobileOrEmail' => 'required',
                'password' => 'required|min:6',
            ], [
                'mobileOrEmail.required' => 'Please enter your mobile number or email address',
                'password.required' => 'Please enter your password',
                'password.min' => 'Password must be at least 6 characters long',
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

                $user = AffilatedUser::where('mobile', $request->mobileOrEmail)
                            ->where('country_code', $request->country_code)
                            ->first();
            } else {
                $credentials = [
                    'email'    => $request->mobileOrEmail,
                    'password' => $request->password,
                ];

                $user = AffilatedUser::where('email', $request->mobileOrEmail)->first();
            }

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Affiliate User is not Regsiter',
                ], 401);
            }

            if ($user->otp_verify == '0') {
                return response()->json([
                    'status' => false,
                    'message' => 'Please verify your ' . $loginField . ' with OTP to login',
                ], 401);
            }

            if (Auth::guard('affilated_user')->attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();

                return response()->json([
                    'status' => true,
                    'message' => 'Affiliate User Login successfully',
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Invalid ' . $loginField . ' or password',
                // 'message'=>'User is not Regsiter'
            ], 401);

    }


        public function affiliate_loginWithOtp(Request $request){

                   if ($request->isMethod('get')) {
                        $country =   all_countrie::all();
                        return view('affiliatedUser.auth.loginWithOtp', compact('country'));
            }else{

              
                $rules = [];
                $messages = [];

                if ($request->forgetPassword == '1') {
                    $rules = [
                        'country_code' => 'required',
                        'mobile' => 'required|digits_between:7,15',
                    ];

                    $messages = [
                        'country_code.required' => 'Please select your country code',
                        'mobile.required' => 'Please enter your mobile number',
                        'mobile.digits' => 'Mobile number must be between 7 and 15 digits',
                    ];
                } else {
                    $rules = [
                        'email' => 'required|email',
                    ];

                    $messages = [
                        'email.required' => 'Please enter your email address',
                        'email.email' => 'Please enter a valid email address',
                    ];
                }

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'errors' => $validator->errors()
                    ]);
                }

                // OTP value
                $otp = config('services.otp');

                if ($request->forgetPassword == '1') {
                    $user = AffilatedUser::where([
                        ['country_code', $request->country_code],
                        ['mobile', $request->mobile],
                    ])->first();
                } else {
                    $user = AffilatedUser::where('email', $request->email)->first();
                }

                if ($user) {
                    $user->otp = $otp;
                    $user->save();

                    $id = Crypt::encryptString($user->id);
                    Session::put('verify-password', '1');
                    return response()->json([
                        'status' => true,
                        'message' => 'OTP sent successfully',
                        'id' => $id,
                        'type'=> $request->forgetPassword
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => $request->forgetPassword == '1'
                        ? 'This mobile number is not registered'
                        : 'This email address is not registered',
                ], 403);
            }
        }


        

        public function affiliate_forgotpassword(Request $request){
               if ($request->isMethod('get')) {
                $country =   all_countrie::all();
                return view('affiliatedUser.auth.forgetPassword', compact('country'));
            }else{   
            
                if ($request->forgetPassword == '1') {
                    $rules['mobile'] = 'required|digits_between:7,15|exists:affilated_users,mobile';
                    $messages['mobile.required'] = 'Please enter your mobile number';
                    $messages['mobile.digits_between'] = 'Mobile number must be between 7 and 15 digits';
                    $messages['mobile.exists'] = 'This mobile number is not registered';
                }

                if ($request->forgetPassword == '2') {
                    $rules['email'] = 'required|email|exists:affilated_users,email';
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
                        $user = AffilatedUser::where([
                            ['country_code',$request->country_code],
                            ['mobile',$request->mobile],
                        ])->first();
                    } else {
                        $user = AffilatedUser::where('email', $request->email)->first();
                    }

                $otp= config('services.otp');
         


                if ($user) {
                    $user->otp = $otp ;
                    $user->save();
                    $id = Crypt::encryptString($user->id);
                    Session::put('verify-password', '1');
                    return response()->json([
                        'status' => true,
                        'message' => 'OTP sent successfully',
                        'id' => $id,
                        'type'=>$request->forgetPassword
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ],403);

     

            }
        }


    public function affiliate_otpVerify(Request $request){
        if($request->isMethod('get')){

                  return view('affiliatedUser.auth.otpVerify'); 
        }else{
                 
            $validator = Validator::make($request->all(), [
                'id'=>'required',
                'otp' => 'required|array',
            ], [
                'otp.required' => 'Please enter OTP',
                'otp.*.required' => 'Please enter OTP',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ]);
        }

            try {
                $id = Crypt::decryptString($request->id);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid user reference',
                ], 400);
            }


            $user = AffilatedUser::find($id);


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
                    
                 Session::forget('verify-password');
                    return response()->json([
                        'status' => true,
                        'message' => 'OTP verified successfully',
                        'redirect_url' => route('affiliate.userCreatePassword', ['temp_user_id' => $request->id]),
                    ]);
                    
                } else {
                    Auth::guard('web')->login($user);
                    Session::forget('verify-password');
                    return response()->json([
                    'status' => true,
                    'message' => $request->type == 1 
                        ? 'Login successfully' 
                        : 'Affilated User registered successfully',
                    'redirect_url' => route('affiliate.affiliateDashboard'),
                ]);

                }
    
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP, please try again',
                ], 422);
            }


        }
    }



        public function userCreatePassword(Request $request){
            if ($request->isMethod('get')) {
                return view('affiliatedUser.auth.createPassword');
            }else{


                $rules = [
                    'password' => [
                        'required',
                        // 'string',
                        // 'min:8',
                        // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                    ],
                    'confirm_password' => 'required|same:password',
                    ];

                $messages = [
                 'password.required' => 'Please Enter New password',
                // 'password.min' => 'Password must be at least 8 characters long',
                // 'password.regex' => 'Password must include at least one uppercase, one lowercase, one number, and one special character',
                'confirm_password.required' => 'Please enter confirm password',
                'confirm_password.same' => 'Passwords do not match',
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
                    'message' => 'Invalid user reference',
                ], 400);
            }

            $user = AffilatedUser::find($id);

            if ($user) {
                $user->update([
                    'password' => bcrypt($request->password),
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Password updated successfully'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ]);
            
               
            }
        }


    public function affiliate_signup(){
        return View('affiliatedUser.register');
    }

     public function affiliate_addaddress(){
        return View('affiliatedUser.addaddress');
    }

     public function affiliateAddBankDetails(){
        return View('affiliatedUser.addBankInformation');
    }
    
    public function affiliateDashboard(){
        return View('affiliatedUser.dashboard');
    }

}