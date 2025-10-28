<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;

class UserDashboardController extends Controller
{
    
    public function index(Request $request){

        $user_details=$request->user();

        return ApiResponse::generateResponse('success','User Details fetch Successfully',$user_details, 200);

    }


}
