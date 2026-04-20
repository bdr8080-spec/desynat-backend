<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Hash;


use App\Models\{ seller,sellerStoreInformation,Bankdetails,sellermenuAction,SellerMenus_table};
use App\Models\color;
use App\Models\Brand;
use App\Models\SellerSubcriptionPlanBuy;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


use App\Models\{ product,ProductSpecification,ProductVariant,StockInventoryRecords};

class SellerStaffManagementService
{
    public function AddNewStaffManagment($request)
    {
        try {

        $check_user_already=seller::where('email',$request->email)->where('otp_verify','0')->first();

        if($check_user_already){
           return [
                'status' => 'error',
                'message' => 'Email Address is Already used',
                'data' => []
            ];

        }

        $check_mobile_already=seller::where('type','0')->where('country_code',$request->country_code)->where('mobile',$request->mobile)->where('otp_verify','0')->first();
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
        //   'otp'=>123456,
          'admin_verify'=>'2',
          'lang'=>$request->lang??null,
          'parent_id'=>$request->seller_id
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
    

}