<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\seller;
use App\Models\color;


use App\Models\SellerSubcriptionPlanBuy;

use App\Helpers\ApiResponse;


use Validator;


use App\Services\SellerAuthService;


class SellerDashboardController extends Controller
{

    public function __construct(SellerAuthService $SellerAuthService){

        $this->SellerAuthService=$SellerAuthService;

    }


    public function index(Request $request){

        $user_details=$request->user();


        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details','subcription_plan')->where('id',$user_details->id)->first();
        
        return ApiResponse::generateResponse('success','Seller Dashboard fetch Successfully',$seller_details, 200);


    }

    




    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::generateResponse('success','Logged out successfully',(object)[], 200);
    }



    public function all_plans(Request $request){

        $seller_details=$request->user();

        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details')->where('id',$seller_details->id)->first();

        $request_data=(object )[
            'seller_id'=>$seller_details->id,
            'country_id' =>$seller_details->store_info->country
        ];

      $data= $this->SellerAuthService->seller_allPlan($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    
    }

    

    public function single_plans_show(Request $request , $id){

        $request_data=(object )[
            'plan_id'=>$id,
        ];

      $data= $this->SellerAuthService->seller_single_allPlan($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function create_subcription_plan_buy(Request $request){

        
        $validate = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
        ]);


        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }


        $seller_details=$request->user();

        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details')->where('id',$seller_details->id)->first();

        $tranasaction_id='Tran'.rand(1111111111111,9999999999999);

        $request_data=(object )[
            'transaction_id'=>$tranasaction_id,
            'seller_id'=>$seller_details->id,
            'plan_id' =>$request->plan_id,
            "payment_method"=>$request->payment_method??'online',
            'payment_status'=>'0',
        ];

      $data= $this->SellerAuthService->create_Subcription_Order($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    
    }

    



    public function payment_subcription_plan(Request $request){

        
        $validate = Validator::make($request->all(), [
            'transaction_id' => 'required|exists:seller_subcription_plan_buys,transaction_id',
            'payment_status'=>"required|in:1,2"
        ]);


        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }

        $request_data=(object )[
            'transaction_id'=>$request->transaction_id,
            'payment_status'=>$request->payment_status,
            'online_transaction_id'=>$request->online_transaction_id??null
        ];

      $data= $this->SellerAuthService->complete_Subcription_Order($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function seller_profile(Request $request){

        $user_details=$request->user();
        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details','subcription_plan')->where('id',$user_details->id)->first();
        
        return ApiResponse::generateResponse('success','Seller Dashboard fetch Successfully',$seller_details, 200);


    }


    public function store_on_off(Request $request){

        $user_details=$request->user();
   
        $request_data=(object )[
            'seller_id'=>$user_details->id,
        ];

     $data= $this->SellerAuthService->seller_storeOnOff($request_data);
      
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }


    public function upload_color(){

      $colors = include app_path('Helpers/color.php');

        foreach($colors as $key=>$value){
            $data=[
                'name'=>$key,
                'hex_code'=>$value
            ];

            color::updateOrCreate($data);
        }

          $color=  color::all();

        return ApiResponse::generateResponse('success',"All Color fetch Successfully",$color, 200);

    }

    public function renew_subcription_plan_buy(Request $request){

        
        $validate = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
        ]);


        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }


        $seller_details=$request->user();

        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details')->where('id',$seller_details->id)->first();

        $tranasaction_id='Tran'.rand(1111111111111,9999999999999);

        $request_data=(object )[
            'transaction_id'=>$tranasaction_id,
            'seller_id'=>$seller_details->id,
            'plan_id' =>$request->plan_id,
            "payment_method"=>$request->payment_method??'online',
            'payment_status'=>'0',
        ];

      $data= $this->SellerAuthService->renew_Subscription_Order($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    
    }

    public function my_plans(Request $request){

        $seller_details=$request->user();

        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details')->where('id',$seller_details->id)->first();

        $request_data=(object )[
            'seller_id'=>$seller_details->id,
            'limit' =>$request->limit??10,
        ];

      $data= $this->SellerAuthService->seller_myPlan($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],200);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    
    }

    

    



}