<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use App\Services\UserManagementService;
use App\Services\UserDashboardService;
use App\Services\StoryManagementService;


use Validator;
use App\Models\Brand;
use App\Models\color;
use App\Models\{Category,size,wishlist,product};
use Auth;
use App\Models\Addtocart;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Storage;


class UserStoreController extends Controller
{

    public function __construct(UserManagementService $UserManagementService,UserDashboardService $UserDashboardService,StoryManagementService $StoryManagementService){

        $this->UserManagementService=$UserManagementService;
        $this->UserDashboardService=$UserDashboardService;
        $this->StoryManagementService=$StoryManagementService;
   
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
            $request_data1 = (object)[
                    'type'        => '3',
                    'category'    => $id,
                ];

            $catBanners= $this->UserDashboardService->HomeScreenBanner($request_data1);
           // dd($catBanners);

    
       return view('user.category.store',compact('store_data','catBanners'));

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
        //dd($store_details);

        // Fetch filters for view
        $brand = Brand::orderBy('name_english', 'asc')->get();
        $category = Category::orderBy('id', 'desc')->get();
        $size = Size::orderBy('name', 'desc')->get();
        $color = Color::orderBy('name', 'asc')->get();
        
        // Qr Create Scanner Code 
           $qrSellerCode = url()->full();

        $seller_id = $store_details['store']['seller_id'];
       // dd($seller_id);

        $request_data1 = (object)[
            'seller_id' => $seller_id,
        ];

        $seller_highlights = $this->StoryManagementService->getSellerHighlightOnUser($request_data1)['data'];
        //dd($seller_highlights);
        $request_data2 = (object)[
            'seller_id' => $seller_id,
            'user_id' => $user_id,
            'limit' => $request->limit??null,
        ];
        $seller_reels = $this->StoryManagementService->getSellerReelOnUser($request_data2)['data'];
       // dd($seller_reels);

          
        return view('user.category.index', compact('store_details', 'category', 'brand', 'size', 'color','qrSellerCode','seller_highlights','seller_reels'));
        
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

        $affiliate_id = $request->query('ref'); // get affiliate id from URL
        $product_id = $id;

        if ($affiliate_id) {
            $request_data1=(object)[
            'user_id' => $request->user()->id ?? null,
                'product_id' => $product_id,
                'affiliate_id' => $affiliate_id,
                'reference_link' => $request->fullUrl()
            ];

            $result = $this->UserManagementService->recordAffiliateClick($request_data1);

        }

        $request_data=(object)[
            'product_id'=>$id,
            'user_id'=> $request->user()->id ?? null
                   ];
        $result = $this->UserManagementService->singleproductView($request_data);
    
        $data = $result['data'];
        //dd($data);



        $product_variants = [];

 foreach ($data->product_variants as $key=>$item) {

    $colorKey = $item->color->name;
    $colorHex = $item->color->hex_code;

    if (isset($product_variants[$colorHex])) {  // <-- FIXED HERE
           
        if($key==0){
    
        if (is_array($item->variant_image)) {      
            $product_variants[$colorHex]['variant_image'] =
             array_merge(
                $product_variants[$colorHex]['variant_image'],
                $item->variant_image
            );
        }
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




  
        return view('user.category.product-store-details', compact('data','product_variants','cartCount','cartData','productVariantsById'));
    }




     public function wishList(Request $request){
        
        $id = $request->user()->id;

        $product_id = wishlist::where('user_id', $id)->pluck('product_id');

        $wishListProduct = product::with('product_variants','review')->whereIn('id',$product_id)->get();
        
       $wishListProduct->map(function ($item) use ($request) {

            $item->user_name = $request->user()->full_name;

            $item->product_avg_rating = $item->review->avg('product_rating') ?? 0;

            $item->review_count = $item->review->count() ?? 0;

            return $item;
        });

        $request_data=(object)[
            'user_id'=>$id,
            ];

        $wishlistedReels = $this->StoryManagementService->GetWhislistedReels($request_data)['data'];
       // dd($wishlistedReels);

        return view('user.profile.wishlist', compact('wishListProduct','wishlistedReels'));
       

     }

      public function addToCart(Request $request){
        //dd($request->all());

        $request_data = (object)[
            'user_id'     => $request->user()->id,
            'product_id'  => $request->product_id,
            'variants_id' => $request->variant_id, 
            'quantity'    => $request->quantity,
            'reference_link'    => $request->reference_link??null,
        ];
        $data = $this->UserManagementService->product_add_to_cart_without_quantity_increment($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
               return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
           }

           return ApiResponse::generateResponse($data['status'],$data['message'],$data['data'], 200); 

     }




     public function all_product(Request $request)
    {
      
        // Get logged-in user ID
        $user_id = isset($request->user()->id) ? $request->user()->id : null;

        $request_data=(object)[
        'user_id'=>$user_id??null,
        'search' =>$request->search,
        'sort_filter'=> $request->sort_filter,
        'brand_id'     => is_array($request->brand_id) ? $request->brand_id : [],     
        'category_id'  => is_array($request->category_id) ? $request->category_id : [],   
        'size_id'      => is_array($request->size_id) ? $request->size_id : [],       
        'color_id'     => is_array($request->color_id) ? $request->color_id : [],      
        'price_min'    => $request->price_min ?? null,
        'price_max'    => $request->price_max ?? null,
       ];

     $AllProduct_data=$this->UserDashboardService->HomePageSearch($request_data);
    
    $AllProduct = $AllProduct_data['data'];


        // Fetch filters for view
        $brand = Brand::orderBy('name_english', 'asc')->get();
        $category = Category::orderBy('id', 'desc')->get();
        $size = Size::orderBy('name', 'desc')->get();
        $color = Color::orderBy('name', 'asc')->get();
        
        return view('user.product.all-product', compact('AllProduct', 'category', 'brand', 'size', 'color'));
    }



       public function CustomorderAddToCard(Request $request)
    {
        $user_id=$request->user()->id;

        try {

        $validate = Validator::make($request->all(), [
            'unique_id' => 'required|exists:allproductchats,unique_id',
         ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

        $request_data=(object)[
          'user_id'=>$user_id,
          'unique_id'=>$request->unique_id,
         ];

            $data = $this->UserManagementService->CustomorderAddToCard($request_data);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }      
    
    
       public function RemoveCustomProductAddToCard(Request $request)
    {
        $user_id=$request->user()->id;

        try {

        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:addtocarts,id',
         ]);

       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

        $request_data=(object)[
          'user_id'=>$user_id,
          'id'=>$request->id,
         ];

            $data = $this->UserManagementService->RemoveCustomProductAddToCard($request_data);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }      

    
}