<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\PlanService;
use App\Models\Plan;

use Illuminate\Validation\Rule;

use Validator;

class PlanController extends Controller
{

    public function __construct(PlanService $PlanService){

        $this->PlanService=$PlanService;

    }

    // public function add_plan(Request $request)
    // {

    //     $validate = Validator::make($request->all(), [
    //         'country_id' => 'required|exists:countries,id',
    //         'plan_name_english' => 'required|string|max:255',
    //         'plan_name_arabic' => 'required|string|max:255',
    //         'duration' => 'required|integer|min:1',
    //         'duration_type' => 'required|in:1,2', 
    //         'no_of_videos' => 'required|integer|min:1',
    //         'no_of_products' => 'required|integer|min:1',
    //         'no_of_highlights' => 'required|integer|min:1',
    //         'no_of_employee' => 'required|integer|min:1',
    //         'stories' => 'required|in:0,1',
    //         'price' => 'required|numeric|min:1',
    //         'commission' => 'required|in:0,1',
    //         'commission_percentage' => 'nullable|numeric|min:0',
    //     ]);

    //     if ($validate->fails()) {
    //         return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
    //     }

    //     try {
    //         $result = $this->PlanService->addPlan($request);

    //         if ($result['status'] === 'error') {
    //             return ApiResponse::generateResponse('error', $result['message'], [], 400);
    //         }

    //         return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);

    //     } catch (\Exception $e) {
    //         return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
    //     }
    // }

    // public function update_plan(Request $request)
    // {
    //     $validate = Validator::make($request->all(), [
    //         'plan_id' => 'required|exists:plans,id',
    //         'country_id' => 'required|exists:countries,id',
    //         'plan_name_english' => 'required|string|max:255',
    //         'plan_name_arabic' => 'required|string|max:255',
    //         'duration' => 'required|integer|min:1',
    //         'duration_type' => 'required|in:1,2', 
    //         'no_of_videos' => 'required|integer|min:1',
    //         'no_of_products' => 'required|integer|min:1',
    //         'no_of_highlights' => 'required|integer|min:1',
    //         'no_of_employee' => 'required|integer|min:1',
    //         'stories' => 'required|in:0,1',
    //         'price' => 'required|numeric|min:1',
    //         'commission' => 'required|in:0,1',
    //         'commission_percentage' => 'nullable|numeric|min:0',
    //     ]);

    //     if ($validate->fails()) {
    //         return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
    //     }

    //     try {
    //         $result = $this->PlanService->updatePlan($request);

    //         if ($result['status'] === 'error') {
    //             return ApiResponse::generateResponse('error', $result['message'], [], 400);
    //         }

    //         return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);

    //     } catch (\Exception $e) {
    //         return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
    //     }
    // }

    public function add_plan(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'country_id' => 'required|exists:countries,id',
                'plan_name_english' => 'required|string|max:255',
                'plan_name_arabic' => 'required|string|max:255',

                'duration' => [
                    'required',
                    'integer',
                    'min:1',
                    Rule::when($request->duration_type == 1, ['max:11']),
                    Rule::when($request->duration_type == 2, ['in:1']),
                ],

                'duration_type' => 'required|in:1,2',

                'no_of_videos' => 'required|integer|min:1',
                'product_type' => 'required|in:0,1',
                'no_of_products' => 'required_if:product_type,0|nullable|integer|min:1',
                'no_of_highlights' => 'required|integer|min:1',
                'no_of_employee' => 'required|integer|min:1',
                'stories' => 'required|in:0,1',
                'price' => 'required|numeric|min:1',
                'commission' => 'required|in:0,1',
                'commission_percentage' => 'required_if:commission,1|nullable|numeric|min:0',
                'is_free_months' => 'required|in:0,1',

                'no_of_free_months' => [
                    'nullable',
                    'required_if:is_free_months,1',
                    'integer',
                    'min:1',
                    'max:11'
                ],
            ],
            [
                'duration.max' => 'Duration must not be greater than 11 months.',
                'duration.in' => 'For yearly plan, duration must be 1.',
            ]
        );

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
        $validate = Validator::make(
            $request->all(),
            [
                'plan_id' => 'required|exists:plans,id',
                'country_id' => 'required|exists:countries,id',
                'plan_name_english' => 'required|string|max:255',
                'plan_name_arabic' => 'required|string|max:255',

                'duration' => [
                    'required',
                    'integer',
                    'min:1',
                    Rule::when($request->duration_type == 1, ['max:11']),
                    Rule::when($request->duration_type == 2, ['in:1']),
                ],

                'duration_type' => 'required|in:1,2',

                'new_duration' => 'nullable|integer|min:1',
                'new_duration_type' => 'nullable|in:1,2',
                'no_of_videos' => 'required|integer|min:1',
                'product_type' => 'required|in:0,1',
                'no_of_products' => 'required_if:product_type,0|nullable|integer|min:1',
                'no_of_highlights' => 'required|integer|min:1',
                'no_of_employee' => 'required|integer|min:1',
                'stories' => 'required|in:0,1',
                'price' => 'required|numeric|min:1',
                'discounted_price' => 'nullable|numeric|min:0',
                'commission' => 'required|in:0,1',
                'commission_percentage' => 'required_if:commission,1|nullable|numeric|min:0',
                'is_free_months' => 'required|in:0,1',
                'no_of_free_months' => 'required_if:is_free_months,1|nullable|integer|min:1|max:11',
            ],
            [
                'duration.max' => 'Duration must not be greater than 11 months.',
                'duration.in' => 'For yearly plan, duration must be 1.',
            ]
        );
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
