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













    

    


      






}
