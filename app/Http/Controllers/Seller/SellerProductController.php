<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;

use App\Models\{ Brand,color,size};


use App\Services\SellerProductService;

use Auth;

use Validator;

use App\Rules\MatchArrayProductSpecification;
use App\Rules\MatchArrayProductVariation;

use App\Helpers\ApiResponse;

use Illuminate\Validation\Rule;




class SellerProductController extends Controller
{

    public function __construct(SellerProductService $SellerProductService){
        $this->SellerProductService=$SellerProductService;
    }

    public function products(Request $request){

        $seller_details=  Auth::guard('seller')->user();
        $seller_id=$seller_details->id;
      
        $category = Category::orderBy('id', 'asc')->get();
        $brand = Brand::all();
    
        
        if(isset($request->cargory_filter)){
            $cargory_filter= [$request->cargory_filter];
        }else{
            $cargory_filter='';
        }

        if(isset($request->brand_filter)){
            $brand_filter= [$request->brand_filter];
        }else{
            $brand_filter='';
        }
        
        $request_data=(object) [
        'seller_id'=>$seller_id,
        'search' =>$request->search,
        'type' =>$request->type, //  0 all product 1 active product 2 inactive product 
        'cargory_filter' =>$cargory_filter,
        'brand_filter' =>$brand_filter,    
        ];
    
      $all_records= $this->SellerProductService->AllProduct($request_data);

      
      $data=$all_records['data'];

    return view('dealer.product.product',compact('category','brand','data'));

    }


public function product_status_active_inactive(Request $request){

    $request_data=(object) [
    'product_id'=>$request->id,
    
    ];

  $data=  $this->SellerProductService->product_status_active_inactive($request_data);

  return $data;

}




public function Add_product(){

    $category = Category::orderBy('id', 'asc')->get();
    $brand = Brand::all();
    $color = color::all();
    $size = size::all();

    return view('dealer.product.Add_product',compact('category','brand','color','size'));
}


public function Add_product_code(Request $request){

    $seller_details=Auth::guard('seller')->user();
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
            'product_spe_en'           => ['required', 'array', new MatchArrayProductSpecification],
            'product_spe_en.*'         => ['required'], // ← catch null & empty value

            'product_spe_feature_en'   => ['required', 'array',new MatchArrayProductSpecification],
            'product_spe_feature_en.*' => ['required'],

            'product_spe_ar'           => ['required', 'array',new MatchArrayProductSpecification],
            'product_spe_ar.*'         => ['required'],

            'product_spe_feature_ar'   => ['required', 'array',new MatchArrayProductSpecification],
            'product_spe_feature_ar.*' => ['required'],


          // product vartion start
          'variant_image' => ['required', 'array'],
          'color_id' => ['required', 'array'],
          'size_id' => ['required', 'array', ],
          'color_id.*' => ['required','exists:colors,id'],
          'size_id.*' => ['required','exists:sizes,id'],

          'total_stock' => ['required', 'array'],
          'sku' => ['required', 'array'],
          'sku_threshold_value' => ['required', 'array'],
          'actual_price' => ['required', 'array'],
          'discount_type' => ['required', 'array'],
          'discount_value' => ['required', 'array'],
          'final_price' => ['required', 'array'],

          'variant_image.*' => ['required'],
         'total_stock.*' => ['required'],
          'sku.*' => ['required'],
          'sku_threshold_value.*' => ['required'],
          'actual_price.*' => ['required'],
          'discount_type.*' => ['required'],
          'discount_value.*' => ['required'],
          'final_price.*' => ['required'],


          // product vartion end
          
          'min_card_quantity'=>'required',
          'max_card_quantity'=>'required',
          'product_return'=>'required|in:0,1', // 0 Not return 1 return Availble 
          'return_days'=> 'required_if:product_return,1|nullable|integer',
          'product_exchangable'=>'required|in:0,1',  // 0 not 1 yes
          'exchangable_days'=>'required_if:product_exchangable,1|nullable|integer',
          'review_rating'=>'required|in:0,1', // 0 not 1 yes
          'affiliated_product'=>'required|in:0,1', // // 0 not 1 yes
          'customized_product'=>'required|in:0,1', // // 0 not 1 yes
          'ready_to_ship'=>'required|in:0,1', // // 0 not 1 yes
          'cash_on_delivery'=>'required|in:0,1', // // 0 not 1 yes
          'upload_size_chart'=>'required',


        //   if The category is women
         // MAIN ARRAY FIELDS (required only if category_id = 2)
    'bust'           => [Rule::requiredIf($request->category_id == 2), 'array'],
    'waist'          => [Rule::requiredIf($request->category_id == 2), 'array'],
    'hip'            => [Rule::requiredIf($request->category_id == 2), 'array'],
    'shoulder'       => [Rule::requiredIf($request->category_id == 2), 'array'],
    'sleeve_length'  => [Rule::requiredIf($request->category_id == 2), 'array'],
    'length'         => [Rule::requiredIf($request->category_id == 2), 'array'],

    // INNER ARRAY VALUES (apply required only if category_id = 2)
    'bust.*'           => [Rule::requiredIf($request->category_id == 2)],
    'waist.*'          => [Rule::requiredIf($request->category_id == 2)],
    'hip.*'            => [Rule::requiredIf($request->category_id == 2)],
    'shoulder.*'       => [Rule::requiredIf($request->category_id == 2)],
    'sleeve_length.*'  => [Rule::requiredIf($request->category_id == 2)],
    'length.*'         => [Rule::requiredIf($request->category_id == 2)], 
       
      ],[
        
            // Basic fields
            'category_id.required'       => 'Please select a category.',
            'category_id.exists'         => 'Selected category does not exist.',
            
            'subcategory_id.required'    => 'Please select a subcategory.',
            'subcategory_id.exists'      => 'Selected subcategory does not exist.',
        
            'brand_id.required'          => 'Please select a brand.',
            'brand_id.exists'            => 'Selected brand does not exist.',
        
            'other_en.required'          => 'Other (English) field is required.',
            'other_ar.required'          => 'Other (Arabic) field is required.',
        
            'product_name_en.required'   => 'Product name (English) is required.',
            'product_name_en.unique'     => 'This English product name is already taken.',
        
            'product_name_ar.required'   => 'Product name (Arabic) is required.',
            'product_name_ar.unique'     => 'This Arabic product name is already taken.',
        
            'description_en.required'    => 'Description (English) is required.',
            'description_ar.required'    => 'Description (Arabic) is required.',
        
            // Specifications
            'product_spe_en.required'           => 'English specifications are required.',
            'product_spe_en.array'              => 'English specifications must be an array.',
            'product_spe_en.*.required'         => 'Each English specification is required.',
        
            'product_spe_feature_en.required'   => 'English specification features are required.',
            'product_spe_feature_en.*.required' => 'Each English specification feature is required.',
        
            'product_spe_ar.required'           => 'Arabic specifications are required.',
            'product_spe_ar.*.required'         => 'Each Arabic specification is required.',
        
            'product_spe_feature_ar.required'   => 'Arabic specification features are required.',
            'product_spe_feature_ar.*.required' => 'Each Arabic specification feature is required.',
        
            // Product Variant Fields
            'variant_image.required'      => 'Variant images are required.',
            'variant_image.*.required'    => 'Each variant image is required.',
        
            'color_id.required'           => 'Color field is required.',
            'color_id.array'              => 'Color field must be an array.',
            'color_id.*.required'         => 'Each color is required.',
            'color_id.*.distinct'         => 'Duplicate colors are not allowed.',
            'color_id.*.exists'           => 'Selected color does not exist.',
        
            'size_id.required'            => 'Size field is required.',
            'size_id.array'               => 'Size field must be an array.',
            'size_id.*.required'          => 'Each size is required.',
            'size_id.*.exists'            => 'Selected size does not exist.',
            'size_id.*.distinct'          => 'Duplicate sizes are not allowed.',
        
            'total_stock.required'        => 'Stock field is required.',
            'total_stock.*.required'      => 'Each stock value is required.',
        
            'sku.required'                => 'SKU field is required.',
            'sku.*.required'              => 'Each SKU is required.',
        
            'sku_threshold_value.required'   => 'SKU threshold field is required.',
            'sku_threshold_value.*.required' => 'Each SKU threshold value is required.',
        
            'actual_price.required'       => 'Actual price is required.',
            'actual_price.*.required'     => 'Each actual price is required.',
        
            'discount_type.required'      => 'Discount type is required.',
            'discount_type.*.required'    => 'Each discount type is required.',
        
            'discount_value.required'     => 'Discount value is required.',
            'discount_value.*.required'   => 'Each discount value is required.',
        
            'final_price.required'        => 'Final price is required.',
            'final_price.*.required'      => 'Each final price is required.',
        
            // General Product Details
            'min_card_quantity.required'  => 'Minimum cart quantity is required.',
            'max_card_quantity.required'  => 'Maximum cart quantity is required.',
        
            // Return
            'product_return.required'     => 'Please choose if product is returnable.',
            'product_return.in'           => 'Invalid return option.',
            'return_days.required_if'     => 'Return days are required when product is returnable.',
            'return_days.integer'         => 'Return days must be a number.',
        
            // Exchange
            'product_exchangable.required'     => 'Please choose if product is exchangeable.',
            'product_exchangable.in'           => 'Invalid exchange option.',
            'exchangable_days.required_if'     => 'Exchangable days are required when product is exchangeable.',
            'exchangable_days.integer'         => 'Exchangable days must be a number.',
        
            // Review
            'review_rating.required'      => 'Please choose review rating option.',
            'review_rating.in'            => 'Invalid rating option.',
        
            // Affiliated
            'affiliated_product.required' => 'Please choose affiliated product option.',
            'affiliated_product.in'       => 'Invalid affiliated option.',
        
            // Customized
            'customized_product.required' => 'Please choose customized product option.',
            'customized_product.in'       => 'Invalid customized option.',
        
            // Shipping
            'ready_to_ship.required'      => 'Ready to ship field is required.',
            'ready_to_ship.in'            => 'Invalid ready-to-ship option.',
        
            // COD
            'cash_on_delivery.required'   => 'Cash on delivery option is required.',
            'cash_on_delivery.in'         => 'Invalid cash on delivery option.',
        
            // Size Chart
            'upload_size_chart.required'  => 'Size chart is required.',
        
            // Women Category (category_id = 2)
            'bust.required'               => 'Bust field is required for women category.',
            'bust.*.required'             => 'Each bust value is required.',
        
            'waist.required'              => 'Waist field is required for women category.',
            'waist.*.required'            => 'Each waist value is required.',
        
            'hip.required'                => 'Hip field is required for women category.',
            'hip.*.required'              => 'Each hip value is required.',
        
            'shoulder.required'           => 'Shoulder field is required for women category.',
            'shoulder.*.required'         => 'Each shoulder value is required.',
        
            'sleeve_length.required'      => 'Sleeve length is required for women category.',
            'sleeve_length.*.required'    => 'Each sleeve length value is required.',
        
            'length.required'             => 'Length field is required for women category.',
            'length.*.required'           => 'Each length value is required.',
        
      ]);


     $validate->after(function ($validate) use ($request) {

    $colors = $request->color_id;
    $sizes  = $request->size_id;

    // Group sizes by color
    $grouped = [];

    foreach ($colors as $i => $color) {
        $size = $sizes[$i] ?? null;
        $grouped[$color][] = $size;
    }

    // Validate: for same color → sizes must be unique
    foreach ($grouped as $color => $sizesForColor) {
        if (count($sizesForColor) !== count(array_unique($sizesForColor))) {
            $validate->errors()->add(
                'size_id_'.$color,
                "For color sizes must be different."
            );
        }
    }
});

      
      if($validate->fails()){
          return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
         }

         
     if($request->category_id=='2'){   // if the category is women Then These field is manditary

      $validate = Validator::make($request->all(), [               
          'bust'=>'required|array',
          'waist'=>'required|array',
          'hip'=>'required|array',
          'shoulder'=>'required|array',
          'sleeve_length'=>'required|array',
          'length'=>'required|array',

          'bust.*'=>'required',
          'waist.*'=>'required',
          'hip.*'=>'required',
          'shoulder.*'=>'required',
          'sleeve_length.*'=>'required',
          'length.*'=>'required',  

        ]);
      
      if($validate->fails()){
          return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
      }

     }


     // Product Vartion Image

     $dir="Product/";
     $variation_image=[];

     foreach($request->variant_image as $key=>$Image1){

        foreach($Image1 as $key1=>$Image2){
            $variation_image[$key][$key1]=image_upload($Image2,$dir);  // chart Image
        }
     }

    //  Product Size Chart Upload 
     if($request->upload_size_chart){ 
     $upload_size_chart=image_upload($request->upload_size_chart,$dir);  // chart Image
     
    }




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
'variant_image' => $variation_image,
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
'upload_size_chart'=> $upload_size_chart

     ];

  $data=  $this->SellerProductService->AddProduct($request_data);

  if(isset($data['status']) && $data['status']=='error' ){
      return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
  }

  return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
  }


