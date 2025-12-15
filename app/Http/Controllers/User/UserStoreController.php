<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use App\Services\UserManagementService;
use Validator;
use App\Models\Brand;
use App\Models\color;
use App\Models\{Category,size,wishlist,product};
use Auth;
use App\Models\Addtocart;

class UserStoreController extends Controller
{

    public function __construct(UserManagementService $UserManagementService){

        $this->UserManagementService=$UserManagementService;
           
    }


    public function category_wise_store(Request $request,$id=null){


       $request_data=(object)[
        'category_id'=>$id,
        'search'=>$request->search,
        'rating'=>$request->rating,
        'availbility'=>$request->availability,
        'shortest_delivery'=>$request->shortest_delivery,
        'highest_sale'=>$request->highest_sale
       ];
       
       

       $store_data=$this->UserManagementService->getStoreWithCatgory($request_data);

       $store_data=$store_data['data'];

       //dd($store_data);

    
       return view('user.category.store',compact('store_data'));

    }


    // public function store_details(Request $request ,$id){

    //     $validate = Validator::make(['id'=>$id], [
    //         // "profile_image"=>"required",
    //         'id' => 'required|exists:seller_store_information,id',
    //     ]);

    //     if ($validate->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validate)
    //             ->withInput();
    //     }

    //     if(isset($request->user()->id)){
    //          $user_id=  $request->user()->id;
    //     }
       

    

    //     $request_data = (object)[
    //         'user_id'        => $user_id,
    //         'store_id'       => $id,
    //         'search'         => $request->search ?? null,
    //         'sort_filter'    => $request->sort_filter ?? null,
    //         'brand_id'       => $request->brand_id ?? null,
    //         'category_id'    => $request->category_id ?? null,
    //         'size_id'        => $request->size_id ?? null,
    //         'color_id'       => $request->color_id ?? null, 
    //         'rating'         => $request->rating ?? null,
    //         'delivery_time'  => $request->delivery_time ?? null,
    //         'delivery_option'=> $request->delivery_option ?? null,
    //     ];


    //     if(isset($request->price_min)){
    //         $request_data['price_min']  = Intval($request->price_min) ?? null;          
    //     }
    //     if(isset($request->price_max)){
            
    //         $request_data['price_max']  = Intval($request->price_max) ?? null;          
    //     }
    //     if(isset($request->discount)){
            
    //         $request_data['discount']  = Intval($request->discount) ?? null;          
    //     }
              
    //     $store_details=$this->UserManagementService->singleStoreWiseAllproduct($request_data);


    //    $store_details=$store_details['data'];

