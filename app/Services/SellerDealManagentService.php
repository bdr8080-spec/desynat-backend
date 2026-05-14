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

use Carbon\Carbon;



use App\Models\{ product,ProductSpecification,ProductVariant,StockInventoryRecords};

class SellerDealManagentService
{

public function seller_ViewDeal($request){
        
try{

  
$today = Carbon::today();
$all_deal = Deal::query()
    ->where('status', '1');

/**
 * Listed Deals (active deals by date)
 */$listed_deal = (clone $all_deal)
    ->whereDate('to', '>=', $today)
    ->whereDoesntHave('sellerDealrecord')
    ->when($request->tab == "1", function ($q) use ($request) {

    $q->when($request->from, function ($qq) use ($request) {
        $qq->whereDate('from', '<=', $request->from);
    });
    $q->when($request->to, function ($qq) use ($request) {
        $qq->whereDate('to', '>=', $request->to);
    });
    })

    ->orderBy('id','desc')
    ->get();

    
/**
 * Enrolled Deals (seller joined + active)
 */
$enrolled = (clone $all_deal)
    ->when($request->tab == "2", function ($q) use ($request) {

    $q->when($request->from, function ($qq) use ($request) {
        $qq->whereDate('from', '<=', $request->from);
    });
    $q->when($request->to, function ($qq) use ($request) {
        $qq->whereDate('to', '>=', $request->to);
    });


    })

    ->whereHas('sellerDealrecord', function ($query) use ($request, $today) {
        $query->where('seller_id', $request->seller_id)
            //   ->whereDate('from', '<=', $today)
              ->whereDate('to', '>=', $today);
    })
    ->with([
        'sellerDealrecord' => function ($query) use ($request) {
            $query->where('seller_id', $request->seller_id);
        }
    ])
    ->withCount([
        'sellerDealrecord as seller_deal_count' => function ($query) use ($request) {
            $query->where('seller_id', $request->seller_id);
        }
    ])

    ->orderBy('id','desc')
    ->get();

/**
 * Expired Deals (seller enrolled but expired)
 */
$expired_deal = (clone $all_deal)
    ->when($request->tab == "3", function ($q) use ($request) {

    $q->when($request->from, function ($qq) use ($request) {
        $qq->whereDate('from', '<=', $request->from);
    });
    $q->when($request->to, function ($qq) use ($request) {
        $qq->whereDate('to', '>=', $request->to);
    });


    })
    ->whereHas('sellerDealrecord', function ($query) use ($request, $today) {
        $query->where('seller_id', $request->seller_id)
              ->whereDate('to', '<', $today);
    })
    ->with([
        'sellerDealrecord' => function ($query) use ($request) {
            $query->where('seller_id', $request->seller_id);
        }
    ])
    ->withCount([
        'sellerDealrecord as seller_deal_count' => function ($query) use ($request) {
            $query->where('seller_id', $request->seller_id);
        }
    ])

    ->orderBy('id','desc')
    ->get();

$response = [
    'listed_deal'  => $listed_deal,
    'enrolled'    => $enrolled,
    'expired_deal'=> $expired_deal,
];


return ['status'=>'success','message'=>"All deals data fetch Successfully",'data'=>$response];

} 
catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];

}

}


// public function SingleDealView($request){
        
// try{


//    $deal= Deal::with('category_details','subCategory_details')->where('id',$request->deal_id)
//     ->first();

//     if($deal){

//         $search_data=[
//             "deal_id"=>$deal->id,
//             "seller_id"=>$request->seller_id 
//         ];
        
//         $product_data=SellerDealProduct::
//         with([
//       'product_details' => function ($q) {
//         $q->with([
//             'category',
//             'subcategory',
//             'brand',
//             'product_specifications',
//             'product_variants.color',
//             'review.user_details',
//         ])
//         ->withAvg('review as avg_product_rating', 'product_rating');
//     }
// ])->where($search_data);    
//     if(isset($request->search)){
//         $product_data=$product_data->whereHas('product_details', function($query)use ($request){
//             $query->where('product_name_en','Like','%'.$request->search.'%');
//         });
//     }   
//     $product_data=$product_data->get();

//     //    Remaining product 

//       $already_add_product=  SellerDealProduct::where('deal_id',$deal->id)->where('seller_id',$request->seller_id)->pluck('product_id')->toArray();

//         $search_data=[
//             "category_id"=>$deal->category_id,
//             "subcategory_id"=>$deal->sub_category_id  ,
//             "seller_id"=>$request->seller_id 
//         ];

// $remaining_Product = Product::with([
//     'category',
//     'subcategory',
//     'brand',
//     'product_specifications',
//     'product_variants.color',
//     'review.user_details',
// ])
// ->withAvg('review as avg_product_rating', 'product_rating')->where($search_data);    
//         if(isset($request->search)){
//             $remaining_Product=$remaining_Product->where('product_name_en','Like','%'.$request->search.'%');
//         }

//        $remaining_Product=$remaining_Product->whereNotIn('id',$already_add_product)->get();

//     }

//     $response['deal_data']= $deal;
//     $response['added_products']= $product_data;
//     $response['remaining_Product']= $remaining_Product;

