<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\ApiResponse;
use Validator;

use App\Models\product;
use App\Models\ProductSpecification;
use App\Models\ProductVariant;


use App\Services\SellerProductService;


class SellerProductController extends Controller
{

    public function __construct(SellerProductService $SellerProductService){
        $this->SellerProductService=$SellerProductService;
    }


    public function add_product(){

        $validate = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'other_en' => 'required',
            'other_ar' => 'required',
         
            'product_name_en' => 'required|product_name_en|unique:products,product_name_en',
            'product_name_ar' => 'required|product_name_ar|unique:products,product_name_ar',
         
            'description_en' => 'required',
            'description_ar' => 'required',

            // specification
            'product_spe_en'=>'nullable|array',
            'product_spe_feature_en'=>'nullable|array',
            'product_spe_ar'=>'nullable|array',
            'product_spe_feature_ar'=>'nullable|array',

            // product vartion start

            "variant_image"=>"Array|nullable",
            'color_id'=>"required|exists:colors,id",
            'size_id'=>"required|exists:sizes,id",

            'total_stock' => 'required',
            'sku' => 'required',

            'sku_threshold_value' => 'required',
            'actual_price' => 'required',
            'discount_type'=>'required|in:1,2',
            'discount_value'=>'required',
            'final_price'=>'required',

            // product vartion end

            'min_card_quantity'=>'required',
            'max_card_quantity'=>'required',
            'product_return'=>'required|in:0,1', // 0 Not return 1 return Availble 
            


        //     'mobile' => [
        //     'required',
        //     Rule::unique('sellers')->where(function ($query) use ($request) {
        //         return $query->where('country_code', $request->country_code);
        //     }),
        // ],


        ]);


        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }




    }


}