    //   $brand =  Brand::orderBy('name_english','asc')->get();
    //   $category =  Category::orderBy('id','desc')->get();
    //   $size =  size::orderBy('name','desc')->get();
    //   $color = color::orderBy('name','asc')->get();

      
    //     return view('user.category.index',compact('store_details','category','brand','size','color'));
    // }
    public function store_details(Request $request, $id)
    {
        // Validate store ID
        $validate = Validator::make(['id' => $id], [
            'id' => 'required|exists:seller_store_information,id',
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        // Get logged-in user ID
        $user_id = isset($request->user()->id) ? $request->user()->id : null;

        // Prepare request data as an object
        $request_data = (object)[
            'user_id'        => $user_id,
            'store_id'       => $id,
            'search'         => $request->search ?? null,
            'sort_filter'    => $request->sort_filter ?? null,
            'brand_id'       => $request->brand_id ?? null,
            'category_id'    => $request->category_id ?? null,
            'size_id'        => $request->size_id ?? null,
            'color_id'       => $request->color_id ?? null,
            'price_min'      => isset($request->price_min) ? intval($request->price_min) : null,
            'price_max'      => isset($request->price_max) ? intval($request->price_max) : null,
            'discount'       => isset($request->discount) ? intval($request->discount) : null,
            'rating'         => $request->rating ?? null,
            'delivery_time'  => $request->delivery_time ?? null,
            'delivery_option'=> $request->delivery_option ?? null,
        ];

        // Call service method
        $store_details = $this->UserManagementService->singleStoreWiseAllproduct($request_data);
        $store_details = $store_details['data'];

        // Fetch filters for view
        $brand = Brand::orderBy('name_english', 'asc')->get();
        $category = Category::orderBy('id', 'desc')->get();
        $size = Size::orderBy('name', 'desc')->get();
        $color = Color::orderBy('name', 'asc')->get();

        return view('user.category.index', compact('store_details', 'category', 'brand', 'size', 'color'));
    }

    


    public function AddOrRemove_wishlist(Request $request)
    {

        $user_id=  $request->user()->id;

        $request_data=(object)[
            'user_id'=>$user_id,
            'product_id'=>$request->product_id
           ];

         $data=$this->UserManagementService->product_add_to_wishlist($request_data);

        
           if(isset($data['status']) && $data['status']=='error' ){
               return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
           }

           return ApiResponse::generateResponse($data['status'],$data['message'],$data['data'], 200);
    }



    public function productDetails(Request $request,string $id){

        
        $request_data=(object)[
            'product_id'=>$id,
            'user_id'=> $request->user()->id ?? null
                   ];
        $result = $this->UserManagementService->singleproductView($request_data);
    
        $data = $result['data'];
        //dd($data);



        $product_variants = [];

 foreach ($data->product_variants as $item) {

    $colorKey = $item->color->name;
    $colorHex = $item->color->hex_code;

    if (isset($product_variants[$colorHex])) {  // <-- FIXED HERE

        if (is_array($item->variant_image)) {
            $product_variants[$colorHex]['variant_image'] = array_merge(
                $product_variants[$colorHex]['variant_image'],
                $item->variant_image
            );
        }

        if (!in_array($item->size->name, $product_variants[$colorHex]['sizes'])) {
            $product_variants[$colorHex]['sizes'][] = $item->size->name;
        }

    } else {

        $product_variants[$colorHex] = [
            'variant_id' => $item->id,
            'product_id' => $item->product_id,
            'color_hex'      => $colorHex,
            'variant_image'  => is_array($item->variant_image) ? $item->variant_image : [],
            'sizes'          => [$item->size->name],
            'actual_price'   => $item->actual_price,
            'final_price'    => $item->final_price,
            'discount_value' => $item->discount_value,
            'discount_type'  => $item->discount_type,
            'total_stock'  => $item->total_stock
        ];
    }
}

$productVariantsById = [];
foreach ($data->product_variants as $item) {
    $productVariantsById[$item->id] = [
        'variant_id' => $item->id,
        'product_id' => $item->product_id,
        'color_hex' => $item->color->hex_code,
        'size' => $item->size->name,
        'actual_price' => $item->actual_price,
        'final_price' => $item->final_price,
        'discount_value' => $item->discount_value,
        'discount_type' => $item->discount_type,
        'variant_image' => is_array($item->variant_image) ? $item->variant_image : [],
        'total_stock' => $item->total_stock,
    ];
}


    //dd($product_variants);
    if (!$request->user()) {
    $cartCount = 0;
    } else {
        $cartCount = Addtocart::where('user_id', $request->user()->id)
            //->where('product_id', $id)
            ->count();
    }

    if (!$request->user()) {
    $cartData = [];
    } else {
        $cartData = Addtocart::where('user_id', $request->user()->id)
            //->where('product_id', $id)
            ->get() 
            ->keyBy('variants_id');
    }

   // dd($cartData);




  
        return view('user.category.product-store-details', compact('data','product_variants','cartCount','cartData','productVariantsById'));
    }




     public function wishList(Request $request){
        
        $id = $request->user()->id;

        $product_id = wishlist::where('user_id', $id)->pluck('product_id');

        $wishListProduct = product::with('product_variants')->whereIn('id',$product_id)->get();
        
       $wishListProduct->map(function ($item) use ($request) {
                $item->user_name = $request->user()->full_name;
                return $item;
            });

        return view('user.profile.wishlist', compact('wishListProduct'));
       

     }

      public function addToCart(Request $request){

        $request_data = (object)[
            'user_id'     => $request->user()->id,
            'product_id'  => $request->product_id,
            'variants_id' => $request->variant_id, 
            'quantity'    => $request->quantity
        ];
        $data = $this->UserManagementService->product_add_to_cart_without_quantity_increment($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
               return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
           }

           return ApiResponse::generateResponse($data['status'],$data['message'],$data['data'], 200); 

     }

    
}