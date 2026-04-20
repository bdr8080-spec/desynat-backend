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
}
