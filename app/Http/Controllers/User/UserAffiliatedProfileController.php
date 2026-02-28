<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Validator;

use App\Helpers\ApiResponse;

use App\Models\country;

use App\Services\UserAffilatedAuthService;

class UserAffiliatedProfileController extends Controller
{

    public function __construct(UserAffilatedAuthService $UserAffilatedAuthService)
    {
        $this->UserAffilatedAuthService = $UserAffilatedAuthService;
    }


    public function affiliateProfile(Request $request){

    $affilatedUser=Auth::guard('affilated_user')->user();           

    $request_data = (object) [
        'user_id' => $affilatedUser->id,
    ];

    $data = $this->UserAffilatedAuthService->getProfile($request_data);

    $affilatedUser=$data['data'];

    $country =   country::all();

    return view('affiliatedUser.profiles.profile',compact('affilatedUser','country'));
    
    
    }



public function affiliateChangePassword(Request $request){

    if($request->ismethod('get')){
        return view('affiliatedUser.profiles.change-pwd');
    }


$affilatedUser=Auth::guard('affilated_user')->user();     


   $validate = Validator::make($request->all(), [
        'old_password' => 'required',
        'password'         => 'required',
        'confirm_password' => 'required|same:password',
    ]);

    if ($validate->fails()) {
        return ApiResponse::generateResponse(
            'error',
            $validate->errors()->first(),
            (object) $validate->errors(),
            422
        );
    }

    $affilated_user = $affilatedUser->id;
    
    $request_data = (object) [
        'user_id' => $affilated_user,
        'password' => $request->password,
        "old_password"=>$request->old_password

    ];

    $data = $this->UserAffilatedAuthService->updatePassword($request_data);

    if (isset($data['status']) && $data['status'] === 'error') {
        return ApiResponse::generateResponse(
            'error',
            $data['message'],
            (object) [],
            400
        );
    }

    return ApiResponse::generateResponse(
        'success',
        $data['message'],
        $data['data'],
        200
    );
    
    }



}