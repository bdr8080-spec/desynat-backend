<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use Validator;

use Illuminate\Validation\Rule;
use App\Services\UserAffiliatedProductService;




class UserAffiliatedProductController extends Controller
{

    public function __construct(UserAffiliatedProductService $UserAffiliatedProductService){

        $this->UserAffiliatedProductService=$UserAffiliatedProductService;

    }

    public function get_all_products(Request $request)
    {
        $validate = Validator::make($request->all(), [
        'category_id'         => 'required|exists:categories,id',
        'subcategory_id' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse(
                'error',
                $validate->errors()->first(),
                (object) $validate->errors(),
                422
            );
        }

        try {
            $data = $this->UserAffiliatedProductService->getAllProducts($request);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_product_detail(Request $request)
    { 
        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:products,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->UserAffiliatedProductService->getProductDetail($request);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_my_products(Request $request)
    {
        $affilated_user = $request->user()->id;

        $request_data = (object) [
            'user_id' => $affilated_user,
            'from' => $request->from ?? null,
            'to' => $request->to ?? null,
            'limit' => $request->limit ?? null,
            'search' => $request->search ?? null,
        ];

        try {
            $data = $this->UserAffiliatedProductService->getMyProducts($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }
    









    

    


      






}
