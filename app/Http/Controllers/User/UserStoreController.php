<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use App\Services\UserManagementService;
use Validator;
use App\Models\Brand;
use App\Models\{Category,size};
use Auth;

class UserStoreController extends Controller
{

    public function __construct(UserManagementService $UserManagementService){

        $this->UserManagementService=$UserManagementService;
           
    }


    public function category_wise_store(Request $request,$id){
    

     

        $user_id=  $request->user()->id;
    
       $request_data=(object)[
        'category_id'=>$id,
        'search'=>$request->search,
        'rating'=>$request->rating,
        'availability'=>$request->availability,
        'shortest_delivery'=>$request->shortest_delivery,
        'highest_sale'=>$request->highest_sale
       ];
       

       $store_data=$this->UserManagementService->getStoreWithCatgory($request_data);

       $store_data=$store_data['data'];

    
       return view('user.category.store',compact('store_data'));

    }


    public function store_details(Request $request ,$id){

        $validate = Validator::make(['id'=>$id], [
            // "profile_image"=>"required",
            'id' => 'required|exists:seller_store_information,id',
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $user_id=  $request->user()->id;
      
        $request_data=(object)[
         'user_id'=>$user_id,
         'store_id'=>$request->id,
         'search' =>$request->search,
         'sort_filter'=> $request->sort_filter
        ];
 
        $store_details=$this->UserManagementService->singleStoreWiseAllproduct($request_data);


       $store_details=$store_details['data'];

      $brand =  Brand::orderBy('name_english','asc')->get();
      $category =  Category::orderBy('id','desc')->get();
      $size =  size::orderBy('name','desc')->get();
       
   
      
        return view('user.category.index',compact('store_details','category','brand','size'));
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









    
}