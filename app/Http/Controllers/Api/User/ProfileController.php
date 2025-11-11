<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Hash;
use App\Models\User;
use App\Models\UserContactChangeHistory;
use App\Helpers\ApiResponse;
use App\Services\UserProfileService;
use App\Models\Category;
use App\Models\SubCategory;




class ProfileController extends Controller
{
    //

    public function __construct(UserProfileService $UserProfileService){

        $this->UserProfileService=$UserProfileService;

    }

    public function change_password(Request $request)
    {
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
               return ApiResponse::generateResponse('error',$validator->errors()->first(), $validator->errors(), 422);
        }

        $request_data = (object )[
            'id'=>$request->user()->id,
            'old_password'=>$request->old_password,
            'new_password'=>$request->new_password,
        ];

        $data = $this->UserProfileService->ChangePassword($request_data);
        

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
       
    }


    // view Profile


     public function viewProfile(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return ApiResponse::generateResponse('error', 'User not found', (object)[], 404);
        }

        return ApiResponse::generateResponse('success', 'User profile fetched successfully', $user, 200);
    }

    


     // update Profile  
    public function updateProfile(Request $request)
    {
        $rules = [
            'full_name'    => 'required',
            'country_code' => 'required',
            'mobile'       => 'required',
            'email'        => 'required|email',
        ];

        $messages = [
            'full_name.required'    => 'Please enter your full name.',
            'country_code.required' => 'Please select your country code.',
            'mobile.required'       => 'Please enter your mobile number.',
            'email.required'        => 'Please enter your email address.',
            'email.email'           => 'Please enter a valid email address.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return ApiResponse::generateResponse('error', $validator->errors()->first(), $validator->errors(), 422);
        }

        $user = $request->user();

        $emailVerified = false;
        $mobileVerified = false;

      
        if ($user->email == $request->email) {
            $emailVerified = true;
        } else {
            $emailChange = UserContactChangeHistory::where([
                ['email', $request->email], 
                ['type', '1'], 
            ])->latest()->first();

            if ($emailChange && $emailChange->otp_verify == '1') {
                $emailVerified = true;
            } else {
                return ApiResponse::generateResponse('error', 'Email is not verified.', '', 422);
            }
        }

       
        if ($user->country_code == $request->country_code && $user->mobile == $request->mobile) {
            $mobileVerified = true;
        } else {
            $mobileChange = UserContactChangeHistory::where([
                ['country_code', $request->country_code],
                ['mobile', $request->mobile],
                ['type', '0'], 
            ])->latest()->first();

            if ($mobileChange && $mobileChange->otp_verify == '1') {
                $mobileVerified = true;
            } else {
                return ApiResponse::generateResponse('error', 'Mobile number is not verified.', '', 422);
            }
        }

      
        if ($emailVerified && $mobileVerified) {
            $user->profile_image = $request->image ?? $user->profile_image;
            $user->full_name     = $request->full_name;
            $user->country_code  = $request->country_code;
            $user->mobile        = $request->mobile;
            $user->email         = $request->email;
            $user->save();

      
            if (isset($emailChange)) {
                $emailChange->update(['status' => '1']);
            }
            if (isset($mobileChange)) {
                $mobileChange->update(['status' => '1']);
            }

            return ApiResponse::generateResponse('success', 'Profile updated successfully', $user, 200);
        }

        return ApiResponse::generateResponse('error', 'Verification required for mobile or email.', '', 422);
    }


     
 

 

    // change mobile number

    public function changeMobileNumber(Request $request)
    {
        if ($request->for === 'mobile') {
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
        } elseif ($request->for === 'email') {
            $rules = [
                'email' => 'required|email',
                'type'  => 'required|in:0,1',
            ];

            $messages = [
                'email.required' => 'Please enter your email address.',
                'email.email'    => 'Please enter a valid email address.',
            ];
        } else {
            return ApiResponse::generateResponse('error', 'Invalid "for" value. Use either "mobile" or "email".', [], 400);
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return ApiResponse::generateResponse('error', $validator->errors()->first(), $validator->errors(), 422);
        }

    
        $user = $request->user();
        $otp = config('services.otp');

   
        UserContactChangeHistory::where('user_id', $user->id)
            ->update(['status' => '1']); 

        if ($request->for === 'mobile') {

            if ($request->type == '0') { 
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


                    return ApiResponse::generateResponse('success', 'OTP sent successfully to old number', $data, 201);
                }

                return ApiResponse::generateResponse('error', "Old mobile number does not match", (object)[], 400);
            }

            if ($request->type == '1') {
                $data = UserContactChangeHistory::create([
                    'user_id'      => $user->id,
                    'country_code' => $request->country_code,
                    'mobile'       => $request->mobile,
                    'otp'          => $otp,
                    'type'         => '0',
                    'status'       => '0',
                ]);


                return ApiResponse::generateResponse('success', 'OTP sent successfully to new number', $data, 201);
            }
        }

        if ($request->for === 'email') {
            if ($request->type == '0' && $user->email !== $request->email) {
                return ApiResponse::generateResponse('error', "Old email doesn't match", [], 400);
            }

            $data = UserContactChangeHistory::create([
                'user_id' => $user->id,
                'email'   => $request->email,
                'otp'     => $otp,
                'type'    => '1',
                'status'  => '0',
            ]);


            return ApiResponse::generateResponse('success', 'OTP sent successfully to email', $data, 201);
        }
    }





    // verify otp
    
        public function verifyOtp(Request $request)
    {
        $rules = [
            'otp' => 'required',
        ];

        $messages = [
            'otp.required' => 'Please enter your OTP number.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return ApiResponse::generateResponse('error', $validator->errors()->first(), $validator->errors(), 422);
        }

         $data = $this->UserProfileService->verifyOtp($request);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }



    // fetch category
    public function getCategories(Request $request)
    {
        $category = Category::orderBy('name', 'asc')->get();

        if ($category->isEmpty()) {
            return ApiResponse::generateResponse('success', 'No categories found', (object)[], 200);
        }

        $data = $this->UserProfileService->getCategories($request);

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    }

    // fetch sub category
    public function getSubCategories(Request $request)
    {
        $rules = [
            'category_id' => 'required|integer|exists:categories,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
               return ApiResponse::generateResponse('error', $validator->errors()->first(), $validator->errors(), 422);
        }


         $data = $this->UserProfileService->getSubCategories($request);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

        }

       return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
     
    }

   
    
}