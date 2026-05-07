<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Hash;


use App\Models\{ seller,sellerStoreInformation,Bankdetails};
use App\Models\color;
use App\Models\Brand;
use App\Models\SellerSubcriptionPlanBuy;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



use App\Models\{ product,ProductSpecification,ProductVariant,StockInventoryRecords};

class SellerProductService
{

public function AddProduct($request){
        

try{


DB::beginTransaction();

// FILTER PRODUCT TABLE DATA SEPRATE

$seller_details=seller::with('store_info','subcription_plan')->where('id',$request->seller_id)->first();

    if($seller_details->admin_verify!=='2'){
        return ['status'=>'error','message'=>"You store Didn't Accept or reject By Admin",'data'=>[]];    
    }

    $subscription = SellerSubcriptionPlanBuy::where('seller_id', $request->seller_id)
            ->where('payment_status', '1')
            ->where('is_expired', '0')
            ->where('plan_end_date', '>=', Carbon::today())
            ->first();

        if (!$subscription) {
            return [
                'status' => 'failed',
                'message' => "You have no active plan",
                'data' => []
            ];
        }

        //  CHECK PRODUCT LIMIT
        if ($subscription->product_type == '0') {

            if ($subscription->no_of_products <= '0') {
                return [
                    'status' => 'error',
                    'message' => "Your monthly limit for product addition has reached, you can't add more products this month",
                    'data' => []
                ];
            }
        }


$product=[
'seller_id'=>$request->seller_id,
'store_id'=>$seller_details->store_info->id,
'category_id' => $request->category_id,
'subcategory_id' => $request->subcategory_id,
'brand_id' => $request->brand_id,
'other_en' => $request->other_en,
'other_ar' => $request->other_ar,

'product_name_en' => $request->product_name_en,
'product_name_ar' => $request->product_name_ar,
     
'description_en' => $request->description_en,
'description_ar' => $request->description_ar,
        
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
'product_active_status'=>1
];


$product_data=  product::create($product);

$product_id= $product_data->id;

// specification 

foreach($request->product_spe_en as $key=>$val){

$specification_array=[
    // specification
'product_id'=> $product_id,
'name_en'=> $request->product_spe_en[$key],
'feature_en'=> $request->product_spe_feature_en[$key],
'name_ar'=> $request->product_spe_ar[$key],
'feature_ar'=> $request->product_spe_feature_ar[$key],
];

$product_data=  ProductSpecification::create($specification_array);

}

// variation code 


foreach($request->color_id as $key=>$val){

$variation_array=[
    'product_id'=> $product_id,

    // product vartion start
'variant_image' => $request->variant_image[$key],
'color_id' => $request->color_id[$key],
'size_id' => $request->size_id[$key],

'total_stock' => $request->total_stock[$key],
'sku' => $request->sku[$key],
// 'sku_threshold_value' => $request->sku_threshold_value[$key],
'actual_price' => $request->actual_price[$key],
'discount_type' => $request->discount_type[$key],
'discount_value' => $request->discount_value[$key],
'final_price' => $request->final_price[$key],

// product vartion end  
];

if($request->category_id==2){

    $variation_array['bust']= $request->bust[$key]??null; // only provide when category is women
    $variation_array['waist']= $request->waist[$key]??null; // only provide when category is women
    $variation_array['hip']= $request->hip[$key]??null;  // only provide when category is women
    $variation_array['shoulder']= $request->shoulder[$key]??null; // only provide when category is women
    $variation_array['sleeve_length']= $request->sleeve_length[$key]??null; // only provide when category is women
    $variation_array['length']= $request->length[$key]??null; // only provide when category is women      
    }


    $product_data=  ProductVariant::create($variation_array);
}

if ($subscription->product_type == '0') {
            $subscription->decrement('no_of_products');
        }


// if ($product->isEmpty()) {
//         return ['status'=>'success','message'=>"No Product found",'data'=>[]];
//     // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
// }


$request_data=(object) [
    'product_id'=>$product_id,    
];


$add_product_data=$this->single_product_details_fetch($request_data);

DB::commit();

return ['status'=>'success','message'=>"Product Add successfully",'data'=>$add_product_data['data']];

} 
catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];

}

}


public function editProduct($request){
        

try{


DB::beginTransaction();

// FILTER PRODUCT TABLE DATA SEPRATE

$seller_details=seller::with('store_info','subcription_plan')->where('id',$request->seller_id)->first();

    if($seller_details->admin_verify!=='2'){
        return ['status'=>'error','message'=>"You store Didn't Accept or reject By Admin",'data'=>[]];    
    }


$product=[
'seller_id'=>$request->seller_id,
'store_id'=>$seller_details->store_info->id,
'category_id' => $request->category_id,
'subcategory_id' => $request->subcategory_id,
'brand_id' => $request->brand_id,
'other_en' => $request->other_en,
'other_ar' => $request->other_ar,

'product_name_en' => $request->product_name_en,
'product_name_ar' => $request->product_name_ar,
     
'description_en' => $request->description_en,
'description_ar' => $request->description_ar,
        
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


$product_data=  product::create($product);

$product_id= $product_data->id;

// specification 

foreach($request->product_spe_en as $key=>$val){

$specification_array=[
    // specification
'product_id'=> $product_id,
'name_en'=> $request->product_spe_en[$key],
'feature_en'=> $request->product_spe_feature_en[$key],
'name_ar'=> $request->product_spe_ar[$key],
'feature_ar'=> $request->product_spe_feature_ar[$key],
];

$product_data=  ProductSpecification::create($specification_array);

}

// variation code 


foreach($request->color_id as $key=>$val){

$variation_array=[
    'product_id'=> $product_id,

    // product vartion start
'variant_image' => $request->variant_image[$key],
'color_id' => $request->color_id[$key],
'size_id' => $request->size_id[$key],

'total_stock' => $request->total_stock[$key],
'sku' => $request->sku[$key],
// 'sku_threshold_value' => $request->sku_threshold_value[$key],
'actual_price' => $request->actual_price[$key],
'discount_type' => $request->discount_type[$key],
'discount_value' => $request->discount_value[$key],
'final_price' => $request->final_price[$key],

// product vartion end  
];

if($request->category_id==2){

    $variation_array['bust']= $request->bust[$key]??null; // only provide when category is women
    $variation_array['waist']= $request->waist[$key]??null; // only provide when category is women
    $variation_array['hip']= $request->hip[$key]??null;  // only provide when category is women
    $variation_array['shoulder']= $request->shoulder[$key]??null; // only provide when category is women
    $variation_array['sleeve_length']= $request->sleeve_length[$key]??null; // only provide when category is women
    $variation_array['length']= $request->length[$key]??null; // only provide when category is women      
    }


    $product_data=  ProductVariant::create($variation_array);
}


// if ($product->isEmpty()) {
//         return ['status'=>'success','message'=>"No Product found",'data'=>[]];
//     // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
// }


$request_data=(object) [
    'product_id'=>$product_id,    
];


$add_product_data=$this->single_product_details_fetch($request_data);

DB::commit();

return ['status'=>'success','message'=>"Product Add successfully",'data'=>$add_product_data['data']];

} 
catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];

}

}