public function view_product(Request $request , $id){

$request_data=(object) [
    'product_id'=>$id,    
];
    
    $product =  $this->SellerProductService->single_product_details_fetch($request_data);

    $product=$product['data'];

    // dump($product);
    
    return view('dealer.product.view_product',compact('product'));
    
}



public function edit_product($id){

    
    $category = Category::orderBy('id', 'asc')->get();
    $brand = Brand::all();
    $color = color::all();
    $size = size::all();
 
$request_data=(object) [
    'product_id'=>$id,    
];
    
    $product =  $this->SellerProductService->single_product_details_fetch($request_data);

    $product_details=$product['data'];

    // dump($product_details);

    return view('dealer.product.edit_product',compact('category','brand','color','size','product_details'));

}


public function edit_product_code(Request $request, $id){

    $seller_details=Auth::guard('seller')->user();
    $seller_id=$seller_details->id;

      $validate = Validator::make($request->all(), [
          'category_id' => 'required|exists:categories,id',
          'subcategory_id' => 'required|exists:sub_categories,id',
          'brand_id' => 'required|exists:brands,id',
          'other_en' => 'required',
          'other_ar' => 'required',
       
        'product_name_en' => 'required|unique:products,product_name_en,' . $id,
        'product_name_ar' => 'required|unique:products,product_name_ar,' . $id,

          'description_en' => 'required',
          'description_ar' => 'required',

          // specification
            'product_spe_en'           => ['required', 'array', new MatchArrayProductSpecification],
            'product_spe_en.*'         => ['required'], // ← catch null & empty value

            'product_spe_feature_en'   => ['required', 'array',new MatchArrayProductSpecification],
            'product_spe_feature_en.*' => ['required'],

            'product_spe_ar'           => ['required', 'array',new MatchArrayProductSpecification],
            'product_spe_ar.*'         => ['required'],

            'product_spe_feature_ar'   => ['required', 'array',new MatchArrayProductSpecification],
            'product_spe_feature_ar.*' => ['required'],

          // product vartion start

    'variant_image' => ['required', 'array'],
    // Each variation must be an array
    'variant_image.*' => ['required', 'array'],
    // Each image inside each variation is required
    'variant_image.*.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', new MatchArrayProductVariation],

          'color_id' => ['required', 'array'],
          'size_id' => ['required', 'array', ],
          'color_id.*' => ['required','exists:colors,id'],
          'size_id.*' => ['required','exists:sizes,id'],

          'total_stock' => ['required', 'array'],
          'sku' => ['required', 'array'],
          'sku_threshold_value' => ['required', 'array'],
          'actual_price' => ['required', 'array'],
          'discount_type' => ['required', 'array'],
          'discount_value' => ['required', 'array'],
          'final_price' => ['required', 'array'],

         'total_stock.*' => ['required'],
          'sku.*' => ['required'],
          'sku_threshold_value.*' => ['required'],
          'actual_price.*' => ['required'],
          'discount_type.*' => ['required'],
          'discount_value.*' => ['required'],
          'final_price.*' => ['required'],


          // product vartion end
          
          'min_card_quantity'=>'required',
          'max_card_quantity'=>'required',
          'product_return'=>'required|in:0,1', // 0 Not return 1 return Availble 
          'return_days'=> 'required_if:product_return,1|nullable|integer',
          'product_exchangable'=>'required|in:0,1',  // 0 not 1 yes
          'exchangable_days'=>'required_if:product_exchangable,1|nullable|integer',
          'review_rating'=>'required|in:0,1', // 0 not 1 yes
          'affiliated_product'=>'required|in:0,1', // // 0 not 1 yes
          'customized_product'=>'required|in:0,1', // // 0 not 1 yes
          'ready_to_ship'=>'required|in:0,1', // // 0 not 1 yes
          'cash_on_delivery'=>'required|in:0,1', // // 0 not 1 yes
        
           'upload_size_chart' => 'required_without:old_upload_size_chart',
           'old_upload_size_chart' => 'required_without:upload_size_chart',

        //   if The category is women
         // MAIN ARRAY FIELDS (required only if category_id = 2)
    'bust'           => [Rule::requiredIf($request->category_id == 2), 'array'],
    'waist'          => [Rule::requiredIf($request->category_id == 2), 'array'],
    'hip'            => [Rule::requiredIf($request->category_id == 2), 'array'],
    'shoulder'       => [Rule::requiredIf($request->category_id == 2), 'array'],
    'sleeve_length'  => [Rule::requiredIf($request->category_id == 2), 'array'],
    'length'         => [Rule::requiredIf($request->category_id == 2), 'array'],

    // INNER ARRAY VALUES (apply required only if category_id = 2)
    'bust.*'           => [Rule::requiredIf($request->category_id == 2)],
    'waist.*'          => [Rule::requiredIf($request->category_id == 2)],
    'hip.*'            => [Rule::requiredIf($request->category_id == 2)],
    'shoulder.*'       => [Rule::requiredIf($request->category_id == 2)],
    'sleeve_length.*'  => [Rule::requiredIf($request->category_id == 2)],
    'length.*'         => [Rule::requiredIf($request->category_id == 2)], 
       
      ],[
         'upload_size_chart.required_without' => 'Upload size Chart image is required.',
         'old_upload_size_chart.required_without' => 'oad size Chart image is required.',
        
            // Basic fields
            'category_id.required'       => 'Please select a category.',
            'category_id.exists'         => 'Selected category does not exist.',
            
            'subcategory_id.required'    => 'Please select a subcategory.',
            'subcategory_id.exists'      => 'Selected subcategory does not exist.',
        
            'brand_id.required'          => 'Please select a brand.',
            'brand_id.exists'            => 'Selected brand does not exist.',
        
            'other_en.required'          => 'Other (English) field is required.',
            'other_ar.required'          => 'Other (Arabic) field is required.',
        
            'product_name_en.required'   => 'Product name (English) is required.',
            'product_name_en.unique'     => 'This English product name is already taken.',
        
            'product_name_ar.required'   => 'Product name (Arabic) is required.',
            'product_name_ar.unique'     => 'This Arabic product name is already taken.',
        
            'description_en.required'    => 'Description (English) is required.',
            'description_ar.required'    => 'Description (Arabic) is required.',
        
            // Specifications
            'product_spe_en.required'           => 'English specifications are required.',
            'product_spe_en.array'              => 'English specifications must be an array.',
            'product_spe_en.*.required'         => 'Each English specification is required.',
        
            'product_spe_feature_en.required'   => 'English specification features are required.',
            'product_spe_feature_en.*.required' => 'Each English specification feature is required.',
        
            'product_spe_ar.required'           => 'Arabic specifications are required.',
            'product_spe_ar.*.required'         => 'Each Arabic specification is required.',
        
            'product_spe_feature_ar.required'   => 'Arabic specification features are required.',
            'product_spe_feature_ar.*.required' => 'Each Arabic specification feature is required.',
        
            // Product Variant Fields
            'variant_image.required'      => 'Variant images are required.',
            'variant_image.*.required'    => 'Each variant image is required.',
        
            'color_id.required'           => 'Color field is required.',
            'color_id.array'              => 'Color field must be an array.',
            'color_id.*.required'         => 'Each color is required.',
            'color_id.*.distinct'         => 'Duplicate colors are not allowed.',
            'color_id.*.exists'           => 'Selected color does not exist.',
        
            'size_id.required'            => 'Size field is required.',
            'size_id.array'               => 'Size field must be an array.',
            'size_id.*.required'          => 'Each size is required.',
            'size_id.*.exists'            => 'Selected size does not exist.',
            'size_id.*.distinct'          => 'Duplicate sizes are not allowed.',
        
            'total_stock.required'        => 'Stock field is required.',
            'total_stock.*.required'      => 'Each stock value is required.',
        
            'sku.required'                => 'SKU field is required.',
            'sku.*.required'              => 'Each SKU is required.',
        
            'sku_threshold_value.required'   => 'SKU threshold field is required.',
            'sku_threshold_value.*.required' => 'Each SKU threshold value is required.',
        
            'actual_price.required'       => 'Actual price is required.',
            'actual_price.*.required'     => 'Each actual price is required.',
        
            'discount_type.required'      => 'Discount type is required.',
            'discount_type.*.required'    => 'Each discount type is required.',
        
            'discount_value.required'     => 'Discount value is required.',
            'discount_value.*.required'   => 'Each discount value is required.',
        
            'final_price.required'        => 'Final price is required.',
            'final_price.*.required'      => 'Each final price is required.',
        
            // General Product Details
            'min_card_quantity.required'  => 'Minimum cart quantity is required.',
            'max_card_quantity.required'  => 'Maximum cart quantity is required.',
        
            // Return
            'product_return.required'     => 'Please choose if product is returnable.',
            'product_return.in'           => 'Invalid return option.',
            'return_days.required_if'     => 'Return days are required when product is returnable.',
            'return_days.integer'         => 'Return days must be a number.',
        
            // Exchange
            'product_exchangable.required'     => 'Please choose if product is exchangeable.',
            'product_exchangable.in'           => 'Invalid exchange option.',
            'exchangable_days.required_if'     => 'Exchangable days are required when product is exchangeable.',
            'exchangable_days.integer'         => 'Exchangable days must be a number.',
        
            // Review
            'review_rating.required'      => 'Please choose review rating option.',
            'review_rating.in'            => 'Invalid rating option.',
        
            // Affiliated
            'affiliated_product.required' => 'Please choose affiliated product option.',
            'affiliated_product.in'       => 'Invalid affiliated option.',
        
            // Customized
            'customized_product.required' => 'Please choose customized product option.',
            'customized_product.in'       => 'Invalid customized option.',
        
            // Shipping
            'ready_to_ship.required'      => 'Ready to ship field is required.',
            'ready_to_ship.in'            => 'Invalid ready-to-ship option.',
        
            // COD
            'cash_on_delivery.required'   => 'Cash on delivery option is required.',
            'cash_on_delivery.in'         => 'Invalid cash on delivery option.',
        
            // Size Chart
            'upload_size_chart.required'  => 'Size chart is required.',
        
            // Women Category (category_id = 2)
            'bust.required'               => 'Bust field is required for women category.',
            'bust.*.required'             => 'Each bust value is required.',
        
            'waist.required'              => 'Waist field is required for women category.',
            'waist.*.required'            => 'Each waist value is required.',
        
            'hip.required'                => 'Hip field is required for women category.',
            'hip.*.required'              => 'Each hip value is required.',
        
            'shoulder.required'           => 'Shoulder field is required for women category.',
            'shoulder.*.required'         => 'Each shoulder value is required.',
        
            'sleeve_length.required'      => 'Sleeve length is required for women category.',
            'sleeve_length.*.required'    => 'Each sleeve length value is required.',
        
            'length.required'             => 'Length field is required for women category.',
            'length.*.required'           => 'Each length value is required.',
        
      ]);


     $validate->after(function ($validate) use ($request) {

    $colors = $request->color_id;
    $sizes  = $request->size_id;

    // Group sizes by color
    $grouped = [];

    foreach ($colors as $i => $color) {
        $size = $sizes[$i] ?? null;
        $grouped[$color][] = $size;
    }

    // Validate: for same color → sizes must be unique
    foreach ($grouped as $color => $sizesForColor) {
        if (count($sizesForColor) !== count(array_unique($sizesForColor))) {
            $validate->errors()->add(
                'size_id_'.$color,
                "For color sizes must be different."
            );
        }
    }
});

      
      if($validate->fails()){
          return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
         }

         
     if($request->category_id=='2'){   // if the category is women Then These field is manditary

      $validate = Validator::make($request->all(), [               
          'bust'=>'required|array',
          'waist'=>'required|array',
          'hip'=>'required|array',
          'shoulder'=>'required|array',
          'sleeve_length'=>'required|array',
          'length'=>'required|array',

          'bust.*'=>'required',
          'waist.*'=>'required',
          'hip.*'=>'required',
          'shoulder.*'=>'required',
          'sleeve_length.*'=>'required',
          'length.*'=>'required',  

        ]);
      
      if($validate->fails()){
          return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
      }

     }


     // Product Vartion Image

     $dir="Product/";
     $variation_image=[];

     foreach($request->variant_image as $key=>$Image1){

        foreach($Image1 as $key1=>$Image2){
            $variation_image[$key][$key1]=image_upload($Image2,$dir);  // chart Image
        }
     }

    //  Product Size Chart Upload 
     if($request->upload_size_chart){ 
     $upload_size_chart=image_upload($request->upload_size_chart,$dir);  // chart Image
     
    }else{
          $upload_size_chart=$request->old_upload_size_chart;  // old Image Upload
    }

$request_data=(object) [
'product_id'=>$request->product_id,
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
'variant_image' => $variation_image,
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
'upload_size_chart'=> $upload_size_chart

     ];

  $data=  $this->SellerProductService->edit_Product($request_data);

  if(isset($data['status']) && $data['status']=='error' ){
      return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
  }

  return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
  }





    public function Inventory_Management(){

        return view('dealer.product.Inventory_Management');

    }
    public function Affilate_Commission(){

        return view('dealer.product.Affilate_Commission');

    }
    
    

    

}