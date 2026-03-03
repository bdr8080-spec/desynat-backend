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
    //dd($affilatedUser);

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

    

public function affiliateProductPerformance(Request $request){

    if($request->ismethod('get')){
         return view('affiliatedUser.myproducts.performance');
    }
    }

public function updateBankAccountDetails(Request $request, $id)
{
    try {

        $request->validate([
            'bank_name' => 'required',
            'account_holder_name' => 'required',
            'account_no' => 'required',
            'confirm_account_no' => 'required|same:account_no',
        ]);

        $request->merge([
            'bank_details_id' => $id
        ]);

        $response = $this->UserAffilatedAuthService->updateBankDetails($request);

        return response()->json($response);

    } catch (\Exception $e) {

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}

public function addAnotherBankDetails(Request $request)
{
    try {

        $request->validate([
            'bank_name' => 'required',
            'account_holder_name' => 'required',
            'account_no' => 'required',
            'iban' => 'required',
            'swift' => 'required',
        ]);

        $affilatedUser=Auth::guard('affilated_user')->user(); 

        $request_data = (object) [
            'affilated_user' => $affilatedUser->id,
            'bank_name' => $request->bank_name,
            'account_holder_name' => $request->account_holder_name,
            'account_no' => $request->account_no,
            'iban' => $request->iban,
            'swift' => $request->swift,
        ];

        $data = $this->UserAffilatedAuthService->addBankDetails($request_data);

        return response()->json([
            'status' => 'success',
            'message' => 'Bank details added successfully',
            'data' => $data
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong',
            'data' => $e->getMessage()
        ]);
    }
}



//catgory Code 

public function affiliateMyCategory(Request $request){

    $category=Category::all();
    
    if($request->ismethod('get')){
     return view('affiliatedUser.category.categorys',compact('category'));
    }
        
    }

    public function Affilateallsubcategory(Request $request)
{
    $affilatedUser=Auth::guard('affilated_user')->user();     
    
    $category_id = $request->category;
    $subcategory = $request->subcategory;
    $search = $request->search;

    
$query = SubCategory::query();

if ($category_id != 'all') {
    $query->where('category_id', $category_id);
}

if (isset($subcategory) && $subcategory != 'all') {
    $query->where('subcategory_id', $subcategory);
}

if (!empty($search)) {
    $query->where('name_english', 'like', '%' . $search . '%');
}

$all_subcategory = $query->get();


    // if($category_id=='all'){
    //  $all_subcategory=SubCategory::all();

    //  $category_id='';

    // }else{
    //    $all_subcategory=SubCategory::where('category_id',$category_id)->get();
    //  }
        
    // if($subcategory=='all'){
    //     $subcategory='';
    // }


    return view('affiliatedUser.category.partials.showSubcatory',compact('all_subcategory'))->render();
    
}

// affilate all product accoprding to category and subcategory

public function AffilateAllProducts(Request $request){

  $affilatedUser=Auth::guard('affilated_user')->user()->id;     
    

        // $request_data = (object)[
        // 'category_id' => $request->category_id,
        // 'subcategory_id' => $request->subcategory_id,
        // "limit"=>10,
        // ];
        
    // $data = $this->UserAffiliatedProductService->getAllProducts($request);
    
     $request_data=(object)[
        'user_id'=>$affilatedUser,
        'search' =>$request->search,
        'sort_filter'=> $request->sort_filter,
        'brand_id'     => is_array($request->brand_id) ? $request->brand_id : [],     
        'category_id'  => is_array($request->category_id) ? $request->category_id : [],   
        'subcategory_id'  => is_array($request->subcategory_id) ? $request->subcategory_id : [],   
        
        'size_id'      => is_array($request->size_id) ? $request->size_id : [],       
        'color_id'     => is_array($request->color_id) ? $request->color_id : [],      
        'price_min'    => $request->price_min ?? null,
        'price_max'    => $request->price_max ?? null,
        'attributes'    => $request->attributes_data ?? null,
        'discount'    => $request->discount ?? null,
       ];


  $data = $this->UserAffiliatedProductService->ProductSearch($request_data);


    $products=$data['data'];
    
    if($request->ismethod('get')){
        return view('affiliatedUser.category.allproducts',compact('products'));
    }

    }




public function generateProductLink(Request $request){
    
    $affilatedUser=Auth::guard('affilated_user')->user();     

           $request_data = (object) [
            'user_id' => $affilatedUser->id,
            'product_id' => $request->product_id,
        ];

    $data = $this->UserAffiliatedProductService->generateProductLink($request_data);
    $products=$data['data'];
        return $products->link;  // return Link 

    }



public function add_to_my_products(Request $request){

    $affilatedUser=Auth::guard('affilated_user')->user();     

    $request_data = (object) [
    'user_id' => $affilatedUser->id,
    'product_id' => $request->product_id,
];

    $data = $this->UserAffiliatedProductService->addToMyProducts($request_data);    

    return response()->json([
                'status' => $data['status'],
                'message' => $data['message'],
                'data' => $data['data']
            ]);

    }

    


    
    public function deleteBankAccount(Request $request, $id)
    {
        try {
            $affilatedUser = Auth::guard('affilated_user')->user();

            $request_data = (object)[
                'bank_details_id' => $id,
                'affilated_user'  => $affilatedUser->id
            ];

            $data = $this->UserAffilatedAuthService->deleteBankAccount($request_data);

          
            

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'data' => (object)[]
            ]);
        }
    }

    

}