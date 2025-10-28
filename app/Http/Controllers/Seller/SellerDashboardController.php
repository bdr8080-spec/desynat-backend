<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;

class SellerDashboardController extends Controller
{
    public function index(Request $request){

        $user_details=$request->user();

        return ApiResponse::generateResponse('success','Seller Details fetch Successfully',$user_details, 200);



    }
}
