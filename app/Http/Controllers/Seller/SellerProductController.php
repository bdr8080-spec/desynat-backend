<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;

use App\Models\{ Brand,color,size};



use App\Models\{ product,ProductSpecification,ProductVariant};



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

        // $seller_details=  Auth::guard('seller')->user();
        // $seller_id=$seller_details->id;

        $seller_id=sellerAndStaffId();

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




// public function Add_product(){

//     $category = Category::orderBy('id', 'asc')->get();
//     $brand = Brand::all();
//     $color = color::all();
//     $size = size::all();

//     return view('dealer.product.Add_product',compact('category','brand','color','size'));
// }


// public function Add_product_code(Request $request){


//     $seller_details=Auth::guard('seller')->user();
//     $seller_id=$seller_details->id;
    
//       $validate = Validator::make($request->all(), [
//           'category_id' => 'required|exists:categories,id',
//           'subcategory_id' => 'required|exists:sub_categories,id',
//           'brand_id' => 'required|exists:brands,id',
//           'other_en' => 'nullable',
//           'other_ar' => 'nullable',
       
//           'product_name_en' => 'required|unique:products,product_name_en',
//           'product_name_ar' => 'required|unique:products,product_name_ar',
       
//           'description_en' => 'required',
//           'description_ar' => 'required',

//           // specification
//             'product_spe_en'           => ['required', 'array', new MatchArrayProductSpecification],
//             'product_spe_en.*'         => ['required'], // ← catch null & empty value

//             'product_spe_feature_en'   => ['required', 'array',new MatchArrayProductSpecification],
//             'product_spe_feature_en.*' => ['required'],

//             'product_spe_ar'           => ['required', 'array',new MatchArrayProductSpecification],
//             'product_spe_ar.*'         => ['required'],

//             'product_spe_feature_ar'   => ['required', 'array',new MatchArrayProductSpecification],
//             'product_spe_feature_ar.*' => ['required'],


//           // product vartion start
//           'variant_image' => ['required', 'array'],
//           'color_id' => ['required', 'array'],
//           'size_id' => ['required', 'array', ],
//           'color_id.*' => ['required','exists:colors,id'],
//           'size_id.*' => ['required','exists:sizes,id'],

//           'total_stock' => ['required', 'array'],
//           'sku' => ['required', 'array'],
//         //   'sku_threshold_value' => ['required', 'array'],
//           'actual_price' => ['required', 'array'],
//           'discount_type' => ['required', 'array'],
//           'discount_value' => ['required', 'array'],
//           'final_price' => ['required', 'array'],

//           'variant_image.*' => ['required'],
//          'total_stock.*' => ['required'],
//           'sku.*' => ['required'],
//         //   'sku_threshold_value.*' => ['required'],
//           'actual_price.*' => ['required'],
//           'discount_type.*' => ['required'],
//           'discount_value.*' => ['required'],
//           'final_price.*' => ['required'],


//           // product vartion end
          
//           'min_card_quantity'=>'required',
//           'max_card_quantity'=>'required',
//           'product_return'=>'required|in:0,1', // 0 Not return 1 return Availble 
//           'return_days'=> 'required_if:product_return,1|nullable|integer',
//           'product_exchangable'=>'required|in:0,1',  // 0 not 1 yes
//           'exchangable_days'=>'required_if:product_exchangable,1|nullable|integer',
//           'review_rating'=>'required|in:0,1', // 0 not 1 yes
//           'affiliated_product'=>'required|in:0,1', // // 0 not 1 yes
//           'customized_product'=>'required|in:0,1', // // 0 not 1 yes
//           'ready_to_ship'=>'required|in:0,1', // // 0 not 1 yes
//           'cash_on_delivery'=>'required|in:0,1', // // 0 not 1 yes
//           'upload_size_chart'=>'required',


//         //   if The category is women
//          // MAIN ARRAY FIELDS (required only if category_id = 2)
//     'bust'           => [Rule::requiredIf($request->category_id == 2), 'array'],
//     'waist'          => [Rule::requiredIf($request->category_id == 2), 'array'],
//     'hip'            => [Rule::requiredIf($request->category_id == 2), 'array'],
//     'shoulder'       => [Rule::requiredIf($request->category_id == 2), 'array'],
//     'sleeve_length'  => [Rule::requiredIf($request->category_id == 2), 'array'],
//     'length'         => [Rule::requiredIf($request->category_id == 2), 'array'],

//     // INNER ARRAY VALUES (apply required only if category_id = 2)
//     'bust.*'           => [Rule::requiredIf($request->category_id == 2)],
//     'waist.*'          => [Rule::requiredIf($request->category_id == 2)],
//     'hip.*'            => [Rule::requiredIf($request->category_id == 2)],
//     'shoulder.*'       => [Rule::requiredIf($request->category_id == 2)],
//     'sleeve_length.*'  => [Rule::requiredIf($request->category_id == 2)],
//     'length.*'         => [Rule::requiredIf($request->category_id == 2)], 
       
//       ],[
        
//             // Basic fields
//             'category_id.required'       => 'Please select a category',
//             'category_id.exists'         => 'Selected category does not exist',
            
//             'subcategory_id.required'    => 'Please select a subcategory',
//             'subcategory_id.exists'      => 'Selected subcategory does not exist',
        
//             'brand_id.required'          => 'Please select a brand',
//             'brand_id.exists'            => 'Selected brand does not exist',
        
//             'other_en.required'          => 'Please Enter Other in English',
//             'other_ar.required'          => 'Please Enter Other in Arabic',
        
//             'product_name_en.required'   => 'Please Enter Product Name in English',
//             'product_name_en.unique'     => 'This English product name is already taken',
        
//             'product_name_ar.required'   => 'Please Enter Product Name in Arabic',
//             'product_name_ar.unique'     => 'This Arabic product name is already taken',
        
//             'description_en.required'    => 'Please Enter Description in English',
//             'description_ar.required'    => 'Please Enter Description in Arabic',
        
//             // Specifications
//             'product_spe_en.required'           => 'Please Enter Specification in English',
//             'product_spe_en.array'              => 'English specifications must be an array',
//             'product_spe_en.*.required'         => 'Please Enter Each Specification in English',
        
//             'product_spe_feature_en.required'   => 'Please Enter Specification Feature in English',
//             'product_spe_feature_en.*.required' => 'Please Enter Each Specification Feature in English',
        
//             'product_spe_ar.required'           => 'Please Enter Specification in Arabic',
//             'product_spe_ar.*.required'         => 'Please Enter Each Specification in Arabic',
        
//             'product_spe_feature_ar.required'   => 'Please Enter Specification Feature in Arabic',
//             'product_spe_feature_ar.*.required' => 'Please Enter Each Specification Feature in Arabic',
        
//             // Product Variant Fields
//             'variant_image.required'      => 'Please Upload Variant Images',
//             'variant_image.*.required'    => 'Please Upload Each Variant Image',
        
//             'color_id.required'           => 'Please Select a Colour',
//             'color_id.array'              => 'Color field must be an array',
//             'color_id.*.required'         => 'Please Select Colour',
//             'color_id.*.distinct'         => 'Duplicate colors are not allowed',
//             'color_id.*.exists'           => 'Selected color does not exist',
        
//             'size_id.required'            => 'Size field is required',
//             'size_id.array'               => 'Size field must be an array',
//             'size_id.*.required'          => 'Please Select Size',
//             'size_id.*.exists'            => 'Selected size does not exist',
//             'size_id.*.distinct'          => 'Duplicate sizes are not allowed',
        
//             'total_stock.required'        => 'Stock field is required',
//             'total_stock.*.required'      => 'Please Enter Total Stocks',
        
//             'sku.required'                => 'SKU field is required',
//             'sku.*.required'              => 'Please Enter SKU',
        
//             'sku_threshold_value.required'   => 'SKU threshold field is required',
//             'sku_threshold_value.*.required' => 'Please Enter SKU Threshold Value',
        
//             'actual_price.required'       => 'Actual price is required',
//             'actual_price.*.required'     => 'Please Enter Actual Price',
        
//             'discount_type.required'      => 'Discount type is required',
//             'discount_type.*.required'    => 'Each discount type is required',
        
//             'discount_value.required'     => 'Discount value is required',
//             'discount_value.*.required'   => 'Plesae Enter Discount',
        
//             'final_price.required'        => 'Final price is required',
//             'final_price.*.required'      => 'Plesae Enter Final Price',
        
//             // General Product Details
//             'min_card_quantity.required'  => 'Plesae Enter Minimum Cart Quantity',
//             'max_card_quantity.required'  => 'Plesae Enter Maximum Cart Quantity',
        
