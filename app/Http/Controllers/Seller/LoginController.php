<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\country;
use App\Models\seller;



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

        return view('dealer.store_page',compact('country'));
        
        }

        $validate = Validator::make($request->all(), [
            'store_image' => 'required',
            'store_name' => 'required',
            'country'=>"required",
            "store_address"=>"required",
            'address_line1'=>'required',
            'address_line2'=>'required',
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
        return view('dealer.bank-details');
        }


        


    }


    public function upload_summary(Request $request){
        return view('dealer.summary_page');
    }

    public function signup_review(Request $request){
        return view('dealer.signup-review');
    }


    public function reset_password(Request $request){
        return view('dealer.reset_password');
    }

    
    public function forgot_password(Request $request){
        return view('dealer.forgot');
    }

}