public function Seller_Plan_check($seller_id){

      $seller_details=seller::with('store_info','subcription_plan')->where('id',$seller_id)->first();

        if($seller_details->admin_verify!=='2'){
            return ['status'=>'error','message'=>"You store Didn't Accept or reject By Admin",'data'=>[]];    
        }

        return  $seller_details;

}


// Edit-Product 
public function edit_Product($request){
        
    try{

        DB::beginTransaction();

        // FILTER PRODUCT TABLE DATA SEPRATE

       $seller_details= $this->Seller_Plan_check($request->seller_id);

        // $seller_details=seller::with('store_info','subcription_plan')->where('id',$request->seller_id)->first();

        //     if($seller_details->admin_verify!=='2'){
        //         return ['status'=>'error','message'=>"You store Didn't Accept or reject By Admin",'data'=>[]];    
        //     }

        $match=[
            'id'=>$request->product_id
        ];

        $product=[
        'seller_id'=>$request->seller_id,
        'store_id'=>$seller_details->store_info->id,
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'brand_id' => $request->brand_id,
        'other_en' => $request->other_en,
        'other_ar' => $request->other_ar,

        'product_name_en' => $request->product_name_en,
        'product_name_ar' => $request->product_name_ar,
            
        'description_en' => $request->description_en,
        'description_ar' => $request->description_ar,
                
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


        $product_data=  product::UpdateOrCreate($match,$product);

        $product_id= $request->product_id;
        
        // old specification delete
        ProductSpecification::where('product_id',$product_id)->delete();

        foreach($request->product_spe_en as $key=>$val){

        $specification_array=[
            // specification
        'product_id'=> $product_id,
        'name_en'=> $request->product_spe_en[$key],
        'feature_en'=> $request->product_spe_feature_en[$key],
        'name_ar'=> $request->product_spe_ar[$key],
        'feature_ar'=> $request->product_spe_feature_ar[$key],
        ];

        $product_data=  ProductSpecification::updateOrCreate($specification_array);

        }

        // variation code 
        // OLD variants
        $existingVariants = ProductVariant::where('product_id', $product_id)
        ->pluck('id')
        ->toArray();

        $newVariantIDs = [];

        foreach($request->color_id as $key=>$val){

        $match=[
        'product_id'=> $product_id,
        'color_id' => $request->color_id[$key],
        'size_id' => $request->size_id[$key],
            ];

        $variation_array=[
     'product_id'=> $product_id,

            // product vartion start
        'variant_image' => $request->variant_image[$key],
        'color_id' => $request->color_id[$key],
        'size_id' => $request->size_id[$key],

        'total_stock' => $request->total_stock[$key],
        'sku' => $request->sku[$key],
        // 'sku_threshold_value' => $request->sku_threshold_value[$key],
        'actual_price' => $request->actual_price[$key],
        'discount_type' => $request->discount_type[$key],
        'discount_value' => $request->discount_value[$key],
        'final_price' => $request->final_price[$key],

        // product vartion end  
        ];

        if($request->category_id==2){

            $variation_array['bust']= $request->bust[$key]??null; // only provide when category is women
            $variation_array['waist']= $request->waist[$key]??null; // only provide when category is women
            $variation_array['hip']= $request->hip[$key]??null;  // only provide when category is women
            $variation_array['shoulder']= $request->shoulder[$key]??null; // only provide when category is women
            $variation_array['sleeve_length']= $request->sleeve_length[$key]??null; // only provide when category is women
            $variation_array['length']= $request->length[$key]??null; // only provide when category is women      
            }

            $product_data=  ProductVariant::updateOrCreate($match,$variation_array);

              $newVariantIDs[] = $product_data->id;
        }

        // DELETE VARIANTS NOT INCLUDED IN FORM
        ProductVariant::where('product_id', $product_id)
            ->whereNotIn('id', $newVariantIDs)
            ->delete();

        // if ($product->isEmpty()) {
        //         return ['status'=>'success','message'=>"No Product found",'data'=>[]];
        //     // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
        // }


        $request_data=(object) [
            'product_id'=>$product_id,    
        ];


        $add_product_data=$this->single_product_details_fetch($request_data);

        DB::commit();

        return ['status'=>'success','message'=>"Product Update successfully",'data'=>$add_product_data['data']];

} 
catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];

}

}





// Stock function
private function applyStockStatus($products)
{
    foreach ($products as $product) {
        $product->stock = 'Out of Stock';

        foreach ($product->product_variants as $variant) {
            if ($variant->total_stock > 1) {
                $product->stock = 'In Stock';
                break;
            }
        }
    }

    return $products;
}

