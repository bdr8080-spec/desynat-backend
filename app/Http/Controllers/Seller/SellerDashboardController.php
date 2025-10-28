<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;

class SellerDashboardController extends Controller
{
    public function index(Request $request){

        $user_details=$request->user();

        return ApiResponse::generateResponse('success','Seller Dashboard fetch Successfully',$user_details, 200);



    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::generateResponse('success','Logged out successfully',(object)[], 200);
    }



}
