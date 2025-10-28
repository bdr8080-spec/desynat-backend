<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\CategoryService;
use App\Models\Category;
use App\Models\SubCategory;

use Validator;

class CategoryController extends Controller
{

    public function __construct(CategoryService $CategoryService){

        $this->CategoryService=$CategoryService;

    }


    public function get_category(Request $req)
    {
        try {
            $data = $this->CategoryService->getCategory($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_subcategories(Request $request)
    {
       //print_r('123');
        $validate = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->CategoryService->getSubCategoriesByCategoryId($request->category_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function change_category_status(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->CategoryService->changeCategoryStatus($request->category_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function change_subcategory_status(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'subcategory_id' => 'required|exists:sub_categories,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->CategoryService->changeSubCategoryStatus($request->subcategory_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function add_subcategory(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->CategoryService->createSubCategory($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    

    


      






}
