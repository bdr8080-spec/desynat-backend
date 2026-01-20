<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use Validator;


use App\Services\UserAffilatedAuthService;


class UserAffilatedControlller extends Controller
{

    public function __construct(UserAffilatedAuthService $UserAffilatedAuthService)
    {
        $this->UserAffilatedAuthService = $UserAffilatedAuthService;
    }


    public function CreateAffilatedAccount(Request $request){
    
        $validate = Validator::make($request->all(), [
                'profile_image' => 'required',
                'full_name' => 'required',
                'country_code' => 'required',
                "mobile" =>"required|email",
                "email" =>"required",
                "password"=>"required",
                "confirm_password"=>"required|same:password",
                "document1"=>"required",
                "document2"=>"required",
                "accept" =>"required|In:1"
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $user = $request->user()->id;


     $request_data=(object) [
    'user_id'=>$user,
    "profile_image"=>$request->profile_image,
    'full_name'=>$request->full_name??null,
    'country_code'=>$request->country_code??null,
    'mobile'=>$request->mobile??null,
    'email'=>$request->email??null,
    'password'=>$request->password??null,
    'document1'=>$request->document1??null,
    'document2'=>$request->document2??null,

    'let'=>$request->let??null,
    'long'=>$request->long??null,
    "device_type"=>$request->device_type??null
    ];

  $data=$this->UserAffilatedAuthService->RegisterAffilatedUser($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    



    }
}