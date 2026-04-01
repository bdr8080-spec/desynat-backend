<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

Use Auth;
use Validator;
use App\Models\seller;
use App\Models\sellerStoreInformation;
use App\Models\country;
use App\Models\SellerSubcriptionPlanBuy;

use Illuminate\Support\Facades\Cache;

use App\Services\SellerAuthService;

use App\Services\SellerProductService;
use App\Services\StoryManagementService;


use App\Helpers\ApiResponse;



class WebSellerDashboard extends Controller
{

    public function __construct(SellerAuthService $SellerAuthService,SellerProductService $SellerProductService,StoryManagementService $StoryManagementService){
        $this->SellerAuthService=$SellerAuthService;
       $this->SellerProductService=$SellerProductService;
       $this->StoryManagementService=$StoryManagementService;

    }


    public function seller_dashboard(Request $request){

        // if i got payment Then Show This message
        if($request->payment=='yes'){
        session()->flash('success', 'You have successfully purchased a plan!');
        return  redirect()->route('seller.dashboard');
        }




        $seller_details=Auth::guard('seller')->user();

        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details','subcription_plan')->where('id',$seller_details->id)->first();

       $plan_page=Cache::get('plan_page');


   if($plan_page!=='yes'){

    if(count($seller_details->subcription_plan) <= 0 ){

            $request_data=(object )[
                'seller_id'=>$seller_details->id,
                'country_id' =>@$seller_details->store_info->country
            ];
    
          $plans= $this->SellerAuthService->seller_allPlan($request_data);
    
        if(isset($plans['status']) && $plans['status']=='error' ){
            return view('dealer.index',compact('seller_details'))->with('error','No Plan Found');
        }

        $plans=$plans['data'];

        Cache::put('plan_page', 'yes', 10000);

        return redirect()->route('seller.all_plans')->with('success','Please purchase a Plan for Better option');
                   
        }
        
    }

          return view('dealer.index',compact('seller_details'));
      }


    public function all_plans(Request $request){


        if($request->payment=='no'){
            session()->flash('error', 'You payment is failed Please try again');
            return  redirect()->route('seller.all_plans');
        }     

        $seller_details=Auth::guard('seller')->user();
  
        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details','subcription_plan')->where('id',$seller_details->id)->first();
    
        if($seller_details){

            $request_data=(object )[
                'seller_id'=>$seller_details->id,
                'country_id' =>$seller_details->store_info->country
            ];
    
          $plans= $this->SellerAuthService->seller_allPlan($request_data);
    
        if(isset($plans['status']) && $plans['status']=='error' ){
            return view('dealer.index',compact('seller_details'))->with('error','No Plan Found');
        }

        $plans=$plans['data'];

         return view('dealer.planlist',compact('seller_details','plans'));
           
        }else{
    
            return  redirect()->route('seller.dashboard')->with('error','No Plan Found');

        }


      }


    public function single_plans(Request $request,$id){

        $request_data=(object )[
            'plan_id'=>$id,
        ];

      $plans= $this->SellerAuthService->seller_single_allPlan($request_data);

      
    if(isset($data['status']) && $data['status']=='error' ){
        return view('dealer.index',compact('seller_details'))->with('error','No Plan Found');;
    }

    $plans=$plans['data'];

    if($request->payment=='yes'){
        session()->flash('success1', 'You have successfully purchased a plan!');
        return  redirect()->route('seller.single_plans', $id);
    }       

    return view('dealer.package-page',compact('plans'));
    
    }


    public function skip_plan(Request $request){
        Cache::put('plan_page', 'yes', 10000);
        
        return redirect()->route('seller.dashboard');

    }





    public function create_subcription(Request $request){

        $validate = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'payment_method'=>"required"
        ],[
            'payment_method.required'=>"Payment Method is required"
        ]);

        if ($validate->fails()) {
            return redirect()->back()
            ->withErrors($validate)
            ->withInput();
         }

         $seller_details=Auth::guard('seller')->user();
         $seller_details=seller::where('id',$seller_details->id)->first();

        $tranasaction_id='Tran'.rand(1111111111111,9999999999999);

        $request_data=(object )[
            'transaction_id'=>$tranasaction_id,
            'seller_id'=>$seller_details->id,
            'plan_id' =>$request->plan_id,
            'payment_status'=>'0',
            "payment_method"=>$request->payment_method??'online'
        ];

      $data= $this->SellerAuthService->create_Subcription_Order($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return redirect()->back()->with('error',$data['message']);
    }

    $data=$data['data'];
    
    if($request->payment_method=='Myfatoorah'){

        return redirect()->to('/myfatoorah/' . $data->transaction_id.'?type=subcription'); // send To Payment Gateway
    }


    


    $request_data=(object )[
        'transaction_id'=>$data->transaction_id,
        'payment_status'=>'1',
        'online_transaction_id'=>$request->online_transaction_id??null
    ];

  $complete_payment= $this->SellerAuthService->complete_Subcription_Order($request_data);

  if(isset($complete_payment['status']) && $complete_payment['status']=='error'){
    return redirect()->back()->with('error',$complete_payment['message']);
}