//             // Return
//             'product_return.required'     => 'Please choose if product is returnable',
//             'product_return.in'           => 'Invalid return option',
//             'return_days.required_if'     => 'Please Enter Return Days When Product is Returnable',
//             'return_days.integer'         => 'Return days must be a number',
        
//             // Exchange
//             'product_exchangable.required'     => 'Please choose if product is exchangeable',
//             'product_exchangable.in'           => 'Invalid exchange option',
//             'exchangable_days.required_if'     => 'Please Enter Exchangable Days When Product is Exchangeable',
//             'exchangable_days.integer'         => 'Exchangable days must be a number',
        
//             // Review
//             'review_rating.required'      => 'Please choose review rating option',
//             'review_rating.in'            => 'Invalid rating option',
        
//             // Affiliated
//             'affiliated_product.required' => 'Please choose affiliated product option',
//             'affiliated_product.in'       => 'Invalid affiliated option',
        
//             // Customized
//             'customized_product.required' => 'Please choose customized product option',
//             'customized_product.in'       => 'Invalid customized option',
        
//             // Shipping
//             'ready_to_ship.required'      => 'Ready to ship field is required',
//             'ready_to_ship.in'            => 'Invalid ready-to-ship option',
        
//             // COD
//             'cash_on_delivery.required'   => 'Cash on delivery option is required',
//             'cash_on_delivery.in'         => 'Invalid cash on delivery option',
        
//             // Size Chart
//             'upload_size_chart.required'  => 'Please Upload Size Chart',
        
//             // Women Category (category_id = 2)
//             'bust.required'               => 'Bust field is required for women category',
//             'bust.*.required'             => 'Each bust value is required',
        
//             'waist.required'              => 'Waist field is required for women category',
//             'waist.*.required'            => 'Each waist value is required',
        
//             'hip.required'                => 'Hip field is required for women category',
//             'hip.*.required'              => 'Each hip value is required',
        
//             'shoulder.required'           => 'Shoulder field is required for women category',
//             'shoulder.*.required'         => 'Each shoulder value is required',
        
//             'sleeve_length.required'      => 'Sleeve length is required for women category',
//             'sleeve_length.*.required'    => 'Each sleeve length value is required',
        
//             'length.required'             => 'Length field is required for women category',
//             'length.*.required'           => 'Each length value is required',
        
//       ]);

//        $validate->after(function ($validate) use ($request) {
//             $totalStock = $request->total_stock;
//             $sku        = $request->sku;

//             if (is_array($totalStock) && is_array($sku)) {
//                 foreach ($sku as $index => $skuValue) {
//                     $stockValue = $totalStock[$index] ?? null;

//                     if ($stockValue !== null && $skuValue >= $stockValue) {
//                         $validate->errors()->add("sku.$index", "SKU Limit Not should be greater than Total Stock");
//                     }
//                 }
//             }
//         });



//      $validate->after(function ($validate) use ($request) {

//     $colors = $request->color_id;
//     $sizes  = $request->size_id;

//     // Group sizes by color
//     $grouped = [];

//     foreach ($colors as $i => $color) {
//         $size = $sizes[$i] ?? null;
//         $grouped[$color][] = $size;
//     }

//     // Validate: for same color → sizes must be unique
//     foreach ($grouped as $color => $sizesForColor) {
//         if (count($sizesForColor) !== count(array_unique($sizesForColor))) {
//             $validate->errors()->add(
//                 'size_id_'.$color,
//                 "For color sizes must be different."
//             );
//         }
//     }
// });

      
//       if($validate->fails()){
//           return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
//          }

         
//      if($request->category_id=='2'){   // if the category is women Then These field is manditary

//       $validate = Validator::make($request->all(), [               
//           'bust'=>'required|array',
//           'waist'=>'required|array',
//           'hip'=>'required|array',
//           'shoulder'=>'required|array',
//           'sleeve_length'=>'required|array',
//           'length'=>'required|array',

//           'bust.*'=>'required',
//           'waist.*'=>'required',
//           'hip.*'=>'required',
//           'shoulder.*'=>'required',
//           'sleeve_length.*'=>'required',
//           'length.*'=>'required',  

//         ]);
      
//       if($validate->fails()){
//           return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
//       }

//      }



//      // Product Vartion Image

//      $dir="Product";
//      $variation_image=[];

//      foreach($request->variant_image as $key=>$Image1){

//         foreach($Image1 as $key1=>$Image2){
//             $variation_image[$key][$key1]=doc_upload($Image2,$dir);  // chart Image
//         }
//      }

//     //  Product Size Chart Upload 
//      if($request->upload_size_chart){ 
//      $upload_size_chart=doc_upload($request->upload_size_chart,$dir);  // chart Image
     
//     }




// $request_data=(object) [
// 'seller_id'=>$seller_id,
// 'category_id' => $request->category_id,
// 'subcategory_id' => $request->subcategory_id,
// 'brand_id' => $request->brand_id,
// 'other_en' => $request->other_en??null,
// 'other_ar' => $request->other_ar??null,

// 'product_name_en' => $request->product_name_en,
// 'product_name_ar' => $request->product_name_ar,
   
// 'description_en' => $request->description_en,
// 'description_ar' => $request->description_ar,

//       // specification
// 'product_spe_en'=> $request->product_spe_en,
// 'product_spe_feature_en'=> $request->product_spe_feature_en,
// 'product_spe_ar'=> $request->product_spe_ar,
// 'product_spe_feature_ar'=> $request->product_spe_feature_ar,

//       // product vartion start
// 'variant_image' => $variation_image,
// 'color_id' => $request->color_id,
// 'size_id' => $request->size_id,
      
// 'bust'=> $request->bust??null, // only provide when category is women
// 'waist'=> $request->waist??null, // only provide when category is women
// 'hip'=> $request->hip??null,  // only provide when category is women
// 'shoulder'=> $request->shoulder??null, // only provide when category is women
// 'sleeve_length'=> $request->sleeve_length??null, // only provide when category is women
// 'length'=> $request->length??null, // only provide when category is women

      
// 'total_stock' => $request->total_stock,
// 'sku' => $request->sku,
// 'sku_threshold_value' => $request->sku_threshold_value??null,
// 'actual_price' => $request->actual_price,
// 'discount_type' => $request->discount_type,
// 'discount_value' => $request->discount_value,
// 'final_price' => $request->final_price,

// // product vartion end
      
// 'min_card_quantity'=> $request->min_card_quantity,
// 'max_card_quantity'=> $request->max_card_quantity,
// 'product_return'=> $request->product_return, // 0 Not return 1 return Availble 
// 'return_days'=> $request->return_days,
// 'product_exchangable'=> $request->product_exchangable,  // 0 not 1 yes
// 'exchangable_days'=> $request->exchangable_days,
// 'review_rating'=> $request->review_rating, // 0 not 1 yes
// 'affiliated_product'=> $request->affiliated_product, // // 0 not 1 yes
// 'customized_product'=> $request->customized_product, // // 0 not 1 yes
// 'ready_to_ship'=> $request->ready_to_ship, // // 0 not 1 yes
// 'cash_on_delivery'=> $request->cash_on_delivery, // // 0 not 1 yes
// 'upload_size_chart'=> $upload_size_chart

//      ];

//   $data=  $this->SellerProductService->AddProduct($request_data);

//   if(isset($data['status']) && $data['status']=='error' ){
//       return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
//   }

//   return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
//   }


public function view_product(Request $request , $id){

$request_data=(object) [
    'product_id'=>$id,    
];
    
    $product =  $this->SellerProductService->single_product_details_fetch($request_data);

    $product=$product['data'];

    // dump($product);
    
    return view('dealer.product.view_product',compact('product'));
    
}


// public function edit_product($id){

//     $category = Category::orderBy('id', 'asc')->get();
//     $brand = Brand::all();
//     $color = color::all();
//     $size = size::all();
        
//         $request_data=(object) [
//             'product_id'=>$id,    
//         ];
            
//     $product =  $this->SellerProductService->single_product_details_fetch($request_data);

//     $product_details=$product['data'];

//     // dump($product_details);

//     return view('dealer.product.edit_product',compact('category','brand','color','size','product_details'));

// }


// public function edit_product_code(Request $request, $id){

//     $seller_details=Auth::guard('seller')->user();
//     $seller_id=$seller_details->id;

//       $validate = Validator::make($request->all(), [
//           'category_id' => 'required|exists:categories,id',
//           'subcategory_id' => 'required|exists:sub_categories,id',
//           'brand_id' => 'required|exists:brands,id',
//           'other_en' => 'nullable',
//           'other_ar' => 'nullable',
       
//         'product_name_en' => 'required|unique:products,product_name_en,' . $id,
//         'product_name_ar' => 'required|unique:products,product_name_ar,' . $id,

