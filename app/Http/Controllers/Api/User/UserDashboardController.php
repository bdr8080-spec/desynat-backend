<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use Validator;

use App\Services\UserDashboardService;

class UserDashboardController extends Controller
{

    public function __Construct(UserDashboardService $UserDashboardService){
        $this->UserDashboardService=$UserDashboardService;
    }


    
    public function index(Request $request){

        $user_details=$request->user();

        return ApiResponse::generateResponse('success','User Dashbaord fetch Successfully',$user_details, 200);

    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::generateResponse('success','Logged out successfully',(object)[], 200);

    }


public function home_page_search(Request $request){

    // $validate = Validator::make($request->all(), [
    //     'search' => 'required',
    //     ]);

    // if($validate->fails()){
    //   return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    // }

    $user_id=$request->user()->id;

     $request_data=(object)[
        'user_id'=>$user_id,
        'search' =>$request->search,
        'sort_filter'=> $request->sort_filter,
        'brand_id'     => is_array($request->brand_id) ? $request->brand_id : [],     
        'category_id'  => is_array($request->category_id) ? $request->category_id : [],   
        'size_id'      => is_array($request->size_id) ? $request->size_id : [],       
        'color_id'     => is_array($request->color_id) ? $request->color_id : [],      
        'price_min'    => $request->price_min ?? null,
        'price_max'    => $request->price_max ?? null,
        'attributes'    => $request->attributes_data ?? null,
       ];

     $data=$this->UserDashboardService->HomePageSearch($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    


public function get_recent_search_data(Request $request){

    $user_id=$request->user()->id;

     $request_data=(object)[
        'user_id'=>$user_id,
        ];

     $data=$this->UserDashboardService->HomeRecentSearchList($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }



public function get_recommanded_search_data(Request $request){

    $user_id=$request->user()->id;

     $request_data=(object)[
        'user_id'=>$user_id,
        ];

     $data=$this->UserDashboardService->Recommanded_HomeRecentSearchList($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    

public function get_Invoice(Request $request){

    $validate = Validator::make($request->all(), [
        'order_id' => 'required|exists:orders,order_id',
        ]);

    if($validate->fails()){
      return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $request_data=(object)[
        'order_id'=>$request->order_id,
        ];

    $data=Url('/')."/invoice/".$request->order_id;
        

    return ApiResponse::generateResponse('success', "Invoice Url get Successfully ",$data, 200);

    }


public function popUpHomescreenBanner(Request $request){


     $user_id=$request->user()->id;

     $request_data=(object)[
        'user_id'=>$user_id,
        "type" =>"1"
        ];
      
  $data=$this->UserDashboardService->PopUPHomeScreenBanner($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }


public function HomescreenBanner(Request $request){

      $validate = Validator::make($request->all(), [
                'type' => 'required|in:1,2,3',
                'category' => 'nullable|required_if:type,3',
                // 'subcategory' => 'nullable|required_if:type,3',
                ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

    //  $user_id=$request->user()->id;

     $request_data=(object) [
    // 'user_id'=>$user_id,
    "type"=>$request->type,
    'category'=>$request->category??null,
    'subcatgory'=>$request->subcategory??null,
    
    ];

  $data=$this->UserDashboardService->HomeScreenBanner($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    }



    



}