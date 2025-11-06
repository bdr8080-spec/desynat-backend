<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Hash;
use App\Helpers\ApiResponse;



class ProfileController extends Controller
{
    //

    public function change_password(Request $request)
    {
        $rules = [
            'id' => 'required',
            'old_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
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
               return ApiResponse::generateResponse('error', 'Validation Error', $validator->errors(), 422);
        }

        $user = User::find($request->id);

        if (!$user) {
           return ApiResponse::generateResponse('error','User not found','',401);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return ApiResponse::generateResponse("error", "Old password doesn't match","",400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return ApiResponse::generateResponse("success", "Password changed successfully","", 201);
    }


    public function updateProfile(Request $request){
            $rules = [
            'id' => 'required',
            'first_name' => 'required',
            'country_code' => 'required',
            'mobile' => 'required',
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
               return ApiResponse::generateResponse('error', 'Validation Error', $validator->errors(), 422);
        }

        $user = User::find($request->id);

        if (!$user) {
           return ApiResponse::generateResponse('error','User not found','',401);
        }

        
    }

    
}