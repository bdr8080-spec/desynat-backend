<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Validator;

use App\Helpers\ApiResponse;

use App\Models\{country,Category,SubCategory,Product,UserContactChangeHistory,all_countrie};

use App\Services\UserAffilatedAuthService;
use App\Services\UserAffiliatedProductService;
use App\Models\AffiliateProduct;

use Illuminate\Validation\Rule;

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
    

    public function affiliateSaveProfile(Request $request){

    $affilatedUser=Auth::guard('affilated_user')->user();


    $validate = Validator::make($request->all(), [
    'profile_image'      => 'required_without:old_profile_image',
    'old_profile_image'  => 'nullable',
    'full_name'          => 'required',
    'document1'          => 'required_without:old_document1',
    'old_document1'      => 'nullable',
    'document2'          => 'required_without:old_document2',
    'old_document2'      => 'nullable',
], [
    'full_name.required' => 'Please enter full name',
    'document1.required_without' => 'Please upload document 1',
    'document2.required_without' => 'Please upload document 2',
    'profile_image.required_without' => 'Please upload a profile image',
]);

    if ($validate->fails()) {
      return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
    }

      if ($request->hasFile('profile_image')) {
            $dir = "profile";
            $profile_image = image_upload($request->profile_image, $dir);
            } else {
             $profile_image =$request->old_profile_image;
        }

      if ($request->hasFile('document1')) {
            $dir = "profile";
            $document1 = image_upload($request->document1, $dir);
            } else {
             $document1 =$request->old_document1;
        }

        
        
      if ($request->hasFile('document2')) {
            $dir = "profile";
            $document2 = image_upload($request->document2, $dir);
            } else {
             $document2 =$request->old_document2;
        }

    $request_data = (object) [
        'affilated_user' => $affilatedUser->id,
        'profile_image'        => $profile_image,
        'full_name'      => $request->full_name,
        'country_code'       => $affilatedUser->country_code,
        'mobile'       => $affilatedUser->mobile,
        'email'        => $affilatedUser->email,
        'document1'        => $document1,
        'document2'        => $document2,
    ];

    $data = $this->UserAffilatedAuthService->updateProfile($request_data);    
    
    if (isset($data['status']) && $data['status'] === 'error') {
        return ApiResponse::generateResponse(
            'error',
            $data['message'],
            $data['data'],
            422
        );
    }

    return ApiResponse::generateResponse(
        'success',
        $data['message'],
        $data['data'],
        200
    );

    
    }

    public function affiliateProfilesaveAddress(Request $request){

     $validate = Validator::make($request->all(), [
                'country' => 'required',
                'locations' => 'required',
                'address1' => 'required',
                "address2" =>"nullable",
                // "pincode" =>"required",
                // "town"=>"required",
                // "state"=>"required",
                // "city"=>"required",
                "let"=>"required",
                "long" =>"required"
                ],
             [
        'country.required'   => 'Please select a country.',
        'locations.required' => 'Please select a location.',
        'address1.required'  => 'Address line 1 is required.',
        'address2.required'  => 'Address line 2 is required.',
        'pincode.required'   => 'Pincode is required.',
        'town.required'      => 'Town is required.',
        'state.required'     => 'State is required.',
        'city.required'      => 'City is required.',
        'let.required'       => 'Latitude is required.',
        'long.required'      => 'Longitude is required.',
    ]);
            
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
    }

    $affilated_user=Auth::guard('affilated_user')->user()->id;
     
     $request_data=(object) [
    'affilated_user'=>$affilated_user,
    "country"=>$request->country,
    'locations'=>$request->locations,
    'address1'=>$request->address1,
    'address2'=>$request->address2,
    'pincode'=>$request->pincode??null,
    'town'=>$request->town??null,
    'state'=>$request->state??null,
    'city'=>$request->city??null,
    'let'=>$request->let??null,
    'long'=>$request->long??null
    ];

  $data=$this->UserAffilatedAuthService->affilatedAddAddress($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    $id = $data['data']->affiliate_id;

        return response()->json([
            'status' => 'success',
            'message' => $data['message'],
            'id' => $id,
        ]);

    // return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);




    }