public function AllProduct($request)
{

    
    $seller = Seller::with('store_info','subcription_plan')->find($request->seller_id);

    if (!$seller) {
        return ['status'=>'error','message'=>'Seller not found','data'=>[]];
    }

    $productQuery = Product::with(['category','subcategory','brand','product_specifications','product_variants.color'])
                           ->where('seller_id', $seller->id);
        if ($request->search) {
        if ($request->type == '0') {
            // Search only English name
            $productQuery->where(function($q) use ($request) {
                $q->where('product_name_en', 'like', '%' . $request->search . '%')
                    ->orWhere('product_name_ar', 'like', '%' . $request->search . '%');
                });

        }
    } 

    if ($request->type == '0') {

        if ($request->cargory_filter) {
            $productQuery->where(function($q) use ($request) {
                $q->whereIn('category_id', $request->cargory_filter);
                });
        }

        if ($request->brand_filter) {
            $productQuery->where(function($q) use ($request) {
                $q->whereIn('brand_id', $request->brand_filter);
                });
        }

    }

    $productQuery=$this->applyStockStatus($productQuery->orderBy('id','desc')->get());

    // dd($productQuery);

    // active Product 

    $active_productQuery = Product::with(['category','subcategory','brand','product_specifications','product_variants.color'])
    ->where('seller_id', $seller->id);

        if ($request->search) {
        if ($request->type == '1') {
        // Search only English name
        $active_productQuery->where(function($q) use ($request) {
        $q->where('product_name_en', 'like', '%' . $request->search . '%')
        ->orWhere('product_name_ar', 'like', '%' . $request->search . '%');
        });

        }
    } 

    if ($request->type == '1') {

        if ($request->cargory_filter) {
            $active_productQuery->where(function($q) use ($request) {
                $q->whereIn('category_id', $request->cargory_filter);
                });
        }

        if ($request->brand_filter) {
            $active_productQuery->where(function($q) use ($request) {
                $q->whereIn('brand_id', $request->brand_filter);
                });
        }

    }


$active_productQuery=$this->applyStockStatus($active_productQuery->where('product_active_status', 1)->orderBy('id','desc')->get());

// inactive product

$inactive_productQuery = Product::with(['category','subcategory','brand','product_specifications','product_variants.color'])
->where('seller_id', $seller->id);


    if ($request->search) {
    if ($request->type == '2') {
    // Search only English name
    $inactive_productQuery->where(function($q) use ($request) {
    $q->where('product_name_en', 'like', '%' . $request->search . '%')
    ->orWhere('product_name_ar', 'like', '%' . $request->search . '%');
    });

    }
} 

if ($request->type == '2') {
    
    if ($request->cargory_filter) {
        $inactive_productQuery->where(function($q) use ($request) {
            $q->whereIn('category_id', $request->cargory_filter);
            });
    }
    
    if ($request->brand_filter) {
        $inactive_productQuery->where(function($q) use ($request) {
            $q->whereIn('brand_id', $request->brand_filter);
            });
    }
}

$inactive_productQuery=$this->applyStockStatus($inactive_productQuery->where('product_active_status', 0)->orderBy('id','desc')->get());

    // if ($productQuery->isEmpty()) {
    //     return ['status'=>'success','message'=>'No Product found','data'=>[]];
    // }
    
    return [
        'status' => 'success',
        'message' => 'All Product Data Fetched Successfully',
        'data' => [
          
            'all_product_count' => $productQuery->count(),
            'active_product_count'   => $active_productQuery->count(),
            'inactive_product_count' => $inactive_productQuery->count(),

            'all_product_data' => $productQuery,
            'active_product'   => $active_productQuery,
            'inactive_product' => $inactive_productQuery
        ]
    ];
}



public function AllInventoryProduct($request)
{

    
    $seller = Seller::with('store_info','subcription_plan')->find($request->seller_id);

    if (!$seller) {
        return ['status'=>'error','message'=>'Seller not found','data'=>[]];
    }

    $productQuery = Product::with(['category','subcategory','brand','product_specifications','product_variants.color'])
                           ->where('seller_id', $seller->id);
        if ($request->search) {
        if ($request->type == '0') {
            // Search only English name
            $productQuery->where(function($q) use ($request) {
                $q->where('product_name_en', 'like', '%' . $request->search . '%')
                    ->orWhere('product_name_ar', 'like', '%' . $request->search . '%');
                });

        }
    } 

    if ($request->type == '0') {

     

        if ($request->brand_filter) {
            $productQuery->where(function($q) use ($request) {
                $q->whereIn('brand_id', $request->brand_filter);
                });
        }

    }

    if ($request->cargory_filter) {
        $productQuery->where(function($q) use ($request) {
            $q->whereIn('category_id', $request->cargory_filter);
            });
    }

    $productQuery=$this->applyStockStatus($productQuery->orderBy('id','desc')->get());

    // dd($productQuery);

    // active Product 

    $active_productQuery = Product::with(['category','subcategory','brand','product_specifications','product_variants.color'])
    ->where('seller_id', $seller->id);

        if ($request->search) {
        if ($request->type == '1') {
        // Search only English name
        $active_productQuery->where(function($q) use ($request) {
        $q->where('product_name_en', 'like', '%' . $request->search . '%')
        ->orWhere('product_name_ar', 'like', '%' . $request->search . '%');
        });

        }
    } 

    if ($request->type == '1') {


        if ($request->brand_filter) {
            $active_productQuery->where(function($q) use ($request) {
                $q->whereIn('brand_id', $request->brand_filter);
                });
        }

    }


    if ($request->cargory_filter) {
        $active_productQuery->where(function($q) use ($request) {
            $q->whereIn('category_id', $request->cargory_filter);
            });
    }


$active_productQuery=$this->applyStockStatus($active_productQuery->where('product_active_status', 1)->orderBy('id','desc')->get());

// inactive product

$inactive_productQuery = Product::with(['category','subcategory','brand','product_specifications','product_variants.color'])
->where('seller_id', $seller->id);


    if ($request->search) {
    if ($request->type == '2') {
    // Search only English name
    $inactive_productQuery->where(function($q) use ($request) {
    $q->where('product_name_en', 'like', '%' . $request->search . '%')
    ->orWhere('product_name_ar', 'like', '%' . $request->search . '%');
    });

    }
} 

if ($request->type == '2') {
    
   
    
    if ($request->brand_filter) {
        $inactive_productQuery->where(function($q) use ($request) {
            $q->whereIn('brand_id', $request->brand_filter);
            });
    }
}

if ($request->cargory_filter) {
    $inactive_productQuery->where(function($q) use ($request) {
        $q->whereIn('category_id', $request->cargory_filter);
        });
}

$inactive_productQuery=$this->applyStockStatus($inactive_productQuery->where('product_active_status', 0)->orderBy('id','desc')->get());

    // if ($productQuery->isEmpty()) {
    //     return ['status'=>'success','message'=>'No Product found','data'=>[]];
    // }
    
    return [
        'status' => 'success',
        'message' => 'All Product Data Fetched Successfully',
        'data' => [
          
            'all_product_count' => $productQuery->count(),
            'active_product_count'   => $active_productQuery->count(),
            'inactive_product_count' => $inactive_productQuery->count(),

            'all_product_data' => $productQuery,
            'active_product'   => $active_productQuery,
            'inactive_product' => $inactive_productQuery
        ]
    ];
}