//           'description_en' => 'required',
//           'description_ar' => 'required',

//           // specification
//             'product_spe_en'           => ['required', 'array', new MatchArrayProductSpecification],
//             'product_spe_en.*'         => ['required'], // ← catch null & empty value

//             'product_spe_feature_en'   => ['required', 'array',new MatchArrayProductSpecification],
//             'product_spe_feature_en.*' => ['required'],

//             'product_spe_ar'           => ['required', 'array',new MatchArrayProductSpecification],
//             'product_spe_ar.*'         => ['required'],

//             'product_spe_feature_ar'   => ['required', 'array',new MatchArrayProductSpecification],
//             'product_spe_feature_ar.*' => ['required'],

//           // product vartion start

//             'variant_image' => ['array'],
//             // Each variation must be an array
//             'variant_image.*' => ['array'],
//             // Each image inside each variation is required
//             // 'variant_image.*.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', new MatchArrayProductVariation],

//              'variant_image.*.*' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
    

//             'old_variant_image' => ['array'],
//             'old_variant_image.*' => ['nullable'],

           
//           'color_id' => ['required', 'array'],
//           'size_id' => ['required', 'array', ],
//           'color_id.*' => ['required','exists:colors,id'],
//           'size_id.*' => ['required','exists:sizes,id'],

//           'total_stock' => ['required', 'array'],
//           'sku' => ['required', 'array'],
//         //   'sku_threshold_value' => ['required', 'array'],
//           'actual_price' => ['required', 'array'],
//           'discount_type' => ['required', 'array'],
//           'discount_value' => ['required', 'array'],
//           'final_price' => ['required', 'array'],

//          'total_stock.*' => ['required'],
//           'sku.*' => ['required'],
//         //   'sku_threshold_value.*' => ['required'],
//           'actual_price.*' => ['required'],
//           'discount_type.*' => ['required'],
//           'discount_value.*' => ['required'],
//           'final_price.*' => ['required'],


//           // product vartion end
          
//           'min_card_quantity'=>'required',
//           'max_card_quantity'=>'required',
//           'product_return'=>'required|in:0,1', // 0 Not return 1 return Availble 
//           'return_days'=> 'required_if:product_return,1|nullable|integer',
//           'product_exchangable'=>'required|in:0,1',  // 0 not 1 yes
//           'exchangable_days'=>'required_if:product_exchangable,1|nullable|integer',
//           'review_rating'=>'required|in:0,1', // 0 not 1 yes
//           'affiliated_product'=>'required|in:0,1', // // 0 not 1 yes
//           'customized_product'=>'required|in:0,1', // // 0 not 1 yes
//           'ready_to_ship'=>'required|in:0,1', // // 0 not 1 yes
//           'cash_on_delivery'=>'required|in:0,1', // // 0 not 1 yes
        
//            'upload_size_chart' => 'required_without:old_upload_size_chart',
//            'old_upload_size_chart' => 'required_without:upload_size_chart',

//         //   if The category is women
//                 // MAIN ARRAY FIELDS (required only if category_id = 2)
//             'bust'           => [Rule::requiredIf($request->category_id == 2), 'array'],
//             'waist'          => [Rule::requiredIf($request->category_id == 2), 'array'],
//             'hip'            => [Rule::requiredIf($request->category_id == 2), 'array'],
//             'shoulder'       => [Rule::requiredIf($request->category_id == 2), 'array'],
//             'sleeve_length'  => [Rule::requiredIf($request->category_id == 2), 'array'],
//             'length'         => [Rule::requiredIf($request->category_id == 2), 'array'],

//             // INNER ARRAY VALUES (apply required only if category_id = 2)
//             'bust.*'           => [Rule::requiredIf($request->category_id == 2)],
//             'waist.*'          => [Rule::requiredIf($request->category_id == 2)],
//             'hip.*'            => [Rule::requiredIf($request->category_id == 2)],
//             'shoulder.*'       => [Rule::requiredIf($request->category_id == 2)],
//             'sleeve_length.*'  => [Rule::requiredIf($request->category_id == 2)],
//             'length.*'         => [Rule::requiredIf($request->category_id == 2)], 
            
//       ],[
//             'upload_size_chart.required_without' => 'Upload size Chart image is required.',
//             'old_upload_size_chart.required_without' => 'oad size Chart image is required.',
            
//             // Basic fields
//             'category_id.required'       => 'Please select a category.',
//             'category_id.exists'         => 'Selected category does not exist.',
            
//             'subcategory_id.required'    => 'Please select a subcategory.',
//             'subcategory_id.exists'      => 'Selected subcategory does not exist.',
        
//             'brand_id.required'          => 'Please select a brand.',
//             'brand_id.exists'            => 'Selected brand does not exist.',
        
//             'other_en.required'          => 'Other (English) field is required.',
//             'other_ar.required'          => 'Other (Arabic) field is required.',
        
//             'product_name_en.required'   => 'Product name (English) is required.',
//             'product_name_en.unique'     => 'This English product name is already taken.',
        
//             'product_name_ar.required'   => 'Product name (Arabic) is required.',
//             'product_name_ar.unique'     => 'This Arabic product name is already taken.',
        
//             'description_en.required'    => 'Description (English) is required.',
//             'description_ar.required'    => 'Description (Arabic) is required.',
        
//             // Specifications
//             'product_spe_en.required'           => 'English specifications are required.',
//             'product_spe_en.array'              => 'English specifications must be an array.',
//             'product_spe_en.*.required'         => 'Each English specification is required.',
        
//             'product_spe_feature_en.required'   => 'English specification features are required.',
//             'product_spe_feature_en.*.required' => 'Each English specification feature is required.',
        
//             'product_spe_ar.required'           => 'Arabic specifications are required.',
//             'product_spe_ar.*.required'         => 'Each Arabic specification is required.',
        
//             'product_spe_feature_ar.required'   => 'Arabic specification features are required.',
//             'product_spe_feature_ar.*.required' => 'Each Arabic specification feature is required.',
        
//             // Product Variant Fields
//             'variant_image.required'      => 'Variant images are required.',
//             'variant_image.*.required'    => 'Each variant image is required.',
        
//             'color_id.required'           => 'Color field is required.',
//             'color_id.array'              => 'Color field must be an array.',
//             'color_id.*.required'         => 'Each color is required.',
//             'color_id.*.distinct'         => 'Duplicate colors are not allowed.',
//             'color_id.*.exists'           => 'Selected color does not exist.',
        
//             'size_id.required'            => 'Size field is required.',
//             'size_id.array'               => 'Size field must be an array.',
//             'size_id.*.required'          => 'Each size is required.',
//             'size_id.*.exists'            => 'Selected size does not exist.',
//             'size_id.*.distinct'          => 'Duplicate sizes are not allowed.',
        
//             'total_stock.required'        => 'Stock field is required.',
//             'total_stock.*.required'      => 'Each stock value is required.',
        
//             'sku.required'                => 'SKU field is required.',
//             'sku.*.required'              => 'Each SKU is required.',
        
//             'sku_threshold_value.required'   => 'SKU threshold field is required.',
//             'sku_threshold_value.*.required' => 'Each SKU threshold value is required.',
        
//             'actual_price.required'       => 'Actual price is required.',
//             'actual_price.*.required'     => 'Each actual price is required.',
        
//             'discount_type.required'      => 'Discount type is required.',
//             'discount_type.*.required'    => 'Each discount type is required.',
        
//             'discount_value.required'     => 'Discount value is required.',
//             'discount_value.*.required'   => 'Each discount value is required.',
        
//             'final_price.required'        => 'Final price is required.',
//             'final_price.*.required'      => 'Each final price is required.',
        
//             // General Product Details
//             'min_card_quantity.required'  => 'Minimum cart quantity is required.',
//             'max_card_quantity.required'  => 'Maximum cart quantity is required.',
        
//             // Return
//             'product_return.required'     => 'Please choose if product is returnable.',
//             'product_return.in'           => 'Invalid return option.',
//             'return_days.required_if'     => 'Return days are required when product is returnable.',
//             'return_days.integer'         => 'Return days must be a number.',
        
//             // Exchange
//             'product_exchangable.required'     => 'Please choose if product is exchangeable.',
//             'product_exchangable.in'           => 'Invalid exchange option.',
//             'exchangable_days.required_if'     => 'Exchangable days are required when product is exchangeable.',
//             'exchangable_days.integer'         => 'Exchangable days must be a number.',
        
//             // Review
//             'review_rating.required'      => 'Please choose review rating option.',
//             'review_rating.in'            => 'Invalid rating option.',
        
//             // Affiliated
//             'affiliated_product.required' => 'Please choose affiliated product option.',
//             'affiliated_product.in'       => 'Invalid affiliated option.',
        