//     return ['status'=>'success','message'=>"Single deals data fetch Successfully",'data'=>$response];

// } 
// catch (\Exception $e) {
//     return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];

// }

// }

public function SingleDealView($request)
{
    try {

        // Load only REAL relationships
        $deal = Deal::with('category_details')
            ->where('id', $request->deal_id)
            ->first();

        if (!$deal) {
            return [
                'status'  => 'error',
                'message' => __('service_messages.deal_not_found'),
                'data'    => (object)[]
            ];
        }

        /**
         * Handle multiple subcategories manually
         */
        $subCategoryIds = [];

        if (!empty($deal->sub_category_id)) {
            if (is_array($deal->sub_category_id)) {
                $subCategoryIds = $deal->sub_category_id;
            } elseif (is_string($deal->sub_category_id)) {
                $subCategoryIds = array_filter(explode(',', $deal->sub_category_id));
            }
        }

        $deal->subCategory_details = SubCategory::whereIn('id', $subCategoryIds)->get();

        /**
         * Added products in deal
         */
        $product_data = SellerDealProduct::with([
            'product_details' => function ($q) {
                $q->with([
                    'category',
                    'subcategory',
                    'brand',
                    'product_specifications',
                    'product_variants.color',
                    'review.user_details',
                ])->withAvg('review as avg_product_rating', 'product_rating');
            }
        ])
        ->where([
            'deal_id'   => $deal->id,
            'seller_id' => $request->seller_id
        ]);

        if (isset($request->search)) {
            $product_data->whereHas('product_details', function ($query) use ($request) {
                $query->where('product_name_en', 'like', '%' . $request->search . '%');
            });
        }

        $product_data = $product_data->get();

        /**
         * Already added product IDs
         */
        $already_add_product = SellerDealProduct::where('deal_id', $deal->id)
            ->where('seller_id', $request->seller_id)
            ->pluck('product_id')
            ->toArray();

        /**
         * Remaining products
         */
        $remaining_Product = Product::with([
            'category',
            'subcategory',
            'brand',
            'product_specifications',
            'product_variants.color',
            'review.user_details',
        ])
        ->withAvg('review as avg_product_rating', 'product_rating')
        ->where('category_id', $deal->category_id)
        ->whereIn('subcategory_id', $subCategoryIds)
        ->where('seller_id', $request->seller_id)
        ->whereNotIn('id', $already_add_product);

        if (isset($request->search)) {
            $remaining_Product->where('product_name_en', 'like', '%' . $request->search . '%');
        }

        $remaining_Product = $remaining_Product->get();

        /**
         * Response
         */
        $response = [
            'deal_data'         => $deal,
            'added_products'    => $product_data,
            'remaining_Product' => $remaining_Product
        ];

        return [
            'status'  => 'success',
            'message' => 'Single deals data fetch Successfully',
            'data'    => $response
        ];

    } catch (\Exception $e) {
        return [
            'status'  => 'error',
            'message' => 'Error found',
            'data'    => $e->getMessage()
        ];
    }
}




public function SellerProductListCatgoryAndSubcatgeoryAccording($request){
        
try{


   $deal= Deal::where('id',$request->deal_id)
    ->first();

    if($deal){

        // Already Add Product 

      $already_add_product=  SellerDealProduct::where('deal_id',$deal->id)->where('seller_id',$request->seller_id)->pluck('product_id')->toArray();

        $search_data=[
            "category_id"=>$deal->category_id,
            "subcategory_id"=>$deal->sub_category_id  ,
            "seller_id"=>$request->seller_id 
        ];
        
        $product_data=product::with('category','subcategory','brand','product_specifications','product_variants.color')->where($search_data);    
        if(isset($request->search)){
            $product_data=$product_data->where('product_name_en','Like','%'.$request->search.'%');
        }
       $product_data=$product_data->whereNotIn('id',$already_add_product)->get();


    
    }else{

        return ['status'=>'error','message'=>"deal id Is Invalid",'data'=>(object)[]];

    }

    return ['status'=>'success','message'=>"Single deals data fetch Successfully",'data'=>$product_data];

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

        return ['status'=>'success','message' => __('service_messages.deal_product_added_successfully'),'data'=>$deal];


    }else{
         return ['status'=>'error','message'=>"deal id Is Invalid",'data'=>(object)[]];
    }

 
} 
catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];

}

}




public function removeProductsFromTheDeal($request){
        
try{
    
   $deal= Deal::where('id',$request->deal_id)
    ->first();

    if($deal){

          $check_data=[
            "deal_id"=>$deal->id,
            "id"=>$request->id,
            // "seller_id"=>$request->seller_id,
        ];
        SellerDealProduct::where($check_data)->delete();

        return ['status'=>'success','message' => __('service_messages.products_removed_from_deal'),'data'=>(object)[]];

     
    }else{

        return ['status'=>'error','message'=>"deal id Is Invalid",'data'=>(object)[]];

    }

    return ['status'=>'success','message'=>"Single deals data fetch Successfully",'data'=>(object)[]];

} 
catch (\Exception $e) {
    return ['status'=>'error','message'=>"error found1",'data'=>$e->getMessage()];

}

}



}