<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\sellerStoreInformation;
use App\Models\country;
use Illuminate\Support\Facades\Crypt;
use App\Services\UserProfileService;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\FullBanner;
use App\Models\all_countrie;
use Illuminate\Validation\Rule;
// use Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use App\Services\UserDashboardService;
use App\Helpers\ApiResponse;
use App\Services\UserAuthService;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserOtpMail;


use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
     public function __construct(UserDashboardService $UserDashboardService, UserAuthService $UserAuthService, TwilioService $TwilioService)
    {
        $this->UserDashboardService = $UserDashboardService;
        $this->UserAuthService = $UserAuthService;
        $this->TwilioService=$TwilioService;
    }



    public function userRegister(Request $request){
        if($request->isMethod('get')){
            $country =   all_countrie::where('status',1)->get();
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
                    // 'image'=> 'required',
                    'email' => 'required|email|unique:users,email',
                    'mobile'=> [
                            'required',
                            'digits_between:7,15',
                            Rule::unique('users')->where(function ($query) use ($request) {
                                return $query->where('country_code', $request->country_code);
                            }),
                        ],
                    'password' => [
                            'required',
                            // 'string',
                            // 'min:8',
                            // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
                        ],
                    'confirm_password' => 'required|same:password',
                    'accept_terms' => 'required|in:1',
                ];

                $messages = [      
                    // 'full_name.required'    => 'Please enter your full name',
                    // 'country_code.required' => 'Please select your country code',
                    // 'email.required'        => 'Please enter your email address',
                    // 'email.email'           => 'Please enter a valid email address',
                    // 'email.unique'          => 'This email address is already registered',
                    // 'mobile.required'       => 'Please enter your mobile number',
                    // 'password.required'     => 'Please enter your password',
                    // 'password.min' => 'Password must be at least 8 characters long',
                    // 'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, one number, and one special symbol',
                    // 'confirm_password.required' => 'Please confirm your password',
                    // 'confirm_password.same' => 'Password do not match',
                    // 'accept_terms.required' => 'Please accept the terms and conditions',
                    // 'accept_terms.in' => 'You must agree to the terms and conditions to continue',
                    'full_name.required' => __('user_messages.full_name_required'),
                    'country_code.required' => __('user_messages.country_code_required'),
                    'email.required' => __('user_messages.enter_email'),
                    'email.email' => __('user_messages.enter_valid_email'),
                    'email.unique' => __('user_messages.email_already_registered'),
                    'mobile.required' => __('user_messages.enter_mobile_number1'),
                    'mobile.digits_between' => __('user_messages.mobile_digits'),
                    'mobile.unique' => __('user_messages.mobile_already_registered'),
                    'password.required' => __('user_messages.enter_password'),
                    'password.min' => __('user_messages.password_min'),
                    'password.regex' => __('user_messages.password_regex'),
                    'confirm_password.required' => __('user_messages.confirm_password_required'),
                    'confirm_password.same' => __('user_messages.password_do_not_match'),
                    'accept_terms.required' => __('user_messages.accept_terms_required'),
                    'accept_terms.in' => __('user_messages.must_accept_terms'),
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

               if($validator->fails()){
                   return response()->json([
                    'status'=>false,
                    'errors'=>$validator->errors()
                   ]);
               }

            //    if($request->image){
                
            //      $dir = 'profile_image/';
            //      $image_path = $this->image_upload($request->image, $dir);
                 
            //     }

                if ($request->hasFile('image')) {
                    $commonController = app(CommonController::class);
                    $uploadResult = $commonController->upload($request);
                    $uploadResultArray = $uploadResult->getData(true);

                    if ($uploadResultArray['status'] === 'error') {
                        return response()->json([
                            'status'  => 'error',
                            'message' => $uploadResultArray['message']
                        ], 400);
                    }

                    $imageUrl = $uploadResultArray['data']['url'];
                }
    
                $otp= config('services.otp');

                $data = User::create([
                    'full_name'     => $request->full_name,
                    'country_code'  => $request->country_code,
                    'mobile'        => $request->mobile,
                    'email'         => $request->email,
                    'password'      => bcrypt($request->password),
                    'otp'           => $otp,
                    'profile_image'=>$imageUrl??null
                ]);

                CreateNotification([
                    'sender_id' => $data->id,
                    'sender_type' => 2,

                    'receiver_id' => 1,
                    'receiver_type' => 1,

                    'title_english' => 'New User Registered',
                    'title_arabic' => 'تسجيل مستخدم جديد',

                    'description_english' => $data->full_name . ' has registered as a user',
                    'description_arabic' => $data->full_name . ' قام بالتسجيل كمستخدم جديد',

                    'notification_type' => 'new_user_registration'
                ]);

                $id  = Crypt::encryptString($data->id);

                Session::put('verify-password', '1');
                $phone = $request->country_code . $request->mobile;
                $message = "Your verification Code Is $otp";
                if (preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
                    try {
                        $this->TwilioService->sendOtp($phone, $message);
                    } catch (\Exception $e) {
                        // ❌ silently skip (no return, no error)
                        // Optional: log for debugging
                        //\Log::warning('Twilio SMS skipped: ' . $e->getMessage());
                    }
                }
                Mail::to($data->email)->send(new UserOtpMail($data, $otp));
                return response()->json([
                                'status'=>true,
                                // 'message'=>'OTP sent to your mobile number succesfully ',
                                'message' => __('user_messages.otp_sent_successfully'),
                                'id'=>$id,
                            ]);



        }

    }


    public function userVerifyOtp(Request $request){
        if($request->isMethod('get')){
                  return view('user.auth.otpVerify'); 
        }else{
            
 
            $validator = Validator::make($request->all(), [
                'id'=>'required',
                'otp' => 'required|array',
            ], [
                // 'otp.required' => 'Please enter OTP',
                // 'otp.*.required' => 'Please enter OTP',
                'otp.required' => __('user_messages.enter_otp'),
            'otp.*.required' => __('user_messages.enter_otp'),
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
                    // 'message' => 'Invalid user reference',
                    'message' => __('user_messages.invalid_user_reference'),
                ], 400);
            }


            $user = User::find($id);


            if (!$user) {
                return response()->json([
                    'status' => false,
                    // 'message' => 'User not found.',
                    'message' => __('user_messages.user_not_found'),
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
                        // 'message' => 'OTP verified successfully',
                        'message' => __('user_messages.otp_verified_success'),
                        'redirect_url' => route('userCreatePassword', ['temp_user_id' => $request->id]),
                    ]);
                    
                } else {
                    Auth::guard('web')->login($user);
                    Session::forget('verify-password');
                    return response()->json([
                    'status' => true,
                    // 'message' => $request->type == 1 
                    //     ? 'Login successfully' 
                    //     : 'User registered successfully',
                    'message' => $request->type == 1
                        ? __('user_messages.login_success')
                        : __('user_messages.user_registered_success'),
                    'redirect_url' => route('dashboard'),
                ]);

                }
    
            } else {
                return response()->json([
                    'status' => false,
                    // 'message' => 'Invalid OTP, please try again',
                    'message' => __('user_messages.invalid_otp'),
                ], 422);
            }


        }
    }


        public function userLogin(Request $request)
        {
            if ($request->isMethod('get')) {
                $country = all_countrie::where('status',1)->get();
                return view('user.auth.login', compact('country'));
            }

            $validator = Validator::make($request->all(), [
                'mobileOrEmail' => 'required',
                'password' => 'required|min:6',
            ], [
                // 'mobileOrEmail.required' => 'Please enter your mobile number or email address',
                // 'password.required' => 'Please enter your password',
                // 'password.min' => 'Password must be at least 6 characters long',
                'mobileOrEmail.required' => __('user_messages.please_enter_mobile_number_or_email_address'),
                'password.required' => __('user_messages.please_enter_password'),
                'password.min' => __('user_messages.password_min'),
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
                    // 'message' => 'User is not Regsiter',
                    'message' => __('user_messages.user_not_registered'),
                ], 401);
            }

            if ($user->otp_verify == '0') {
                return response()->json([
                    'status' => false,
                    // 'message' => 'Please verify your ' . $loginField . ' with OTP to login',
                    'message' => __('user_messages.verify_otp', ['field' => $loginField]),
                ], 401);
            }

            if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                $user->update(['is_login' => 1]);
                $user->update(['is_visit_website' => 1]);

                return response()->json([
                    'status' => true,
                    // 'message' => 'Login successfully',
                    'message' => __('user_messages.login_success'),
                ]);
            }

            return response()->json([
                'status' => false,
                // 'message' => 'Invalid ' . $loginField . ' or password',
                'message' => __('user_messages.invalid_credentials', ['field' => $loginField]),
            ], 401);
        }




        public function userForgetPassword(Request $request){
               if ($request->isMethod('get')) {
                $country =   all_countrie::where('status',1)->get();
                return view('user.auth.forgetPassword', compact('country'));
            }else{   
            
                if ($request->forgetPassword == '1') {
                    // $rules['mobile'] = 'required|digits_between:7,15|exists:users,mobile';
                    // $messages['mobile.required'] = 'Please enter your mobile number';
                    // $messages['mobile.digits_between'] = 'Mobile number must be between 7 and 15 digits';
                    // $messages['mobile.exists'] = 'This mobile number is not registered';
                    $rules['mobile'] = 'required|digits_between:7,15|exists:users,mobile';
                    $messages['mobile.required'] = __('user_messages.mobile_required');
                    $messages['mobile.digits_between'] = __('user_messages.mobile_digits');
                    $messages['mobile.exists'] = __('user_messages.mobile_exists');
                }

                if ($request->forgetPassword == '2') {
                    // $rules['email'] = 'required|email|exists:users,email';
                    // $messages['email.required'] = 'Please enter your email address';
                    // $messages['email.email'] = 'Please enter a valid email address';
                    // $messages['email.exists'] = 'This email is not registered';
                     $rules['email'] = 'required|email|exists:users,email';
                    $messages['email.required'] = __('user_messages.email_required');
                    $messages['email.email'] = __('user_messages.email_invalid');
                    $messages['email.exists'] = __('user_messages.email_exists');
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
                    Session::put('verify-password', '1');
                    $phone = $user->country_code . $user->mobile;
                    $message = "Your verification Code Is $otp";
                    if (preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
                        try {
                            $this->TwilioService->sendOtp($phone, $message);
                        } catch (\Exception $e) {
                            // ❌ silently skip (no return, no error)
                            // Optional: log for debugging
                            //\Log::warning('Twilio SMS skipped: ' . $e->getMessage());
                        }
                    }
                    Mail::to($user->email)->send(new UserOtpMail($user, $otp));
                    return response()->json([
                        'status' => true,
                        // 'message' => 'OTP sent successfully',
                        'message' => __('user_messages.otp_sent_success'),
                        'id' => $id,
                        'type'=>$request->forgetPassword
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => __('user_messages.user_not_found')
                ],403);

     

            }
        }


        public function userCreatePassword(Request $request){
            if ($request->isMethod('get')) {
                return view('user.auth.createPassword');
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
                'confirm_password.required' => __('user_messages.please_enter_confirm_password'),
                'confirm_password.same' => __('user_messages.password_do_not_match'),
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
                    'message' => __('user_messages.invalid_user_reference'),
                ], 400);
            }

            $user = User::find($id);

            if ($user) {
                $user->update([
                    'password' => bcrypt($request->password),
                ]);

                return response()->json([
                    'status' => true,
                    'message' => __('user_messages.password_updated_successfully')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => __('user_messages.user_not_found')
            ]);
            
               
            }
        }


        public function loginWithOtp(Request $request){

                   if ($request->isMethod('get')) {
                        $country =   all_countrie::where('status',1)->get();
                        return view('user.auth.loginWithOtp', compact('country'));
            }else{

              
                $rules = [];
                $messages = [];

                if ($request->forgetPassword == '1') {
                    $rules = [
                        'country_code' => 'required',
                        'mobile' => 'required|digits_between:7,15',
                    ];

                    $messages = [
                        // 'country_code.required' => 'Please select your country code',
                        // 'mobile.required' => 'Please enter your mobile number',
                        // 'mobile.digits' => 'Mobile number must be between 7 and 15 digits',
                        'country_code.required' => __('user_messages.country_code_required'),
                        'mobile.required' => __('user_messages.mobile_required'),
                        'mobile.digits' => __('user_messages.mobile_digits'),
                    ];
                } else {
                    $rules = [
                        'email' => 'required|email',
                    ];

                    $messages = [
                        // 'email.required' => 'Please enter your email address',
                        // 'email.email' => 'Please enter a valid email address',
                        'email.required' => __('user_messages.email_required'),
                        'email.email' => __('user_messages.email_invalid'),
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
                    $user = User::where([
                        ['country_code', $request->country_code],
                        ['mobile', $request->mobile],
                    ])->first();
                } else {
                    $user = User::where('email', $request->email)->first();
                }

                if ($user) {
                    $user->otp = $otp;
                    $user->save();

                    $id = Crypt::encryptString($user->id);
                    Session::put('verify-password', '1');
                    $phone = $user->country_code . $user->mobile;
                    $message = "Your verification Code Is $otp";
                    if (preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
                        try {
                            $this->TwilioService->sendOtp($phone, $message);
                        } catch (\Exception $e) {
                            // ❌ silently skip (no return, no error)
                            // Optional: log for debugging
                            //\Log::warning('Twilio SMS skipped: ' . $e->getMessage());
                        }
                    }
                     Mail::to($user->email)->send(new UserOtpMail($user, $otp));
                    return response()->json([
                        'status' => true,
                        // 'message' => 'OTP sent successfully',
                        'message' => __('user_messages.otp_sent_success'),
                        'id' => $id,
                        'type'=> $request->forgetPassword
                    ]);

                }

                return response()->json([
                    'status' => false,
                    // 'message' => $request->forgetPassword == '1'
                    //     ? 'This mobile number is not registered'
                    //     : 'This email address is not registered',
                    'message' => $request->forgetPassword == '1'
                        ? __('user_messages.mobile_not_registered')
                        : __('user_messages.email_not_registered'),
                ], 403);
            }
        }


        public function userLogout()
        {
            $user = auth()->user();
            //dd($user);

        if ($user) {
            $user->update(['is_login' => 0]);
            $user->update(['banner_view' => '0']);
        }
            Auth::guard('web')->logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect('user/login');
        }



        public function resendOtp(Request $request)
        {
            try {
                $id = Crypt::decryptString($request->id);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid user reference',
                ], 400);
            }

            // Find user
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                ], 404);
            }

            $otp= config('services.otp');
            $user->otp = $otp;
            $user->save();
            $phone = $user->country_code . $user->mobile;
            $message = "Your verification Code Is $otp";
            if (preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
                    try {
                        $this->TwilioService->sendOtp($phone, $message);
                    } catch (\Exception $e) {
                        // ❌ silently skip (no return, no error)
                        // Optional: log for debugging
                        //\Log::warning('Twilio SMS skipped: ' . $e->getMessage());
                    }
                }

                Mail::to($user->email)->send(new UserOtpMail($user, $otp));

       
            return response()->json([
                'status' => true,
                // 'message' => 'OTP resent successfully',
                'message' => __('user_messages.otp_resent_successfully'),
            ]);
        }




   public function dashboard(Request $request)
    {

        // $subCategory = SubCategory::where('category_id','1')->where('status',1)->orderBy('name_english','desc')->get();
        $subCategory = SubCategory::where('category_id', 1)
            ->where('status', 1)
            ->whereHas('category', function ($query) {
                $query->where('status', 1);
            })
            ->orderBy('name_english', 'desc')
            ->get();

        if ($subCategory->isEmpty()) {
            $subCategory = SubCategory::where('category_id', 2)
                ->where('status', 1)
                ->whereHas('category', fn($q) => $q->where('status', 1))
                ->orderBy('name_english', 'desc')
                ->get();
        }

        if ($subCategory->isEmpty()) {
            $subCategory = SubCategory::where('category_id', 3)
                ->where('status', 1)
                ->whereHas('category', fn($q) => $q->where('status', 1))
                ->orderBy('name_english', 'desc')
                ->get();
        }

        if($request->ajax()){
            $subCategory = SubCategory::where('category_id', $request->id)->where('status',1)->orderBy('name_english','desc')->get();
            return view('user.dashboard.subCategory', compact('subCategory'))->render();
        }

        $stores = sellerStoreInformation::orderBy('store_name', 'desc')->get();

        // Fetch banners only if user is logged in
       $banners = collect(); // default empty collection

        if (auth()->check() && auth()->user()->banner_view == '0') {

            $userCountryCode = auth()->user()->country_code;

            $banners = FullBanner::with('country_info')->where('type','2')
                ->whereHas('country_info', function($query) use ($userCountryCode) {
                    $query->where('dial_code', $userCountryCode);
                })
                ->orderBy('id', 'desc')
                ->get();
        }
    // dd($banners);

             $request_data = (object)[
                    'type'        => '1',
                ];

            $topBanners= $this->UserDashboardService->HomeScreenBanner($request_data);
            

            $request_data1 = (object)[
                    'type'        => '2',
                ];

            $bottomBanners= $this->UserDashboardService->HomeScreenBanner($request_data1);
            //dd($bottomBanners);

            $request_data2=(object) [
            'type'        => '3',
            'category'=>$request->category??null,   
            ];

          $homeDealBanner1=$this->UserDashboardService->HomeScreenDealManagement($request_data2);
          $homeDealBanner=$homeDealBanner1['data'];

          // dd($homeDealBanner);

        // best Selling products
        $user_id = auth()->guard('web')->id() ?? '';        

        $bestSellingProduct=$this->UserDashboardService->bestSellingProduct($user_id);
        $bestSellingProduct=$bestSellingProduct['data'];

        // Top rating products

        $TopRatingProduct=$this->UserDashboardService->TopRatingProduct($user_id);
        $TopRatingProduct=$TopRatingProduct['data'];

        // New Arrival products
        $userNewestProduct=$this->UserDashboardService->userNewestProduct($user_id);
        $userNewestProduct=$userNewestProduct['data'];


        return view('user.dashboard.dashboard', compact('subCategory','stores','banners','topBanners','bottomBanners','homeDealBanner','bestSellingProduct','TopRatingProduct','userNewestProduct'));
    }

    public function updateBannerView(Request $request)
    {
        $user = auth()->user();
        $user->banner_view = '1'; 
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Banner marked as viewed'
        ]);
    }

    // public function delete_account(Request $request){


    //      $user_id = auth()->guard('web')->id();

    //      $request_data = (object)[
    //             'user_id' => $user_id,
    //         ];
  
    //       $data= $this->UserAuthService->DeleteAccount($request_data);

    //       if(isset($data['status']) && $data['status']=='error' ){
    //           return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    //       }
  
    //       return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
    // }


    public function delete_account(Request $request)
    {
        try {

            DB::beginTransaction();

            $user = Auth::guard('web')->user();

            if (!$user) {
                return ApiResponse::generateResponse(
                    'error',
                    'User not found',
                    [],
                    400
                );
            }

            // clear token if exists
            $user->accessToken = null;
            $user->save();

            $user->delete();

            DB::commit();

            Auth::guard('web')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return ApiResponse::generateResponse(
                'success',
                __('user_messages.account_deleted_successfully'),
                [],
                200
            );

        } catch (\Exception $e) {

            DB::rollBack();

            return ApiResponse::generateResponse(
                'error',
                $e->getMessage(),
                [],
                400
            );
        }
    }

    // Login With Ggogle and facebook Code

 // GOOGLE LOGIN
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            [
                'email' => $googleUser->email,
            ],
            [
                "socialType"=>"1",
                'email' => $googleUser->email, 
                'full_name' => $googleUser->name,
                'unique_id' => $googleUser->id,
                'profile_image' => $googleUser->avatar,
                'otp_verify' => 1,                 
            ]
        );

        Auth::login($user);

        return redirect('/');
    }

    // FACEBOOK LOGIN
    public function facebookLogin()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();


        $user = User::updateOrCreate(
            [
                'unique_id' => $facebookUser->id,
            ],
            [
                'email' => $facebookUser->email,
                "socialType"=>"1",
                'full_name' => $facebookUser->name,
                'unique_id' => $facebookUser->id,
                
                // 'profile_image' => $googleUser->avatar,
                'otp_verify' => 1,       

            ]
        );

        Auth::login($user);

        return redirect('/');
    }





}