//             // Customized
//             'customized_product.required' => 'Please choose customized product option.',
//             'customized_product.in'       => 'Invalid customized option.',
        
//             // Shipping
//             'ready_to_ship.required'      => 'Ready to ship field is required.',
//             'ready_to_ship.in'            => 'Invalid ready-to-ship option.',
        
//             // COD
//             'cash_on_delivery.required'   => 'Cash on delivery option is required.',
//             'cash_on_delivery.in'         => 'Invalid cash on delivery option.',
        
//             // Size Chart
//             'upload_size_chart.required'  => 'Size chart is required.',
        
//             // Women Category (category_id = 2)
//             'bust.required'               => 'Bust field is required for women category.',
//             'bust.*.required'             => 'Each bust value is required.',
        
//             'waist.required'              => 'Waist field is required for women category.',
//             'waist.*.required'            => 'Each waist value is required.',
        
//             'hip.required'                => 'Hip field is required for women category.',
//             'hip.*.required'              => 'Each hip value is required.',
        
//             'shoulder.required'           => 'Shoulder field is required for women category.',
//             'shoulder.*.required'         => 'Each shoulder value is required.',
        
//             'sleeve_length.required'      => 'Sleeve length is required for women category.',
//             'sleeve_length.*.required'    => 'Each sleeve length value is required.',
        
//             'length.required'             => 'Length field is required for women category.',
//             'length.*.required'           => 'Each length value is required.',
        
//       ]);

//         $validate->after(function ($validate) use ($request) {
//             $totalStock = $request->total_stock;
//             $sku        = $request->sku;

//             if (is_array($totalStock) && is_array($sku)) {
//                 foreach ($sku as $index => $skuValue) {
//                     $stockValue = $totalStock[$index] ?? null;

//                     if ($stockValue !== null && $skuValue >= $stockValue) {
//                         $validate->errors()->add("sku.$index", "SKU Limit Not should be greater than Total Stock");
//                     }
//                 }
//             }
//         });
        

//      $validate->after(function ($validate) use ($request) {

// // new image and old image one must show 

//   foreach ($request->size_id as $key => $val) {

//         $newImages = $request->variant_image[$key] ?? [];
//         $oldImages = $request->old_variant_image[$key] ?? [];

//         // Check if both are empty
//         if ((empty($newImages) || count($newImages) == 0) &&
//             (empty($oldImages) || count($oldImages) == 0)) {

//             $validate->errors()->add(
//                 "variant_image.$key",
//                 "At least one image is required for variation #".($key + 1)
//             );
//         }
//     }


// // start Color and size are not dublicate 
//     $colors = $request->color_id;
//     $sizes  = $request->size_id;
//     // Group sizes by color
//     $grouped = [];

//     foreach ($colors as $i => $color) {
//         $size = $sizes[$i] ?? null;
//         $grouped[$color][] = $size;
//     }

//     // Validate: for same color → sizes must be unique
//     foreach ($grouped as $color => $sizesForColor) {
//         if (count($sizesForColor) !== count(array_unique($sizesForColor))) {
//             $validate->errors()->add(
//                 'size_id_'.$color,
//                 "For color sizes must be different."
//             );
//                }
//                  }
//             });

      
//       if($validate->fails()){
//           return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
//          }

         
//      if($request->category_id=='2'){   // if the category is women Then These field is manditary

//       $validate = Validator::make($request->all(), [               
//           'bust'=>'required|array',
//           'waist'=>'required|array',
//           'hip'=>'required|array',
//           'shoulder'=>'required|array',
//           'sleeve_length'=>'required|array',
//           'length'=>'required|array',

//           'bust.*'=>'required',
//           'waist.*'=>'required',
//           'hip.*'=>'required',
//           'shoulder.*'=>'required',
//           'sleeve_length.*'=>'required',
//           'length.*'=>'required',  

//         ]);
      
//       if($validate->fails()){
//           return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
//       }

//      }


//      // Product Vartion Image

//      $dir="Product";
//      $variation_image=[];

//     //  foreach($request->variant_image as $key=>$Image1){
//     //     foreach($Image1 as $key1=>$Image2){
//     //         $variation_image[$key][$key1]=image_upload($Image2,$dir);  // chart Image
//     //     }
//     //  }

//    $final_variation_images = [];

// //    dd($request->variant_image);

// foreach ($request->color_id as $key => $val) {

//     $final_variation_images[$key] = []; // initialize

//     $count_array=0;

//     // 1️⃣ Add OLD images (if exist)
//     if (!empty($request->old_variant_image)) {

//         foreach ($request->old_variant_image[$key] as $oldImgPath) {

//             //  foreach($oldImgPath as $key1=>$Image2){
//                   $final_variation_images[$key][$count_array]=$oldImgPath;  // chart Image


//                   $count_array++;
//             //  }

//             // $final_variation_images[$key][] = $oldImgPath;  // existing saved path
//         }
//     }


//     // 2️⃣ Add NEW uploaded images (if exist)
//     if (!empty($request->variant_image[$key])) {

//         foreach ($request->variant_image[$key] as $imgFile) {

//             // foreach($imgFile as $key1=>$Image2){

//             $uploadedPath = doc_upload($imgFile, $dir);   // upload
//             $final_variation_images[$key][$count_array] = $uploadedPath;

//             //  }
//         }
//     }

//     // 3️⃣ If neither → stays empty
// }



// // dd($final_variation_images);

//     //  Product Size Chart Upload 
//      if($request->upload_size_chart){ 
//      $upload_size_chart=doc_upload($request->upload_size_chart,$dir);  // chart Image
     
//     }else{
//           $upload_size_chart=$request->old_upload_size_chart;  // old Image Upload
//     }

// $request_data=(object) [
// 'product_id'=>$request->product_id,
// 'seller_id'=>$seller_id,
// 'category_id' => $request->category_id,
// 'subcategory_id' => $request->subcategory_id,
// 'brand_id' => $request->brand_id,
// 'other_en' => $request->other_en??null,
// 'other_ar' => $request->other_ar??null,

// 'product_name_en' => $request->product_name_en,
// 'product_name_ar' => $request->product_name_ar,
   
// 'description_en' => $request->description_en,
// 'description_ar' => $request->description_ar,

//       // specification
// 'product_spe_en'=> $request->product_spe_en,
// 'product_spe_feature_en'=> $request->product_spe_feature_en,
// 'product_spe_ar'=> $request->product_spe_ar,
// 'product_spe_feature_ar'=> $request->product_spe_feature_ar,

//       // product vartion start
// 'variant_image' => $final_variation_images,
// 'color_id' => $request->color_id,
// 'size_id' => $request->size_id,
      
// 'bust'=> $request->bust??null, // only provide when category is women
// 'waist'=> $request->waist??null, // only provide when category is women
// 'hip'=> $request->hip??null,  // only provide when category is women
// 'shoulder'=> $request->shoulder??null, // only provide when category is women
// 'sleeve_length'=> $request->sleeve_length??null, // only provide when category is women
// 'length'=> $request->length??null, // only provide when category is women

      
// 'total_stock' => $request->total_stock,
// 'sku' => $request->sku,
// // 'sku_threshold_value' => $request->sku_threshold_value,
// 'actual_price' => $request->actual_price,
// 'discount_type' => $request->discount_type,
// 'discount_value' => $request->discount_value,
// 'final_price' => $request->final_price,

// // product vartion end

// 'min_card_quantity'=> $request->min_card_quantity,
// 'max_card_quantity'=> $request->max_card_quantity,
// 'product_return'=> $request->product_return, // 0 Not return 1 return Availble 
// 'return_days'=> $request->return_days,
// 'product_exchangable'=> $request->product_exchangable,  // 0 not 1 yes
// 'exchangable_days'=> $request->exchangable_days,
// 'review_rating'=> $request->review_rating, // 0 not 1 yes
// 'affiliated_product'=> $request->affiliated_product, // // 0 not 1 yes
// 'customized_product'=> $request->customized_product, // // 0 not 1 yes
// 'ready_to_ship'=> $request->ready_to_ship, // // 0 not 1 yes
// 'cash_on_delivery'=> $request->cash_on_delivery, // // 0 not 1 yes
// 'upload_size_chart'=> $upload_size_chart

//      ];



//   $data=  $this->SellerProductService->edit_Product($request_data);

//   if(isset($data['status']) && $data['status']=='error' ){
//       return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
//   }

//   return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
//   }



  public function getSizesByColor(Request $request)
{
    
   $sizes= ProductVariant::with('size')->where('product_id', $request->product_id)->where('color_id',$request->color)->get();
    
   // $sizes = $product->ColorPriceCombination[$request->color];

    return view('dealer.product.ajax.sizes', compact('sizes'))->render();
}


