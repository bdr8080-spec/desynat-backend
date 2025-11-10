<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserProfileService;
use App\Models\country;
use App\Models\UserContactChangeHistory;
use App\Helpers\ApiResponse;
use Validator;

class ProfileController extends Controller
{
    //

    public function __construct(UserProfileService $UserProfileService){

        $this->UserProfileService=$UserProfileService;

    }

    public function userProfile(Request $request){

        $user = $request->user();
        return view('user.profile.index', compact('user'));
    }

    public function changePassword(Request $request){
        if($request->isMethod('get')){
                    return view('user.profile.changePassword');
        }else{
            
               $rules = [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password', 
        ];

        $messages = [
            'old_password.required'     => 'Please enter your old password.',
            'new_password.required'     => 'Please enter your new password.',
            'new_password.min'          => 'New password must be at least 8 characters long.',
            'new_password.regex'        => 'New password must include at least one uppercase letter, one lowercase letter, one number, and one special symbol.',
            'confirm_password.required' => 'Please confirm your new password.',
            'confirm_password.same'     => 'New password and confirm password do not match.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
               return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
               ]);
        }

        $request_data = (object )[
            'id'=>$request->user()->id,
            'old_password'=>$request->old_password,
            'new_password'=>$request->new_password,
        ];

        $data = $this->UserProfileService->ChangePassword($request_data);
        
        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);

        }

        return response()->json([
            'status'=>true,
            'message'=>$data['message']
        ]);
     
        }
    }


    public function oldNumberSendOtp(Request $request)
{
    $for = $request->input('for');
    $type = $request->input('type');

    if ($for === 'mobile') {
        $rules = [
            'country_code' => 'required|string|max:10',
            'mobile'       => 'required|string|max:20',
            'type'         => 'required|in:0,1',
        ];

        $messages = [
            'country_code.required' => 'Please enter your country code.',
            'mobile.required'       => 'Please enter your mobile number.',
            'type.required'         => 'Please specify whether it is old or new number.',
        ];
    } elseif ($for === 'email') {
        $rules = [
            'email' => 'required|email',
            'type'  => 'required|in:0,1',
        ];

        $messages = [
            'email.required' => 'Please enter your email address.',
            'email.email'    => 'Please enter a valid email address.',
        ];
    } else {
        return redirect()->back()->with('error', 'Invalid "for" value. Use either "mobile" or "email".');
    }

    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }


    $user = $request->user();
    $otp =   config('services.otp');

    UserContactChangeHistory::where('user_id', $user->id)->update(['status' => '1']); 


    if ($for === 'mobile') {
  
        if ($type == '0') { 
            if (
                $user->country_code === $request->country_code &&
                $user->mobile === $request->mobile
            ) {
               $data = UserContactChangeHistory::create([
                    'user_id'      => $user->id,
                    'country_code' => $request->country_code,
                    'mobile'       => $request->mobile,
                    'otp'          => $otp,
                    'type'         => '0',
                    'status'       => '0',
                ]);
                
                return redirect()->route('userOldNumberVerify',['country_code'=>$user->country_code, 'mobile'=>$user->mobile,'id'=> encrypt($data->id),])->with('success', 'OTP sent successfully to your old mobile number.');
            }

            return redirect()->back()->with('error', "Old mobile number doesn't match our records.");
        }

        if ($type == '1') {
         $data =   UserContactChangeHistory::create([
                'user_id'      => $user->id,
                'country_code' => $request->country_code,
                'mobile'       => $request->mobile,
                'otp'          => $otp,
                'type'         => '1',
                'status'       => '0',
            ]);

            return redirect()->route('userOldNumberVerify',['country_code'=>$data->country_code, 'mobile'=>$data->mobile,'id'=> encrypt($data->id),])->with('success', 'OTP sent successfully to your new mobile number.');
        }
    }


    if ($for === 'email') {
        if ($type == '0' && $user->email !== $request->email) {
            return redirect()->back()->with('error', "Old email doesn't match our records.");
        }

       $data = UserContactChangeHistory::create([
            'user_id' => $user->id,
            'email'   => $request->email,
            'otp'     => $otp,
            'type'    => $type,
            'status'  => '0',
        ]);

        return redirect()->route('userOldNumberVerify',['email'=>$data->email, 'id'=> encrypt($data->id),])->with('success', 'OTP sent successfully to your email');
    }

    return redirect()->back()->with('error', 'Something went wrong. Please try again.');
}



    public function oldNumberVerify(Request $request){
          if($request->isMethod('get')){
                    return view('user.profile.profileChangeNumberOtp');
        }else{
         
        $validator = Validator::make($request->all(), [
                'id'  => 'required',
                'otp' => 'required|array',
                'otp.*' => 'required|digits:1', // each digit should be a single number
            ], [
                'id.required' => 'Verification ID is missing.',
                'otp.required' => 'Please enter OTP.',
                'otp.*.required' => 'Please enter all digits of your OTP',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error'  => $validator->errors()->first(),
                ]);
            }

  
        try {
            $id = decrypt($request->id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid or expired verification link.');
        }

        $request->merge(['id' => $id]);
         $request->merge([
                'otp' => implode('', $request->otp)
            ]);



        $data = $this->UserProfileService->verifyOtp($request);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);

        }

      
        return response()->json([
            'status'=>true,
            'message'=>$data['message'],
            'type'=>$data['data']['type'],
        ]);

        }
    }


    public function updateNewNumber(Request $request){
               if($request->isMethod('get')){
                  $country =   country::all();
                    return view('user.profile.profileChangeNumber', compact('country'));
        }
    }


    public function updateEmailAddress(){
                    return view('user.profile.profileChangeNumber');  
    }
}