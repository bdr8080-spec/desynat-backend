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

        $validate = Validator::make($req->all(), [
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


    

    


      






}
