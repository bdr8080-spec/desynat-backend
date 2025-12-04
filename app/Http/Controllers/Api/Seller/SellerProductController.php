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
use App\Services\SellerAuthService;


class SellerProductController extends Controller
{

    public function __construct(SellerProductService $SellerProductService, SellerAuthService $SellerAuthService){
        $this->SellerProductService=$SellerProductService;

        $this->SellerAuthService=$SellerAuthService;

    }


    public function add_product(Request $request){


      $seller_details=  $request->user();
      $seller_id=$seller_details->id;

        $validate = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            // 'other_en' => 'required',
            // 'other_ar' => 'required',
         
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
            // 'sku_threshold_value' => ['required', 'array', new MatchArrayProductVariation],
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
    

 $request_data=(object) [
'seller_id'=>$seller_id,
'category_id' => $request->category_id,
'subcategory_id' => $request->subcategory_id,
'brand_id' => $request->brand_id,
'other_en' => $request->other_en??null,
'other_ar' => $request->other_ar??null,

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
'sku_threshold_value' => $request->sku_threshold_value??null,
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

// edit_product



    public function edit_product(Request $request){


      $seller_details=  $request->user();
      $seller_id=$seller_details->id;

        $validate = Validator::make($request->all(), [
            'product_id'=>'required|exists:products,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            // 'other_en' => 'required',
            // 'other_ar' => 'required',
         
            'product_name_en' => 'required|unique:products,product_name_en,' . $request->product_id,
            'product_name_ar' => 'required|unique:products,product_name_ar,' . $request->product_id,

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
            // 'sku_threshold_value' => ['required', 'array', new MatchArrayProductVariation],
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
    

 $request_data=(object) [
'product_id'=>$request->product_id,
'seller_id'=>$seller_id,
'category_id' => $request->category_id,
'subcategory_id' => $request->subcategory_id,
'brand_id' => $request->brand_id,
'other_en' => $request->other_en??null,
'other_ar' => $request->other_ar??null,

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
'sku_threshold_value' => $request->sku_threshold_value??null,
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


 $data=  $this->SellerProductService->edit_Product($request_data);


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }



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


  


public function seller_single_product_details(Request $request){


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




  public function add_product1(Request $request){


    $seller_details=  $request->user();
    $seller_id=$seller_details->id;

      $validate = Validator::make($request->all(), [
          'category_id' => 'required|exists:categories,id',
          'subcategory_id' => 'required|exists:sub_categories,id',
          'brand_id' => 'required|exists:brands,id',
          // 'other_en' => 'required',
          // 'other_ar' => 'required',
       
        //   'product_name_en' => 'required|unique:products,product_name_en',
        //   'product_name_ar' => 'required|unique:products,product_name_ar',
       
          'description_en' => 'required',
          'description_ar' => 'required',

          // specification
          'product_spe_en'=>['required', 'array', new MatchArrayProductSpecification],
          'product_spe_feature_en'=>['required', 'array', new MatchArrayProductSpecification],
          'product_spe_ar'=>['required', 'array', new MatchArrayProductSpecification],
          'product_spe_feature_ar'=>['required', 'array', new MatchArrayProductSpecification],

          // product vartion start
        //   'variant_image' => ['required', 'array', new MatchArrayProductVariation],
       
       
        //   'color_id' => ['required', 'array', new MatchArrayProductVariation],
        //   'size_id' => ['required', 'array', new MatchArrayProductVariation],   
        //   'color_id.*' => ['required','distinct','exists:colors,id'],
        //   'size_id.*' => ['required','exists:sizes,id','distinct'],
          
        //   'total_stock' => ['required', 'array', new MatchArrayProductVariation],
        //   'sku' => ['required', 'array', new MatchArrayProductVariation],
        //   // 'sku_threshold_value' => ['required', 'array', new MatchArrayProductVariation],
        //   'actual_price' => ['required', 'array', new MatchArrayProductVariation],
        //   'discount_type' => ['required', 'array', new MatchArrayProductVariation],
        //   'discount_value' => ['required', 'array', new MatchArrayProductVariation],
        //   'final_price' => ['required', 'array', new MatchArrayProductVariation],

    'Products' => 'required|array',
    'Products.*.variant_image' => 'required|array|min:1',
    'Products.*.variant_image.*' => 'required|string',

    'Products.*.color_id' => 'required|integer|exists:colors,id',

    'Products.*.product_variation' => 'required|array|min:1',
    'Products.*.product_variation.*.size_id' => 'required|integer|exists:sizes,id',

    // required fields for all
    'Products.*.product_variation.*.total_stock' => 'required|integer|min:1',
    'Products.*.product_variation.*.sku' => 'required',
    'Products.*.product_variation.*.actual_price' => 'required|numeric',
    'Products.*.product_variation.*.discount_type' => 'required|in:1,2',
    'Products.*.product_variation.*.discount_value' => 'required|numeric|min:0',
    'Products.*.product_variation.*.final_price' => 'required|numeric',

    // woman category only — so optional
    'Products.*.product_variation.*.bust' => 'nullable|numeric',
    'Products.*.product_variation.*.waist' => 'nullable|numeric',
    'Products.*.product_variation.*.hip' => 'nullable|numeric',
    'Products.*.product_variation.*.shoulder' => 'nullable|numeric',
    'Products.*.product_variation.*.sleeve_length' => 'nullable|numeric',
    'Products.*.product_variation.*.length' => 'nullable|numeric',
    

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

    //   check Color and size combination

    $validate->after(function ($validate) use ($request) {
        if (!$request->Products) return;
    
        foreach ($request->Products as $index => $product) {
            $color_id = $product['color_id'] ?? null;
    
            if (!$color_id || empty($product['product_variation'])) continue;
    
            $combos = [];
    
            foreach ($product['product_variation'] as $i => $variation) {
                $size_id = $variation['size_id'];
    
                $comboKey = $color_id . '-' . $size_id;
    
                if (isset($combos[$comboKey])) {
                    $validate->errors()->add(
                        "Products.$index.product_variation.$i.size_id",
                        "Duplicate size for selected color."
                    );
                } else {
                    $combos[$comboKey] = true;
                }
            }
        }
    });

    // color and size combination end here

      if($validate->fails()){
          return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
         }


$request_data=(object) [
'seller_id'=>$seller_id,
'category_id' => $request->category_id,
'subcategory_id' => $request->subcategory_id,
'brand_id' => $request->brand_id,
'other_en' => $request->other_en??null,
'other_ar' => $request->other_ar??null,

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
'sku_threshold_value' => $request->sku_threshold_value??null,
'actual_price' => $request->actual_price,
'discount_type' => $request->discount_type,
'discount_value' => $request->discount_value,
'final_price' => $request->final_price,


// new keys
"Product_data"=>$request->Products,

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


  $data=  $this->SellerProductService->AddProduct1($request_data);

  if(isset($data['status']) && $data['status']=='error' ){
      return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
  }

  return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
  }




  public function edit_product1(Request $request){


    $seller_details=  $request->user();
    $seller_id=$seller_details->id;

    $validate = Validator::make($request->all(), [
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'required|exists:sub_categories,id',
        'brand_id' => 'required|exists:brands,id',
        // 'other_en' => 'required',
        // 'other_ar' => 'required',
     
      //   'product_name_en' => 'required|unique:products,product_name_en',
      //   'product_name_ar' => 'required|unique:products,product_name_ar',
     
        'description_en' => 'required',
        'description_ar' => 'required',

        // specification
        'product_spe_en'=>['required', 'array', new MatchArrayProductSpecification],
        'product_spe_feature_en'=>['required', 'array', new MatchArrayProductSpecification],
        'product_spe_ar'=>['required', 'array', new MatchArrayProductSpecification],
        'product_spe_feature_ar'=>['required', 'array', new MatchArrayProductSpecification],

  'Products' => 'required|array',
  'Products.*.variant_image' => 'required|array|min:1',
  'Products.*.variant_image.*' => 'required|string',

  'Products.*.color_id' => 'required|integer|exists:colors,id',

  'Products.*.product_variation' => 'required|array|min:1',
  'Products.*.product_variation.*.size_id' => 'required|integer|exists:sizes,id',

  // required fields for all
  'Products.*.product_variation.*.total_stock' => 'required|integer|min:1',
  'Products.*.product_variation.*.sku' => 'required',
  'Products.*.product_variation.*.actual_price' => 'required|numeric',
  'Products.*.product_variation.*.discount_type' => 'required|in:1,2',
  'Products.*.product_variation.*.discount_value' => 'required|numeric|min:0',
  'Products.*.product_variation.*.final_price' => 'required|numeric',

  // woman category only — so optional
  'Products.*.product_variation.*.bust' => 'nullable|numeric',
  'Products.*.product_variation.*.waist' => 'nullable|numeric',
  'Products.*.product_variation.*.hip' => 'nullable|numeric',
  'Products.*.product_variation.*.shoulder' => 'nullable|numeric',
  'Products.*.product_variation.*.sleeve_length' => 'nullable|numeric',
  'Products.*.product_variation.*.length' => 'nullable|numeric',
  

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
        'upload_size_chart'=>'required',
                     
    ]);
    


    //   check Color and size combination

    $validate->after(function ($validate) use ($request) {
        if (!$request->Products) return;
    
        foreach ($request->Products as $index => $product) {
            $color_id = $product['color_id'] ?? null;
    
            if (!$color_id || empty($product['product_variation'])) continue;
    
            $combos = [];
    
            foreach ($product['product_variation'] as $i => $variation) {
                $size_id = $variation['size_id'];
    
                $comboKey = $color_id . '-' . $size_id;
    
                if (isset($combos[$comboKey])) {
                    $validate->errors()->add(
                        "Products.$index.product_variation.$i.size_id",
                        "Duplicate size for selected color."
                    );
                } else {
                    $combos[$comboKey] = true;
                }
            }
        }
    });

    // color and size combination end here

    

    if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
       }


$request_data=(object) [
'product_id'=>$request->product_id,
'seller_id'=>$seller_id,
'category_id' => $request->category_id,
'subcategory_id' => $request->subcategory_id,
'brand_id' => $request->brand_id,
'other_en' => $request->other_en??null,
'other_ar' => $request->other_ar??null,

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
'sku_threshold_value' => $request->sku_threshold_value??null,
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
'upload_size_chart'=> $request->upload_size_chart,

// new keys
"Product_data"=>$request->Products,

     ];


$data=  $this->SellerProductService->edit_Product1($request_data);


  if(isset($data['status']) && $data['status']=='error' ){
      return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
  }

  return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
  }


public function all_Inventory_product(Request $request){


    $validate = Validator::make($request->all(), [               
        'cargory_filter'=>'required|array',
     ]);
    
    if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }


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
    



public function update_stock_inventory(Request $request){

    $validate = Validator::make($request->all(), [               
        'product_id'=>'required|exists:products,id',
        'variation_id'=>'required|exists:product_variants,id' ,
        'stock_quantity'=>'required',
        'sku' =>'nullable'
        
     ]);
    
    if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }


    $seller_details=  $request->user();
    $seller_id=$seller_details->id;
    
    $request_data=(object) [
    'seller_id'=>$seller_id,
    'product_id'=>$request->product_id,
    'variation_id'=>$request->variation_id,
    'stock_quantity'=>$request->stock_quantity,
    'sku'=>$request->sku??null
    ];
    
      $data=  $this->SellerProductService->Update_Product_Inventory($request_data);
    
      if(isset($data['status']) && $data['status']=='error' ){
          return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
      }
    
      return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
      
      }

      

public function update_affilate_commission(Request $request){

    $validate = Validator::make($request->all(), [               
        'affilate_commission'=>'required|numeric|min:0|max:100'        
     ],[
        
        'affilate_commission.required' => 'Affiliate commission is required.',
        'affilate_commission.numeric' => 'Affiliate commission must be a number.',
        'affilate_commission.min' => 'Affiliate commission cannot be less than 0%.',
        'affilate_commission.max' => 'Affiliate commission cannot be more than 100%.',

     ]);
    
    if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }


    $seller_details=  $request->user();
    $seller_id=$seller_details->id;
    
    $request_data=(object) [
    'seller_id'=>$seller_id,
    'affilate_commission'=>$request->affilate_commission
    ];
    
      $data=  $this->SellerProductService->Update_affilate_commission_Inventory($request_data);
    
      if(isset($data['status']) && $data['status']=='error' ){
          return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
      }
    
      return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
      
      }
    



public function view_profile(Request $request){


    $seller_details=  $request->user();
    $seller_id=$seller_details->id;
    
    $request_data=(object) [
    'seller_id'=>$seller_id,
    ];
    
      $data=  $this->SellerProductService->View_seller_profile($request_data);
    
      if(isset($data['status']) && $data['status']=='error' ){
          return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
      }
    
      return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
      
      }




    public function update_store_information(Request $req){


        $seller_details=  $req->user();
        $seller_id=$seller_details->id;

        $validate = Validator::make($req->all(), [
            // 'profile_pic'=>'nullable|required',
            'full_name'=>'required',
            
            'store_image' => 'required',
            'store_name' => 'required',
            'country'=>"required",
            "store_address"=>"required",
            // 'address_line1'=>'required',
            // 'address_line2'=>'required',
            "store_phone"=>"required",
            'store_mail_id'=>'required',
            'bio'=>'required',
            'let'=>'required',
            'long'=>'required'
            
            ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }


       $request_data= (object)[
        'profile_pic' => $req->profile_pic??null,
        'full_name' => $req->full_name??null,

        'user_id' => $seller_id,
        'store_image' => $req->store_image ,
        'store_name' => $req->store_name ,
        'country'=>$req->country ,
        "store_address"=>$req->store_address ,
        'address_line1'=>$req->address_line1 ,
        'address_line2'=>$req->address_line2 ,
        'country_code' => $req->country_code,
        "store_phone"=>$req->store_phone ,
        'store_mail_id'=>$req->store_mail_id,
        'bio'=>$req->bio,
        'let'=>$req->let,
        'long'=>$req->long
       ];

        $data= $this->SellerProductService->profile_store_information_insert($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function update_store_bank_details(Request $req){

        $seller_details=  $req->user();
        $seller_id=$seller_details->id;

        $validate = Validator::make($req->all(), [
            'account_type'=>"required|in:0,1", // 0 Personal 1 Busness
            // "iban"=>"required",
            // 'swift'=>'required',
            'bank_name'=>'required',
            "account_holder_name"=>"required",
            'upload_proof'=>'required'
            ]);
            
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $request_data= (object) [
        'user_id' => $seller_id,
        'type'=> '1',
        'account_type' => strVal($req->account_type),
        'iban' => $req->iban??null ,
        'swift'=>$req->swift??null ,
        "bank_name"=>$req->bank_name ,
        'account_holder_name'=>$req->account_holder_name ,
        'upload_proof'=>$req->upload_proof,
       ];
       
        $data= $this->SellerProductService->store_bank_details_update($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

      

      

}