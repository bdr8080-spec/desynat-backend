<?php

namespace App\Http\Controllers\User;

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


       dump($store_details);
       
        return view('user.category.index',compact('store_details'));
    }



    


    public function AddOrRemove_wishlist(Request $request)
    {

        dd("sdd");

        $user_id=  $request->user()->id;

        $request_data=(object)[
            'user_id'=>$user_id,
            'product_id'=>$request->product_id
           ];
    
        dd($request_data);

         $data=$this->UserManagementService->product_add_to_wishlist($request_data);


           if(isset($data['status']) && $data['status']=='error' ){
               return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
       
           }

           return ApiResponse::generateResponse('success','Wishlist_Add_Successfully', [], 200);
    

    }









    
}