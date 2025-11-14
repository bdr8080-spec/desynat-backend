<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Hash;


use App\Models\product;
use App\Models\ProductSpecification;
use App\Models\ProductVariant;



class SellerProductService
{

    // get categories
    public function getCategories($request){
        
        $category = Category::orderBy('id', 'asc')->get();


        if ($category->isEmpty()) {
             return ['status'=>'success','message'=>"No categories found",'data'=>[]];
            // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
        }

        return ['status'=>'success','message'=>"Category list fetched successfully",'data'=>$category];
        // return ApiResponse::generateResponse('success', 'Sub category list fetched successfully', $subCategory, 201);
    }





}