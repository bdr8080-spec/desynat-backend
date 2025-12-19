<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;

use Validator;

class UserDashboardController extends Controller
{
    
    public function index(Request $request){

        $user_details=$request->user();

        return ApiResponse::generateResponse('success','User Dashbaord fetch Successfully',$user_details, 200);

    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::generateResponse('success','Logged out successfully',(object)[], 200);

    }


public function home_page_search(Request $request){

    $validate = Validator::make($request->all(), [
        'search' => 'required',
        ]);

    if($validate->fails()){
      return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }








    }

    



}