public function getPriceBySize(Request $request)
{

    $sizes= ProductVariant::with('size')->where('product_id', $request->product_id)
    ->where('color_id',$request->color)
    ->where('size_id',$request->size)
    ->get();

    // dd($product_data);

     return view('dealer.product.ajax.price', compact('sizes'))->render();

}


public function getSizeByVariation(Request $request)
{

 $product_data_called= product::where('id', $request->product_id)->first();

    $sizes= ProductVariant::with('size')->where('product_id', $request->product_id)
    ->where('color_id',$request->color)
    ->where('size_id',$request->size)
    ->get();

    // dd($product_data);

     return view('dealer.product.ajax.variation_show', compact('sizes','product_data_called'))->render();

}





public function getimagesBySize(Request $request)
{
    $images_show= ProductVariant::with('size')->where('product_id', $request->product_id)
    ->where('color_id',$request->color)
    ->where('size_id',$request->size)
    ->pluck('variant_image');

      return view('dealer.product.ajax.images_show', compact('images_show'))->render();

}



public function product_delete(Request $request, $id){

    $request_data=(object) [
    'product_id'=>$id,
    ];

  $data=  $this->SellerProductService->product_delete_code($request_data);

  if(isset($data['status']) && $data['status']=='error' ){
      return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
  }

  return ApiResponse::generateResponse('success', $data['message'],(object)[], 200);
  
  }




    public function Inventory_Management(Request $request){
        // $seller_details=  Auth::guard('seller')->user();
        // $seller_id=$seller_details->id;

         $seller_id=sellerAndStaffId();
       
      
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


    return view('dealer.product.Inventory_Management',compact('category','brand','data'));


    }
    public function Affilate_Commission(){

        return view('dealer.product.Affilate_Commission');

    }


    // new ADD PRODUCT CODE start
    
    

public function Add_product1(){

    $category = Category::orderBy('id', 'asc')->get();
    $brand = Brand::all();
    $color = color::all();
    $size = size::all();

    return view('dealer.product.Add_product1',compact('category','brand','color','size'));
}


