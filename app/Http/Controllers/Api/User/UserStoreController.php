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


       $request_data=(object)[
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

    
}