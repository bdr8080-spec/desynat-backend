<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    //
    public function userRegister(Request $request){
        if($request->isMethod('get')){
                  return view('user.auth.register'); 
        }else{
    
            $rules = [
                    'full_name' => 'required',
                    'country_code' => 'required',
                    'email' => 'required|email|unique:sellers,email',
                    'mobile' => 'required',
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                    'accept_terms' => 'required|in:1',
                ];

                $messages = [
                    'full_name.required' => 'First name is required.',
                    'country_code.required' => 'Please select your country code.',
                    'email.required' => 'Email address is required.',
                    'email.email' => 'Please enter a valid email address.',
                    'email.unique' => 'This email address is already registered.',
                    'mobile.required' => 'Mobile number is required.',
                    'password.required' => 'Password is required.',
                    'confirm_password.required' => 'Please confirm your password.',
                    'confirm_password.same' => 'Confirm password must match the password.',
                    'accept_terms.required' => 'You must accept the terms and conditions.',
                    'accept_terms.in' => 'You must agree to the terms and conditions to continue.',
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

               if($validator->fails()){
                   return response()->json([
                    'status'=>false,
                    'errors'=>$validator->errors()
                   ]);
               }
    
        }

    }
}