public function Add_product_code1(Request $request){


    $categoryId = $request->category_id;
    
    // $seller_details=Auth::guard('seller')->user();
    // $seller_id=$seller_details->id;
     $seller_id=sellerAndStaffId();
       
    
      $validate = Validator::make($request->all(), [
          'category_id' => 'required|exists:categories,id',
          'subcategory_id' => 'required|exists:sub_categories,id',
          'brand_id' => 'required|exists:brands,id',
          'other_en' => 'nullable',
          'other_ar' => 'nullable',
       
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

          
        // Colors validation (first level array)
        'color_id' => 'required|array|min:1',
        'color_id.*' => 'required|integer|exists:colors,id',
   
        // Image Variation code
        
        'variant_image' => ['required', 'array'],
        'variant_image.*' => ['required','array'],        
        

        // Sizes: second level array
        'size_id' => 'required|array|min:1',
        'size_id.*' => 'required|array|min:1',
        'size_id.*.*' => 'required|integer|exists:sizes,id|distinct',

        // Product Inventory
        'total_stock.*.*' => 'required|integer|min:0',
        'sku.*.*' => 'required|string|max:50',
        'actual_price.*.*' => 'required|numeric|min:0',
    
        // Discount fields
        'discount_type.*.*' => 'required|in:1,2', // 1=percentage, 2=fixed price
        'discount_value.*.*' => 'required|numeric|min:0',
        'final_price.*.*' => 'required|numeric|min:0',


          // product vartion end
          
          'min_card_quantity'=>'required',
          'max_card_quantity'=>'required',
          'product_return'=>'required|in:0,1', // 0 Not return 1 return Availble 
          'return_days'=> 'required_if:product_return,1|nullable|integer',
          'product_exchangable'=>'required|in:0,1',  // 0 not 1 yes
          'exchangable_days'=>'required_if:product_exchangable,1|nullable|integer',
          'review_rating'=>'required|in:0,1', // 0 not 1 yes
          'affiliated_product'=>'required|in:0,1', // // 0 not 1 yes

          'affiliated_commission'=>'required_if:affiliated_product,1|nullable|integer',
          

          'customized_product'=>'required|in:0,1', // // 0 not 1 yes
          'ready_to_ship'=>'required|in:0,1', // // 0 not 1 yes
          'cash_on_delivery'=>'required|in:0,1', // // 0 not 1 yes
          'upload_size_chart'=>'required',

      // Body Measurements arrays (required only for category 2)
    'bust'          => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'waist'         => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'hip'           => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'shoulder'      => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'sleeve_length' => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'length'        => $categoryId == 2 ? 'required|array' : 'nullable|array',

    // Color-level array
    'bust.*'          => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'waist.*'         => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'hip.*'           => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'shoulder.*'      => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'sleeve_length.*' => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'length.*'        => $categoryId == 2 ? 'required|array' : 'nullable|array',

    // Size-level numeric values
    'bust.*.*'          => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',
    'waist.*.*'         => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',
    'hip.*.*'           => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',
    'shoulder.*.*'      => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',
    'sleeve_length.*.*' => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',
    'length.*.*'        => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',


        
      ],[
   
    // Base Fields
   
     // Category / Brand
    'category_id.required' => __('seller_messages.category_required'),
    'category_id.exists' => __('seller_messages.category_invalid'),

    'subcategory_id.required' => __('seller_messages.subcategory_required'),
    'subcategory_id.exists' => __('seller_messages.subcategory_invalid'),

    'brand_id.required' => __('seller_messages.brand_required'),
    'brand_id.exists' => __('seller_messages.brand_invalid'),

    // Product Names
    'product_name_en.required' => __('seller_messages.product_name_en_required'),
    'product_name_en.unique' => __('seller_messages.product_name_en_unique'),

    'product_name_ar.required' => __('seller_messages.product_name_ar_required'),
    'product_name_ar.unique' => __('seller_messages.product_name_ar_unique'),

      'description_en.required' => __('seller_messages.description_en_required'),
    'description_ar.required' => __('seller_messages.description_ar_required'),

    // Specification
    'product_spe_en.required' => __('seller_messages.product_spe_en_required'),
    'product_spe_en.array' => __('seller_messages.product_spe_en_array'),
    'product_spe_en.*.required' => __('seller_messages.product_spe_en_value_required'),

    'product_spe_feature_en.required' => __('seller_messages.product_spe_feature_en_required'),
    'product_spe_feature_en.array' => __('seller_messages.product_spe_feature_en_array'),
    'product_spe_feature_en.*.required' => __('seller_messages.product_spe_feature_en_value_required'),

    'product_spe_ar.required' => __('seller_messages.product_spe_ar_required'),
    'product_spe_ar.array' => __('seller_messages.product_spe_ar_array'),
    'product_spe_ar.*.required' => __('seller_messages.product_spe_ar_value_required'),

    'product_spe_feature_ar.required' => __('seller_messages.product_spe_feature_ar_required'),
    'product_spe_feature_ar.array' => __('seller_messages.product_spe_feature_ar_array'),
    'product_spe_feature_ar.*.required' => __('seller_messages.product_spe_feature_ar_value_required'),

    // Colors
    'color_id.required' => __('seller_messages.color_required'),
    'color_id.array' => __('seller_messages.color_array'),
    'color_id.*.required' => __('seller_messages.color_field_required'),
    'color_id.*.exists' => __('seller_messages.color_invalid'),

    // Variant Image
    'variant_image.required' => __('seller_messages.variant_image_required'),
    'variant_image.array' => __('seller_messages.variant_image_array'),
    'variant_image.*.required' => __('seller_messages.variant_image_each_required'),
    'variant_image.*.array' => __('seller_messages.variant_image_invalid'),

    // Size Validation
    'size_id.required' => __('seller_messages.size_required'),
    'size_id.array' => __('seller_messages.size_array'),
    'size_id.*.required' => __('seller_messages.size_entry_required'),
    'size_id.*.array' => __('seller_messages.size_array'),
    'size_id.*.*.required' => __('seller_messages.size_value_required'),
    'size_id.*.*.exists' => __('seller_messages.size_invalid'),

    // Inventory
    'total_stock.*.*.required' => __('seller_messages.stock_required'),
    'total_stock.*.*.integer' => __('seller_messages.stock_integer'),

    'sku.*.*.required' => __('seller_messages.sku_required'),
    'sku.*.*.max' => __('seller_messages.sku_max'),

    'actual_price.*.*.required' => __('seller_messages.actual_price_required'),
    'actual_price.*.*.numeric' => __('seller_messages.actual_price_numeric'),

    // Discount
    'discount_type.*.*.required' => __('seller_messages.discount_type_required'),
    'discount_type.*.*.in' => __('seller_messages.discount_type_invalid'),

    'discount_value.*.*.required' => __('seller_messages.discount_value_required'),
    'discount_value.*.*.numeric' => __('seller_messages.discount_value_numeric'),

    'final_price.*.*.required' => __('seller_messages.final_price_required'),
    'final_price.*.*.numeric' => __('seller_messages.final_price_numeric'),

    // Product Policy
    'min_card_quantity.required' => __('seller_messages.min_cart_required'),
    'max_card_quantity.required' => __('seller_messages.max_cart_required'),

    'product_return.required' => __('seller_messages.product_return_required'),
    'product_return.in' => __('seller_messages.product_return_invalid'),

    'return_days.required_if' => __('seller_messages.return_days_required'),
    'return_days.integer' => __('seller_messages.return_days_numeric'),

    'product_exchangable.required' => __('seller_messages.exchange_required'),
    'product_exchangable.in' => __('seller_messages.exchange_invalid'),

    'exchangable_days.required_if' => __('seller_messages.exchange_days_required'),
    'exchangable_days.integer' => __('seller_messages.exchange_days_numeric'),

    'review_rating.required' => __('seller_messages.review_required'),
    'review_rating.in' => __('seller_messages.review_invalid'),

    'affiliated_product.required' => __('seller_messages.affiliate_required'),
    'affiliated_product.in' => __('seller_messages.affiliate_invalid'),
    'affiliated_commission.required_if' => __('seller_messages.affiliate_commission_required'),

    'customized_product.required' => __('seller_messages.customized_required'),
    'customized_product.in' => __('seller_messages.customized_invalid'),

    'ready_to_ship.required' => __('seller_messages.ready_to_ship_required'),
    'ready_to_ship.in' => __('seller_messages.ready_to_ship_invalid'),

    'cash_on_delivery.required' => __('seller_messages.cod_required'),
    'cash_on_delivery.in' => __('seller_messages.cod_invalid'),

    'upload_size_chart.required' => __('seller_messages.size_chart_required'),

    // Body measurement
    'bust.*.*.required' => __('seller_messages.bust_required'),
    'bust.*.*.numeric' => __('seller_messages.bust_numeric'),

    'waist.*.*.required' => __('seller_messages.waist_required'),
    'waist.*.*.numeric' => __('seller_messages.waist_numeric'),

    'hip.*.*.required' => __('seller_messages.hip_required'),
    'hip.*.*.numeric' => __('seller_messages.hip_numeric'),

    'shoulder.*.*.required' => __('seller_messages.shoulder_required'),
    'shoulder.*.*.numeric' => __('seller_messages.shoulder_numeric'),

    'sleeve_length.*.*.required' => __('seller_messages.sleeve_required'),
    'sleeve_length.*.*.numeric' => __('seller_messages.sleeve_numeric'),

    'length.*.*.required' => __('seller_messages.length_required'),
    'length.*.*.numeric' => __('seller_messages.length_numeric'),
        
      ]);

       $validate->after(function ($validate) use ($request) {
            $totalStock = $request->total_stock;
            $sku        = $request->sku;

            if (is_array($totalStock) && is_array($sku)) {
                foreach ($sku as $index => $skuValue) {

                    foreach ($skuValue as $index1 => $skuValue1) {

                    $stockValue = $totalStock[$index][$index1] ?? null;

                    if ($stockValue !== null && $skuValue1 >= $stockValue) {
                        $validate->errors()->add("sku.$index.$index1",__('seller_messages.sku_limit_exceeded'));
                    }
                }

            }
            }
        });



     $validate->after(function ($validate) use ($request) {


    // Image Upload Code Required Field

//   foreach ($request->size_id as $key => $val) {

//     $newImages = $request->variant_image[$key] ?? [];
//     $oldImages = $request->old_variant_image[$key] ?? [];

//     // Check if both are empty
//     if ((empty($newImages) || count($newImages) == 0) &&
//         (empty($oldImages) || count($oldImages) == 0)) {

//         $validate->errors()->add(
//             "variant_image.$key",
//             __('seller_messages.variation_image_required')."#".($key + 1)
//         );
//     }
// }

foreach ($request->size_id as $key => $val) {

    $newImages = $request->variant_image[$key] ?? [];
    $oldImages = $request->old_variant_image[$key] ?? [];

    // Must have at least one file
    if ((empty($newImages) || count($newImages) == 0) &&
        (empty($oldImages) || count($oldImages) == 0)) {

        $validate->errors()->add(
            "variant_image.$key",
            __('seller_messages.upload_atleast_one_product_image')
        );

        continue;
    }

    // Check first file must be image
    $firstFileIsImage = false;

    if (!empty($newImages)) {

        $firstFile = reset($newImages);

        if ($firstFile && str_starts_with($firstFile->getMimeType(), 'image/')) {
            $firstFileIsImage = true;
        }

    } elseif (!empty($oldImages)) {

        $firstOldFile = reset($oldImages);

        $ext = strtolower(pathinfo($firstOldFile, PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $firstFileIsImage = true;
        }
    }

    if (!$firstFileIsImage) {
        $validate->errors()->add(
            "variant_image.$key",
            __('seller_messages.upload_first_image_then_video')
        );
    }
}


    $colors = $request->color_id;
    $sizes  = $request->size_id;

    // Group sizes by color
    $grouped = [];

    foreach ($colors as $i => $color) {

        if(!isset($sizes[$i])) {
            continue;
        }

        $size = $sizes[$i] ?? null;

        foreach ($size as $i1 => $si) {
            $grouped[$i][] = $si;
        }
    }
    
    // // Validate: for same color → sizes must be unique
    foreach ($grouped as $color => $sizesForColor) {
        if (count($sizesForColor) !== count(array_unique($sizesForColor))) {
            $validate->errors()->add(
                'size_id_'.$color,
                "__('seller_messages.color_sizes_must_be_different')"
            );
        }
    }
});

      
      if($validate->fails()){
          return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
         }



     // Product Vartion Image

     $dir="Product";
     $variation_image=[];

     foreach($request->variant_image as $key=>$Image1){

        foreach($Image1 as $key1=>$Image2){
            $variation_image[$key][$key1]=doc_upload($Image2,$dir);  // chart Image
        }
     }

    //  Product Size Chart Upload 
     if($request->upload_size_chart){ 
     $upload_size_chart=doc_upload($request->upload_size_chart,$dir);  // chart Image
     
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
'affiliated_commission'=>$request->affiliated_commission,
'customized_product'=> $request->customized_product, // // 0 not 1 yes
'ready_to_ship'=> $request->ready_to_ship, // // 0 not 1 yes
'cash_on_delivery'=> $request->cash_on_delivery, // // 0 not 1 yes
'upload_size_chart'=> $upload_size_chart,

     ];

  $data=  $this->SellerProductService->AddProduct_web($request_data);

  if(isset($data['status']) && $data['status']=='error' ){
      return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
  }

  if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
        }

  return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
  }

  


public function edit_product1($id){

    $category = Category::orderBy('id', 'asc')->get();
    $brand = Brand::all();
    $color = color::all();
    $size = size::all();
        
        $request_data=(object) [
            'product_id'=>$id,    
        ];
            
    $product =  $this->SellerProductService->single_product_details_fetchweb($request_data);

    $product_details=$product['data'];

    // dump($product_details);
    

    return view('dealer.product.edit_product2',compact('category','brand','color','size','product_details'));
       
}

