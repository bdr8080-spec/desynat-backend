<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use Validator;



use App\Services\SellerStaffManagementService;

class SellerStaffManagementController extends Controller
{

       public function __construct(SellerStaffManagementService $SellerStaffManagementService){
        $this->SellerStaffManagementService=$SellerStaffManagementService;
    }

    public function newStaffCategoryType(Request $request){

    $data=  $this->SellerStaffManagementService->newStaffCategoryType();

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}


 public function SellerAllMenu(Request $request){

    $data=  $this->SellerStaffManagementService->SellerAllMenu();

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    


    }



 public function addNewStaff(Request $request){


 $validate = Validator::make($request->all(), [
            'full_name' => 'required',
            'name_ar' => 'required',
            'profile_pic'=>'required',
            'country_code'=>'required',
            'mobile'=>'required',
            'email'=>'required',
            'select_category'=>'required',
            'password'=>'required',
            'menu_id' => 'required|array',
            'menu_id.*.id' => 'required|integer',
            'menu_id.*.can_view' => 'required|integer',                       
            'menu_id.*.can_action' => 'required|integer',                       
        ]);

        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }

    $seller_id=  $request->user()->id;

    $request_data=(object)$validate->validate();
    $request_data->seller_id=$seller_id;


           
    $data=  $this->SellerStaffManagementService->AddNewStaffManagment($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}



 public function EditNewStaff(Request $request){

 $validate = Validator::make($request->all(), [
            "id"=>"required|exists:sellers,id",
            'full_name' => 'required',
            'name_ar' => 'required',
            'profile_pic'=>'required',
            'country_code'=>'required',
            'mobile'=>'required',
            'email'=>'required',
            'select_category'=>'required',
            'password'=>'required',
            'menu_id' => 'required|array',
            'menu_id.*.id' => 'required|integer',
            'menu_id.*.can_view' => 'required|integer',                       
            'menu_id.*.can_action' => 'required|integer',                       
        ]);

        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }

    $seller_id=  $request->user()->id;

    $request_data=(object)$validate->validate();
    $request_data->seller_id=$seller_id;


    
           
    $data=  $this->SellerStaffManagementService->EditNewStaffManagment($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}





public function AllStaffDetails(Request $request){

    $seller_id=  $request->user()->id;

    $request=(object)[
        'from'=>$request->from,
        "to"=>$request->to,
        "status_filter"=>$request->status_filter,
        "role_filter"=>$request->role_filter,
        "seller_id"=>$seller_id
    ];


    $data=  $this->SellerStaffManagementService->AllStaffDetails($request);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}


public function StaffActiveInactive(Request $request){



 $validate = Validator::make($request->all(), [
            'id' => 'required|exists:sellers,id',
        ]);

        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }

    $seller_id=$request->user()->id;

    $request_data=(object)[
        'id'=>$request->id,
        "seller_id"=>$seller_id
    ];

    $data=  $this->SellerStaffManagementService->StaffActiveInactive($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    


    }

    


public function staffDeleteStaff(Request $request){
    $validate = Validator::make($request->all(), [
    'id' => 'required|exists:sellers,id',
    ]);

    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }
    $seller_id=$request->user()->id;

    $request_data=(object)[
        'id'=>$request->id,
        "seller_id"=>$seller_id
    ];

    $data=  $this->SellerStaffManagementService->staffDelete($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

public function viewSingleStaffDetails(Request $request){
    $validate = Validator::make($request->all(), [
    'id' => 'required|exists:sellers,id',
    ]);

    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }
    $seller_id=$request->user()->id;

    $request_data=(object)[
        'id'=>$request->id,
        "seller_id"=>$seller_id
    ];

    $data=  $this->SellerStaffManagementService->viewSingleStaffDetails($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }





}
