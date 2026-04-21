<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Hash;


use App\Models\{ seller,sellerStoreInformation,Bankdetails,sellermenuAction,SellerMenus_table,SellerTypeCategory};
use App\Models\color;
use App\Models\Brand;
use App\Models\SellerSubcriptionPlanBuy;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


use App\Models\{ product,ProductSpecification,ProductVariant,StockInventoryRecords};

class SellerStaffManagementService
{


    public function newStaffCategoryType(){

      $allcategory=SellerTypeCategory::all();

       return [
            'status' => 'success',
            'message' => 'Seller stuff All category fetch Successfully',
            'data' => $allcategory
        ];

    }



  public function SellerAllMenu(){

    $allcategory=SellerMenus_table::all();

    return [
        'status' => 'success',
        'message' => 'Seller All Menu fetch Successfully',
        'data' => $allcategory
    ];

    }


    public function AddNewStaffManagment($request)
    {
        try {

        $check_user_already=seller::where('email',$request->email)->where('admin_verify','2')->first();

        if($check_user_already){
           return [
                'status' => 'error',
                'message' => 'Email Address is Already used',
                'data' => []
            ];

        }

        $check_mobile_already=seller::where('country_code',$request->country_code)->where('mobile',$request->mobile)->where('admin_verify','2')->first();
        if($check_mobile_already){
            return [
                'status' => 'error',
                'message' => 'Phone Number is Already used',
                'data' => []
            ];

          }

        $password_hash=Hash::make($request->password);

         $record=[
          'profile_pic' => $request->profile_pic,
          'type' => '1',          
          'first_name' => $request->full_name,
          'last_name' => $request->last_name??'-',
          'name_ar' => $request->name_ar,
          'country_code' => $request->country_code,
          'mobile' => $request->mobile,
          'email' => $request->email,
          'password' => $password_hash,
          'accept_terms' => '1',
          'device_type' => $request->device_type??null,
          'device_token'=>$request->device_token??null,
          "otp_verify"=>'1',
        //   'otp'=>123456,
          'admin_verify'=>'2',
          'lang'=>$request->lang??null,
          'parent_id'=>$request->seller_id,
          "select_category"=>$request->select_category
        ];

       $check_seller= seller::create($record);


       foreach($request->menu_id as $key=>$val){

        $insert=[
            'seller_id'=>$check_seller->id,
            "menu_id"=>intval($val['id']),
            "can_view"=>intval($val['can_view']),
            "can_action"=>intval($val['can_action']),
        ];

     sellermenuAction::create($insert);

    }
        return [
            'status' => 'success',
            'message' => 'Seller Add stuff create Successfully',
            'data' => $check_seller
        ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function AllStaffDetails($request){

        try{

    $All_staff=seller::with('seller_category','Role_Action.sellermenu')->where('parent_id',$request->seller_id)
    ->when($request->role_filter,function($query) use($request){
        $query->where('select_category',$request->role_filter);
    })
->when($request->status_filter,function($query) use($request){
        $query->where('is_block',$request->status_filter);
    });
    
    if ($request->from && $request->to) {
    $All_staff = $All_staff->whereBetween('created_at', [
        $request->from . ' 00:00:00',
        $request->to . ' 23:59:59'
    ]);
    } elseif ($request->from) {
    $All_staff = $All_staff->whereDate('created_at', $request->from);
}

   $All_staff=$All_staff->get();

    return [
        'status' => 'success',
        'message' => 'Seller All Menu fetch Successfully',
        'data' => $All_staff
    ];

     } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error ' . $e->getMessage(),
                'data' => []
            ];
        }


    }


    public function StaffActiveInactive($request){

        try{

    $staff=seller::with('seller_category','Role_Action.sellermenu')->where('id',$request->id)->first();

    if($staff->is_block==0){ //0 No Block 

        $msg="staff member Block Successfully";
        $staff->update(['is_block'=>1]);
    }else{  // 1 block
        $msg="staff member UnBlock Successfully";
        $staff->update(['is_block'=>0]);
    }


    return [
        'status' => 'success',
        'message' => $msg,
        'data' => []
    ];

     } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error ' . $e->getMessage(),
                'data' => []
            ];
        }
        

    }


    public function staffDelete($request){

        try{

    $staff=seller::with('seller_category','Role_Action.sellermenu')->where('id',$request->id)->first();

    $msg="staff member delete Successfully";
    $staff->delete();

    return [
        'status' => 'success',
        'message' => $msg,
        'data' => []
    ];

     } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error ' . $e->getMessage(),
                'data' => []
            ];
        }
        

    }



    public function viewSingleStaffDetails($request){

        try{

    $All_staff=seller::with('seller_category','Role_Action.sellermenu')->where('id',$request->id)->get();

    return [
        'status' => 'success',
        'message' => 'view Single Staff details fetch Successfully',
        'data' => $All_staff
    ];

     } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error ' . $e->getMessage(),
                'data' => []
            ];
        }


    }



}