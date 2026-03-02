<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Validator;

use App\Helpers\ApiResponse;

use App\Models\{country,Category,SubCategory,Product};

use App\Services\UserAffilatedAuthService;
use App\Services\UserAffiliatedProductService;


class UserAffiliatedProfileController extends Controller
{

    public function __construct(UserAffilatedAuthService $UserAffilatedAuthService,UserAffiliatedProductService $UserAffiliatedProductService)
    {
        $this->UserAffilatedAuthService = $UserAffilatedAuthService;
        $this->UserAffiliatedProductService = $UserAffiliatedProductService;
    }


    public function affiliateProfile(Request $request){

    $affilatedUser=Auth::guard('affilated_user')->user();           

    $request_data = (object) [
        'user_id' => $affilatedUser->id,
    ];

    $data = $this->UserAffilatedAuthService->getProfile($request_data);

    $affilatedUser=$data['data'];

    $country =   country::all();

    return view('affiliatedUser.profiles.profile',compact('affilatedUser','country'));
    
    
    }



public function affiliateChangePassword(Request $request){

    
    if($request->ismethod('get')){
        return view('affiliatedUser.profiles.change-pwd');
    }


$affilatedUser=Auth::guard('affilated_user')->user();     


   $validate = Validator::make($request->all(), [
        'old_password' => 'required',
        'password'         => 'required',
        'confirm_password' => 'required|same:password',
    ]);

    if ($validate->fails()) {
        return ApiResponse::generateResponse(
            'error',
            $validate->errors()->first(),
            (object) $validate->errors(),
            422
        );
    }

    $affilated_user = $affilatedUser->id;
    
    $request_data = (object) [
        'user_id' => $affilated_user,
        'password' => $request->password,
        "old_password"=>$request->old_password

    ];

    $data = $this->UserAffilatedAuthService->updatePassword($request_data);

    if (isset($data['status']) && $data['status'] === 'error') {
        return ApiResponse::generateResponse(
            'error',
            $data['message'],
            (object) [],
            400
        );
    }

    return ApiResponse::generateResponse(
        'success',
        $data['message'],
        $data['data'],
        200
    );
    
    }



public function affiliateMyCategory(Request $request){

    $category=Category::all();
    

    if($request->ismethod('get')){
     return view('affiliatedUser.category.categorys',compact('category'));
    }


$affilatedUser=Auth::guard('affilated_user')->user();     


   $validate = Validator::make($request->all(), [
        'old_password' => 'required',
        'password'         => 'required',
        'confirm_password' => 'required|same:password',
    ]);

    if ($validate->fails()) {
        return ApiResponse::generateResponse(
            'error',
            $validate->errors()->first(),
            (object) $validate->errors(),
            422
        );
    }

    $affilated_user = $affilatedUser->id;
    
    $request_data = (object) [
        'user_id' => $affilated_user,
        'password' => $request->password,
        "old_password"=>$request->old_password
    ];

    $data = $this->UserAffilatedAuthService->updatePassword($request_data);

    if (isset($data['status']) && $data['status'] === 'error') {
        return ApiResponse::generateResponse(
            'error',
            $data['message'],
            (object) [],
            400
        );
    }

    return ApiResponse::generateResponse(
        'success',
        $data['message'],
        $data['data'],
        200
    );
    
    }


public function affiliateMyProduct(Request $request){

    $category=Category::all();

    if($request->ismethod('get')){
      return view('affiliatedUser.myproducts.my-products',compact('category'));
    }

   
    }




    public function myProductFiltersubcategory(Request $request)
{
    $affilatedUser=Auth::guard('affilated_user')->user();     
    
    $category_id = $request->category;
    $subcategory = $request->subcategory;

    

    if($category_id=='all'){
     $all_subcategory=SubCategory::all();

     $category_id='';

    }else{
       $all_subcategory=SubCategory::where('category_id',$category_id)->get();
     }
        
    if($subcategory=='all'){
        $subcategory='';
    }


    return view('affiliatedUser.myproducts.partials.catgorySubcatgorydata',compact('all_subcategory'))->render();
    
}



    public function myProductFilter(Request $request)
{
    $affilatedUser=Auth::guard('affilated_user')->user();     
    
    $category_id = $request->category;
    $subcategory = $request->subcategory;

    

    if($category_id=='all'){
     $all_subcategory=SubCategory::all();

     $category_id='';

    }else{
       $all_subcategory=SubCategory::where('category_id',$category_id)->get();
     }
        
    if($subcategory=='all'){
        $subcategory='';
    }
    
     $request_data = (object) [
            'user_id' => $affilatedUser->id,
            'from' => $request->from ?? null,
            'to' => $request->to ?? null,
            'limit' => $request->limit ?? null,
            'search' => $request->search ?? null,
            'category_id' => $category_id ?? null,
            'subcategory_id' => $subcategory ?? null,
        ];

    $data = $this->UserAffiliatedProductService->getMyProducts($request_data);
    $products=$data['data'];
    
    return view('affiliatedUser.myproducts.partials.myproductShowdata',compact('products','category_id','all_subcategory'))->render();
    
}

    


    



}