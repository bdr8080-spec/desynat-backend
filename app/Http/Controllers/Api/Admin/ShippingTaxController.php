<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\ShippingTaxService;


use Validator;

class ShippingTaxController extends Controller
{

    public function __construct(ShippingTaxService $ShippingTaxService){

        $this->ShippingTaxService=$ShippingTaxService;

    }
    
    public function countries_with_tax_shipping(Request $request)
    {
        try {
            $data = $this->ShippingTaxService->getCountriesWithTaxShipping();

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function add_tax(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'tax' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->ShippingTaxService->addTax($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 200);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function add_shipping_charge(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'range_from' => 'required|numeric',
            'range_to' => 'required|numeric',
            'shipping_fee' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->ShippingTaxService->addShippingFee($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 200);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function update_shipping_charge(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'shipping_charge_id' => 'required|exists:shipping_charges,id',
            'range_from' => 'required|numeric',
            'range_to' => 'required|numeric',
            'shipping_fee' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->ShippingTaxService->updateShippingFee($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 200);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function delete_shipping_fee(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'shipping_charge_id' => 'required|exists:shipping_charges,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->ShippingTaxService->deleteShippingCharge($request->shipping_charge_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 200);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }








    

    


      






}