public function single_product_details_fetch($request){
        
    $product_data=  product::with('seller_details.store_info','brand','category','subcategory','product_specifications','product_variants.color','product_variants.size')->where('id',$request->product_id)->first();
    
    if (!$product_data) {
        return ['status'=>'error','message'=>"No product id is invalid",'data'=>(object)[]];
    }

    $new_color=[];

    foreach($product_data->product_variants as $key1=>$val){


      $new_data= [
        'product_id'=>$val->product_id,
        'color_id'=>$val->color->id,
        'color'=>$val->color->hex_code,
        'size_id'=>$val->size->id,
        'size'=>$val->size->name,
        'actual_price'=>$val->actual_price,
        'discount_type'=>$val->discount_type,
        'discount_value'=>$val->discount_value,
        'final_price'=>$val->final_price,

        'variant_image'=>$val->variant_image,
        'bust'=>$val->bust,
        'waist'=>$val->waist,
        'hip'=>$val->hip,
        'shoulder'=>$val->shoulder,
        'sleeve_length'=>$val->sleeve_length,
        'length'=>$val->length,
        'total_stock'=>$val->total_stock,
        'sku'=>$val->sku,
        // 'sku_threshold_value'=>$val->sku_threshold_value,

      ];

      if (!isset($new_color[$val->color->hex_code])) {
        $new_color[$val->color->hex_code] = [];
    }

    $new_color[$val->color->hex_code][] = $new_data;  
 
    }

    if($product_data){

    $product_data->ColorPriceCombination=$new_color;

    }

          
    return ['status'=>'success','message'=>'single product detaile fetch successfully','data'=>$product_data];
        }


// product Status Active and Inactive

    public function product_status_active_inactive($request){

        $product_data=  product::with('product_specifications','product_variants')->where('id',$request->product_id)->first();
        
        if (!$product_data) {
            return ['status'=>'error','message'=>"No product id is invalid",'data'=>(object)[]];
        }

        if($product_data->product_active_status==0){
            $msg="Product Active Successfully";
            $value=1;
        }else{
            $msg="Product Deactive Successfully";
            $value=0;
        }

        $product_data->update(['product_active_status'=>$value]);
                
        return ['status'=>'success','message'=>$msg,'data'=>$product_data];
            }


            // product delete



    public function product_delete_code($request){
        
        $product_data=  product::with('product_specifications','product_variants')->where('id',$request->product_id)->first();

        
        if (!$product_data) {
            return ['status'=>'error','message'=>"No product id is invalid",'data'=>(object)[]];
        }

        $product_data->delete();
                
        return ['status'=>'success','message'=>'Product delete Successfully','data'=>$product_data];
            }


// New add product copy Code


public function AddProduct1($request){
        

    try{
    
    
    DB::beginTransaction();
    
    // FILTER PRODUCT TABLE DATA SEPRATE
    
    $seller_details=seller::with('store_info','subcription_plan')->where('id',$request->seller_id)->first();
    
        if($seller_details->admin_verify!=='2'){
            return ['status'=>'error','message'=>"You store Didn't Accept or reject By Admin",'data'=>[]];    
        }
    

    $product=[
    'seller_id'=>$request->seller_id,
    'store_id'=>$seller_details->store_info->id,
    'category_id' => $request->category_id,
    'subcategory_id' => $request->subcategory_id,
    'brand_id' => $request->brand_id,
    'other_en' => $request->other_en,
    'other_ar' => $request->other_ar,
    
    'product_name_en' => $request->product_name_en,
    'product_name_ar' => $request->product_name_ar,
         
    'description_en' => $request->description_en,
    'description_ar' => $request->description_ar,
            
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
    'product_active_status'=>1
    ];
    
    
    $product_data=  product::create($product);
    
    $product_id= $product_data->id;
    
    // specification 
    
    foreach($request->product_spe_en as $key=>$val){
    
    $specification_array=[
        // specification
    'product_id'=> $product_id,
    'name_en'=> $request->product_spe_en[$key],
    'feature_en'=> $request->product_spe_feature_en[$key],
    'name_ar'=> $request->product_spe_ar[$key],
    'feature_ar'=> $request->product_spe_feature_ar[$key],
    ];
    
    $product_data=  ProductSpecification::create($specification_array);
    
    }
    
    // variation code 
    
    
    // foreach ($request['product_variation'] as $variation) {



    foreach($request->Product_data as $key=>$val){

    

      foreach($val['product_variation'] as $key1=>$product_variation){
        
                
            $variation_array=[
            'product_id'=> $product_id,
                // product vartion start
            'variant_image' => $val['variant_image'],
            'color_id' => $val['color_id'],
            'size_id' => $product_variation['size_id'],
            
            'total_stock' => $product_variation['total_stock'],
            'sku' => $product_variation['sku'],
            // 'sku_threshold_value' => $request->sku_threshold_value[$key],
            'actual_price' => $product_variation['actual_price'],
            'discount_type' => $product_variation['discount_type'],
            'discount_value' => $product_variation['discount_value'],
            'final_price' => $product_variation['final_price'],
            
            // product vartion end  
            ];
    
    if($request->category_id==2){
    
        $variation_array['bust']= $product_variation['bust']??null; // only provide when category is women
        $variation_array['waist']= $product_variation['waist']??null; // only provide when category is women
        $variation_array['hip']= $product_variation['hip']??null;  // only provide when category is women
        $variation_array['shoulder']= $product_variation['shoulder']??null; // only provide when category is women
        $variation_array['sleeve_length']= $product_variation['sleeve_length']??null; // only provide when category is women
        $variation_array['length']= $product_variation['length']??null; // only provide when category is women      

    }
    

    $product_data=  ProductVariant::create($variation_array);

    }

    }
    
    
    // if ($product->isEmpty()) {
    //         return ['status'=>'success','message'=>"No Product found",'data'=>[]];
    //     // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
    // }
    
    
    $request_data=(object) [
        'product_id'=>$product_id,    
    ];
    
    
    $add_product_data=$this->single_product_details_fetch($request_data);
    
    DB::commit();
    
    return ['status'=>'success','message'=>"Product Add successfully",'data'=>$add_product_data['data']];
    
    } 
    catch (\Exception $e) {
        return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];
    
    }
    
    }
    



