<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

use Validator;

class AuthController extends Controller
{
    public function create_account(Request $request){

        $validate = Validator::make($request->all(), [
            'full_name' => 'required',
            'country_code' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);


        if($validate->fails()){
            return ApiResponse::generateResponse('error', 'Validation error',$validate->errors()->first(),422);
           }
    


    }
}
