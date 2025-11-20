<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\DeliveryBoyManagementService;
use App\Models\DeliveryBoy;



use Validator;

class DeliveryBoyController extends Controller
{

    public function __construct(DeliveryBoyManagementService $DeliveryBoyManagementService){

        $this->DeliveryBoyManagementService=$DeliveryBoyManagementService;

    }


    public function getDeliveryBoys(Request $req)
    {
        try {
            $data = $this->DeliveryBoyManagementService->getDeliveryBoys($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_deliveryboy_details(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:delivery_boys,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->DeliveryBoyManagementService->getDeliveryBoyDetailsById($request->user_id);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function block_unblock_deliveryboy(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:delivery_boys,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->DeliveryBoyManagementService->blockUnblockDeliveryBoy($request->user_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function delete_deliveryboy(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:delivery_boys,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->DeliveryBoyManagementService->deleteDeliveryBoy($request->user_id);

            if ($result['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Delivery Boy deleted successfully',
                    'data' => null
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => $result['message'] ?? 'Failed to delete delivery boy',
                'data' => (object)[]
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'data' => (object)[]
            ], 500);
        }
    }

    public function add_deliveryboy(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'profile_pic' => 'required|url',

            'full_name_english' => 'required|string|max:255',
            'full_name_arabic' => 'required|string|max:255',
            'email' => 'required|email|unique:delivery_boys,email',
            'country_code' => 'required|string|max:5',
            'mobile' => 'required|string|max:15|unique:delivery_boys,mobile',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:password',

            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'let' => 'required|numeric',
            'long' => 'required|numeric',
            'zone_id' => 'required|exists:zones,id',
            'vehicle_name' => 'required|string|max:255',
            'vehicle_reg_no' => 'required|string|max:255',

            'vehicle_image_front' => 'required|url',
            'vehicle_image_back' => 'required|url',

            'identity_proof_front' => 'required|url',
            'identity_proof_back' => 'required|url',

            'driving_license_front' => 'required|url',
            'driving_license_back' => 'required|url',

            'vehicle_insurance' => 'required|url',
            // 'pollution_paper' => 'required|url',

            // 'registration_certificate_front' => 'required|url',
            // 'registration_certificate_back' => 'required|url',
        ]);


        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->DeliveryBoyManagementService->addDeliveryBoy($request);

            if ($data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', 'Delivery boy added successfully', $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function update_deliveryBoy(Request $request)
    {
        $validate = Validator::make($request->all(), [

            'delivery_boy_id' => 'required|exists:delivery_boys,id',
            'profile_pic' => 'required|url',

            'full_name_english' => 'required|string|max:255',
            'full_name_arabic' => 'required|string|max:255',
            'email' => 'required|email|unique:delivery_boys,email,' . $request->delivery_boy_id,
            'country_code' => 'required|string|max:5',
            'mobile' => 'required|string|max:15|unique:delivery_boys,mobile,' . $request->delivery_boy_id,
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:password',

            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'let' => 'required|numeric',
            'long' => 'required|numeric',
            'zone_id' => 'required|exists:zones,id',
            'vehicle_name' => 'required|string|max:255',
            'vehicle_reg_no' => 'required|string|max:255',

            'vehicle_image_front' => 'required|url',
            'vehicle_image_back' => 'required|url',

            'identity_proof_front' => 'required|url',
            'identity_proof_back' => 'required|url',

            'driving_license_front' => 'required|url',
            'driving_license_back' => 'required|url',

            'vehicle_insurance' => 'required|url',
            // 'pollution_paper' => 'required|url',

            // 'registration_certificate_front' => 'required|url',
            // 'registration_certificate_back' => 'required|url',
        ]);


        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->DeliveryBoyManagementService->updateDeliveryBoy($request);

            if ($data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', 'Delivery boy updated successfully', $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_kuwait_zones(Request $request)
    {
        try {
            $data = $this->DeliveryBoyManagementService->getKuwaitZones();

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }














    

    


      






}
