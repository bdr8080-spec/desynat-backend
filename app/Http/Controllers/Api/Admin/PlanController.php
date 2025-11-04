<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\PlanService;
use App\Models\Plan;


use Validator;

class PlanController extends Controller
{

    public function __construct(PlanService $PlanService){

        $this->PlanService=$PlanService;

    }

    public function add_plan(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'plan_name_english' => 'required|string|max:255',
            'plan_name_arabic' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'duration_type' => 'required|in:1,2', 
            'no_of_videos' => 'required|integer|min:1',
            'no_of_products' => 'required|integer|min:1',
            'no_of_highlights' => 'required|integer|min:1',
            'stories' => 'required|in:0,1',
            'price' => 'required|numeric|min:1',
            'commission' => 'required|in:0,1',
            'commission_percentage' => 'nullable|numeric|min:0',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->PlanService->addPlan($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function update_plan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'country_id' => 'required|exists:countries,id',
            'plan_name_english' => 'required|string|max:255',
            'plan_name_arabic' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'duration_type' => 'required|in:1,2', 
            'no_of_videos' => 'required|integer|min:1',
            'no_of_products' => 'required|integer|min:1',
            'no_of_highlights' => 'required|integer|min:1',
            'stories' => 'required|in:0,1',
            'price' => 'required|numeric|min:1',
            'commission' => 'required|in:0,1',
            'commission_percentage' => 'nullable|numeric|min:0',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->PlanService->updatePlan($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_plans(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country_id' => 'nullable|exists:countries,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->PlanService->getPlans($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_plan_details(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->PlanService->getPlanDetails($request->plan_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 404);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function change_plan_status(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->PlanService->changePlanStatus($request->plan_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function delete_plan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->PlanService->deletePlan($request->plan_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }







    

    


      






}
