<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\country;
use App\Models\seller;

use App\Models\sellerStoreInformation;
use App\Models\sellerDocument;
use App\Models\Bankdetails;

use App\Helpers\ApiResponse;

use Illuminate\Validation\Rule;

Use Auth;

use Validator;

use App\Services\SellerAuthService;

use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
 
    public function __construct(SellerAuthService $SellerAuthService){
        $this->SellerAuthService=$SellerAuthService;
    }

    public function login(Request $request){

        $country= country::all();

        if ($request->isMethod('get')) {
       
        return view('dealer.login',compact('country'));
        }


        $validate = Validator::make($request->all(), [
            'email_mobile' => 'required',
            'password' => 'required',
           ],
         [
        'email_mobile.required' => __('seller_messages.email_mobile_required'),
        'password.required' => __('seller_messages.password_required'),
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput(); // keep old input values
        }


        $loginField = filter_var($request->email_mobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        if ($loginField === 'mobile') {
            $credentials = [
                'country_code' => $request->country_code,
                'mobile'       => $request->email_mobile,
                'password'     => $request->password,
            ];

            $seller = seller::where('mobile', $request->email_mobile)
                        ->where('country_code', $request->country_code)
                        ->where('otp_verify','1')
                        ->first();
        } else {
            $credentials = [
                'email'    => $request->email_mobile,
                'password' => $request->password,
            ];
            
            $seller = seller::where('email', $request->email_mobile)->where('otp_verify','1')->first();
        }


        if(!$seller){        

        // return redirect()->back()
        // ->withErrors(['error'=>'No Seller Account Found'])
        // ->withInput();

        return redirect()->back()->with('error',__('seller_messages.no_seller_account'));

        }
 

        if (Auth::guard('seller')->attempt($credentials)) {


           $seller_details=Auth::guard('seller')->user();

           if($seller_details->is_block==1){

            Auth::guard('seller')->logout(); 

             return redirect()->back()
            ->withErrors(['password'=>'This Account is Blocked'])
            ->withInput();
           }

           if($seller_details->admin_verify=='0' || $seller_details->admin_verify=='1'){

            Auth::guard('seller')->logout();


            return redirect()->back()
            ->withErrors(['password'=>__('seller_messages.seller_not_verified')])
            ->withInput();
           }
           
           if($seller_details->admin_verify=='3'){

            $msg="Your Account is Rejected By admin $seller_details->reject_reason";

            Auth::guard('seller')->logout();
            
            return redirect()->back()
            ->withErrors(['password'=>$msg])
            ->withInput();
            
           }

           if($seller_details->admin_verify=='4'){
            // return redirect()->back()
            // ->withErrors(['password'=>'Seller Document is Rejected By Admin'])
            // ->withInput();
            
            return redirect()->route('seller.upload_document',$seller_details->id)->with('error',__('seller_messages.document_rejected'));
        
            }

        if(!session('lang')){
            session(['locale' => $seller_details->lang]);
            session(['lang' => $seller_details->lang]);
        } 

        return redirect()->route('seller.dashboard')->with('success',__('seller_messages.login_success'));
           
        }{
            return redirect()->back()
            ->withErrors(['password'=>__('seller_messages.incorrect_password')])
            ->withInput();

        }

    }

    public function verify_otp(Request $request){

        return view('dealer.otp_verify');
    
    }

    public function register(Request $request){

        $country= country::all();

        if ($request->isMethod('get')) {
            
            return view('dealer.sign-up',compact('country'));
        }

        $check_user_already=seller::where('email',$request->email)->where('otp_verify','0')->first();

        if($check_user_already){
          $check_user_already->delete();
        }
   

        $validate = Validator::make($request->all(), [
            'profile_pic' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'email' => 'required|email|unique:sellers,email',
            // 'mobile' => 'required',
            'mobile' => [
            'required',
            Rule::unique('sellers')->where(function ($query) use ($request) {
                return $query->where('country_code', $request->country_code);
            }),
        ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'confirm_password' => 'required|same:password',
            'accept_terms'=>"required|in:1"
        ],[
    
    'profile_pic.required' => __('seller_messages.profile_pic_required'),
    'first_name.required' => __('seller_messages.first_name_required'),
    'last_name.required' => __('seller_messages.last_name_required'),
    'country_code.required' => __('seller_messages.country_code_required'),
    'mobile.required' => __('seller_messages.mobile_required'),
    'mobile.unique' => __('seller_messages.mobile_unique'),

    'email.required' => __('seller_messages.email_required'),
    'email.email' => __('seller_messages.email_email'),
    'email.unique' => __('seller_messages.email_unique'),

    'password.required' => __('seller_messages.password_required'),
    'password.min' => __('seller_messages.password_min'),
    'password.regex' => __('seller_messages.password_regex'),

    'confirm_password.required' => __('seller_messages.confirm_password_required'),
    'confirm_password.same' => __('seller_messages.confirm_password_same'),

    'accept_terms.required' => __('seller_messages.accept_terms_required'),
    'accept_terms.in' => __('seller_messages.accept_terms_in'),
        
        
        ]);

        if ($validate->fails()) {
            
            return redirect()->back()
                ->withErrors($validate)
                ->withInput(); // keep old input values
        }


        $data=$this->SellerAuthService->register($request); // seller insert Code

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
        }

        $seller_id=$data['data']->id;

        return redirect()->route('seller.register_otp_verify',$seller_id)->with('success',__('seller_messages.otp_sent_successfully'));

    }


    public function register_otp_verify(Request $request){

        $seller_details=seller::where('id',$request->id)->first();
       
        if ($request->isMethod('get')) {
        return view('dealer.signup_otp',compact('seller_details'));
        }

        // $validate = Validator::make($request->all(), [
        //     'otp' => 'required|array|min:6',
        //     'otp.*' => 'required|min:6' // each element (digit) is required and must be a single digit
        // ], [
        //     'otp.required' => 'Please enter your OTP.',
        //     'otp.array' => 'OTP must be in a valid format.',
        //     'otp.*.required' => 'All OTP digits are required.'
        // ]);
    
        $validate = Validator::make($request->all(), [
            'otp' => 'required|array|min:6',
            'otp.*' => 'required|digits:1', // each input must be exactly one digit
        ], [
        'otp.required' => __('seller_messages.otp_required'),
        'otp.array' => __('seller_messages.otp_array'),
        'otp.min' => __('seller_messages.otp_min'),
        'otp.*.required' => __('seller_messages.otp_digit_required'),
        'otp.*.digits' => __('seller_messages.otp_digit_only'),
       ]
    
    );
        

        if ($validate->fails()) {

            // dd($validate);

            return redirect()->back()
            ->withErrors($validate)
            ->withInput();
        
         }


       $enteredOtp = implode('', $request->otp);

       if($seller_details->otp==$enteredOtp){

        $seller_details->update(['otp_verify'=>'1']);
        
        if($request->forgot=='yes'){

        return redirect()->route('seller.create_password',$seller_details->id)->with('success', __('seller_messages.otp_verify_successfully'));

        }else{
            
        Auth::guard('seller')->login($seller_details); // login with seller details

        return redirect()->route('seller.store_information',$seller_details->id)->with('success', __('seller_messages.otp_verify_successfully'));

        }

       }else{

        return redirect()->back()
        ->withErrors(['otp'=>" __('seller_messages.invalid_otp')"])
        ->withInput();

       }




    }


    public function store_information(Request $request){

        $country= country::all();

        if ($request->isMethod('get')) {

        $seller_data=Auth::guard('seller')->user()->id;

         $store_info=sellerStoreInformation::where('seller_id',$seller_data)->first();


        return view('dealer.store_page',compact('country','store_info'));

        }

        $validate = Validator::make($request->all(), [
            'store_image' => 'required',
            'store_name' => 'required',
            'country'=>"required",
            "store_address"=>"required",
            // 'address_line1'=>'required',
            // 'address_line2'=>'required',
            'country'=>'required',
            "store_phone"=>"required|digits_between:7,15",
            'store_mail_id'=>'required|email',
            'bio'=>'required',
            // 'let'=>'required|nullable',
            // 'long'=>'required|nullable'
            
            ],[
            'store_image.required' => __('seller_messages.store_image_required'),
            'store_name.required' => __('seller_messages.store_name_required'),
            'country.required' => __('seller_messages.country_required'),
            'store_address.required' => __('seller_messages.store_address_required'),
            'address_line1.required' => __('seller_messages.address_line1_required'),
            'address_line2.required' => __('seller_messages.address_line2_required'),

            'store_phone.required' => __('seller_messages.store_phone_required'),
            'store_phone.digits_between' => __('seller_messages.store_phone_digits'),

            'store_mail_id.required' => __('seller_messages.store_email_required'),
            'store_mail_id.email' => __('seller_messages.store_email_valid'),

            'bio.required' => __('seller_messages.bio_required'),
                
            ]);

            if ($validate->fails()) {
                return redirect()->back()
                    ->withErrors($validate)
                    ->withInput();
            }
    
            // 'seller_id' => $request->user_id,

        $seller_id=  $request->id;

        $request['user_id']=$seller_id;

        $data= $this->SellerAuthService->store_information_insert($request);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }
        
        return redirect()->route('seller.upload_document',$seller_id)->with('success', __('seller_messages.store_info_saved'));

    }

    public function upload_document(Request $request){

        if ($request->isMethod('get')) {

           $seller_details=Auth::guard('seller')->user();

           $seller_data=$seller_details->id;

           if($seller_details->admin_verify!=='4'){
           
           $owner_document=sellerDocument::where('seller_id',$seller_data)->where('document_type','1')->where('status','1')->get();
           $store_document=sellerDocument::where('seller_id',$seller_data)->where('document_type','2')->where('status','1')->get();
           $seller_bank=Bankdetails::where('user_id',$seller_data)->first();
           
        }else{
       
            $owner_document=[];
            $store_document=[];
            $seller_bank= (object)[];
        
        }



        return view('dealer.bank-details',compact('owner_document','store_document','seller_bank'));

    }

    
    $validate = Validator::make($request->all(), [
        // 'user_id' => 'required|exists:sellers,id',

        'owner_document' => [
        'nullable',
        'array',
        'min:2',
        Rule::requiredIf(empty($request->old_owner_document) || count($request->old_owner_document) < 2),
    ],
    // 👇 Validate each file inside array
    'owner_document.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
    // 👇 Old documents (for keeping old images)
    'old_owner_document' => 'nullable|array',

    // store Value
    'store_document' => [
        'nullable',
        'array',
        'min:2',
        Rule::requiredIf(empty($request->old_store_document) || count($request->old_store_document) < 2),
    ],
    // 👇 Validate each file inside array
    'store_document.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
    // 👇 Old documents (for keeping old images)
    'old_store_document' => 'nullable|array',


    // 'owner_document' => 'nullable|array',        
    // 'store_document' => 'required|array',
    
        'account_type'=>"required|in:0,1", // 0 Personal 1 Busness
        "iban"=>"required",
        'swift'=>'required',
        'bank_name'=>'required',
        "account_holder_name"=>"required",
        'upload_proof' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|required_without:old_upload_proof',
        'old_upload_proof' => 'nullable|required_without:upload_proof', 
    ],[
        // 'iban.required' =>'please enter IBAN number',
        // 'swift.required' =>'please enter SWIFT\BIC number',
        
        // 'account_type.required'=>'Please select account type',
        // 'bank_name.required'=>'Please enter bank name',
        // 'account_holder_name.required'=>'Please enter account holder name',
        // 'store_document.required'=>'Please upload store document',
        // 'owner_document.required'=>'Please upload owner document',

        // 'upload_proof.required_without' => 'Please upload proof of Account',
        // 'upload_proof.image' => 'The upload proof must be an image file.',
        // 'upload_proof.mimes' => 'Only JPG, JPEG, PNG, and WEBP formats are allowed.',
        // 'upload_proof.max' => 'The image size must not exceed 2MB.',

    'iban.required' => __('seller_messages.iban_required'),
    'swift.required' => __('seller_messages.swift_required'),

    'account_type.required' => __('seller_messages.account_type_required'),
    'account_type.in' => __('seller_messages.account_type_invalid'),

    'bank_name.required' => __('seller_messages.bank_name_required'),
    'account_holder_name.required' => __('seller_messages.account_holder_required'),

    'store_document.required' => __('seller_messages.store_document_required'),
    'store_document.min' => __('seller_messages.store_document_min'),
    'store_document.*.image' => __('seller_messages.store_document_image'),
    'store_document.*.mimes' => __('seller_messages.store_document_mimes'),
    'store_document.*.max' => __('seller_messages.store_document_max'),

    'owner_document.required' => __('seller_messages.owner_document_required'),
    'owner_document.min' => __('seller_messages.owner_document_min'),
    'owner_document.*.image' => __('seller_messages.owner_document_image'),
    'owner_document.*.mimes' => __('seller_messages.owner_document_mimes'),
    'owner_document.*.max' => __('seller_messages.owner_document_max'),

    'upload_proof.required_without' => __('seller_messages.upload_proof_required'),
    'upload_proof.image' => __('seller_messages.upload_proof_image'),
    'upload_proof.mimes' => __('seller_messages.upload_proof_mimes'),
    'upload_proof.max' => __('seller_messages.upload_proof_max'),

    ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
        
        $dir="image";

        $owner_document1=[];
        $store_document1=[];

       $seller_id=$request->id;

       if($request->has('old_owner_document')){
        $owner_document1=$request->old_owner_document;

       }else{
        foreach($request->owner_document as $key=>$val){
            $owner_document1[$key]=image_upload($val,$dir);
            }
       }

       if($request->has('old_store_document')){
        $store_document1=$request->old_store_document;
       }else{

        foreach($request->store_document as $key=>$val){
            $store_document1[$key]=image_upload($val,$dir);
        }

    }

        if($request->has('old_upload_proof') && $request->old_upload_proof!==''){
            $upload_proof1=$request->old_upload_proof;
        }else{
            $upload_proof1=image_upload($request->upload_proof,$dir);
        }


        // unset data in request

        $data = $request->except(['owner_document', 'store_document', 'upload_proof']);
        $data['user_id'] = $seller_id;
        $data['owner_document'] = $owner_document1;
        $data['store_document'] = $store_document1;
        $data['upload_proof'] = $upload_proof1;


        $data = (object) $data;

        $data= $this->SellerAuthService->store_document_and_bank_details($data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return redirect()->route('seller.upload_review',$seller_id)->with('success', "__('seller_messages.store_document_bank_saved')");

    }


    public function upload_summary(Request $request){


        $seller_id=$request->id;

        if ($request->isMethod('get')) {

        $request['user_id']=$request->id;

        $review_data= $this->SellerAuthService->seller_review($request);
        if($review_data['status']=='success'){
            $review=$review_data['data'];
            return view('dealer.summary_page',compact('review'))->with('success', __('seller_messages.store_review_confirmed'));
            }

        }

        return redirect()->route('seller.review_submit_page',$seller_id)->with('success',__('seller_messages.store_review_confirmed'));


    }

    public function signup_review(Request $request){


        $request['user_id']=$request->id;
        $request = (object) $request;

        $data= $this->SellerAuthService->seller_store_submit_request($request);
        return view('dealer.signup-review')->with('success', __('seller_messages.wait_admin_verify'));
    }

    public function logout(Request $request)
    {
        
        Cache::forget('plan_page');
        Auth::guard('seller')->logout();


        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login');
    }

     
    public function forgot_password(Request $request){

    if ($request->isMethod('get')) {
        $country= country::all();
        return view('dealer.forgot',compact('country'));
    }


    if($request->type=='0'){
        $validate = Validator::make($request->all(), [
            'country_code'=>"required",
            'mobile'=>"required"
        ],[
              'country_code.required'=> __('seller_messages.country_code_required'),
                'mobile.required'=> __('seller_messages.mobile_required')
       
        ]);

       if($validate->fails()){
        return redirect()->back()
        ->withErrors(['mobile'=>__('seller_messages.mobile_required')])
        ->withInput();
     }
       }

    // when i use forgot password with Email
        if($request->type=='1'){
        $validate = Validator::make($request->all(), [
            'email'=>"required",
        ]);

        if($validate->fails()){

         return redirect()->back()
            ->withErrors(['email'=>__('seller_messages.email_required')])
        ->withInput();
        }
        }

    // $loginField = filter_var($request->email_mobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

    if ($request->type === '0') {
        $credentials = [
            'type'=>'0',
            'country_code' => $request->country_code,
            'mobile'       => $request->mobile,
        ];

        $seller = seller::where('mobile', $request->mobile)
                    ->where('country_code', $request->country_code)
                    ->where('otp_verify','1')
                    ->first();
    } else {
        $credentials = [
            'type'=>'1',
            'email'    => $request->email,
        ];
        
        $seller = seller::where('email', $request->email)->where('otp_verify','1')->first();
    }


    if(!$seller){                   
    return redirect()->back()
    ->withErrors(['error'=>__('seller_messages.account_not_exists')])
    ->withInput();
    }
    
    $credentials=(object) $credentials;
    
    $data= $this->SellerAuthService->mobile_or_email_forgot_password($credentials);

    if(isset($data['status']) && $data['status']=='error' ){

        return redirect()->back()
        ->withErrors(['error'=>$data['message']])
        ->withInput();
    }
    
    $seller_id= $data['data']->id."?forgot=yes";
    
    return redirect()->route('seller.register_otp_verify',$seller_id)->with('success',__('seller_messages.forgot_password_otp_sent'));
    
    }



    public function reset_password(Request $request){
        if ($request->isMethod('get')) {
        return view('dealer.reset_password');
        }

       $validate = Validator::make($request->all(), [
        'password' => [
            'required',
            'string',
            // 'min:8',
            // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
        ],
        'confirm_password'=>"required|same:password"
           ],[

            // 'password.required'     => 'Please enter password',
            // 'password.min' => 'Password must be at least 8 characters long',
            // 'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, one number, and one special symbol',
            // 'confirm_password.required' => 'Please confirm your password',
            // 'confirm_password.same' => 'Password do not match',

            'password.required' => __('seller_messages.reset_password_required'),
            'password.min' => __('seller_messages.reset_password_min'),
            'password.regex' => __('seller_messages.reset_password_regex'),

            'confirm_password.required' => __('seller_messages.reset_confirm_password_required'),
            'confirm_password.same' => __('seller_messages.reset_confirm_password_same'),

           ]);
    
   if($validate->fails()){
    if ($validate->fails()) {
        return redirect()->back()
            ->withErrors($validate)
            ->withInput();
    }

   }

   $data=[
   'id'=>$request->id,
   'password' => $request->password,
   'confirm_password'=>$request->confirm_password,
   ];

   $data= (object) $data;

   $data= $this->SellerAuthService->create_password($data);
  
    if(isset($data['status']) && $data['status']=='error' ){
        return redirect()->back()
        ->withErrors(['error'=>$data['message']])
        ->withInput();
    }
    
    return redirect()->route('seller.login')->with('success', __('seller_messages.password_reset_success'));

    }

   


    public function removeImage(Request $request){
            
        sellerDocument::where('id',$request->id)->delete();
        return ApiResponse::generateResponse('success', __('seller_messages.image_removed_success'),(object)[],200);
    
    }



    



}