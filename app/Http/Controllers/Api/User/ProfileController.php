<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\UserContactChangeHistory;
use Hash;
use App\Helpers\ApiResponse;



class ProfileController extends Controller
{
    //

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

        $user = User::find($request->user()->id);

        if (!$user) {
           return ApiResponse::generateResponse('error','User not found',(object)[],401);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return ApiResponse::generateResponse("error", "Old password doesn't match",(object)[],400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return ApiResponse::generateResponse("success", "Password changed successfully",(object)[], 201);
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
        'email'=> 'required'
    ];

    $messages = [
        'full_name.required'    => 'Please enter your full name.',
        'country_code.required' => 'Please select your country code.',
        'mobile.required'       => 'Please enter your mobile number.',
        'email.required' =>        'Please enter your email address',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return ApiResponse::generateResponse('error', $validator->errors()->first(), $validator->errors(), 422);
    }

     $user = User::find($request->user()->id);

    $user->profile_image = $request->image;
    $user->full_name = $request->full_name;
    $user->country_code = $request->country_code;
    $user->mobile = $request->mobile;
    $user->email = $request->email;
    $user->save();

      return ApiResponse::generateResponse('success', 'Profile updated successfully', $user, 200);
    }

     

 
    public function getCategories()
    {
        $category = Category::orderBy('name', 'asc')->get();

        if ($category->isEmpty()) {
            return ApiResponse::generateResponse('success', 'No categories found', (object)[], 200);
        }

        return ApiResponse::generateResponse('success', 'Category list fetched successfully', $category, 200);
    }

   
    public function getSubCategories(Request $request)
    {
        $rules = [
            'category_id' => 'required|integer|exists:categories,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
               return ApiResponse::generateResponse('error', $validator->errors()->first(), $validator->errors(), 422);
        }

        $subCategory = SubCategory::where('category_id', $request->category_id)->get();

        if ($subCategory->isEmpty()) {
            return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
        }

        return ApiResponse::generateResponse('success', 'Sub category list fetched successfully', $subCategory, 201);
    }


    // change mobile number

    public function changeMobileNumber(Request $request)
    {
        if ($request->for === 'mobile') {
            $rules = [
                'country_code' => 'required|string|max:10',
                'mobile'       => 'required|string|max:20',
                'type'         => 'required|in:0,1', // 0 = old, 1 = new
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
                        'status'       => '0',
                    ]);


                    return ApiResponse::generateResponse('success', 'OTP sent successfully to old number', $data, 201);
                }

                return ApiResponse::generateResponse('error', "Old mobile number doesn't match", (object)[], 400);
            }

            if ($request->type == '1') {
                $data = UserContactChangeHistory::create([
                    'user_id'      => $user->id,
                    'country_code' => $request->country_code,
                    'mobile'       => $request->mobile,
                    'otp'          => $otp,
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

        $user = $request->user();

        $userDetails = UserContactChangeHistory::find($request->id);

        if (!$userDetails) {
            return ApiResponse::generateResponse('error', 'No User Found', (object)[], 404);
        }


        if ($userDetails->otp === $request->otp) {
            $userDetails->otp = null;
            $userDetails->otp_verify = '1';
            $userDetails->status = '1';
            $userDetails->save();

            return ApiResponse::generateResponse('success', 'OTP verified successfully', $userDetails, 201);
        }

        return ApiResponse::generateResponse('error', 'Invalid OTP. Please try again.', (object)[], 400);
    }


   
    
}