<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\size;
use App\Models\color;
use App\Models\ProductVariant;
use Carbon\Carbon;

use App\Models\{UserGiftCards,GiftCard,UserWallet,Reason};
use App\Models\{Promocode,userAddress,country,all_countrie,allproductchats};
use App\Models\{Order,OrderDeliveryAddress,orderdetail,Addtocart,productRatings,product};


use Hash;



use App\Models\{AffilatedUser,AffilatedUserAddress,Bankdetails};

use DB;

class UserAffilatedAuthService
{


function RegisterAffilatedUser($request){

try{

        $password_hash=Hash::make($request->password);

        // $otp="123456";

       $otp= config('services.otp');

      $insert_Data=[
    'user_id'=>$request->user_id,
    "profile_image"=>$request->profile_image,
    'full_name'=>$request->full_name??null,
    'country_code'=>$request->country_code??null,
    'mobile'=>$request->mobile??null,
    'email'=>$request->email??null,
    'password'=>$request->password??null,
    'document1'=>$request->document1??null,
    'document2'=>$request->document2??null,
    'otp'=>$otp,
    'let'=>$request->let??null,
    'long'=>$request->long??null,
    "device_type"=>$request->device_type??0,
    'otp'=>$otp,
    ];


      $check=  AffilatedUser::UpdateOrCreate($insert_Data);

        if($check){
            return ['status'=>'success','message'=>"OTP sent succesfully",'data'=>$check];            
        }

         } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update Affliated status: ' . $e->getMessage(),
            'data' => $e->getMessage()
        ];
    }


    }

//  // User_View_Promocode_list
//  public function RegisterAffilatedUser($request){

//     try{


//       $user_address_check=  userAddress::where('id',$request->delivery_address)->where('user_id',$request->user_id)->first();

//       if(!$user_address_check){

//         return [
//             'status' => 'error',
//             'message' => 'User and Address didn\'t Match',
//             'data' => []
//         ];
//       }

//       $getCountry_dial_code=$user_address_check->country_code;


//       $getCountryId= country::where('dial_code',$getCountry_dial_code)->first();

//       if(!$getCountryId){
//         return [
//             'status' => 'success',
//             'message' => 'No promo Code found In',
//             'data' => []
//         ];
//       }

//      $get_all_promo_codes=Promocode::where('country_id',$getCountryId->id)
//      ->wheredate('start_date','<=',now())
//      ->wheredate('end_date','>=',now())
//      ->where('status','1')->get();


//     return ['status'=>'success','message'=>"All promcode fetch Successfully",'data'=>$get_all_promo_codes];


        
//     } catch (\Exception $e) {
//         return [
//             'status' => 'error',
//             'message' => 'Failed to update seller status: ' . $e->getMessage(),
//             'data' => []
//         ];
//     }

    
//     }


    



}