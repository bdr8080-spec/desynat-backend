<?php

namespace App\Http\Controllers\Api\DeliveryBoy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryBoy;
use App\Helpers\ApiResponse;


use Validator;


use App\Services\DeliveryBoyManagementService;


class DeliveryBoyProfileController extends Controller
{

    public function __construct(DeliveryBoyManagementService $DeliveryBoyManagementService){

        $this->DeliveryBoyManagementService=$DeliveryBoyManagementService;

    }


    public function get_profile_details(Request $request)
    {
        $user_details=$request->user();

        try {
            $data = $this->DeliveryBoyManagementService->getDeliveryBoyDetailsById($user_details->id);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function update_profile(Request $request)
    {
        $validate = Validator::make($request->all(), [

            'delivery_boy_id' => 'required|exists:delivery_boys,id',
            'profile_pic' => 'required|url',

            'full_name_english' => 'required|string|max:255',
            'full_name_arabic' => 'required|string|max:255',
            'email' => 'required|email|unique:delivery_boys,email,' . $request->delivery_boy_id,
            'country_code' => 'required|string|max:5',
            'mobile' => 'required|string|max:15|unique:delivery_boys,mobile,' . $request->delivery_boy_id,
            // 'password' => 'required|string|min:6',
            // 'confirm_password' => 'required|string|same:password',

            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'let' => 'required|numeric',
            'long' => 'required|numeric',
            'zone_id' => 'required|exists:zones,id',
            // 'vehicle_name' => 'required|string|max:255',
            // 'vehicle_reg_no' => 'required|string|max:255',
        ]);


        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->DeliveryBoyManagementService->updateDeliveryBoyProfileExceptDocument($request);

            if ($data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function duty_on_off(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'delivery_boy_id' => 'required|exists:delivery_boys,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->DeliveryBoyManagementService->dutyOnOff($request->delivery_boy_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

}


    

    

    
