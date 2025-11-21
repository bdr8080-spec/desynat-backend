<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;

use App\Services\UserManagementService;

use Validator;


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
        'category_id'=>$request->category_id
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

       $user_id=$request->user()->id;
      
       $request_data=(object)[
        'user_id'=>$user_id,
        'store_id'=>$request->store_id,
        'search' =>$request->search,
        'sort_filter'=> $request->sort_filter
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

       $user_id=$request->user()->id;
      
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

       

    
}