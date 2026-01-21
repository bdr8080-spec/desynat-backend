<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use Validator;

use Illuminate\Validation\Rule;

use App\Services\UserAffilatedAuthService;


class UserAffilatedControlller extends Controller
{

    public function __construct(UserAffilatedAuthService $UserAffilatedAuthService)
    {
        $this->UserAffilatedAuthService = $UserAffilatedAuthService;
    }


    public function CreateAffilatedAccount(Request $request){

        $user = $request->user()->id;

        $validate = Validator::make($request->all(), [
                'profile_image' => 'required',
                'full_name' => 'required',
                'country_code' => 'required',
                "mobile" =>"required",
                 'email' => [
                    'required',
                    'email',
                ],
                "password"=>"required",
                "confirm_password"=>"required|same:password",
                "document1"=>"required",
                "document2"=>"required",
                "accept" =>"required|In:1"
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

    

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


    public function AffilatedVerifyotp(Request $request){
    
        $validate = Validator::make($request->all(), [
                'id' => 'required|exists:affilated_users,id',
                'otp' => 'required',
                "type"=>"required|in:1"
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $user = $request->user()->id;


     $request_data=(object) [
    'user_id'=>$user,
    "affilated_id"=>$request->id,
    'otp'=>$request->otp,
    "type"=>$request->type
    ];

  $data=$this->UserAffilatedAuthService->AffilatedVerifyotp($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function affilatedAddAddress(Request $request){
    
        $validate = Validator::make($request->all(), [
                'country' => 'required',
                'locations' => 'required',
                'address1' => 'required',
                "address2" =>"required",
                "pincode" =>"required",
                "town"=>"required",
                "state"=>"required",
                "city"=>"required",
                "let"=>"required",
                "long" =>"required"
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $affilated_user = $request->user()->id;

     $request_data=(object) [
    'affilated_user'=>$affilated_user,
    "country"=>$request->country,
    'locations'=>$request->locations,
    'address1'=>$request->address1,
    'address2'=>$request->address2,
    'pincode'=>$request->pincode,
    'town'=>$request->town,
    'state'=>$request->state,
    'city'=>$request->city,
    'let'=>$request->let??null,
    'long'=>$request->long??null
    ];

  $data=$this->UserAffilatedAuthService->affilatedAddAddress($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }

public function affilatedAddBankDetails(Request $request){
    
        $validate = Validator::make($request->all(), [
                'bank_name' => 'required',
                'account_holder_name' => 'required',
                'account_no' => 'required',
                "confirm_account_no" =>"required|same:account_no",
                "iban" =>"required",
                "swift"=>"required",
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $affilated_user = $request->user()->id;

     $request_data=(object) [
    'affilated_user'=>$affilated_user,
    "bank_name"=>$request->bank_name,
    'account_holder_name'=>$request->account_holder_name,
    'account_no'=>$request->account_no,
    'iban'=>$request->iban,
    'swift'=>$request->swift,
    ];

  $data=$this->UserAffilatedAuthService->affilatedAddAddBankDetails($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }

}