// Edit-Product 
public function edit_Product1($request){  /// for api 
        
    try{

        DB::beginTransaction();

        // FILTER PRODUCT TABLE DATA SEPRATE

       $seller_details= $this->Seller_Plan_check($request->seller_id);

        // $seller_details=seller::with('store_info','subcription_plan')->where('id',$request->seller_id)->first();

        //     if($seller_details->admin_verify!=='2'){
        //         return ['status'=>'error','message'=>"You store Didn't Accept or reject By Admin",'data'=>[]];    
        //     }

        $match=[
            'id'=>$request->product_id
        ];

        $product=[
        'seller_id'=>$request->seller_id,
        'store_id'=>$seller_details->store_info->id,
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'brand_id' => $request->brand_id,
        'other_en' => $request->other_en,
        'other_ar' => $request->other_ar,

        'product_name_en' => $request->product_name_en,
        'product_name_ar' => $request->product_name_ar,
            
        'description_en' => $request->description_en,
        'description_ar' => $request->description_ar,
                
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


        $product_data=  product::UpdateOrCreate($match,$product);

        $product_id= $request->product_id;
        
        // old specification delete
        ProductSpecification::where('product_id',$product_id)->delete();

        foreach($request->product_spe_en as $key=>$val){

        $specification_array=[
            // specification
        'product_id'=> $product_id,
        'name_en'=> $request->product_spe_en[$key],
        'feature_en'=> $request->product_spe_feature_en[$key],
        'name_ar'=> $request->product_spe_ar[$key],
        'feature_ar'=> $request->product_spe_feature_ar[$key],
        ];

        $product_data=  ProductSpecification::updateOrCreate($specification_array);

        }

        // variation code 
        // OLD variants
        $existingVariants = ProductVariant::where('product_id', $product_id)
        ->pluck('id')
        ->toArray();

        $newVariantIDs = [];

    foreach($request->Product_data as $key=>$val){

       foreach($val['product_variation'] as $key1=>$product_variation){
          

        $match=[
        'product_id'=> $product_id,
        'color_id' => $val['color_id'],
        'size_id' => $product_variation['size_id'],
    
    
    ];

        $variation_array=[
            'product_id'=> $product_id,
                // product vartion start
            'variant_image' => $val['variant_image'],
            'color_id' => $val['color_id'],
            'size_id' => $product_variation['size_id'],
            
            'total_stock' => $product_variation['total_stock'],
            'sku' => $product_variation['sku'],
            // 'sku_threshold_value' => $request->sku_threshold_value[$key],
            'actual_price' => $product_variation['actual_price'],
            'discount_type' => $product_variation['discount_type'],
            'discount_value' => $product_variation['discount_value'],
            'final_price' => $product_variation['final_price'],
            
            // product vartion end  
            ];
    
    if($request->category_id==2){
    
        $variation_array['bust']= $product_variation['bust']??null; // only provide when category is women
        $variation_array['waist']= $product_variation['waist']??null; // only provide when category is women
        $variation_array['hip']= $product_variation['hip']??null;  // only provide when category is women
        $variation_array['shoulder']= $product_variation['shoulder']??null; // only provide when category is women
        $variation_array['sleeve_length']= $product_variation['sleeve_length']??null; // only provide when category is women
        $variation_array['length']= $product_variation['length']??null; // only provide when category is women      

    }
        $product_data=  ProductVariant::updateOrCreate($match,$variation_array);

        $newVariantIDs[] = $product_data->id;
        
    }

    }

        // DELETE VARIANTS NOT INCLUDED IN FORM
        ProductVariant::where('product_id', $product_id)
            ->whereNotIn('id', $newVariantIDs)
            ->delete();

        // if ($product->isEmpty()) {
        //         return ['status'=>'success','message'=>"No Product found",'data'=>[]];
        //     // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
        // }


        $request_data=(object) [
            'product_id'=>$product_id,    
        ];


        $add_product_data=$this->single_product_details_fetch($request_data);

        DB::commit();

        return ['status'=>'success','message'=>"Product Update successfully",'data'=>$add_product_data['data']];

} 
catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];

}

}




