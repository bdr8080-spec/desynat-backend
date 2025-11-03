<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\country;
use App\Models\seller;

use App\Models\sellerStoreInformation;
use App\Models\sellerDocument;
use App\Models\Bankdetails;


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

        if (Auth::guard('seller')->attempt(['email' => $request->email_mobile, 'password' => $request->password])) {
          
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






        dd($request->all());

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
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'accept_terms'=>"required|in:1"
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

        return redirect()->route('seller.register_otp_verify',$seller_id);

    }


    public function register_otp_verify(Request $request){

        $seller_details=seller::where('id',$request->id)->first();
       

        if ($request->isMethod('get')) {
        return view('dealer.signup_otp',compact('seller_details'));
        }

        $validate = Validator::make($request->all(), [
            'otp' => 'required|array',
            'otp.*' => 'required|digits:1' // each element (digit) is required and must be a single digit
        ], [
            'otp.required' => 'Please enter your OTP.',
            'otp.array' => 'OTP must be in a valid format.',
            'otp.*.required' => 'All OTP digits are required.'
        ]);
    
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    

       $enteredOtp = implode('', $request->otp);

       if($seller_details->otp==$enteredOtp){

        Auth::guard('seller')->login($seller_details); // login with seller details


        return redirect()->route('seller.store_information',$seller_details->id);

       }else{

        return redirect()->back()
        ->withErrors(['otp'=>'Otp Is Wrong'])
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
            'address_line1'=>'required',
            'address_line2'=>'required',
            'country'=>'required',
            "store_phone"=>"required",
            'store_mail_id'=>'required',
            'bio'=>'required',
            // 'let'=>'required|nullable',
            // 'long'=>'required|nullable'
            
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
        
        return redirect()->route('seller.upload_document',$seller_id);

    }

    public function upload_document(Request $request){

        if ($request->isMethod('get')) {

           $seller_data=Auth::guard('seller')->user()->id;

           $seller_document=sellerDocument::where('seller_id',$seller_data)->where('status','1')->get();
           $seller_bank=Bankdetails::where('user_id',$seller_data)->first();
        return view('dealer.bank-details',compact('seller_document','seller_bank'));
       
    }

    $validate = Validator::make($request->all(), [
        // 'user_id' => 'required|exists:sellers,id',
        'owner_document' => 'required|array',
        'store_document' => 'required|array',
        'account_type'=>"required|in:0,1", // 0 Personal 1 Busness
        "iban"=>"required",
        'swift'=>'required',
        'bank_name'=>'required',
        "account_holder_name"=>"required",
        'upload_proof'=>'required'
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

        foreach($request->owner_document as $key=>$val){
        $owner_document1[$key]=image_upload($val,$dir);
        }

        foreach($request->store_document as $key=>$val){
            $store_document1[$key]=image_upload($val,$dir);
        }

        $upload_proof1=image_upload($request->upload_proof,$dir);

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

        return redirect()->route('seller.upload_review',$seller_id);

    }


    public function upload_summary(Request $request){


        $seller_id=$request->id;

        if ($request->isMethod('get')) {

        $request['user_id']=$request->id;

        $review_data= $this->SellerAuthService->seller_review($request);
        if($review_data['status']=='success'){
            $review=$review_data['data'];
            return view('dealer.summary_page',compact('review'));
            }

        }

        return redirect()->route('seller.review_submit_page',$seller_id);


    }

    public function signup_review(Request $request){


        $request['user_id']=$request->id;
        $request = (object) $request;

        $data= $this->SellerAuthService->seller_store_submit_request($request);
        return view('dealer.signup-review');


    }


    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login');
    }



    public function reset_password(Request $request){
        return view('dealer.reset_password');
    }

    
    public function forgot_password(Request $request){
        return view('dealer.forgot');
    }


    public function seller_dashboard(Request $request){
        return view('dealer.index');
    }

    



}