public function edit_product_code1(Request $request, $id){


    $categoryId = $request->category_id;

    // $seller_details=Auth::guard('seller')->user();
    // $seller_id=$seller_details->id;

     $seller_id=sellerAndStaffId();
       

      $validate = Validator::make($request->all(), [
          'category_id' => 'required|exists:categories,id',
          'subcategory_id' => 'required|exists:sub_categories,id',
          'brand_id' => 'required|exists:brands,id',
          'other_en' => 'nullable',
          'other_ar' => 'nullable',
       
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

            'variant_image' => ['array'],
            // Each variation must be an array
            'variant_image.*' => ['array'],
            // Each image inside each variation is required
            // 'variant_image.*.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', new MatchArrayProductVariation],

            //  'variant_image.*.*' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'variant_image.*.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,webm,mkv|max:20480',
    

            'old_variant_image' => ['array'],
            'old_variant_image.*' => ['nullable'],

      
          // Colors validation (first level array)
          'color_id' => 'required|array|min:1',
          'color_id.*' => 'required|integer|exists:colors,id',
  
          // Sizes: second level array
          'size_id' => 'required|array|min:1',
          'size_id.*' => 'required|array|min:1',
          'size_id.*.*' => 'required|integer|exists:sizes,id',
  
          // Product Inventory
          'total_stock.*.*' => 'required|integer|min:0',
          'sku.*.*' => 'required|string|max:50',
          'actual_price.*.*' => 'required|numeric|min:0',
      
          // Discount fields
          'discount_type.*.*' => 'required|in:1,2', // 1=percentage, 2=fixed price
          'discount_value.*.*' => 'required|numeric|min:0',
          'final_price.*.*' => 'required|numeric|min:0',
  

          // product vartion end
          
          'min_card_quantity'=>'required',
          'max_card_quantity'=>'required',
          'product_return'=>'required|in:0,1', // 0 Not return 1 return Availble 
          'return_days'=> 'required_if:product_return,1|nullable|integer',
          'product_exchangable'=>'required|in:0,1',  // 0 not 1 yes
          'exchangable_days'=>'required_if:product_exchangable,1|nullable|integer',
          'review_rating'=>'required|in:0,1', // 0 not 1 yes
          'affiliated_product'=>'required|in:0,1', // // 0 not 1 yes
          'affiliated_commission'=>'required_if:affiliated_product,1|nullable|integer',

          'customized_product'=>'required|in:0,1', // // 0 not 1 yes
          'ready_to_ship'=>'required|in:0,1', // // 0 not 1 yes
          'cash_on_delivery'=>'required|in:0,1', // // 0 not 1 yes
        
           'upload_size_chart' => 'required_without:old_upload_size_chart',
           'old_upload_size_chart' => 'required_without:upload_size_chart',

       // Body Measurements arrays (required only for category 2)
       
      // Body Measurements arrays (required only for category 2)
    'bust'          => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'waist'         => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'hip'           => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'shoulder'      => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'sleeve_length' => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'length'        => $categoryId == 2 ? 'required|array' : 'nullable|array',

    // Color-level array
    'bust.*'          => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'waist.*'         => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'hip.*'           => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'shoulder.*'      => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'sleeve_length.*' => $categoryId == 2 ? 'required|array' : 'nullable|array',
    'length.*'        => $categoryId == 2 ? 'required|array' : 'nullable|array',

    // Size-level numeric values
    'bust.*.*'          => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',
    'waist.*.*'         => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',
    'hip.*.*'           => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',
    'shoulder.*.*'      => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',
    'sleeve_length.*.*' => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',
    'length.*.*'        => $categoryId == 2 ? 'required|numeric' : 'nullable|numeric',


            
      ],[
    
        // Base Fields
     'category_id.required' => __('seller_messages.category_required'),
    'category_id.exists' => __('seller_messages.category_invalid'),

    'subcategory_id.required' => __('seller_messages.subcategory_required'),
    'subcategory_id.exists' => __('seller_messages.subcategory_invalid'),

    'brand_id.required' => __('seller_messages.brand_required'),
    'brand_id.exists' => __('seller_messages.brand_invalid'),

    'product_name_en.required' => __('seller_messages.product_name_en_required'),
    'product_name_en.unique' => __('seller_messages.product_name_en_unique'),

    'product_name_ar.required' => __('seller_messages.product_name_ar_required'),
    'product_name_ar.unique' => __('seller_messages.product_name_ar_unique'),

    'description_en.required' => __('seller_messages.description_en_required'),
    'description_ar.required' => __('seller_messages.description_ar_required'),


    // Specifications
     'product_spe_en.required' => __('seller_messages.product_spe_en_required'),
    'product_spe_en.array' => __('seller_messages.product_spe_en_array'),
    'product_spe_en.*.required' => __('seller_messages.product_spe_en_value_required'),

    'product_spe_feature_en.required' => __('seller_messages.product_spe_feature_en_required'),
    'product_spe_feature_en.array' => __('seller_messages.product_spe_feature_en_array'),
    'product_spe_feature_en.*.required' => __('seller_messages.product_spe_feature_en_value_required'),

    'product_spe_ar.required' => __('seller_messages.product_spe_ar_required'),
    'product_spe_ar.array' => __('seller_messages.product_spe_ar_array'),
    'product_spe_ar.*.required' => __('seller_messages.product_spe_ar_value_required'),

    'product_spe_feature_ar.required' => __('seller_messages.product_spe_feature_ar_required'),
    'product_spe_feature_ar.array' => __('seller_messages.product_spe_feature_ar_array'),
    'product_spe_feature_ar.*.required' => __('seller_messages.product_spe_feature_ar_value_required'),

    'color_id.required' => __('seller_messages.color_required'),
    'color_id.array' => __('seller_messages.color_array'),
    'color_id.*.required' => __('seller_messages.color_value_required'),
    'color_id.*.exists' => __('seller_messages.color_invalid'),


    // Sizes
    'size_id.required' => __('seller_messages.size_required'),
    'size_id.array' => __('seller_messages.size_array'),
    'size_id.*.required' => __('seller_messages.size_group_required'),
    'size_id.*.*.required' => __('seller_messages.size_value_required'),
    'size_id.*.*.exists' => __('seller_messages.size_invalid'),

'variant_image.array' => __('seller_messages.variant_image_array'),
'variant_image.*.array' => __('seller_messages.variant_image_group_array'),
'variant_image.*.*.image' => __('seller_messages.variant_image_image'),
'variant_image.*.*.mimes' => __('seller_messages.variant_image_mimes'),
'variant_image.*.*.max' => __('seller_messages.variant_image_max'),

'old_variant_image.array' => __('seller_messages.old_variant_image_array'),
'old_variant_image.*.nullable' => __('seller_messages.old_variant_image_nullable'),

'total_stock.*.*.required' => __('seller_messages.total_stock_required'),
'total_stock.*.*.integer' => __('seller_messages.total_stock_integer'),
'total_stock.*.*.min' => __('seller_messages.total_stock_min'),

'sku.*.*.required' => __('seller_messages.sku_required'),
'sku.*.*.string' => __('seller_messages.sku_string'),
'sku.*.*.max' => __('seller_messages.sku_max'),

'actual_price.*.*.required' => __('seller_messages.actual_price_required'),
'actual_price.*.*.numeric' => __('seller_messages.actual_price_numeric'),
'actual_price.*.*.min' => __('seller_messages.actual_price_min'),

'discount_type.*.*.required' => __('seller_messages.discount_type_required'),
'discount_type.*.*.in' => __('seller_messages.discount_type_invalid'),

'discount_value.*.*.required' => __('seller_messages.discount_value_required'),
'discount_value.*.*.numeric' => __('seller_messages.discount_value_numeric'),
'discount_value.*.*.min' => __('seller_messages.discount_value_min'),

'final_price.*.*.required' => __('seller_messages.final_price_required'),
'final_price.*.*.numeric' => __('seller_messages.final_price_numeric'),
'final_price.*.*.min' => __('seller_messages.final_price_min'),

'min_card_quantity.required' => __('seller_messages.min_cart_quantity_required'),
'max_card_quantity.required' => __('seller_messages.max_cart_quantity_required'),

'product_return.required' => __('seller_messages.product_return_required'),
'product_return.in' => __('seller_messages.product_return_invalid'),

'return_days.required_if' => __('seller_messages.return_days_required'),
'return_days.integer' => __('seller_messages.return_days_integer'),

'product_exchangable.required' => __('seller_messages.product_exchange_required'),
'product_exchangable.in' => __('seller_messages.product_exchange_invalid'),

'exchangable_days.required_if' => __('seller_messages.exchange_days_required'),
'exchangable_days.integer' => __('seller_messages.exchange_days_integer'),

'review_rating.required' => __('seller_messages.review_rating_required'),
'review_rating.in' => __('seller_messages.review_rating_invalid'),

'affiliated_product.required' => __('seller_messages.affiliated_product_required'),
'affiliated_product.in' => __('seller_messages.affiliated_product_invalid'),

'affiliated_commission.required_if' => __('seller_messages.affiliated_commission_required'),

'customized_product.required' => __('seller_messages.customized_product_required'),
'customized_product.in' => __('seller_messages.customized_product_invalid'),

'ready_to_ship.required' => __('seller_messages.ready_to_ship_required'),
'ready_to_ship.in' => __('seller_messages.ready_to_ship_invalid'),

'cash_on_delivery.required' => __('seller_messages.cash_on_delivery_required'),
'cash_on_delivery.in' => __('seller_messages.cash_on_delivery_invalid'),

'upload_size_chart.required_without' => __('seller_messages.upload_size_chart_required'),
'old_upload_size_chart.required_without' => __('seller_messages.old_upload_size_chart_required'),

'bust.*.*.required' => __('seller_messages.bust_required'),
'bust.*.*.numeric' => __('seller_messages.bust_numeric'),

'waist.*.*.required' => __('seller_messages.waist_required'),
'waist.*.*.numeric' => __('seller_messages.waist_numeric'),

'hip.*.*.required' => __('seller_messages.hip_required'),
'hip.*.*.numeric' => __('seller_messages.hip_numeric'),

'shoulder.*.*.required' => __('seller_messages.shoulder_required'),
'shoulder.*.*.numeric' => __('seller_messages.shoulder_numeric'),

'sleeve_length.*.*.required' => __('seller_messages.sleeve_length_required'),
'sleeve_length.*.*.numeric' => __('seller_messages.sleeve_length_numeric'),

'length.*.*.required' => __('seller_messages.length_required'),
'length.*.*.numeric' => __('seller_messages.length_numeric'),


      ]);

      $validate->after(function ($validate) use ($request) {
        $totalStock = $request->total_stock;
        $sku        = $request->sku;

        if (is_array($totalStock) && is_array($sku)) {
            foreach ($sku as $index => $skuValue) {

                foreach ($skuValue as $index1 => $skuValue1) {

                $stockValue = $totalStock[$index][$index1] ?? null;

                if ($stockValue !== null && $skuValue1 >= $stockValue) {
                    $validate->errors()->add("sku.$index.$index1", "SKU Limit Not should be greater than Total Stock");
                }
            }

        }
        }
    });
        

     $validate->after(function ($validate) use ($request) {

// new image and old image one must show 

//   foreach ($request->size_id as $key => $val) {

//         $newImages = $request->variant_image[$key] ?? [];
//         $oldImages = $request->old_variant_image[$key] ?? [];

//         // Check if both are empty
//         if ((empty($newImages) || count($newImages) == 0) &&
//             (empty($oldImages) || count($oldImages) == 0)) {

//             $validate->errors()->add(
//                 "variant_image.$key",
//                 "At least one image is required for variation #".($key + 1)
//             );
//         }
//     }

foreach ($request->size_id as $key => $val) {

    $newImages = $request->variant_image[$key] ?? [];
    $oldImages = $request->old_variant_image[$key] ?? [];

    // At least one file required
    if ((empty($newImages) || count($newImages) == 0) &&
        (empty($oldImages) || count($oldImages) == 0)) {

        $validate->errors()->add(
            "variant_image.$key",
            "Please upload at least 1 product image"
        );

        continue;
    }

    $hasImage = false;

    // Check uploaded files
    foreach ($newImages as $file) {

        if (!$file) {
            continue;
        }

        if (str_starts_with($file->getMimeType(), 'image/')) {
            $hasImage = true;
            break;
        }
    }

    // Check old files
    if (!$hasImage && !empty($oldImages)) {

        foreach ($oldImages as $oldFile) {

            $ext = strtolower(pathinfo($oldFile, PATHINFO_EXTENSION));

            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $hasImage = true;
                break;
            }
        }
    }

    if (!$hasImage) {

        $validate->errors()->add(
            "variant_image.$key",
            __('seller_messages.upload_atleast_one_product_image')
        );

        continue;
    }

    // First file must be image
    $firstFileIsImage = false;

    // If old images exist, they come first in edit mode
    if (!empty($oldImages)) {

        $firstFile = reset($oldImages);

        $ext = strtolower(pathinfo($firstFile, PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $firstFileIsImage = true;
        }

    } elseif (!empty($newImages)) {

        $firstFile = reset($newImages);

        if ($firstFile &&
            str_starts_with($firstFile->getMimeType(), 'image/')) {

            $firstFileIsImage = true;
        }
    }

    if (!$firstFileIsImage) {

        $validate->errors()->add(
            "variant_image.$key",
            __('seller_messages.upload_first_image_then_video')
        );
    }
}


// start Color and size are not dublicate 
    $colors = $request->color_id;
    $sizes  = $request->size_id;
    // Group sizes by color
    $grouped = [];

       // Group sizes by color
       $grouped = [];


       foreach ($colors as $i => $color) {

        if(!isset($sizes[$i])) {
            continue;
        }
        
           $size = $sizes[$i] ?? null;
   
           foreach ($size as $i1 => $si) {
               $grouped[$i][] = $si;
           }
       }
       
       // // Validate: for same color → sizes must be unique
       foreach ($grouped as $color => $sizesForColor) {
           if (count($sizesForColor) !== count(array_unique($sizesForColor))) {
               $validate->errors()->add(
                   'size_id_'.$color,
                   __('seller_messages.color_sizes_must_be_different')
               );
           }
       }
            });

      
      if($validate->fails()){
          return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
         }

         

         
     // Product Vartion Image

     $dir="Product";
     $variation_image=[];

    //  foreach($request->variant_image as $key=>$Image1){
    //     foreach($Image1 as $key1=>$Image2){
    //         $variation_image[$key][$key1]=image_upload($Image2,$dir);  // chart Image
    //     }
    //  }

   $final_variation_images = [];

//    dd($request->variant_image);


foreach ($request->color_id as $key => $val) {

    $final_variation_images[$key] = []; // initialize

    $count_array=0;

    // 1️⃣ Add OLD images (if exist)
    if (!empty($request->old_variant_image)) {

        if(isset($request->old_variant_image[$key])!==false){

        foreach ($request->old_variant_image[$key] as $oldImgPath) {
                  $final_variation_images[$key][$count_array]=$oldImgPath;  // chart Image
                  $count_array++;
                  
        }

    }

    }
    
    // 2️⃣ Add NEW uploaded images (if exist)
    if (isset($request->variant_image)) {
        
        if(isset($request->variant_image[$key])!==false){

        foreach ($request->variant_image[$key] as $imgFile) {

            $uploadedPath = doc_upload($imgFile, $dir);   // upload
            $final_variation_images[$key][$count_array] = $uploadedPath;
            $count_array++;

        }
    }

    }

}



    //  Product Size Chart Upload 
     if($request->upload_size_chart){ 
     $upload_size_chart=doc_upload($request->upload_size_chart,$dir);  // chart Image
     
    }else{
          $upload_size_chart=$request->old_upload_size_chart;  // old Image Upload
    }

$request_data=(object) [
'product_id'=>$id,
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
'variant_image' => $final_variation_images,
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
// 'sku_threshold_value' => $request->sku_threshold_value,
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

'affiliated_commission'=>$request->affiliated_commission,

'customized_product'=> $request->customized_product, // // 0 not 1 yes
'ready_to_ship'=> $request->ready_to_ship, // // 0 not 1 yes
'cash_on_delivery'=> $request->cash_on_delivery, // // 0 not 1 yes
'upload_size_chart'=> $upload_size_chart

     ];



  $data=  $this->SellerProductService->edit_Product_web($request_data);

  if(isset($data['status']) && $data['status']=='error' ){
      return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
  }

  return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
  }



  // new Add edit product code End here 
    