return  redirect()->route('seller.dashboard')->with('success','You are successfully purchase a Plan');

    }


    


    public function web_store_on_off(Request $request){


        $seller_details=Auth::guard('seller')->user();


        $request_data=(object )[
            'seller_id'=>$seller_details->id,
        ];


     $data= $this->SellerAuthService->seller_storeOnOff($request_data);
      
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


      }



  public function view_profile(REQUEST $request){

    $seller_id=Auth::guard('seller')->user()->id;
    //dd($seller_id);

    $request_data=(object) [
    'seller_id'=>$seller_id,
    ];

      $seller_details=  $this->SellerProductService->View_seller_profile($request_data);

      $seller_details=$seller_details['data'];

      $reels=  $this->StoryManagementService->getSellerReels($request_data)['data'];
      //sdd($reels);
      $highlights=  $this->StoryManagementService->getSellerHighlights($request_data)['data'];

      return view('dealer.profile.view_profile',compact('seller_details','reels','highlights'));
      }


      public function edit_profile(REQUEST $request){

        $seller_id=Auth::guard('seller')->user()->id;

        $request_data=(object) [
        'seller_id'=>$seller_id,
        ];

      $seller_details=  $this->SellerProductService->View_seller_profile($request_data);
      $seller_details=$seller_details['data'];

        $all_country=country::get();

        return view('dealer.profile.edit_profile',compact('seller_details','all_country'));
      }

                
    public function update_profile(REQUEST $req){

          $validate = Validator::make($req->all(), [

            'profile_pic' => 'required_without:old_profile_pic',
            'old_profile_pic' => 'required_without:profile_pic',

            'first_name'=>'required',
            'last_name'=>'required',            
            // 'store_image' => 'required',

            'store_image' => 'required_without:old_store_image',
            'old_store_image' => 'required_without:store_image',

            'store_name' => 'required',
            'country'=>"required",
            "store_address"=>"required",
            // 'address_line1'=>'required',
            // 'address_line2'=>'required',
            "store_phone"=>"required",
            'store_mail_id'=>'required',
            'bio'=>'required',
            // 'let'=>'required',
            // 'long'=>'required'
            
            ],[
                'profile_pic.required_without'     => 'Please upload a profile picture.',
    'old_profile_pic.required_without' => 'Previous profile picture missing.',

    'store_image.required_without'     => 'Please upload a store image.',
    'old_store_image.required_without' => 'Previous store image missing.',

    // Basic fields
    'first_name.required'     => 'Please Enter First name',
    'last_name.required'      => 'Please Enter Last name ',
    'store_name.required'     => 'Please Enter Store name ',
    'country.required'        => 'Country is required.',
    'store_address.required'  => 'Please Enter Store address.',
    'store_phone.required'    => 'Please Enter Store phone number ',
    'store_mail_id.required'  => 'Please Enter Store email.',
    'bio.required'            => 'Please Enter Bio.',
    
            ]);
        
       if($validate->fails()){

        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
     
       }

        $seller_id=Auth::guard('seller')->user()->id;

        $dir='profile/';

        if($req->profile_pic){

          $profile_pic= image_upload($req->profile_pic,$dir);
        }else{
        $profile_pic=$req->old_profile_pic;

        }

         if($req->store_image){

          $store_image= image_upload($req->store_image,$dir);
        }else{
        $store_image=$req->old_store_image;

        }


       $request_data= (object)[
        'profile_pic' => $profile_pic??null,
        'first_name' => $req->first_name??null,
        'last_name' => $req->last_name??null,
        'user_id' => $seller_id,
        'store_image' => $store_image??null ,
        'store_name' => $req->store_name ,
        'country'=>$req->country ,
        "store_address"=>$req->store_address ,
        'address_line1'=>$req->address_line1 ,
        'address_line2'=>$req->address_line2 ,
        'country_code' => $req->country_code,
        "store_phone"=>$req->store_phone ,
        'store_mail_id'=>$req->store_mail_id,
        'bio'=>$req->bio,
        'let'=>$req->let??null,
        'long'=>$req->long??null
       ];
       
        $data= $this->SellerProductService->profile_store_information_insert($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }


        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

        }


    public function editbankdetails(REQUEST $req){

        $seller_id=Auth::guard('seller')->user()->id;

        $validate = Validator::make($req->all(), [
            'account_type'=>"required|in:0,1", // 0 Personal 1 Busness
            "iban"=>"required",
            'swift'=>'required',
            'bank_name'=>'required',
            "account_holder_name"=>"required",
            // 'upload_proof'=>'required',

            'upload_proof' => 'required_without:old_upload_proof',
            'old_upload_proof' => 'required_without:upload_proof',

            ],[

            'account_type.required' => 'Account type is required.',
            'account_type.in'       => 'Invalid account type selected.',

            'iban.required'                => 'IBAN number is required.',
            'swift.required'               => 'SWIFT code is required.',
            'bank_name.required'           => 'Bank name is required.',
            'account_holder_name.required' => 'Account holder name is required.',

            // Proof upload messages
            'upload_proof.required_without'     => 'Please upload proof document.',
            'old_upload_proof.required_without' => 'Previous proof document is missing.',

            ]);
            
         if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
            
        }

        if($req->upload_proof){

        $dir='profile/';
        $upload_proof= image_upload($req->upload_proof,$dir);
       
        }else{
        $upload_proof=$req->old_upload_proof;

        }

       $request_data= (object) [
        'user_id' => $seller_id,
        'type'=> '1',
        'account_type' => strVal($req->account_type),
        'iban' => $req->iban??null ,
        'swift'=>$req->swift??null ,
        "bank_name"=>$req->bank_name ,
        'account_holder_name'=>$req->account_holder_name ,
        'upload_proof'=>$upload_proof,
       ];

       
        $data= $this->SellerProductService->store_bank_details_update($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
                
        }

        

       public function update_commison(REQUEST $request){

$seller_id=Auth::guard('seller')->user()->id;

        if($request->isMethod('get')){

          

        $request_data=(object) [
        'seller_id'=>$seller_id,
        ];

      $seller_details=  $this->SellerProductService->View_seller_profile($request_data);
      $seller_details=$seller_details['data'];
      
    return view('dealer.commission.commission',compact('seller_details'));
    
        }

        if($request->isMethod('post')){


      $validate = Validator::make($request->all(), [               
        'affilate_commission'=>'required|numeric|min:0|max:100'        
     ],[
        
        'affilate_commission.required' => 'Affiliate commission is required.',
        'affilate_commission.numeric' => 'Affiliate commission must be a number.',
        'affilate_commission.min' => 'Affiliate commission cannot be less than 0%.',
        'affilate_commission.max' => 'Affiliate commission cannot be more than 100%.',

     ]);
    
    if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors(),422);
    }

    
    $request_data=(object) [
    'seller_id'=>$seller_id,
    'affilate_commission'=>$request->affilate_commission
    ];
    
      $data=  $this->SellerProductService->Update_affilate_commission_Inventory($request_data);
    
      if(isset($data['status']) && $data['status']=='error' ){
          return ApiResponse::generateResponse('error', $data['message'],(object)[],422);
      }
    
      return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
     


        }
      
      
        }
    
    public function subscriptionPlan(Request $request){
        $seller_details=Auth::guard('seller')->user();
        $request_data=(object )[
            'seller_id'=>$seller_details->id,
        ];
     $myPlans= $this->SellerAuthService->seller_myPlan($request_data)['data'];
     //dd($myPlans);
     $sellerCountry = sellerStoreInformation::with('country_info')->where('seller_id',$seller_details->id)->first();
     //dd($sellerCountry);
     $request_data=(object )[
            'country_id'=>$sellerCountry->country,
        ];
     $allPlans= $this->SellerAuthService->seller_allPlan($request_data)['data'];
     //dd($allPlans);
     $activePlan = SellerSubcriptionPlanBuy::where('seller_id', $seller_details->id)
                    ->where('is_expired','0')
                    ->where('status', '1')
                    ->first();
    return view('dealer.plans.index',compact('myPlans','allPlans','activePlan'));

    
    }
    
    public function renew_subcription_plan_buy(Request $request){

        
        $validate = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
        ]);


        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }


        $seller_details=Auth::guard('seller')->user();

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

    public function add_story(REQUEST $request){

        $seller_id=Auth::guard('seller')->user()->id;
        //dd($seller_id);

        $request_data=(object) [
        'seller_id'=>$seller_id,
        ];

        $stories=  $this->StoryManagementService->getSellerStories($request_data)['data'];
        //dd($stories);

        return view('dealer.addstory.index',compact('stories'));
    }

    public function add_highlight(REQUEST $request){

        $seller_id=Auth::guard('seller')->user()->id;
        //dd($seller_id);

        $request_data=(object) [
        'seller_id'=>$seller_id,
        ];

        $highlights=  $this->StoryManagementService->getSellerHighlights($request_data)['data'];

        return view('dealer.addstory.add-highlight',compact('highlights'));
    }


      

      

      

}