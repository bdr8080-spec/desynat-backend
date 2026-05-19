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


use Illuminate\Support\Facades\Mail;
use App\Mail\StaffCredentialsMail;

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



  public function SellerAllMenu($menu=null){

    if($menu==1){
        $allcategory=SellerMenus_table::whereNotIn('order_by',['12','10'])->get();

    }else{
        $allcategory=SellerMenus_table::get();
    }

    return [
        'status' => 'success',
        'message' => 'Seller All Menu fetch Successfully',
        'data' => $allcategory
    ];

    }


    public function AddNewStaffManagment($request)
    {
        try {

        $check_user_alreadyinseller=seller::where('email',$request->email)->where('type','0')->first();
        
        if($check_user_alreadyinseller){
           return [
                'status' => 'error',
                'message' => __('Service_messages.email_address_already_used'),
                'data' => []
            ];

        }

        $check_user_already=seller::where('email',$request->email)->where('admin_verify','2')->first();

        if($check_user_already){
           return [
                'status' => 'error',
                'message' => __('Service_messages.email_address_already_used'),
                'data' => []
            ];

        }

        $check_mobile_already=seller::where('country_code',$request->country_code)->where('mobile',$request->mobile)->where('admin_verify','2')->first();
        if($check_mobile_already){
            return [
                'status' => 'error',
                'message' => __('Service_messages.phone_number_already_used'),
                'data' => []
            ];

          }

        //   check Seller Plan 

        $checkSellerPlan=seller::with('subcription_plan')->
        whereHas('subcription_plan', function($query){
            $query->where('plan_end_date','>',Now());
        })
        ->where('id',$request->seller_id)->first();

        if($checkSellerPlan){

            if($checkSellerPlan->subcription_plan[0]){

                $staff_limit=IntVal($checkSellerPlan->subcription_plan[0]->no_of_employee);
                // $staff_limit=3;

                $sellerCount=seller::where('parent_id',$request->seller_id)->count();
              
                if($staff_limit<$sellerCount ){
                    return [
                'status' => 'error',
                'message' => 'Your Plan is Over please buy new plan',
                'data' => []
            ];
                }
            }


        }else{
            return [
                'status' => 'error',
                'message' => 'No Plan Found You Canot Add Staff',
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
          "select_category"=>$request->select_category,
           "save_password"=>$request->password,
           "store_information"=>1,
           "bank_information"=>1,

        ];

       $check_seller= seller::create($record);

        Mail::to($request->email)->send(new StaffCredentialsMail($check_seller, $request->password));

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
            'message' => __('Service_messages.staff_created_successfully'),
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



    public function EditNewStaffManagment($request)
{
    try {

        // ✅ Check if EDIT or CREATE
        $isEdit = !empty($request->id);

        // ✅ Get existing user if edit
        if ($isEdit) {
            $seller = seller::find($request->id);

            if (!$seller) {
                return [
                    'status' => 'error',
                    'message' => 'Staff not found',
                    'data' => []
                ];
            }
        }

        // ✅ Email check (ignore current user in edit)
        $check_user_already = seller::where('email', $request->email)
            ->where('admin_verify', '2')
            ->when($isEdit, function ($q) use ($request) {
                $q->where('id', '!=', $request->id);
            })
            ->first();

        if ($check_user_already) {
            return [
                'status' => 'error',
                'message' => __('Service_messages.email_address_already_used'),
                'data' => []
            ];
        }

        // ✅ Mobile check (ignore current user in edit)
        $check_mobile_already = seller::where('country_code', $request->country_code)
            ->where('mobile', $request->mobile)
            ->where('admin_verify', '2')
            ->when($isEdit, function ($q) use ($request) {
                $q->where('id', '!=', $request->id);
            })
            ->first();

        if ($check_mobile_already) {
            return [
                'status' => 'error',
                'message' => __('Service_messages.phone_number_already_used'),
                'data' => []
            ];
        }

        // ✅ Prepare data
        $record = [
            'profile_pic' => $request->profile_pic ?? ($isEdit ? $seller->profile_pic : null),
            'type' => '1',
            'first_name' => $request->full_name,
            'last_name' => $request->last_name ?? '-',
            'name_ar' => $request->name_ar,
            'country_code' => $request->country_code,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'accept_terms' => '1',
            'device_type' => $request->device_type ?? null,
            'device_token' => $request->device_token ?? null,
            'otp_verify' => '1',
            'admin_verify' => '2',
            'lang' => $request->lang ?? null,
            'parent_id' => $request->seller_id,
            'select_category' => $request->select_category,
            "save_password"=>$request->password
        ];

        // ✅ Password only if provided
        if (!empty($request->password)) {
            $record['password'] = Hash::make($request->password);
        }

        // ✅ Create or Update
        if ($isEdit) {
            $seller->update($record);
            $check_seller = $seller;
        } else {
            $check_seller = seller::create($record);
        }

        // ✅ Handle Menu Permissions
        if (!empty($request->menu_id)) {

            // Delete old permissions in edit
            if ($isEdit) {
                sellermenuAction::where('seller_id', $check_seller->id)->delete();
            }

            foreach ($request->menu_id as $val) {
                sellermenuAction::create([
                    'seller_id' => $check_seller->id,
                    'menu_id' => intval($val['id']),
                    'can_view' => intval($val['can_view']),
                    'can_action' => intval($val['can_action']),
                ]);
            }
        }

        return [
            'status' => 'success',
            'message' => $isEdit
                ? __('Service_messages.staff_updated_successfully')
                : __('Service_messages.staff_created_successfully'),
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


    public function AllStaffDetails($request,$type){

        try{


    $All_staff=seller::with('seller_category','Role_Action.sellermenu')->where('parent_id',$request->seller_id)
    ->when($request->role_filter,function($query) use($request){
        $query->where('select_category',$request->role_filter);        
    })
    ->when($request->status_filter !== null, function ($query) use ($request) {
        $query->where('is_block', $request->status_filter);
    })
    ->orderBy('id', 'desc');
    
    if ($request->from && $request->to) {
    $All_staff = $All_staff->whereBetween('created_at', [
        $request->from . ' 00:00:00',
        $request->to . ' 23:59:59'
    ]);
    } elseif ($request->from) {
    $All_staff = $All_staff->whereDate('created_at', $request->from);
}

if($type=='api'){
  $All_staff=$All_staff->paginate();
  
}else{
      $All_staff=$All_staff->get();

}

 
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

        $msg = __('Service_messages.staff_blocked_successfully');
        $staff->update(['is_block'=>1]);
    }else{  // 1 block
        $msg = __('Service_messages.staff_unblocked_successfully');
        $staff->update(['is_block'=>0]);
    }


    return [
        'status' => 'success',
        'message' => $msg,
        'data' => $staff
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

    $msg = __('Service_messages.staff_deleted_successfully');
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

   $All_staff = seller::with([
        'seller_category',
        'country_details',

        // 🔥 Order Role_Action
        'Role_Action' => function ($q) {
            $q->orderBy('menu_id', 'asc');
        },

        // 🔥 Also load menu inside Role_Action
        'Role_Action.sellermenu'
    ])
    ->where('id', $request->id)

    // Only ensure relation exists
    ->whereHas('Role_Action')

    ->first();
    

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