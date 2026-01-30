<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{all_countrie,AffilatedUser,country,AffilatedUserAddress,Bankdetails };
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Auth;
use Validator;
use Session;

use Illuminate\Support\Facades\Hash;

use App\Helpers\ApiResponse;

use App\Services\UserAffilatedAuthService;

class UserAffilatedController extends Controller
{

    public function __construct(UserAffilatedAuthService $UserAffilatedAuthService)
    {
        $this->UserAffilatedAuthService = $UserAffilatedAuthService;
    }




    public function affiliate_startPage(){

        $user_id=Auth::guard('web')->user()->id;
        $affilated_User=AffilatedUser::where('user_id',$user_id)->where('otp_verify','1')->first();

        if($affilated_User){
            return redirect()->route('affiliate.affiliate_login');
        
        }else{
            return redirect()->route('affiliate.affiliate_signup');
        }
        
        // return View('affiliatedUser.startPage');
        
    }
    
    public function affiliate_login(Request $request){

         if ($request->isMethod('get')) {
                $country = country::all();
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


            if ($user->admin_verify == '3') {
                return response()->json([
                    'status' => false,
                    'message' => "Your Registration request is rejected ($user->reject_reason) ",
                ], 401);
            }


              if ($user->status == '0') {
                return response()->json([
                    'status' => false,
                    'message' => 'Account is blocked by admin',
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
                    'data'=>$user
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
                        $country =   country::all();
                        return view('affiliatedUser.auth.loginWithOtp', compact('country'));
            }else{


            $validator = Validator::make($request->all(), [
                'mobileOrEmail' => 'required',
            ], [
                'mobileOrEmail.required' => 'Please enter your mobile number or email address',
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
            

                // // new code 
                // $rules = [];
                // $messages = [];

                // if ($request->forgetPassword == '1') {
                //     $rules = [
                //         'country_code' => 'required',
                //         'mobile' => 'required|digits_between:7,15',
                //     ];

                //     $messages = [
                //         'country_code.required' => 'Please select your country code',
                //         'mobile.required' => 'Please enter your mobile number',
                //         'mobile.digits' => 'Mobile number must be between 7 and 15 digits',
                //     ];
                // } else {
                //     $rules = [
                //         'email' => 'required|email',
                //     ];

                //     $messages = [
                //         'email.required' => 'Please enter your email address',
                //         'email.email' => 'Please enter a valid email address',
                //     ];
                // }

                // $validator = Validator::make($request->all(), $rules, $messages);

                // if ($validator->fails()) {
                //     return response()->json([
                //         'status' => false,
                //         'errors' => $validator->errors()
                //     ]);
                // }

                // OTP value
                $otp = config('services.otp');

                // if ($request->forgetPassword == '1') {
                //     $user = AffilatedUser::where([
                //         ['country_code', $request->country_code],
                //         ['mobile', $request->mobile],
                //     ])->first();
                // } else {
                //     $user = AffilatedUser::where('email', $request->email)->first();
                // }

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
                $country =   country::all();
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



$validator->after(function ($validator) use ($request) {
    if (empty(array_filter($request->otp))) {
        $validator->errors()->add('otp', 'Please enter OTP');
    }
});
$validator->validate();

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
                    
                }elseif ($request->forget_password == 'two') { // Register otp Verify
                    
                    return response()->json([
                        'status' => true,
                        'message' => 'OTP verified successfully',
                        'redirect_url' => route('affiliate.affiliate_addaddress', ['temp_user_id' => $request->id]),
                    ]);

                }else {
                    Auth::guard('affilated_user')->login($user);
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
                        'string',
                        'min:8',      
                        // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                         'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/'
                ],
                    'confirm_password' => 'required|same:password',
                    ];

                $messages = [
                'password.required' => 'Please Enter New password',
                'password.min' => 'Password must be at least 8 characters long. ',
                'password.regex' => 'Password must include at least one uppercase, one lowercase, one number',
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

            if (Hash::check($request->password, $user->password)) {
                
                $validator->after(function ($validator) use ($request) {
                        $validator->errors()->add('password', "You can't use old password as new password");
                });
                $validator->validate();

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'error' => $validator->errors()->first()
                    ]);
                }
            }

            if ($user) {
                $user->update([
                    'password' => bcrypt($request->password),
                    'password_old'=>$request->password,
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


    public function affiliate_signup(Request $request){
        
        if($request->isMethod('get')){

            $country =   country::all();
            return View('affiliatedUser.register',compact('country'));
        }

        $user = $request->user()->id;
     
        $validate = Validator::make($request->all(), [
                'profile_image' => 'required',
                'full_name' => 'required',
                'country_code' => 'required',
                "mobile" =>"required",
                 'email' => [
                    'required',
                    'email',
                ],
                 'password' => [
                            'required',
                            'string',
                            'min:8',
                            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]+$/'
                        ],
                "confirm_password"=>"required|same:password",
                "document1"=>"required",
                "document2"=>"required",
                "accept" =>"required|In:1"
                ],
            [
        'profile_image.required'    => 'Please Upload Profile Picture.',
        'full_name.required'        => 'Please Enter First Name.',
        'country_code.required'     => 'Country code is required.',
        'mobile.required'           => 'Please Enter Mobile number.',
        'email.required'            => 'Please Enter Email address.',
        'email.email'               => 'Please enter a valid email address.',
        'password.required'         => 'Password is required.',
        'confirm_password.required' => 'Please confirm your password.',
        'confirm_password.same'     => 'Password and confirm password must match.',
        'document1.required'        => 'Please Upload Document 1.',
        'document2.required'        => 'Please Upload Document 2',
        'accept.required'           => 'You must accept the terms and conditions.',
        'accept.in'                 => 'You must accept the terms and conditions.',
        'password.required'     => 'Please enter your password',
        'password.min' => 'Password must be at least 8 characters long',
        'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, one number',
    ]
);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
    }


       if ($request->hasFile('profile_image')) {
            $dir = "document";
            $profile_image = image_upload($request->profile_image, $dir);

       }else{
        $profile_image=null;
       }

       if ($request->hasFile('document1')) {
            $dir = "document";
            $document1 = image_upload($request->document1, $dir);
       }else{
        $document1=null;
       }

       if ($request->hasFile('document2')) {
            $dir = "document";
            $document2 = image_upload($request->document2, $dir);
       } else{
        $document2=null;
       }

     $request_data=(object) [
    'user_id'=>$user,
    "profile_image"=>$profile_image,
    'full_name'=>$request->full_name??null,
    'country_code'=>$request->country_code??null,
    'mobile'=>$request->mobile??null,
    'email'=>$request->email??null,
    'password'=>$request->password??null,
    'document1'=>$document1??null,
    'document2'=>$document2??null,

    'let'=>$request->let??null,
    'long'=>$request->long??null,
    "device_type"=>$request->device_type??null
    ];

  $data=$this->UserAffilatedAuthService->RegisterAffilatedUser($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

        $id = Crypt::encryptString($data['data']->id);
        return response()->json([
            'status' => 'success',
            'message' => $data['message'],
            'id' => $id,
        ]);

    
    // return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }

     public function affiliate_addaddress(Request $request){

         $country= country::all();

        if($request->isMethod('get')){

        $id = Crypt::decryptString($request->temp_user_id);


      $affiliate_address=AffilatedUserAddress::where('affiliate_id',$id)->first();
        
        return View('affiliatedUser.auth.addaddress',compact('country','id','affiliate_address'));

        }
        
         $validate = Validator::make($request->all(), [
                'country' => 'required',
                'locations' => 'required',
                'address1' => 'required',
                "address2" =>"required",
                // "pincode" =>"required",
                // "town"=>"required",
                // "state"=>"required",
                // "city"=>"required",
                "let"=>"required",
                "long" =>"required"
                ],
             [
        'country.required'   => 'Please select a country.',
        'locations.required' => 'Please select a location.',
        'address1.required'  => 'Address line 1 is required.',
        'address2.required'  => 'Address line 2 is required.',
        'pincode.required'   => 'Pincode is required.',
        'town.required'      => 'Town is required.',
        'state.required'     => 'State is required.',
        'city.required'      => 'City is required.',
        'let.required'       => 'Latitude is required.',
        'long.required'      => 'Longitude is required.',
    ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
    }

    $affilated_user = $request->affilated_id;
     
     $request_data=(object) [
    'affilated_user'=>$affilated_user,
    "country"=>$request->country,
    'locations'=>$request->locations,
    'address1'=>$request->address1,
    'address2'=>$request->address2,
    'pincode'=>$request->pincode??null,
    'town'=>$request->town??null,
    'state'=>$request->state??null,
    'city'=>$request->city??null,
    'let'=>$request->let??null,
    'long'=>$request->long??null
    ];

  $data=$this->UserAffilatedAuthService->affilatedAddAddress($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

      $id = Crypt::encryptString($data['data']->affiliate_id);

        return response()->json([
            'status' => 'success',
            'message' => $data['message'],
            'id' => $id,
        ]);

    // return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }

     public function affiliateAddBankDetails(Request $request){

        if($request->isMethod('get')){
        $id = Crypt::decryptString($request->temp_user_id);

      $affiliate_bank=Bankdetails::where('user_id',$id)->where('type','3')->first();
        
        return View('affiliatedUser.auth.addBankInformation',compact('id','affiliate_bank'));
        }


         $validate = Validator::make($request->all(), [
                'bank_name' => 'required',
                'account_holder_name' => 'required',
                'account_no' => 'required',
                "confirm_account_no" =>"required|same:account_no",
                "iban" =>"required",
                "swift"=>"required",
                ],
                 [
        'bank_name.required'           => 'Bank name is required.',
        'account_holder_name.required' => 'Account holder name is required.',
        'account_no.required'          => 'Account number is required.',
        'confirm_account_no.required'  => 'Please confirm your account number.',
        'confirm_account_no.same'      => 'Account number and confirm account do not match.',
        'iban.required'                => 'IBAN number is required.',
        'swift.required'               => 'SWIFT code is required.',
    ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
    }

     $affilated_user = $request->affilated_id;
     
     $request_data=(object) [
    'affilated_user'=>$affilated_user,
    "bank_name"=>$request->bank_name,
    'account_holder_name'=>$request->account_holder_name,
    'account_no'=>$request->account_no,
    'iban'=>$request->iban,
    'swift'=>$request->swift,
    ];

  $data=$this->UserAffilatedAuthService->affilatedAddAddBankDetails($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

     $id = Crypt::encryptString($data['data']->user_id);
        return response()->json([
            'status' => 'success',
            'message' => $data['message'],
            'id' => $id,
        ]);

    // return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
        

    }

    public function affiliatereview_submit_page(){
        
         return view('affiliatedUser.auth.signup-review'); 
    }
    
    public function affiliateDashboard(){
        
    $affilatedUser=Auth::guard('affilated_user')->user();

    $id = Crypt::encryptString($affilatedUser->id);

      if($affilatedUser->address_update_status=='0'){

     return redirect()->route('affiliate.affiliate_addaddress', ['temp_user_id' => $id]);
        
        
        // return View('affiliatedUser.auth.addaddress',compact('id'));

        }

      if($affilatedUser->bank_update_status=='0'){

        return redirect()->route('affiliate.affiliateAddBankDetails', ['temp_user_id' => $id]);
        
        // return View('affiliatedUser.auth.addBankInformation',compact('id'));
        }

     if($affilatedUser->admin_verify=='1'){

        return redirect()->route('affiliate.affiliatereview_submit_page', ['temp_user_id' => $id]);        
        // return view('affiliatedUser.auth.signup-review'); 
        }

   
    return View('affiliatedUser.dashboard',compact('affilatedUser'));

}



    public function userLogout()
        {

            $affilatedUser=Auth::guard('affilated_user')->user();
            
            Auth::guard('affilated_user')->logout();
            
            // request()->session()->invalidate();
            // request()->session()->regenerateToken();

            return redirect('user/affiliate-login');
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
            $user = AffilatedUser::find($id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                ], 404);
            }

            $otp= config('services.otp');
            $user->otp = $otp;
            $user->save();

       
            return response()->json([
                'status' => true,
                'message' => 'OTP resent successfully',
            ]);
        }




    public function affiliatereverifyDocument(Request $request){

        $affilatedUser=Auth::guard('affilated_user')->user();
            
        $user = $affilatedUser->id;
        
        if($request->isMethod('get')){

             $affilatedUser = AffilatedUser::with('country_details')->where('id',$user)->first();
            
            $country =   country::all();
            return View('affiliatedUser.reverifyDocument',compact('country','affilatedUser'));
        }
        
        
     
        $validate = Validator::make($request->all(), [
                // 'profile_image' => 'required',
                // 'full_name' => 'required',
                // 'country_code' => 'required',
                // "mobile" =>"required",
                //  'email' => [
                //     'required',
                //     'email',
                // ],
                //  'password' => [
                //             'required',
                //             'string',
                //             'min:8',
                //             'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]+$/'
                //         ],
                // "confirm_password"=>"required|same:password",
                "document1"=>"required",
                "document2"=>"required",
                // "accept" =>"required|In:1"
                ],
            [
        // 'profile_image.required'    => 'Please Upload Profile Picture.',
        // 'full_name.required'        => 'Please Enter First Name.',
        // 'country_code.required'     => 'Country code is required.',
        // 'mobile.required'           => 'Please Enter Mobile number.',
        // 'email.required'            => 'Please Enter Email address.',
        // 'email.email'               => 'Please enter a valid email address.',
        // 'password.required'         => 'Password is required.',
        // 'confirm_password.required' => 'Please confirm your password.',
        // 'confirm_password.same'     => 'Password and confirm password must match.',
        'document1.required'        => 'Please Upload Document 1.',
        'document2.required'        => 'Please Upload Document 2',
        // 'accept.required'           => 'You must accept the terms and conditions.',
        // 'accept.in'                 => 'You must accept the terms and conditions.',
        // 'password.required'     => 'Please enter your password',
        // 'password.min' => 'Password must be at least 8 characters long',
        // 'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, one number',
    ]
);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
    }


    //    if ($request->hasFile('profile_image')) {
    //         $dir = "document";
    //         $profile_image = image_upload($request->profile_image, $dir);

    //    }else{
    //     $profile_image=null;
    //    }

       if ($request->hasFile('document1')) {
            $dir = "document";
            $document1 = doc_upload($request->document1, $dir);
       }else{
        $document1=null;
       }

       if ($request->hasFile('document2')) {
            $dir = "document";
            $document2 = doc_upload($request->document2, $dir);
       } else{
        $document1=null;
       }

     $request_data=(object) [
    'user_id'=>$user,
    // "profile_image"=>$profile_image,
    // 'full_name'=>$request->full_name??null,
    // 'country_code'=>$request->country_code??null,
    // 'mobile'=>$request->mobile??null,
    // 'email'=>$request->email??null,
    // 'password'=>$request->password??null,
    'document1'=>$document1??null,
    'document2'=>$document2??null,

    // 'let'=>$request->let??null,
    // 'long'=>$request->long??null,
    // "device_type"=>$request->device_type??null
    ];

  $data=$this->UserAffilatedAuthService->uploadReverifydocument($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

        $id = Crypt::encryptString($data['data']->id);
        return response()->json([
            'status' => 'success',
            'message' => $data['message'],
            'id' => $id,
        ]);

    
    // return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }




}