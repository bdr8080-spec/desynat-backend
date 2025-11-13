<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserProfileService;
use App\Models\country;
use App\Models\User;
use App\Models\UserCurrentLocation;
use App\Models\all_countrie;
use App\Models\UserContactChangeHistory;
use App\Helpers\ApiResponse;
use Validator;
use Illuminate\Validation\Rule;


class ProfileController extends Controller
{
    //

    public function __construct(UserProfileService $UserProfileService){

        $this->UserProfileService=$UserProfileService;

    }

    public function userProfile(Request $request){
         $user = User::with('country_info')->where('id',$request->user()->id)->first();
        
             if($request->isMethod('get')){
                    return view('user.profile.index', compact('user'));
             }else{

                   
               $rules = [
                    'full_name' => 'required',
                ];

                $messages = [
                    'full_name.required'     => 'Please enter full name.',
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    return response()->json([
                        'status'=>false,
                        'error'=>$validator->errors()->first()
                    ]);
                }

               if($request->image){
                 $dir = 'profile_image/';
                 $image_path = $this->image_upload($request->image, $dir);
                 
                }

                $data = User::where('id', $user->id)->update([
                    'full_name'     => $request->full_name,
                    'profile_image' => $image_path ?? $request->old_image,
                ]);

                    return response()->json([
                        'status'=>true,
                        'message'=>"Profile Update Successfully"
                    ]);


             }
    
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
                'mobile'       => ['required', 'regex:/^[0-9]{7,15}$/', 'string', 'max:20'],
                'type'         => 'required|in:0,1',
            ];

            $messages = [
                'country_code.required' => 'Please enter your country code',
                'mobile.required'       => 'Please enter your mobile number',
                'mobile.regex'          => 'Mobile number must contain 7 to 15 digits',
                'type.required'         => 'Please specify whether it is old or new number',
                'type.in'               => 'Type must be 0 (old number) or 1 (new number)',
            ];

        
            if ($request->type == '0') {
                $rules['mobile'][] = Rule::exists('users', 'mobile')
                    ->where('country_code', $request->country_code);
            } else {
                $rules['mobile'][] = Rule::unique('users', 'mobile')
                    ->where('country_code', $request->country_code);
            }

        } elseif ($for === 'email') {

            $rules = [
                'email' => ['required', 'email'],
                'type'  => 'required|in:0,1',
            ];

            $messages = [
                'email.required' => 'Please enter your email address',
                'email.email'    => 'Please enter a valid email address',
                'type.required'  => 'Please specify whether it is old or new email',
                'type.in'        => 'Type must be 0 (old email) or 1 (new email)',
            ];

            if ($request->type == '0') {
                $rules['email'][] = Rule::exists('users', 'email');
            } else {
                $rules['email'][] = Rule::unique('users', 'email');
            }

        } else {
            return redirect()->back()->with('error', 'Invalid "for" value. Use either "mobile" or "email"');
        }


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return redirect()->back()->with('error', $firstError)->withInput();
        }  



    $user = $request->user();
    $otp = config('services.otp');

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

                return redirect()->route('userOldNumberVerify', [
                    'country_code' => $user->country_code,
                    'mobile'       => $user->mobile,
                    'id'           => encrypt($data->id),
                    'type'         => '0',
                    'for'          => 'mobile',
                ])->with('success', 'OTP sent successfully to your old mobile number.');
            }

            return redirect()->back()->with('error', "Old mobile number doesn't match our records.");
        }

        if ($type == '1') {
            $data = UserContactChangeHistory::create([
                'user_id'      => $user->id,
                'country_code' => $request->country_code,
                'mobile'       => $request->mobile,
                'otp'          => $otp,
                'type'         => '1',
                'status'       => '0',
            ]);

            return redirect()->route('userOldNumberVerify', [
                'country_code' => $data->country_code,
                'mobile'       => $data->mobile,
                'id'           => encrypt($data->id),
                'type'         => '1',
                'for'          => 'mobile',
            ])->with('success', 'OTP sent successfully to your new mobile number.');
        }
    }

    if ($for === 'email') {
        if ($type == '0') {
            if ($user->email !== $request->email) {
                return redirect()->back()->with('error', "Old email doesn't match our records.");
            }

            $data = UserContactChangeHistory::create([
                'user_id' => $user->id,
                'email'   => $request->email,
                'otp'     => $otp,
                'type'    => '1',
                'status'  => '0',
            ]);

            return redirect()->route('userOldNumberVerify', [
                'email' => $data->email,
                'id'    => encrypt($data->id),
                'type'  => '0',
                'for'   => 'email',
            ])->with('success', 'OTP sent successfully to your old email.');
        }

        if ($type == '1') {
            $data = UserContactChangeHistory::create([
                'user_id' => $user->id,
                'email'   => $request->email,
                'otp'     => $otp,
                'type'    => '1',
                'status'  => '0',
            ]);

            return redirect()->route('userOldNumberVerify', [
                'email' => $data->email,
                'id'    => encrypt($data->id),
                'type'  => '1',
                'for'   => 'email',
            ])->with('success', 'OTP sent successfully to your new email.');
        }
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
                'otp.*' => 'required|digits:1',
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
        ]);

        }
    }


    
    
    public function updateNewNumber(Request $request){
               if($request->isMethod('get')){
                  $country =   all_countrie::all();
                    return view('user.profile.profileChangeNumber', compact('country'));
        }
    }


    public function updateEmailAddress(){
                    return view('user.profile.profileChangeEmailOtp');  
    }


 public function updateResendOtp(Request $request)
{
    try {
        // Ensure the ID is present
        if (!$request->has('id')) {
            return response()->json([
                'status' => false,
                'message' => 'ID is required.',
            ], 400);
        }

        $id = decrypt($request->id);

        
        $data = UserContactChangeHistory::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 404);
        }

        $otp = config('services.otp');
        $data->otp = $otp;
        $data->save();


        return response()->json([
            'status' => true,
            'message' => 'OTP resent successfully.',
            'otp' => $otp,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong: ' . $e->getMessage(),
        ], 500);
    }
}

// save currenct location

 public function saveCurrentLocation(Request $request)
{

    if ($request->user() && $request->user()->id) {
        $data = UserCurrentLocation::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
                'address'   => $request->address,
            ]
        );

        return response()->json([
            'status'  => true,
            'message' => 'Address changed successfully!',
            'data'    => $data,
        ]);
    }

        return response()->json([
            'status'  => false,  
            'message' => '',
        ]);

}


}