public function AddProduct_web($request){
        

    try{
    
    
    DB::beginTransaction();
    
    // FILTER PRODUCT TABLE DATA SEPRATE
    
    $seller_details=seller::with('store_info','subcription_plan')->where('id',$request->seller_id)->first();
    
        if($seller_details->admin_verify!=='2'){
            return ['status'=>'error','message'=>"You store Didn't Accept or reject By Admin",'data'=>[]];    
        }

        $subscription = SellerSubcriptionPlanBuy::where('seller_id', $request->seller_id)
            ->where('payment_status', '1')
            ->where('is_expired', '0')
            ->where('plan_end_date', '>=', Carbon::today())
            ->first();

        if (!$subscription) {
            return [
                'status' => 'failed',
                'message' => "You have no active plan",
                'data' => []
            ];
        }

        //  CHECK PRODUCT LIMIT
        if ($subscription->product_type == '0') {

            if ($subscription->no_of_products <= '0') {
                return [
                    'status' => 'error',
                    'message' => "Your monthly limit for product addition has reached, you can't add more products this month",
                    'data' => []
                ];
            }
        }
    


    $product=[
    'seller_id'=>$request->seller_id,
    'store_id'=>$seller_details->store_info->id,
    'category_id' => $request->category_id,
    'subcategory_id' => $request->subcategory_id,
    'brand_id' => $request->brand_id,
    'other_en' => $request->other_en,
    'other_ar' => $request->other_ar,
    
    'product_name_en' => $request->product_name_en,
    'product_name_ar' => $request->product_name_ar,
         
    'description_en' => $request->description_en,
    'description_ar' => $request->description_ar,
            
    'min_card_quantity'=> $request->min_card_quantity,
    'max_card_quantity'=> $request->max_card_quantity,
    'product_return'=> $request->product_return, // 0 Not return 1 return Availble 
    'return_days'=> $request->return_days,
    'product_exchangable'=> $request->product_exchangable,  // 0 not 1 yes
    'exchangable_days'=> $request->exchangable_days,
    'review_rating'=> $request->review_rating, // 0 not 1 yes
    'affiliated_product'=> $request->affiliated_product, // // 0 not 1 yes
    'affiliated_commission'=>$request->affiliated_commission,
    'customized_product'=> $request->customized_product, // // 0 not 1 yes
    'ready_to_ship'=> $request->ready_to_ship, // // 0 not 1 yes
    'cash_on_delivery'=> $request->cash_on_delivery, // // 0 not 1 yes
    'upload_size_chart'=> $request->upload_size_chart,
    'product_active_status'=>1
    ];
    
    
    $product_data=  product::create($product);
    
    $product_id= $product_data->id;
    
    // specification 
    
    foreach($request->product_spe_en as $key=>$val){
    
    $specification_array=[
        // specification
    'product_id'=> $product_id,
    'name_en'=> $request->product_spe_en[$key],
    'feature_en'=> $request->product_spe_feature_en[$key],
    'name_ar'=> $request->product_spe_ar[$key],
    'feature_ar'=> $request->product_spe_feature_ar[$key],
    ];
    
    $product_data=  ProductSpecification::create($specification_array);
    
    }
    
    // variation code 
    
    
    // foreach ($request['product_variation'] as $variation) {



foreach($request->color_id as $key=>$val){

    foreach($request->size_id[$key] as $size_key=>$size_data){            
        
    $variation_array=[
    'product_id'=> $product_id,
    // product vartion start
    'variant_image' => $request->variant_image[$key],
    'color_id' => $request->color_id[$key],


    'size_id' => $size_data,
    'total_stock' => $request->total_stock[$key][$size_key],
    'sku' => $request->sku[$key][$size_key],
    // 'sku_threshold_value' => $request->sku_threshold_value[$key],
    'actual_price' => $request->actual_price[$key][$size_key],
    'discount_type' => $request->discount_type[$key][$size_key],
    'discount_value' => $request->discount_value[$key][$size_key],
    'final_price' => $request->final_price[$key][$size_key],
    
    // product vartion end  
    ];
    
    if($request->category_id==2){
    
        $variation_array['bust']= $request->bust[$key][$size_key]??null; // only provide when category is women
        $variation_array['waist']= $request->waist[$key][$size_key]??null; // only provide when category is women
        $variation_array['hip']= $request->hip[$key][$size_key]??null;  // only provide when category is women
        $variation_array['shoulder']= $request->shoulder[$key][$size_key]??null; // only provide when category is women
        $variation_array['sleeve_length']= $request->sleeve_length[$key][$size_key]??null; // only provide when category is women
        $variation_array['length']= $request->length[$key][$size_key]??null; // only provide when category is women      
        }
    
        $product_data=  ProductVariant::create($variation_array);
    }

}
    
    
    // if ($product->isEmpty()) {
    //         return ['status'=>'success','message'=>"No Product found",'data'=>[]];
    //     // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
    // }
    
    
    $request_data=(object) [
        'product_id'=>$product_id,    
    ];
    
    
    $add_product_data=$this->single_product_details_fetch($request_data);
    
    DB::commit();
    
    return ['status'=>'success','message'=>"Product Add successfully",'data'=>$add_product_data['data']];
    
    } 
    catch (\Exception $e) {
        return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];
    
    }
    
    }
    



public function single_product_details_fetchweb($request){
        
    $product_data=  product::with('seller_details.store_info','brand','category','product_specifications','product_variants.color','product_variants.size')->where('id',$request->product_id)->first();
    
    if (!$product_data) {
        return ['status'=>'error','message'=>"No product id is invalid",'data'=>(object)[]];
    }

    $new_color=[];
    $variation_Group=[];

    foreach($product_data->product_variants as $key1=>$val){

      $new_data= [
        'product_id'=>$val->product_id,
        'color_id'=>$val->color->id,
        'color'=>$val->color->hex_code,
        'size_id'=>$val->size->id,
        'size'=>$val->size->name,
        'actual_price'=>$val->actual_price,
        'discount_type'=>$val->discount_type,
        'discount_value'=>$val->discount_value,
        'final_price'=>$val->final_price,

        'variant_image'=>$val->variant_image,
        'bust'=>$val->bust,
        'waist'=>$val->waist,
        'hip'=>$val->hip,
        'shoulder'=>$val->shoulder,
        'sleeve_length'=>$val->sleeve_length,
        'length'=>$val->length,
        'total_stock'=>$val->total_stock,
        'sku'=>$val->sku,
        // 'sku_threshold_value'=>$val->sku_threshold_value,

      ];

      if (!isset($new_color[$val->color->hex_code])) {
        $new_color[$val->color->hex_code] = [];
    }

    $new_color[$val->color->hex_code][] = $new_data;  

    }

    if($product_data){

        $product_data->ColorPriceCombination=$new_color;
        
    }


    // Variation Code start Here 

    $product_variation = ProductVariant::where('product_id', $request->product_id)
    ->with('color', 'size')
    ->get()
    ->groupBy('color_id');

$variation_array = [];

foreach ($product_variation as $color_id => $items) {

    $in_variation_array = [];

    foreach ($items as $index => $val2) {

        if ($index == 0) {
            // First item will act as main record
            $variation_array[$color_id] = $val2;
            $variation_array[$color_id]->otherVariation = [];
        } else {
            // Correct array merge: assign back
        }

        $in_variation_array[] = $val2;
        

    }

    // Assign merged items to `otherVariation`
    if (!empty($in_variation_array)) {
        $variation_array[$color_id]->otherVariation = $in_variation_array;
    }
}

    $product_data->variation_Group=$variation_array;

          
    return ['status'=>'success','message'=>'single product detaile fetch successfully','data'=>$product_data];
        }



        



