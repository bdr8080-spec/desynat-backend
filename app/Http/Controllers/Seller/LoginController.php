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

class LoginController extends Controller
{
 
    public function __construct(SellerAuthService $SellerAuthService){
        $this->SellerAuthService=$SellerAuthService;
    }

    public function login(Request $request){


        if ($request->isMethod('get')) {
         $country= country::all();

        return view('dealer.login',compact('country'));
        }


        $validate = Validator::make($request->all(), [
            'email_mobile' => 'required',
            'password' => 'required',
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

        return redirect()->back()->with('error','No Seller Account Found');

        }
 

        if (Auth::guard('seller')->attempt($credentials)) {
          
           $seller_details=Auth::guard('seller')->user();

           if($seller_details->admin_verify=='0'){
            return redirect()->back()
            ->withErrors(['password'=>'Seller Is Not verified By Admin'])
            ->withInput();
           }

           if($seller_details->admin_verify=='3'){
            return redirect()->back()
            ->withErrors(['password'=>'Seller Is Rejected By Admin'])
            ->withInput();
           }


           return redirect()->route('seller.dashboard');




        }{
            return redirect()->back()
            ->withErrors(['password'=>'Login Details Is Wrong'])
            ->withInput();

        }

    }

    public function verify_otp(Request $request){

        return view('dealer.otp_verify');
    
    }

    public function register(Request $request){

        if ($request->isMethod('get')) {

            $country= country::all();
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
            'mobile' => 'required',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'confirm_password' => 'required|same:password',
            'accept_terms'=>"required|in:1"
        ],[
            'profile_pic.required'=>'Please Upload profile Picture',
            'first_name.required'    => 'Please enter first name',
            'last_name.required'    => 'Please enter last name',
            'country_code.required' => 'Please select country code',
            'mobile.required' => 'Please enter mobile number',
            
            'email.required'        => 'Please enter email address',
            'email.email'           => 'Please enter a valid email address',
            'email.unique'          => 'This email address is already registered', 

            'password.required'     => 'Please enter password',
            'password.min' => 'Password must be at least 8 characters long',
            'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, one number, and one special symbol',
            'confirm_password.required' => 'Please confirm your password',
            'confirm_password.same' => 'Password do not match',

            'accept_terms.required' => 'Please accept the terms and conditions',
            'accept_terms.in' => 'You must agree to the terms and conditions to continue',
        
        
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

        return redirect()->route('seller.register_otp_verify',$seller_id)->with('success', 'OTP Sent Succesfully');

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
            'otp.required' => 'Please enter your OTP.',
            'otp.array' => 'OTP must be in a valid format.',
            'otp.min' => 'All 6 OTP digits are required.',
            'otp.*.required' => 'OTP Fields is required.',
            'otp.*.digits' => 'Each OTP box must contain only one number.',
        ]);
        

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

        return redirect()->route('seller.create_password',$seller_details->id)->with('success', 'Otp verify Successfully');

        }else{
            
        Auth::guard('seller')->login($seller_details); // login with seller details

        return redirect()->route('seller.store_information',$seller_details->id)->with('success', 'Otp verify Successfully');

        }

       }else{

        return redirect()->back()
        ->withErrors(['otp'=>'Otp Is Invalid'])
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
            'store_mail_id'=>'required',
            'bio'=>'required',
            // 'let'=>'required|nullable',
            // 'long'=>'required|nullable'
            
            ],[
                'store_image.required'=>'Please Upload Store Image',
                'store_name.required' => 'Please Enter store name',
                'store_address.required' => 'Please Enter store address',
                'address_line1.required' => 'Please Enter store Address 1',
                'address_line2.required' => 'Please Enter store Address 2',
                'store_phone.required' => 'Please Enter store phone',
            
                'store_mail_id.required'        => 'Please enter your email address',
                'store_mail_id.email'           => 'Please enter a valid email address',    
                'bio'=>'Bio Field Is Required',
                
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
        
        return redirect()->route('seller.upload_document',$seller_id)->with('success', 'Store Information Save Successfully');

    }

    public function upload_document(Request $request){

        if ($request->isMethod('get')) {

           $seller_data=Auth::guard('seller')->user()->id;

           $owner_document=sellerDocument::where('seller_id',$seller_data)->where('document_type','1')->where('status','1')->get();
           $store_document=sellerDocument::where('seller_id',$seller_data)->where('document_type','2')->where('status','1')->get();

           $seller_bank=Bankdetails::where('user_id',$seller_data)->first();
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
        // "iban"=>"required",
        // 'swift'=>'required',
        'bank_name'=>'required',
        "account_holder_name"=>"required",
        'upload_proof' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|required_without:old_upload_proof',
        'old_upload_proof' => 'nullable|required_without:upload_proof', 
    ],[
        'account_type.required'=>'Please select account type',
        'bank_name.required'=>'Please enter bank name',
        'account_holder_name.required'=>'Please enter account holder name',
        'store_document.required'=>'Please upload store document',
        'owner_document.required'=>'Please upload owner document',

        'upload_proof.required_without' => 'Please upload proof of Account',
        'upload_proof.image' => 'The upload proof must be an image file.',
        'upload_proof.mimes' => 'Only JPG, JPEG, PNG, and WEBP formats are allowed.',
        'upload_proof.max' => 'The image size must not exceed 2MB.',

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

        return redirect()->route('seller.upload_review',$seller_id)->with('success', 'Store Document Save Successfully');

    }


    public function upload_summary(Request $request){


        $seller_id=$request->id;

        if ($request->isMethod('get')) {

        $request['user_id']=$request->id;

        $review_data= $this->SellerAuthService->seller_review($request);
        if($review_data['status']=='success'){
            $review=$review_data['data'];
            return view('dealer.summary_page',compact('review'))->with('success', 'Store Review Confirm Successfully');
            }

        }

        return redirect()->route('seller.review_submit_page',$seller_id)->with('success', 'Store Review Confirm Successfully');


    }

    public function signup_review(Request $request){


        $request['user_id']=$request->id;
        $request = (object) $request;

        $data= $this->SellerAuthService->seller_store_submit_request($request);
        return view('dealer.signup-review')->with('success', 'Wait for Admin To Verify Your Details');;
    }

    public function logout(Request $request)
    {
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
            'email_mobile'=>"required"
        ]);

       if($validate->fails()){
        return redirect()->back()
        ->withErrors(['error'=>'Mobile Number Is required'])
        ->withInput();
     }
       }

    // when i use forgot password with Email
        if($request->type=='1'){
        $validate = Validator::make($request->all(), [
            'email_mobile'=>"required",
        ]);

        if($validate->fails()){

            return redirect()->back()
            ->withErrors(['error'=>'Email Address Is required'])
        ->withInput();
        }
        }

    $loginField = filter_var($request->email_mobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

    if ($loginField === 'mobile') {
        $credentials = [
            'type'=>'0',
            'country_code' => $request->country_code,
            'mobile'       => $request->email_mobile,
        ];

        $seller = seller::where('mobile', $request->email_mobile)
                    ->where('country_code', $request->country_code)
                    ->where('otp_verify','1')
                    ->first();
    } else {
        $credentials = [
            'type'=>'1',
            'email'    => $request->email_mobile,
        ];
        
        $seller = seller::where('email', $request->email_mobile)->where('otp_verify','1')->first();
    }


    if(!$seller){                   
    return redirect()->back()
    ->withErrors(['error'=>'No Seller Account Found'])
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

    return redirect()->route('seller.register_otp_verify',$seller_id);
    
    }



    public function reset_password(Request $request){
        if ($request->isMethod('get')) {
        return view('dealer.reset_password');
        }

       $validate = Validator::make($request->all(), [
        'password' => 'required',
        'confirm_password'=>"required|same:password"
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
    

    return redirect()->route('seller.login');

    }

   


    public function seller_dashboard(Request $request){
        return view('dealer.index');
    }


    public function removeImage(Request $request){
            
        sellerDocument::where('id',$request->id)->delete();
        return ApiResponse::generateResponse('success', 'Image Remove Successfully',(object)[],200);
    
    }
    



}