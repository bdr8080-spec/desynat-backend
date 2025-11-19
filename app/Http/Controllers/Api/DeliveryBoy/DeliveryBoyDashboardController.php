<?php

namespace App\Http\Controllers\Api\DeliveryBoy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryBoy;
use App\Helpers\ApiResponse;


use Validator;


use App\Services\DeliveryBoyAuthService;


class DeliveryBoyDashboardController extends Controller
{

    public function __construct(DeliveryBoyAuthService $DeliveryBoyAuthService){

        $this->DeliveryBoyAuthService=$DeliveryBoyAuthService;

    }


    public function index(Request $request){

        $user_details=$request->user();


        $deliveryboy_details=DeliveryBoy::with('vehicle_image','identity_proof','driving_license','vehicle_insurance','pollution_paper','registration_certificate','zone_info','country_info')->where('id',$user_details->id)->first();
        
        return ApiResponse::generateResponse('success','Delivery Boy Dashboard fetch Successfully',$deliveryboy_details, 200);


    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::generateResponse('success','Logged out successfully',(object)[], 200);
    }

    public function delivery_boy_profile(Request $request){

        $user_details=$request->user();
        $deliveryboy_details=DeliveryBoy::with('vehicle_image','identity_proof','driving_license','vehicle_insurance','pollution_paper','registration_certificate','zone_info','country_info')->where('id',$user_details->id)->first();
        
        return ApiResponse::generateResponse('success','Delivery Boy Dashboard fetch Successfully',$deliveryboy_details, 200);


    }

}


    

    

    