public function view_inventory(Request $request , $id){

    $request_data=(object) [
        'product_id'=>$id,    
    ];
        
        $product =  $this->SellerProductService->single_product_details_fetch($request_data);
    
        $product=$product['data'];
    
        // dump($product);
        
        return view('dealer.product.view_inventory',compact('product'));
        
    }




public function getcolorsizeaccordingdetails(Request $request)
{

    $data= ProductVariant::with('size')->where('product_id', $request->product_id)
    ->where('color_id',$request->color)
    ->where('size_id',$request->size)
    ->first();

    // dd($product_data);

    return response()->json(['data'=>$data]);

}


  public function update_inventory_stock(Request $request){

     $validate = Validator::make($request->all(), [               
        'inventory_product_id'=>'required|exists:products,id',
        'variation_id'=>'required|exists:product_variants,id' ,
        // 'stock_quantity'=>'required',
        // 'sku' =>'nullable'

        'stock_quantity' => 'required|integer',
        'sku' => 'nullable|integer|lte:stock_quantity',        
     ],[
        //  'sku.lte' => 'SKU cannot be greater than stock quantity.',

    'inventory_product_id.required' => __('seller_messages.inventory_product_required'),
    'inventory_product_id.exists' => __('seller_messages.inventory_product_invalid'),

    'variation_id.required' => __('seller_messages.variation_required'),
    'variation_id.exists' => __('seller_messages.variation_invalid'),

    'stock_quantity.required' => __('seller_messages.stock_quantity_required'),
    'stock_quantity.integer' => __('seller_messages.stock_quantity_integer'),

    'sku.integer' => __('seller_messages.sku_integer'),
    'sku.lte' => __('seller_messages.sku_lte'),


     ]);
    
    if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
    }

    // $seller_details=Auth::guard('seller')->user();
    // $seller_id=$seller_details->id;

     $seller_id=sellerAndStaffId();
       
    
    $request_data=(object) [
    'seller_id'=>$seller_id,
    'product_id'=>$request->inventory_product_id,
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
    
    

}

