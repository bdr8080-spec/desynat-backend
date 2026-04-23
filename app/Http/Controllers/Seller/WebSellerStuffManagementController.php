<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\ApiResponse;
use Validator;
use App\Services\SellerStaffManagementService;

use App\Models\country;

use Auth;

class WebSellerStuffManagementController extends Controller
{

    public function __construct(SellerStaffManagementService $SellerStaffManagementService){
        $this->SellerStaffManagementService=$SellerStaffManagementService;
    }

    public function index(Request $request){

    $seller_id=Auth::guard('seller')->user()->id;

    $request=(object)[
        'from'=>$request->from,
        "to"=>$request->to,
        "status_filter"=>$request->status_filter,
        "role_filter"=>$request->role_filter,
        "seller_id"=>$seller_id
    ];

    $data=  $this->SellerStaffManagementService->AllStaffDetails($request);
    $all_staff=$data['data'];


    return view('dealer.staff.index',compact('all_staff'));

    }


    public function addStaff(Request $request){

         $seller_id=Auth::guard('seller')->user()->id;


       if($request->ismethod('get')){
            $data=  $this->SellerStaffManagementService->newStaffCategoryType();
            $staff_category=$data['data'];

            $sellerMenu=  $this->SellerStaffManagementService->SellerAllMenu();
            $sellerMenu=$sellerMenu['data'];

            $all_country=country::get();    
            return view('dealer.staff.add-staff',compact('staff_category','all_country','sellerMenu'));
       }


    //    Add Stuff Code 

     $validator = Validator::make($request->all(), [

        'full_name' => 'required|string|max:255',
        'name_ar' => 'nullable|string|max:255',

        'profile_pic' => 'required',

        'country_code' => 'required|string|max:10',
        'mobile' => 'required|digits_between:8,15',

        'email' => 'required|email',

        'select_category' => 'required|exists:seller_type_categories,id',

        'password' => 'required|min:6|same:confirm_password',
        'confirm_password' => 'required',

        'menu_id' => 'required|array|min:1',

        'menu_id.*.id' => 'required|exists:seller_menus_tables,id',
        'menu_id.*.can_view' => 'required|boolean',
        'menu_id.*.can_action' => 'required|boolean',

    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }


    $request_data= (object) $validator->validate();

    // ✅ Upload Image
    if ($request->hasFile('profile_pic')) {

        $dir='stuff/';

        $image = $request->file('profile_pic');
        $upload_image=image_upload($image,$dir);

        $request_data->profile_pic= $upload_image;

    }

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