public function affiliateChangePassword(Request $request){

    
    if($request->ismethod('get')){
        return view('affiliatedUser.profiles.change-pwd');
    }


$affilatedUser=Auth::guard('affilated_user')->user();     


   $validate = Validator::make($request->all(), [
    'old_password' => 'required',
    'password' => [
        'required',
        // 'min:6',
        'regex:/[A-Z]/', 
        'regex:/[0-9]/',      // at least one capital letter
        'regex:/[@$!%*#?&]/'   // at least one special character
    ],
    'confirm_password' => 'required|same:password',
],[
    'old_password.required' => 'Please Enter Old Password',

    'password.required' => 'Please Enter New Password',
    // 'password.min' => 'Password must be at least 6 characters long',
    'password.regex' => 'Password must be at least 6 characters long,contain at least one uppercase letter,one special character and one number',

    'confirm_password.required' => 'Please Enter Confirm Password',
    'confirm_password.same' => 'Confirm password must match new password',
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
    // dd($products);
    
    return view('affiliatedUser.myproducts.partials.myproductShowdata',compact('products','category_id','all_subcategory'))->render();
    
}

    

public function affiliateProductPerformance(Request $request,$id){
   // dd($id);

  $affilatedUser=Auth::guard('affilated_user')->user();     
   

    if($request->ismethod('get')){

       $request_data = (object) [
            'user_id' => $affilatedUser->id,
            'id' => $request->id ?? null
            ];

    $data = $this->UserAffiliatedProductService->getPerformancewithidProducts($request_data);
    $performace=$data['data'];
    //dd($performace);

    $product = AffiliateProduct::where('id',$id)->first();
    $product_id = $product->product_id;
    //dd($product_id);

    $request_data1 = (object) [
            'user_id' => $affilatedUser->id,
            'id' => $product_id,
            "start_date"=>$request->start_date??null,
                "end_date"=>$request->end_date??null
            ];
            //dd($request_data1);

    $data1 = $this->UserAffiliatedProductService->getMyProductDetail($request_data1);
    $summary=$data1['data'];
    //dd($summary);

    return view('affiliatedUser.myproducts.performance',compact('performace','summary'));


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

          return response()->json($data); 
            

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'data' => (object)[]
            ]);
        }
    }



    // // verify email and Number otp 
    // public function affiliateaffiliateVerifyOtp(Request $request){

    // $affilatedUser=Auth::guard('affilated_user')->user();           

    // $request_data = (object) [
    //     'user_id' => $affilatedUser->id,
    // ];

    // $data = $this->UserAffilatedAuthService->getProfile($request_data);

    // $affilatedUser=$data['data'];
    // $country =   country::all();

    //  return view('affiliatedUser.profiles.verify-Otp',compact('affilatedUser','country'));

    // }

    

    // // add new number and email  
    // public function affiliatechangeNumberAndemail(Request $request){

    // $affilatedUser=Auth::guard('affilated_user')->user();           

    // $request_data = (object) [
    //     'user_id' => $affilatedUser->id,
    // ];

    // $data = $this->UserAffilatedAuthService->getProfile($request_data);

    // $affilatedUser=$data['data'];
    // $country =   country::all();

    // return view('affiliatedUser.profiles.change-mobile',compact('affilatedUser','country'));


    // }



    
    // change affilate product phone no and email code Start


    public function oldNumberSendOtp(Request $request)
{


    $for = $request->input('for');
    $type = $request->input('type');

     if ($for === 'mobile') {
            $rules = [
                'country_code' => 'required|string|max:10',
                'mobile'       => ['required', 'regex:/^[0-9]{7,15}$/', 'string', 'max:20'],
                'type'         => 'required|in:0,1',
            ];

            $messages = [
                'country_code.required' => 'Please enter your country code',
                'mobile.required'       => 'Please enter your mobile number',
                'mobile.regex'          => 'Mobile number must contain 7 to 15 digits',
                'type.required'         => 'Please specify whether it is old or new number',
                'type.in'               => 'Type must be 0 (old number) or 1 (new number)',
            ];

        
            if ($request->type == '0') {
                $rules['mobile'][] = Rule::exists('affilated_users', 'mobile')
                    ->where('country_code', $request->country_code);
            } else {
                $rules['mobile'][] = Rule::unique('affilated_users', 'mobile')
                    ->where('country_code', $request->country_code);
            }

        } elseif ($for === 'email') {

            $rules = [
                'email' => ['required', 'email'],
                'type'  => 'required|in:0,1',
            ];

            $messages = [
                'email.required' => 'Please enter your email address',
                'email.email'    => 'Please enter a valid email address',
                'type.required'  => 'Please specify whether it is old or new email',
                'type.in'        => 'Type must be 0 (old email) or 1 (new email)',
            ];


            if ($request->type == '0') {
                $rules['email'][] = Rule::exists('affilated_users', 'email');

            } else {
                $rules['email'][] = Rule::unique('affilated_users', 'email');
            }

        } else {
            return redirect()->back()->with('error', 'Invalid "for" value. Use either "mobile" or "email"');
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return redirect()->back()->with('error', $firstError)->withInput();
        }  



    // $user = $request->user();
     $user = Auth::guard('affilated_user')->user();

    $otp = config('services.otp');

    UserContactChangeHistory::where('user_id', $user->id)->where('change_table','2')->update(['status' => '1']);

    if ($for === 'mobile') {

        if ($type == '0') {
            if (
                $user->country_code === $request->country_code &&
                $user->mobile === $request->mobile
            ) {
                $data = UserContactChangeHistory::create([
                    'user_id'      => $user->id,
                    'change_table'=>'2',
                    'country_code' => $request->country_code,
                    'mobile'       => $request->mobile,
                    'otp'          => $otp,
                    'type'         => '0',
                    'status'       => '0',
                ]);

                return redirect()->route('affiliate.userOldNumberVerify', [
                    'country_code' => $user->country_code,
                    'mobile'       => $user->mobile,
                    'id'           => encrypt($data->id),
                    'type'         => '0',
                    'for'          => 'mobile',
                ])->with('success', 'OTP sent successfully to your old mobile number.');
            }

            return redirect()->back()->with('error', "Old mobile number doesn't match our records.");
        }

        if ($type == '1') {
            $data = UserContactChangeHistory::create([
                 'change_table'=>'2',
                'user_id'      => $user->id,
                'country_code' => $request->country_code,
                'mobile'       => $request->mobile,
                'otp'          => $otp,
                'type'         => '1',
                'status'       => '0',
            ]);

            return redirect()->route('affiliate.userOldNumberVerify', [
                'country_code' => $data->country_code,
                'mobile'       => $data->mobile,
                'id'           => encrypt($data->id),
                'type'         => '1',
                'for'          => 'mobile',
            ])->with('success', 'OTP sent successfully to your new mobile number.');
        }
    }

    if ($for === 'email') {
        if ($type == '0') {
            if ($user->email !== $request->email) {
                return redirect()->back()->with('error', "Old email doesn't match our records.");
            }

            $data = UserContactChangeHistory::create([
                 'change_table'=>'2',
                'user_id' => $user->id,
                'email'   => $request->email,
                'otp'     => $otp,
                'type'    => '1',
                'status'  => '0',
            ]);

            return redirect()->route('affiliate.userOldNumberVerify', [
                'email' => $data->email,
                'id'    => encrypt($data->id),
                'type'  => '0',
                'for'   => 'email',
            ])->with('success', 'OTP sent successfully to your old email.');
        }

        if ($type == '1') {
            $data = UserContactChangeHistory::create([
                 'change_table'=>'2',
                'user_id' => $user->id,
                'email'   => $request->email,
                'otp'     => $otp,
                'type'    => '1',
                'status'  => '0',
            ]);

            return redirect()->route('affiliate.userOldNumberVerify', [
                'email' => $data->email,
                'id'    => encrypt($data->id),
                'type'  => '1',
                'for'   => 'email',
            ])->with('success', 'OTP sent successfully to your new email.');
        }
    }

    return redirect()->back()->with('error', 'Something went wrong. Please try again.');
}


    public function oldNumberVerify(Request $request){
          if($request->isMethod('get')){
                    return view('affiliatedUser.profiles.setting.profileChangeNumberOtp');
        }else{

        $otpArray = $request->otp ?? [];

        // Check if all OTP inputs are empty
        if(empty(array_filter($otpArray))){
            return response()->json([
                'status' => false,
                'error'  => 'Please enter OTP.',
            ]);
        }
         
        $validator = Validator::make($request->all(), [
                'id'  => 'required',
                'otp' => 'required|array|size:6',
                'otp.*' => 'required|digits:1',
            ], [
                'id.required' => 'Verification ID is missing.',
                // 'otp.required' => 'Please enter OTP.',
                // 'otp.*.required' => 'Please enter all digits of your OTP',
                'otp.required' => 'Please enter OTP.',
                'otp.size' => 'Please enter all digits of your OTP',
                'otp.*.required' => 'Please enter all digits of your OTP',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error'  => $validator->errors()->first(),
                ]);
            }

  
        try {
            $id = decrypt($request->id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid or expired verification link.');
        }

        $request->merge(['id' => $id]);
         $request->merge([
                'otp' => implode('', $request->otp)
            ]);

        $data = $this->UserAffilatedAuthService->verifyOtp($request);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return response()->json([
            'status'=>true,
            'message'=>$data['message'],
        ]);

        }
    }

    public function updateNewNumber(Request $request){
               if($request->isMethod('get')){
                  $country =   all_countrie::all();
                    return view('affiliatedUser.profiles.setting.profileChangeNumber', compact('country'));
        }
    }

    public function updateEmailAddress(){
                    return view('affiliatedUser.profiles.setting.profileChangeEmailOtp');  
    }

 public function updateResendOtp(Request $request)
{
    try {
        // Ensure the ID is present
        if (!$request->has('id')) {
            return response()->json([
                'status' => false,
                'message' => 'ID is required.',
            ], 400);
        }

        $id = decrypt($request->id);

        
        $data = UserContactChangeHistory::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 404);
        }

        $otp = config('services.otp');
        $data->otp = $otp;
        $data->save();


        return response()->json([
            'status' => true,
            'message' => 'OTP resent successfully.',
            'otp' => $otp,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong: ' . $e->getMessage(),
        ], 500);
    }
}
// change mobile number and email Code End here 




    

}