public function edit_Product_web($request){

    try{

    
        DB::beginTransaction();
        
        // FILTER PRODUCT TABLE DATA SEPRATE
        
        $seller_details=seller::with('store_info','subcription_plan')->where('id',$request->seller_id)->first();
        
            if($seller_details->admin_verify!=='2'){
                return ['status'=>'error','message'=>"You store Didn't Accept or reject By Admin",'data'=>[]];    
            }

            $product_id= $request->product_id;

            $match=[
                'id'=>$product_id
            ];
        
            $product=[
                'id'=>$product_id,
                'seller_id'=>$request->seller_id,
                'store_id'=>$seller_details->store_info->id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'brand_id' => $request->brand_id,
                'other_en' => $request->other_en,
                'other_ar' => $request->other_ar,
        
                'product_name_en' => $request->product_name_en,
                'product_name_ar' => $request->product_name_ar,
                    
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                        
                'min_card_quantity'=> $request->min_card_quantity,
                'max_card_quantity'=> $request->max_card_quantity,
                'product_return'=> $request->product_return, // 0 Not return 1 return Availble 
                'return_days'=> $request->return_days,
                'product_exchangable'=> $request->product_exchangable,  // 0 not 1 yes
                'exchangable_days'=> $request->exchangable_days,
                'review_rating'=> $request->review_rating, // 0 not 1 yes
                'affiliated_product'=> $request->affiliated_product, // // 0 not 1 yes

                'affiliated_commission'=>$request->affiliated_commission,

                'customized_product'=> $request->customized_product, // // 0 not 1 yes
                'ready_to_ship'=> $request->ready_to_ship, // // 0 not 1 yes
                'cash_on_delivery'=> $request->cash_on_delivery, // // 0 not 1 yes
                'upload_size_chart'=> $request->upload_size_chart
                ];
        
            $product_data=  product::UpdateOrCreate($match,$product);     
        
        // old specification delete
        ProductSpecification::where('product_id',$product_id)->delete();


        // specification  code start
        foreach($request->product_spe_en as $key=>$val){

        $specification_array=[
            // specification
        'product_id'=> $product_id,
        'name_en'=> $request->product_spe_en[$key],
        'feature_en'=> $request->product_spe_feature_en[$key],
        'name_ar'=> $request->product_spe_ar[$key],
        'feature_ar'=> $request->product_spe_feature_ar[$key],
        ];

        $product_data=  ProductSpecification::create($specification_array);

        }
        
        // variation code 
        
        $existingVariants = ProductVariant::where('product_id', $product_id)
        ->pluck('id')
        ->toArray();
        
        $newVariantIDs = [];


foreach($request->color_id as $key=>$val){



    if (!isset($request->size_id[$key])) {
        continue; // skip if no size for this color
    }

    foreach($request->size_id[$key] as $size_key=>$size_data){            
        
    $match=[
        'product_id'=> $product_id,
        'color_id' => $request->color_id[$key],
        'size_id' => $size_data,
        ];

    $variation_array=[
    'product_id'=> $product_id,
    // product vartion start
    'variant_image' => $request->variant_image[$key],
    'color_id' => $request->color_id[$key],



    'size_id' => $size_data,
    'total_stock' => $request->total_stock[$key][$size_key],
    'sku' => $request->sku[$key][$size_key],
    // 'sku_threshold_value' => $request->sku_threshold_value[$key],
    'actual_price' => $request->actual_price[$key][$size_key],
    'discount_type' => $request->discount_type[$key][$size_key],
    'discount_value' => $request->discount_value[$key][$size_key],
    'final_price' => $request->final_price[$key][$size_key],
    
    // product vartion end  
    ];
    
    if($request->category_id==2){
    
        $variation_array['bust']= $request->bust[$key][$size_key]??null; // only provide when category is women
        $variation_array['waist']= $request->waist[$key][$size_key]??null; // only provide when category is women
        $variation_array['hip']= $request->hip[$key][$size_key]??null;  // only provide when category is women
        $variation_array['shoulder']= $request->shoulder[$key][$size_key]??null; // only provide when category is women
        $variation_array['sleeve_length']= $request->sleeve_length[$key][$size_key]??null; // only provide when category is women
        $variation_array['length']= $request->length[$key][$size_key]??null; // only provide when category is women      
        }
    
        // dump($variation_array);
        

        $product_data=  ProductVariant::updateOrCreate($match,$variation_array);
        $newVariantIDs[] = $product_data->id;

    }
    
}

   // DELETE VARIANTS NOT INCLUDED IN FORM
   ProductVariant::where('product_id', $product_id)
   ->whereNotIn('id', $newVariantIDs)
   ->delete();
        
        
        // if ($product->isEmpty()) {
        //         return ['status'=>'success','message'=>"No Product found",'data'=>[]];
        //     // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
        // }
        
        
        $request_data=(object) [
            'product_id'=>$product_id,    
        ];
        
        $add_product_data=$this->single_product_details_fetch($request_data);
        
        DB::commit();
        
        return ['status'=>'success','message'=>"Product Update successfully",'data'=>$add_product_data['data']];
        
        } 
        catch (\Exception $e) {
            return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];
        
        }


    }



public function Update_Product_Inventory($request){

    try{

    
        DB::beginTransaction();
        
        // FILTER PRODUCT TABLE DATA SEPRATE
        
        $seller_details=seller::with('store_info','subcription_plan')->where('id',$request->seller_id)->first();

        $match=[
        
        'product_id'=> $request->product_id,
        'id'=> $request->variation_id,
        ];

        $data=[
            'total_stock'=> $request->stock_quantity,  
        ];

        if($request->sku!==''){
            $data['sku']= $request->sku;
        }


    $update_inventory=  ProductVariant::where($match)->first();
    
    if($update_inventory){
        $update_inventory->update($data);
    }else{
        return ['status'=>'error','message'=>"Variation Id is Wrong",'data'=>(object)[]];
    }

    //   Update stock record in stock Table

    $inventory_record=[
        'user_type'=>'1',// seller
        'user_id'=>$seller_details->id,
        'product_id'=> $request->product_id,
        'total_stock'=>$request->stock_quantity,
        'sku'=> $request->sku,
    ];
    
    StockInventoryRecords::create($inventory_record);

        if($update_inventory){
            DB::commit();

        return ['status'=>'success','message'=>"Product Inventory Update successfully",'data'=>(object)[]];
      
        }
        
        
        } 
        catch (\Exception $e) {
            return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];
        
        }


    }

    



