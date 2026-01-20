<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Hash;


use App\Models\{ seller,sellerStoreInformation,Bankdetails};
use App\Models\color;
use App\Models\{Brand,Deal,SellerDealProduct};

use Illuminate\Support\Facades\DB;



use App\Models\{ product,ProductSpecification,ProductVariant,StockInventoryRecords};

class SellerDealManagentService
{

public function seller_ViewDeal($request){
        
try{

   $all_deal= Deal::with('sellerDealrecord')->where('status','1');

// listed Code Show 
// $listed_deal= clone($all_deal)
// //  ->whereDate('from' ,'<=',date('Y-m-d'))
//     ->whereDate('to' ,'>=',date('Y-m-d'))
//     ->get(); 


// enrolled Code 
// $enrolled = clone($all_deal)->whereHas('sellerDealrecord', function ($query) use ($request) {
//         $query->where('seller_id', $request->seller_id)
//           ->whereDate('from' ,'<=',date('Y-m-d'))
//          ->whereDate('to' ,'>=',date('Y-m-d'));
//     })
//     ->with('sellerDealrecord')
//     ->get();


    $expired_deal = clone($all_deal)->whereHas('sellerDealrecord', function ($query) use ($request) {
        $query->where('seller_id', $request->seller_id)
         ->whereDate('to' ,'<',date('Y-m-d'));
    })
    ->with('sellerDealrecord')
    ->get();





// $response['listed_deal']=$listed_deal;
// $response['enrolled']=$enrolled;
$response['expired_deal']=$expired_deal;


return ['status'=>'success','message'=>"All deals data fetch Successfully",'data'=>$response];

} 
catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];

}

}


public function SingleDealView($request){
        
try{


   $deal= Deal::where('id',$request->deal_id)
    ->first();

    if($deal){

        $search_data=[
            "category_id"=>$deal->category_id,
            "subcategory_id"=>$deal->sub_category_id  ,
            "seller_id"=>$request->seller_id 
        ];
        
        $product_data=product::with('category','subcategory','brand','product_specifications','product_variants.color')->where($search_data);    
        if(isset($request->search)){
            $product_data=$product_data->where('product_name_en','Like','%'.$request->search.'%');
        }
       $product_data=$product_data->get();
    
    }

    $response['deal_data']= $deal;
    $response['products']= $product_data;

    return ['status'=>'success','message'=>"Single deals data fetch Successfully",'data'=>$response];

} 
catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];

}

}



public function SellerAddProductsInDeals($request){
        
try{


   $deal= Deal::where('id',$request->deal_id)
    ->first();

    if($deal){

    foreach($request->product_ids as $key=>$val){
            
        $insert_data=[
            "deal_id"=>$deal->id,
            "product_id"=>$val,
            "seller_id"=>$request->seller_id,
            "discount"=>$deal->discount
        ];
            SellerDealProduct::UpdateorCreate($insert_data);
        }

        return ['status'=>'success','message'=>"Add product inside Deal Add Successfully",'data'=>$deal];


    }else{
         return ['status'=>'error','message'=>"deal id Is Invalid",'data'=>(object)[]];
    }

 
} 
catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];

}

}


}