<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\PromocodeService;


use Validator;

class PromocodeController extends Controller
{

    public function __construct(PromocodeService $PromocodeService){

        $this->PromocodeService=$PromocodeService;

    }

    public function get_promocodes(Request $req)
    {
        try {
            $data = $this->PromocodeService->getPromoCodes($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }
    
    public function add_promocode(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'description_english' => 'required|string',
            'description_arabic' => 'required|string',
            'applicable_for' => 'required|in:1,2', // 1-first order, 2-all order
            'discount_percent' => 'required|string|max:255',
            'min_order_value' => 'required|string|max:255',
            'upto_discount' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->PromocodeService->addPromoCode($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 200);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function update_promocode(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'promocode_id' => 'required|exists:promocodes,id',
            'country_id' => 'required|exists:countries,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'description_english' => 'required|string',
            'description_arabic' => 'required|string',
            'applicable_for' => 'required|in:1,2', // 1-first order, 2-all order
            'discount_percent' => 'required|string|max:255',
            'min_order_value' => 'required|string|max:255',
            'upto_discount' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->PromocodeService->updatePromoCode($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 200);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function delete_promocode(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'promocode_id' => 'required|exists:promocodes,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->PromocodeService->deletePromoCode($request->promocode_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 200);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function block_unblock_promocode(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'promocode_id' => 'required|exists:promocodes,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->PromocodeService->changePromoCodeStatus($request->promocode_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }








    

    


      






}
