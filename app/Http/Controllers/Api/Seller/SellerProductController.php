<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\ApiResponse;

use Validator;

use App\Models\product;
use App\Models\ProductSpecification;
use App\Models\ProductVariant;

use App\Rules\MatchArrayProductSpecification;
use App\Rules\MatchArrayProductVariation;


use App\Services\SellerProductService;


class SellerProductController extends Controller
{

    public function __construct(SellerProductService $SellerProductService){
        $this->SellerProductService=$SellerProductService;
    }


    public function add_product(Request $request){


      $seller_details=  $request->user();
      $seller_id=$seller_details->id;

        $validate = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'other_en' => 'required',
            'other_ar' => 'required',
         
            'product_name_en' => 'required|unique:products,product_name_en',
            'product_name_ar' => 'required|unique:products,product_name_ar',
         
            'description_en' => 'required',
            'description_ar' => 'required',

            // specification
            'product_spe_en'=>['required', 'array', new MatchArrayProductSpecification],
            'product_spe_feature_en'=>['required', 'array', new MatchArrayProductSpecification],
            'product_spe_ar'=>['required', 'array', new MatchArrayProductSpecification],
            'product_spe_feature_ar'=>['required', 'array', new MatchArrayProductSpecification],

            // product vartion start
            'variant_image' => ['required', 'array', new MatchArrayProductVariation],
            'color_id' => ['required', 'array', new MatchArrayProductVariation],
            'size_id' => ['required', 'array', new MatchArrayProductVariation],
            
            'color_id.*' => ['required','distinct','exists:colors,id'],
            'size_id.*' => ['required','exists:sizes,id','distinct'],
            
            
            'total_stock' => ['required', 'array', new MatchArrayProductVariation],
            'sku' => ['required', 'array', new MatchArrayProductVariation],
            'sku_threshold_value' => ['required', 'array', new MatchArrayProductVariation],
            'actual_price' => ['required', 'array', new MatchArrayProductVariation],
            'discount_type' => ['required', 'array', new MatchArrayProductVariation],
            'discount_value' => ['required', 'array', new MatchArrayProductVariation],
            'final_price' => ['required', 'array', new MatchArrayProductVariation],

            // product vartion end
            
            'min_card_quantity'=>'required',
            'max_card_quantity'=>'required',
            'product_return'=>'required|in:0,1', // 0 Not return 1 return Availble 
            // 'return_days'=>'nullable|integer',
            'return_days'=> 'required_if:product_return,1|nullable|integer',
            'product_exchangable'=>'required|in:0,1',  // 0 not 1 yes
            
            // 'exchangable_days'=>'nullable|integer',
            'exchangable_days'=>'required_if:product_exchangable,1|nullable|integer',
            
            'review_rating'=>'required|in:0,1', // 0 not 1 yes
            'affiliated_product'=>'required|in:0,1', // // 0 not 1 yes
            'customized_product'=>'required|in:0,1', // // 0 not 1 yes
            'ready_to_ship'=>'required|in:0,1', // // 0 not 1 yes
            'cash_on_delivery'=>'required|in:0,1', // // 0 not 1 yes
            'upload_size_chart'=>'required'
                         
        ]);

        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }

       if($request->category_id=='2'){   // if the category is women Then These field is manditary

        $validate = Validator::make($request->all(), [               
            'bust'=>'required|array',
            'waist'=>'required|array',
            'hip'=>'required|array',
            'shoulder'=>'required|array',
            'sleeve_length'=>'required|array',
            'length'=>'required|array',
        ]);
        
        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

       }

    dd($request->all());
    

 $request_data=(object) [
'seller_id'=>$seller_id,
'category_id' => $request->category_id,
'subcategory_id' => $request->subcategory_id,
'brand_id' => $request->brand_id,
'other_en' => $request->other_en,
'other_ar' => $request->other_ar,

'product_name_en' => $request->product_name_en,
'product_name_ar' => $request->product_name_ar,
     
'description_en' => $request->description_en,
'description_ar' => $request->description_ar,

        // specification
'product_spe_en'=> $request->product_spe_en,
'product_spe_feature_en'=> $request->product_spe_feature_en,
'product_spe_ar'=> $request->product_spe_ar,
'product_spe_feature_ar'=> $request->product_spe_feature_ar,

        // product vartion start
'variant_image' => $request->variant_image,
'color_id' => $request->color_id,
'size_id' => $request->size_id,
        
'bust'=> $request->bust??null, // only provide when category is women
'waist'=> $request->waist??null, // only provide when category is women
'hip'=> $request->hip??null,  // only provide when category is women
'shoulder'=> $request->shoulder??null, // only provide when category is women
'sleeve_length'=> $request->sleeve_length??null, // only provide when category is women
'length'=> $request->length??null, // only provide when category is women

        
'total_stock' => $request->total_stock,
'sku' => $request->sku,
'sku_threshold_value' => $request->sku_threshold_value,
'actual_price' => $request->actual_price,
'discount_type' => $request->discount_type,
'discount_value' => $request->discount_value,
'final_price' => $request->final_price,

// product vartion end
        
'min_card_quantity'=> $request->min_card_quantity,
'max_card_quantity'=> $request->max_card_quantity,
'product_return'=> $request->product_return, // 0 Not return 1 return Availble 
'return_days'=> $request->return_days,
'product_exchangable'=> $request->product_exchangable,  // 0 not 1 yes
'exchangable_days'=> $request->exchangable_days,
'review_rating'=> $request->review_rating, // 0 not 1 yes
'affiliated_product'=> $request->affiliated_product, // // 0 not 1 yes
'customized_product'=> $request->customized_product, // // 0 not 1 yes
'ready_to_ship'=> $request->ready_to_ship, // // 0 not 1 yes
'cash_on_delivery'=> $request->cash_on_delivery, // // 0 not 1 yes
'upload_size_chart'=> $request->upload_size_chart

       ];


    $data=  $this->SellerProductService->AddProduct($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }


// all product 



public function all_product(Request $request){


    $seller_details=  $request->user();
    $seller_id=$seller_details->id;

$request_data=(object) [
'seller_id'=>$seller_id,
'search' =>$request->search,
'type' =>$request->type,
'cargory_filter' =>$request->cargory_filter,
'brand_filter' =>$request->brand_filter,

];


  $data=  $this->SellerProductService->AllProduct($request_data);

  if(isset($data['status']) && $data['status']=='error' ){
      return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
  }

  return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
  }


  


public function single_product_details(Request $request){


$validate = Validator::make($request->all(), [               
    'product_id'=>'required|exists:products,id',
]);

if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
}

$request_data=(object) [
    'product_id'=>$request->product_id,    
];
    
$data=  $this->SellerProductService->single_product_details_fetch($request_data);

  if(isset($data['status']) && $data['status']=='error' ){
      return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
  }

  return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
  }

  



public function product_status_active_inactive(Request $request){

    $validate = Validator::make($request->all(), [               
        'product_id'=>'required|exists:products,id',
    ]);

    if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }


    $seller_details=  $request->user();
    $seller_id=$seller_details->id;

$request_data=(object) [
'product_id'=>$request->product_id,

];

  $data=  $this->SellerProductService->product_status_active_inactive($request_data);

  if(isset($data['status']) && $data['status']=='error' ){
      return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
  }

  return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
  }



public function product_delete(Request $request){

    $validate = Validator::make($request->all(), [               
        'product_id'=>'required|exists:products,id',
    ]);

    if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }


    $request_data=(object) [
    'product_id'=>$request->product_id,

    ];

  $data=  $this->SellerProductService->product_delete_code($request_data);

  if(isset($data['status']) && $data['status']=='error' ){
      return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
  }

  return ApiResponse::generateResponse('success', $data['message'],(object)[], 200);
  
  }


}