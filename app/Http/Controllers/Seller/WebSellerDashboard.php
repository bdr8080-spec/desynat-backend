<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

Use Auth;
use Validator;
use App\Models\seller;

use Illuminate\Support\Facades\Cache;

use App\Services\SellerAuthService;



class WebSellerDashboard extends Controller
{

    public function __construct(SellerAuthService $SellerAuthService){
        $this->SellerAuthService=$SellerAuthService;
    }


    public function seller_dashboard(Request $request){

        $seller_details=Auth::guard('seller')->user();

        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details','subcription_plan')->where('id',$seller_details->id)->first();

        

   $plan_page=Cache::get('plan_page');


   if($plan_page!=='yes'){

        if(count($seller_details->subcription_plan) <= 0 ){

            $request_data=(object )[
                'seller_id'=>$seller_details->id,
                'country_id' =>$seller_details->store_info->country
            ];
    
          $plans= $this->SellerAuthService->seller_allPlan($request_data);
    
        if(isset($plans['status']) && $plans['status']=='error' ){
            return view('dealer.index',compact('seller_details'))->with('error','No Plan Found');
        }

        $plans=$plans['data'];

        Cache::put('plan_page', 'yes', 60);

        // session::put(['plan'=>'1']);

        // seller.all_plans'
        return redirect()->route('seller.all_plans')->with('success','Please purchase a Plan for Better option');
                   
        }

    }


          return view('dealer.index',compact('seller_details'));
      }




    public function all_plans(Request $request){


        $seller_details=Auth::guard('seller')->user();
  
        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details','subcription_plan')->where('id',$seller_details->id)->first();
    
        if(count($seller_details->subcription_plan) <= 0 ){


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

    return view('dealer.package-page',compact('plans'));

      }


    public function skip_plan(Request $request){
        Cache::put('plan_page', 'yes', 60);
        
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
        return redrect()->back()->with('error',$data['message']);
    }

    $data=$data['data'];

    if($request->payment_method=='Myfatoorah'){

        return redirect()->to('/myfatoorah/' . $data->transaction_id); // send To Payment Gateway
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

      

}