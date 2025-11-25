<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\ReasonService;
use App\Models\Reason;


use Validator;

class ReasonController extends Controller
{

    public function __construct(ReasonService $ReasonService){

        $this->ReasonService=$ReasonService;

    }


    public function get_reasons(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|integer|in:1,2,3',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->ReasonService->getReason($request);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function change_reason_status(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'reason_id' => 'required|exists:reasons,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->ReasonService->changeReasonStatus($request->reason_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function add_reason(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'reason_english' => 'required|string',
            'reason_arabic' => 'required|string',
            'type'          => 'required|integer|in:1,2,3',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->ReasonService->createReason($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function update_reason(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'reason_id' => 'required|exists:reasons,id',
            'reason_english' => 'required|string',
            'reason_arabic' => 'required|string',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->ReasonService->updateReason($request, $request->reason_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function delete_reason(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'reason_id' => 'required|exists:reasons,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->ReasonService->deleteReason($request->reason_id);

            if ($result['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => $result['message'] ?? 'Reason deleted successfully',
                    'data' => null
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => $result['message'] ?? 'Failed to delete reason',
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