public function Update_affilate_commission_Inventory($request){

    try{

    
        DB::beginTransaction();
        
        // FILTER PRODUCT TABLE DATA SEPRATE
        
        $seller_details=seller::with('store_info','subcription_plan')->where('id',$request->seller_id)->first();

        if($seller_details){
        $seller_details->update(['affilate_commission'=> $request->affilate_commission]);

        product::where('affiliated_product','1')->where('seller_id',$request->seller_id)->update(['affiliated_commission'=>$request->affilate_commission]); // update Affilated commision on product table

        }

        if($seller_details){
        
        DB::commit();
        
        return ['status'=>'success','message'=>"Affilate Commission Update successfully",'data'=>(object)[]];
      
        }
        
        
        } 
        catch (\Exception $e) {
            return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];
        
        }


    }


    




public function View_seller_profile($request){

    try{
    
        $seller_details=seller::with('store_info.country_info','store_info.dialer_info','seller_bank_details','subcription_plan','owner_document','store_document')->where('id',$request->seller_id)->first();

        if($seller_details){
        
        return ['status'=>'success','message'=>"seller details fetch Successfully",'data'=>$seller_details];
      
        }else{
            return ['status'=>'error','message'=>"Seller token is Invalid",'data'=>(object)[]];
        }
        
        
        } 
        catch (\Exception $e) {
            return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];
        
        }


    }



    public function profile_store_information_insert($request){

       
        // Update seller details 

        $match_seller=[
            'id' => $request->user_id
          ];

          if($request->profile_pic){
            $seller_information['profile_pic'] = $request->profile_pic;
          }

        //   $fullname=explode(' ',$request->full_name);

        //   if($fullname){

            $seller_information['first_name'] = $request->first_name;
            $seller_information['last_name'] = $request->last_name;
        //   }
    
         seller::Updateorcreate($match_seller,$seller_information);
         
        // update store details

        $match=[
            'seller_id' => $request->user_id
          ];

        $data_insert=[
          'seller_id' => $request->user_id,
          'store_image' => $request->store_image ,
          'store_name' => $request->store_name ,
          'country'=>$request->country ,
          "store_address"=>$request->store_address ,
          'address_line1'=>$request->address_line1 ,
          'address_line2'=>$request->address_line2 ,
          'country_code' => $request->country_code,
          "store_phone"=>$request->store_phone ,
          'store_mail_id'=>$request->store_mail_id ,
          'bio'=>$request->bio,
          'let'=>$request->let,
          'long'=>$request->long
        ];
  
       $store_information=sellerStoreInformation::Updateorcreate($match,$data_insert);
    
        if($store_information){
        // $get_seller_details=  seller::where('id',$request->user_id)->first();
  
        // seller::where('id',$request->user_id)->update(['store_information'=>'1']); // update store information

        CreateNotification([
                    'sender_id' => 1, 
                    'sender_type' => 1, 

                    'receiver_id' => $request->user_id,
                    'receiver_type' => 3, 

                    'title_english' => 'Store Info',
                    'description_english' => "Your store {$request->store_name} information has been updated",

                    'notification_type' => 'store_info_update'
                ]);
        
        return ['status'=>'success','message'=>"Profile details updated succesfully",'data'=>$store_information];            
  
          }else{
            return ['status'=>'error','message'=>"Otp is invalid",'data'=>(object)[]];                
          }
    
        }
  


    public function Staffprofile_store_information_insert($request){

       
        // Update seller details 

        $match_seller=[
            'id' => $request->user_id
          ];

          if($request->profile_pic){
            $seller_information['profile_pic'] = $request->profile_pic;
          }

        //   $fullname=explode(' ',$request->full_name);

        //   if($fullname){

            $seller_information['first_name'] = $request->first_name;
            $seller_information['last_name'] = $request->last_name;
        //   }
    
         seller::Updateorcreate($match_seller,$seller_information);
        
        CreateNotification([
                    'sender_id' => 1, 
                    'sender_type' => 1, 

                    'receiver_id' => $request->user_id,
                    'receiver_type' => 3, 

                    'title_english' => 'Store Info',
                    'description_english' => "Your store {$request->store_name} information has been updated",

                    'notification_type' => 'store_info_update'
                ]);
        
        return ['status'=>'success','message'=>"Staff Profile details updated succesfully",'data'=>''];            
  
    
        }
  
  
    
    public function store_bank_details_update($request){

            $match=[
              'user_id' => $request->user_id
            ];
      
            $bank_data=[
              'user_id' => $request->user_id,
              'type'=> '1',
              'account_type' => strVal($request->account_type),
              'iban' => $request->iban ,
              'swift'=>$request->swift ,
              "bank_name"=>$request->bank_name ,
              'account_holder_name'=>$request->account_holder_name ,
              'upload_proof'=>$request->upload_proof
            ];
      
           $store_information=Bankdetails::Updateorcreate($match,$bank_data);
        
            if($store_information){
                $store_details = sellerStoreInformation::where('seller_id', $request->user_id)->first();
                //dd($store_details);
                $storeName = $store_details->store_name ?? '';
                //dd($storeName);
    
            //   seller::where('id',$request->user_id)->update(['bank_information'=>'1']); // update store information
            CreateNotification([
                    'sender_id' => 1, 
                    'sender_type' => 1, 

                    'receiver_id' => $request->user_id,
                    'receiver_type' => 3, 

                    'title_english' => 'Store Info',
                    'description_english' => "Your store {$storeName} bank details has been updated",

                    'notification_type' => 'store_bank_details_update'
                ]);
      
                return ['status'=>'success','message'=>"Document and Bank details Save succesfully",'data'=>$store_information];            
      
              }else{
                return ['status'=>'error','message'=>"Otp is invalid",'data'=>(object)[]];                
              }
        
            }
    




}