<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\ApiResponse;
use Validator;
use App\Services\SellerStaffManagementService;

use App\Models\{country,sellermenuAction};

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

    $data=  $this->SellerStaffManagementService->AllStaffDetails($request,'web');
    $all_staff=$data['data'];


    return view('dealer.staff.index',compact('all_staff'));

    }


    public function addStaff(Request $request){

         $seller_id=Auth::guard('seller')->user()->id;


       if($request->ismethod('get')){
            $data=  $this->SellerStaffManagementService->newStaffCategoryType();
            $staff_category=$data['data'];

            $sellerMenu=  $this->SellerStaffManagementService->SellerAllMenu('1');
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

     ],[
        'full_name.required' => __('seller_messages.full_name_required'),
        'full_name.string' => __('seller_messages.full_name_string'),
        'full_name.max' => __('seller_messages.full_name_max'),

        'name_ar.string' => __('seller_messages.name_ar_string'),
        'name_ar.max' => __('seller_messages.name_ar_max'),

        'profile_pic.required' => __('seller_messages.profile_pic_required'),

        'country_code.required' => __('seller_messages.country_code_required'),
        'country_code.string' => __('seller_messages.country_code_string'),
        'country_code.max' => __('seller_messages.country_code_max'),

        'mobile.required' => __('seller_messages.mobile_required'),
        'mobile.digits_between' => __('seller_messages.mobile_digits_between'),

        'email.required' => __('seller_messages.email_required'),
        'email.email' => __('seller_messages.email_email'),

        'select_category.required' => __('seller_messages.select_category_required'),
        'select_category.exists' => __('seller_messages.select_category_exists'),

        'password.required' => __('seller_messages.password_required'),
        'password.min' => __('seller_messages.password_min'),
        'password.same' => __('seller_messages.password_same'),

        'confirm_password.required' => __('seller_messages.confirm_password_required'),

        'menu_id.required' => __('seller_messages.menu_required'),
        'menu_id.array' => __('seller_messages.menu_array'),
        'menu_id.min' => __('seller_messages.menu_min'),

        'menu_id.*.id.required' => __('seller_messages.menu_id_required'),
        'menu_id.*.id.exists' => __('seller_messages.menu_id_exists'),

        'menu_id.*.can_view.required' => __('seller_messages.can_view_required'),
        'menu_id.*.can_view.boolean' => __('seller_messages.can_view_boolean'),

        'menu_id.*.can_action.required' => __('seller_messages.can_action_required'),
        'menu_id.*.can_action.boolean' => __('seller_messages.can_action_boolean'),
     ]
);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }


    $request_data= (object) $validator->validate();

    // ✅ Upload Image
    if ($request->hasFile('profile_pic')) {

        $dir='staff/';

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



public function activeAndInactiveStaff(Request $request){

    $request_data=(object) [
    'id'=>$request->id,
    ];
 
    $data=  $this->SellerStaffManagementService->StaffActiveInactive($request_data);


  return $data;

}



public function deleteStaff(Request $request){

    $request_data=(object) [
    'id'=>$request->id,
    ];
 
    $data=  $this->SellerStaffManagementService->staffDelete($request_data);

  return $data;

}


public function editStaff(Request $request){


     if($request->ismethod('get')){
            $data=  $this->SellerStaffManagementService->newStaffCategoryType();
            $staff_category=$data['data'];

            $sellerMenu=  $this->SellerStaffManagementService->SellerAllMenu(1);
            $sellerMenu=$sellerMenu['data'];

            $all_country=country::get();  
            

            $request_data=(object)[
                'id'=>$request->id
            ];

            $data=  $this->SellerStaffManagementService->viewSingleStaffDetails($request_data);

            $view_staff=$data['data'];

            return view('dealer.staff.edit-staff',compact('staff_category','all_country','sellerMenu','view_staff'));
       }

//  Post request 

$validate = Validator::make($request->all(), [
            "id"=>"required|exists:sellers,id",
            'full_name' => 'required',
            'name_ar' => 'required',
            // 'profile_pic'=>'required',
            'country_code'=>'required',
            'mobile'=>'required',
            'email'=>'required',
            'select_category'=>'required',
            'password'=>'required',
            'menu_id' => 'required|array',
            'menu_id.*.id' => 'required|integer',
            'menu_id.*.can_view' => 'required|integer',                       
            'menu_id.*.can_action' => 'required|integer',                       
],
[
        'full_name.required' => __('seller_messages.full_name_required'),
        'full_name.string' => __('seller_messages.full_name_string'),
        'full_name.max' => __('seller_messages.full_name_max'),

        'name_ar.string' => __('seller_messages.name_ar_string'),
        'name_ar.max' => __('seller_messages.name_ar_max'),

        // 'profile_pic.required' => __('seller_messages.profile_pic_required'),

        'country_code.required' => __('seller_messages.country_code_required'),
        'country_code.string' => __('seller_messages.country_code_string'),
        'country_code.max' => __('seller_messages.country_code_max'),

        'mobile.required' => __('seller_messages.mobile_required'),
        'mobile.digits_between' => __('seller_messages.mobile_digits_between'),

        'email.required' => __('seller_messages.email_required'),
        'email.email' => __('seller_messages.email_email'),

        'select_category.required' => __('seller_messages.select_category_required'),
        'select_category.exists' => __('seller_messages.select_category_exists'),

        'password.required' => __('seller_messages.password_required'),
        'password.min' => __('seller_messages.password_min'),
        'password.same' => __('seller_messages.password_same'),

        'confirm_password.required' => __('seller_messages.confirm_password_required'),

        'menu_id.required' => __('seller_messages.menu_required'),
        'menu_id.array' => __('seller_messages.menu_array'),
        'menu_id.min' => __('seller_messages.menu_min'),

        'menu_id.*.id.required' => __('seller_messages.menu_id_required'),
        'menu_id.*.id.exists' => __('seller_messages.menu_id_exists'),

        'menu_id.*.can_view.required' => __('seller_messages.can_view_required'),
        'menu_id.*.can_view.boolean' => __('seller_messages.can_view_boolean'),

        'menu_id.*.can_action.required' => __('seller_messages.can_action_required'),
        'menu_id.*.can_action.boolean' => __('seller_messages.can_action_boolean'),
     ]

    );

        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }

    $seller_id=Auth::guard('seller')->user()->id;

    $request_data=(object)$validate->validate();
    $request_data->seller_id=$seller_id;

    // ✅ Upload Image

    if(isset($request->old_profile_pic)){
        
        $request_data->profile_pic= $request->old_profile_pic;

    }else{

    if ($request->hasFile('profile_pic')) {

        $dir='staff/';
        $image = $request->file('profile_pic');
        $upload_image=image_upload($image,$dir);

        $request_data->profile_pic= $upload_image;

    }
}

           
    $data=  $this->SellerStaffManagementService->EditNewStaffManagment($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
    }

    if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

}




public function ViewMenuPermission(Request $request){

  $modules=sellermenuAction::with('singleActionmenu')->where('seller_id',$request->id)->get();

 return response()->json([
        'data' => $modules
    ]);


}
    

}