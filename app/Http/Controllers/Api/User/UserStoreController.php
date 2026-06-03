<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;

use App\Services\UserManagementService;

use Validator;

use Auth;

class UserStoreController extends Controller
{
    public function __construct(UserManagementService $UserManagementService){

        $this->UserManagementService=$UserManagementService;
           
    }


    public function category_Wise_Store_List(Request $request){

        $validate = Validator::make($request->all(), [
            // "profile_image"=>"required",
            'category_id' => 'required|exists:categories,id',
         ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       
       $request_data=(object)[
        'category_id'=>$request->category_id,
        'subcategory'=>$request->subcategory,
        "search"=>$request->search,
        "rating"=>$request->rating,
        "availbility"=>$request->availbility,
        "user_id"=>$request->user_id ?? null,
       ];


       $data=$this->UserManagementService->getStoreWithCatgory($request_data);


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    



    public function single_store_details(Request $request){

        $validate = Validator::make($request->all(), [
            // "profile_image"=>"required",
            'store_id' => 'required|exists:seller_store_information,id',
         ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $user_id=$request->user->id??null;

      
       $request_data=(object)[
        'user_id'=>$user_id,
        'store_id'=>$request->store_id,
        'search' =>$request->search,
        'sort_filter'=> $request->sort_filter,
        'brand_id'     => is_array($request->brand_id) ? $request->brand_id : [],     
        'category_id'  => is_array($request->category_id) ? $request->category_id : [],   
        'size_id'      => is_array($request->size_id) ? $request->size_id : [],       
        'color_id'     => is_array($request->color_id) ? $request->color_id : [],      
        'price_min'    => $request->price_min ?? null,
        'price_max'    => $request->price_max ?? null,
        'discount'    => $request->discount ?? null,
        'rating'    => $request->rating ?? null,
        'delivery_time'    => $request->delivery_time ?? null,
        'delivery_option'    => $request->delivery_option ?? null,
       ];

       $data=$this->UserManagementService->singleStoreWiseAllproduct($request_data);


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }





    public function single_product_details(Request $request){

        $validate = Validator::make($request->all(), [
            // "profile_image"=>"required",
            'product_id' => 'required|exists:products,id',
         ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

       $user_id=$request->user->id??null;

      
       $request_data=(object)[
        'user_id'=>$user_id,
        'product_id'=>$request->product_id,
       ];

     $data=$this->UserManagementService->singleproductView($request_data);
       

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }



    public function store_filter(Request $request){

     $data=$this->UserManagementService->get_store_filter();


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }



    

    
    public function product_add_to_wishlist(Request $request){

        

        $validate = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
         ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

      $user_id=$request->user()->id;

       $request_data=(object)[
        'user_id'=>$user_id,
        'product_id'=>$request->product_id
       ];

        $data=$this->UserManagementService->product_add_to_wishlist($request_data);
   
   
       if(isset($data['status']) && $data['status']=='error' ){
           return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
   
       }
   
       return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
   
       }




    
    public function product_add_to_cart(Request $request){

        $validate = Validator::make($request->all(), [
            'product_id' => 'required|integer| exists:products,id',
            'quantity'=>'required|integer',
            'variants_id' => 'required|exists:product_variants,id|integer',
            'reference_link' => 'nullable',
         ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

      $user_id=$request->user()->id;

       $request_data=(object)[
        'user_id'=>$user_id,
        'product_id'=>intval($request->product_id),
        'quantity'=>intval($request->quantity),
        'variants_id'=>intval($request->variants_id),
        'reference_link'=>$request->reference_link,
       ];

        $data=$this->UserManagementService->product_add_to_cart($request_data);
   
       if(isset($data['status']) && $data['status']=='error' ){
           return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
   
       }
   
       return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
   
       }


       


    
    public function view_cart_details(Request $request){


      $user_id=$request->user()->id;

       $request_data=(object)[
        'user_id'=>$user_id,
       ];

        $data=$this->UserManagementService->product_view_cart_details($request_data);
   
       if(isset($data['status']) && $data['status']=='error' ){
           return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
   
       }
   
       return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
   
       }


       
    
    public function addtocart_increment_decrement(Request $request){

        $validate = Validator::make($request->all(), [
            'cart_id' => 'required|integer| exists:addtocarts,id',
            'type' => 'required|in:increment,decrement',
         ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

        $user_id=$request->user()->id;
  
         $request_data=(object)[
          'user_id'=>$user_id,
          'cart_id'=>$request->cart_id,
          'type'=>$request->type,
         ];

          $data=$this->UserManagementService->addtoCart_Increment_decrement($request_data);

          
         if(isset($data['status']) && $data['status']=='error' ){
             return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
     
         }
     
         return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
     
         }

    public function get_wishlist_products(Request $request)
    {
        $user_id=$request->user()->id;

        try {
            $data = $this->UserManagementService->getWishlist($user_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 200);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
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