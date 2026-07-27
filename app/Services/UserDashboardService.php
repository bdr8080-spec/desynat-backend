<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\{RecentSearch,sellerStoreInformation,wishlist,product,Brand,User,all_countrie,FullBanner,sellerBanner,Deal,LiveRequest,orderdetail,Order,productRatings};


use Carbon\Carbon;


class UserDashboardService
{


public function HomePageSearch($data)
    {
        // dd($data->search);
        try {
           // dd($data->search);

    // if($data->search){
    //     //dd($data->search);

    //     $search=[
    //         'user_id'=>$data->user_id,
    //         'name'=>$data->search
    //     ];
    //     //dd($search);
    //     // Store Search Data 
    //     RecentSearch::UpdateOrCreate($search);
    // }

    if (!empty($data->user_id) && !empty($data->search)) {
        RecentSearch::updateOrCreate(
            [
                'user_id' => $data->user_id,
                'name'    => $data->search,
            ],
            []
        );
    }

     $wishlistIds = wishlist::where('user_id', $data->user_id)
    ->pluck('product_id')
    ->toArray();

    

/**
 * Start product query directly
 */

$attributes = is_array($data->attributes ?? null)
    ? $data->attributes
    : [];


$products = product::with([
    'brand',
    'category',
    'subcategory',
    'product_specifications',
    'product_variants' => function ($q) use ($data) {

        if (!empty($data->size_id) && is_array($data->size_id)) {
            $q->whereIn('size_id', array_map('intval', $data->size_id));
        }

        if (!empty($data->color_id) && is_array($data->color_id)) {
            $q->whereIn('color_id', array_map('intval', $data->color_id));
        }

        if (isset($data->price_min)) {
            $q->where('final_price', '>=', intval($data->price_min));
        }

        if (isset($data->price_max)) {
            $q->where('final_price', '<=', intval($data->price_max));
        }
    },
    'product_variants.color',
    'product_variants.size'
]);


/**
 * Search filter
 */
if (!empty($data->search)) {
    $products->where(function ($query) use ($data) {
        $query->where('product_name_en', 'LIKE', '%' . $data->search . '%')
              ->orWhere('other_en', 'LIKE', '%' . $data->search . '%')
              ->orWhere('description_en', 'LIKE', '%' . $data->search . '%');
              
    });
     $products->orWhereHas('brand', function ($q) use ($data) {
                $q->Where('name_english', 'LIKE', "%{$data->search}%");
        });
}

/**
 * Brand filter
 */
if (!empty($data->brand_id) && is_array($data->brand_id)) {
    $products->whereIn('brand_id', array_map('intval', $data->brand_id));
}

/**
 * Category filter
 */
if (!empty($data->category_id) && is_array($data->category_id)) {
    $products->whereIn('category_id', array_map('intval', $data->category_id));
}

if (!empty($data->sub_category_id) && is_array($data->sub_category_id)) {
    $products->whereIn('subcategory_id', array_map('intval', $data->sub_category_id));
}

// if (!empty($data->search)) {



// }



/**
 * Variant-based filtering
 */
if (
    !empty($data->size_id) ||
    !empty($data->color_id) ||
    !empty($data->price_min) ||
    !empty($data->price_max) ||
    !empty($data->discount)
) {
    $products->whereHas('product_variants', function ($q) use ($data) {

        if (!empty($data->size_id) && is_array($data->size_id)) {
            $q->whereIn('size_id', array_map('intval', $data->size_id));
        }

        if (!empty($data->color_id) && is_array($data->color_id)) {
            $q->whereIn('color_id', array_map('intval', $data->color_id));
        }

        if (!empty($data->price_min)) {
            $q->where('final_price', '>=', $data->price_min);
        }

        if (!empty($data->price_max)) {
            $q->where('final_price', '<=', $data->price_max);
        }

        if (!empty($data->discount)) {
            $q->where('discount_value', '<=', $data->discount);
        }
    });
}




if (!empty($attributes)) {
    $products->where(function ($query) use ($attributes) {

        foreach ($attributes as $value) {
            $query->orWhere('product_name_en', 'LIKE', "%{$value}%")
                  ->orWhere('other_en', 'LIKE', "%{$value}%");
                //   ->orWhere('description_en', 'LIKE', "%{$value}%");
        }

        // 🔹 Brand name search
        $query->orWhereHas('brand', function ($q) use ($attributes) {
            foreach ($attributes as $value) {
                $q->orWhere('name_english', 'LIKE', "%{$value}%");
            }
        });

        // 🔹 Category name search
        $query->orWhereHas('category', function ($q) use ($attributes) {
            foreach ($attributes as $value) {
                $q->orWhere('name', 'LIKE', "%{$value}%");
            }
        });

          // 🔹 SubCategory name search
        $query->orWhereHas('subcategory', function ($q) use ($attributes) {
            foreach ($attributes as $value) {
                $q->orWhere('name_english', 'LIKE', "%{$value}%");
            }
        });

    });
}

/**
 * Sorting
 */
if (!empty($data->sort_filter)) {
    switch ($data->sort_filter) {

        case 2: // Price: Low to High
            $products->with(['product_variants' => function ($q) {
                $q->orderBy('final_price', 'asc');
            }]);
            break;

        case 3: // Price: High to Low
            $products->with(['product_variants' => function ($q) {
                $q->orderBy('final_price', 'desc');
            }]);
            break;

        case 4: // Newest
            $products->orderBy('created_at', 'desc');
            break;

        case 8: // Oldest
            $products->orderBy('created_at', 'asc');
            break;
    }
}

/**
 * Pagination + Wishlist flag
 */
$products = $products->paginate()
    ->through(function ($product) use ($wishlistIds) {
        $product->wishlist = in_array($product->id, $wishlistIds) ? 1 : 0;
        return $product;
    })
    ->appends((array) $data);

/**
 * Final response
 */
return [
    'status'  => 'success',
    'message' => 'Product list',
    'data'    => $products
];


        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }






public function HomeRecentSearchList($request)
    {
        try {


    $search=[
        'user_id'=>$request->user_id,
    ];
        // Store Search Data 
$search_result=RecentSearch::where('user_id', $request->user_id)->limit(8)->get();

return [
    'status'  => 'success',
    'message' => 'Recent Search List ',
    'data'    => $search_result
];


        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }

public function HomePageSearchWeb($data)
{
    try {
        if (!empty($data->search) && !empty($data->user_id)) {
            RecentSearch::updateOrCreate(
                ['user_id' => $data->user_id, 'name' => $data->search],
                ['updated_at' => now()]
            );
        }

        $products = product::with([
            'brand',
            'category',
            'subcategory',
            'product_specifications',
            'product_variants' => function ($q) {
                $q->select('id','product_id','final_price'); 
            },
            'product_variants.color',
            'product_variants.size'
        ]);

    if (!empty($data->search)) {
       $products->where(function ($query) use ($data) {
        $query->where('product_name_en', 'LIKE', '%' . $data->search . '%')
              ->orWhere('other_en', 'LIKE', '%' . $data->search . '%')
              ->orWhere('description_en', 'LIKE', '%' . $data->search . '%');
    });
}



/**
 * Brand filter
 */
if (!empty($data->brand_id) && is_array($data->brand_id)) {
    $products->whereIn('brand_id', array_map('intval', $data->brand_id));
}

/**
 * Category filter
 */
if (!empty($data->category_id) && is_array($data->category_id)) {
    $products->whereIn('category_id', array_map('intval', $data->category_id));
}

/**
 * Variant-based filtering
 */
if (
    !empty($data->size_id) ||
    !empty($data->color_id) ||
    !empty($data->price_min) ||
    !empty($data->price_max) ||
    !empty($data->discount)
) {
    $products->whereHas('product_variants', function ($q) use ($data) {

        if (!empty($data->size_id) && is_array($data->size_id)) {
            $q->whereIn('size_id', array_map('intval', $data->size_id));
        }

        if (!empty($data->color_id) && is_array($data->color_id)) {
            $q->whereIn('color_id', array_map('intval', $data->color_id));
        }

        if (!empty($data->price_min)) {
            $q->where('final_price', '>=', $data->price_min);
        }

        if (!empty($data->price_max)) {
            $q->where('final_price', '<=', $data->price_max);
        }
        
        if (!empty($data->discount)) {
            $q->where('discount_value', '<=', $data->discount);
        }
    });
}

/**
 * Sorting
 */
if (!empty($data->sort_filter)) {
    switch ($data->sort_filter) {

        case 2: // Price: Low to High
            $products->with(['product_variants' => function ($q) {
                $q->orderBy('final_price', 'asc');
            }]);
            break;

        case 3: // Price: High to Low
            $products->with(['product_variants' => function ($q) {
                $q->orderBy('final_price', 'desc');
            }]);
            break;

        case 4: // Newest
            $products->orderBy('created_at', 'desc');
            break;

        case 8: // Oldest
            $products->orderBy('created_at', 'asc');
            break;
    }
}

        // Pagination
        $products = $products->paginate(10)->appends((array)$data);

        return [
            'status'  => 'success',
            'message' => 'Product list',
            'data'    => $products
        ];

    } catch (\Exception $e) {
        return [
            'status'  => 'error',
            'message' => 'Failed: ' . $e->getMessage(),
            'data'    => (object)[]
        ];
    }
}




public function RecentSearch_dateGet($request)
    {
        try {


    $search=[
        'user_id'=>$request->user_id,
    ];
        // Store Search Data 
$search_result=RecentSearch::where('user_id', $request->user_id)->limit(8)->orderBy('id','desc')->get();

return [
    'status'  => 'success',
    'message' => 'Recent Search List ',
    'data'    => $search_result
];


        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }





public function Recommanded_HomeRecentSearchList($request)
    {
        try {


    $search=[
        'user_id'=>$request->user_id,
    ];
        // Store Search Data 
// $search_result=RecentSearch::where('user_id', $request->user_id)->limit(8)->orderBy('id','desc')->get();

$search_result = Brand::all();

return [
    'status'  => 'success',
    'message' => 'Recent Search List ',
    'data'    => $search_result
];


        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }


public function PopUPHomeScreenBanner($request)
    {
        try {


$user_id=$request->user_id;


$user_details=  User::where('id', $user_id)->first();

$country_code=all_countrie::where('status',1)->where('dial_code', $user_details->country_code)->first();

$all_Banners = FullBanner::whereDate('start_date', '<=', date('Y-m-d'))
    ->whereDate('end_date', '>=', date('Y-m-d'))
    ->where('type', $request->type)
    ->when($country_code, function ($query) use ($country_code) {
        return $query->where('country_id', $country_code->id);
    })
    ->where('status', '1')
    ->get();

return [
    'status'  => 'success',
    'message' => 'All Banner Get Successfully',
    'data'    => $all_Banners
];


        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }



public function HomeScreenBanner($request)
{
try {

//$user_id=$request->user_id;

$homeScreenBanner=sellerBanner::with('seller_details.store_info','category_details','subcategory_details')->where('banner_position',$request->type)
// ->whereHas('seller_details')
->whereDate('start_date', '<=', now())
->whereDate('end_date', '>=', now())
->where('payment_status','1')
->where('Admin_verify','1')
->where('status','1');


if($request->type=='3'){
    $homeScreenBanner=$homeScreenBanner->where('category',$request->category);
}

if($request->type=='3' && !isset($request->subcategory)){
    $homeScreenBanner=$homeScreenBanner->whereNull('subcatgory');

}

if($request->type=='3' && isset($request->subcategory)){
    $homeScreenBanner=$homeScreenBanner->where('subcatgory',$request->subcategory);

}


$homeScreenBanner=$homeScreenBanner->get();



return [
    'status'  => 'success',
    'message' => 'All Home Screen Banner or category Banner fetch Successfully',
    'data'    => $homeScreenBanner
];


        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }




public function HomeScreenDealManagement($request)
    {
        try {


// $all_deal= Deal::with('sellerDealrecord.product_details')->where('category_id',$request->category)
// ->whereDate('from','<=',date('Y-m-d'))
// ->whereDate('to','>=',date('Y-m-d'))
// ->where('status','1')->get();
$all_deal = Deal::with('sellerDealrecord.product_details')
    ->when($request->category, function ($query) use ($request) {
        $query->where('category_id', $request->category);
    })
    ->whereDate('from', '<=', date('Y-m-d'))
    ->whereDate('to', '>=', date('Y-m-d'))
    ->where('status', '1')
    ->get();
    

return [
    'status'  => 'success',
    'message' => 'All Deal records Get Successfully',
    'data'    => $all_deal
];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }


 public function UserSidelive_room_records()
    {
        try {
          
 
$baseQuery = LiveRequest::with([
    'seller_details',
    'timeslot_details',
    'timeslot_details.country_info',
])
->where('admin_verify', '1');

// 🔍 Search
if (!empty($request_data->search)) {
    $baseQuery->where('order_id', 'like', '%' . $request_data->search . '%');
}

$today = Carbon::today()->toDateString();
$currentTime = Carbon::now()->format('H:i:s'); // 24-hour format

/**
 * ✅ Current (Today)
 */
$currentQuery = clone $baseQuery;
$currentQuery->whereHas('timeslot_details', function ($q) use ($today,$currentTime) {
    $q->whereDate('date', $today)
   // ->whereRaw("STR_TO_DATE(`from`, '%h:%i %p') < ?", [$currentTime])
    ->whereRaw("STR_TO_DATE(`to`, '%h:%i %p') > ?", [$currentTime]);
    // ->where('to','>', )

});

$current_requests = $currentQuery->get();

// ❌ If both empty
if ($current_requests->isEmpty()) {
    return [
        'status' => 'success',
        'message' => 'No Request found',
        'data' => []
    ];
}

// ✅ Final response
return [
    'status' => 'success',
    'message' => 'Requests fetched successfully',
    'data' => 
         $current_requests
];


        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch request: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }





public function UsersuggestStore()
    {
        try {

//   $stores = sellerStoreInformation::orderBy('store_name', 'desc')->limit(10)->get();
    // $stores = sellerStoreInformation::inRandomOrder()
    //                     ->limit(10)
    //                     ->get();
    

    $stores = sellerStoreInformation::whereHas('seller_information.subcription_plan', function ($query) {
        $query->where('is_expired', 0)
            ->whereDate('plan_end_date', '>=', Carbon::today())
            ->whereHas('plan_info', function ($plan) {
                $plan->where('is_recommended_store', 1);
            });
    })
    ->inRandomOrder()
    ->limit(10)
    ->get();

return [
    'status'  => 'success',
    'message' => 'All Suggest Store fetch Successfully',
    'data'    => $stores
];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }





public function bestSellingProduct($user_id=null)
    {
try {

$wishlistIds = wishlist::where('user_id', $user_id)
                       ->pluck('product_id')
                       ->toArray();


//   $bestSeller = orderdetail::where('payment_status','1')->pluck('product_id')->unique();
 $bestSeller = orderdetail::where('payment_status','1')
    ->pluck('product_id')
    ->unique()
    ->values(); // 🔥 reindex keys

if($bestSeller){
 $all_product_fetch=product::with(['category','subcategory','brand','product_specifications','product_variants.color','store'])
  ->withAvg('review as product_avg_rating', 'product_rating')
  ->withCount('review')
 ->whereIn('id',$bestSeller)->limit(10)
 ->inRandomOrder()
 ->get()
 ->map(function ($product) use ($wishlistIds) {
        $product->wishlist = in_array($product->id, $wishlistIds) ? 1 : 0;
        return $product;
    });

}else{
$all_product_fetch=product::with(['category','subcategory','brand','product_specifications','product_variants.color'])
->withAvg('review as product_avg_rating', 'product_rating')
->withCount('review') 
->limit(10)
->inRandomOrder()
->get()
 ->map(function ($product) use ($wishlistIds) {
        $product->wishlist = in_array($product->id, $wishlistIds) ? 1 : 0;
        return $product;
    });
}

return [
    'status'  => 'success',
    'message' => 'All Best sellering product fetch Successfully',
    'data'    => $all_product_fetch
];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }



public function TopRatingProduct($user_id=null)
    {
        
try {

$wishlistIds = wishlist::where('user_id', $user_id)
                       ->pluck('product_id')
                       ->toArray();

                       
//   $bestSeller = orderdetail::where('payment_status','1')->pluck('product_id')->unique();


  $bestSeller = productRatings::pluck('product_id')
    ->unique()
    ->values(); // 🔥 reindex keys

if($bestSeller){
 $all_product_fetch=product::with(['category','subcategory','brand','product_specifications','product_variants.color','store'])->whereIn('id',$bestSeller)
 ->withAvg('review as product_avg_rating', 'product_rating')
  ->withCount('review')
 ->limit(10)
 ->inRandomOrder()
 ->get()
 ->map(function ($product) use ($wishlistIds) {
        $product->wishlist = in_array($product->id, $wishlistIds) ? 1 : 0;
        return $product;
    });
 

}else{
$all_product_fetch=product::with(['category','subcategory','brand','product_specifications','product_variants.color'])
->withAvg('review as product_avg_rating', 'product_rating')
->withCount('review')
->limit(10)
->inRandomOrder()
->get()
 ->map(function ($product) use ($wishlistIds) {
        $product->wishlist = in_array($product->id, $wishlistIds) ? 1 : 0;
        return $product;
    });

}

return [
    'status'  => 'success',
    'message' => 'Top rating product fetch Successfully',
    'data'    => $all_product_fetch
];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }


    
public function userNewestProduct($user_id=null)
    {
try {

$wishlistIds = wishlist::where('user_id', $user_id)
                       ->pluck('product_id')
                       ->toArray();



$all_product_fetch=product::with(['category','subcategory','brand','product_specifications','product_variants.color','store'])
->withAvg('review as product_avg_rating', 'product_rating')
->withCount('review') 
->orderBy('created_at','desc')
->limit(10)
->get()
 ->map(function ($product) use ($wishlistIds) {
        $product->wishlist = in_array($product->id, $wishlistIds) ? 1 : 0;
        return $product;
    });

return [
    'status'  => 'success',
    'message' => 'Newest product fetch Successfully',
    'data'    => $all_product_fetch
];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }


    public function singleStoreWiseAllproduct($data)
    {
        try {
    
            // Step 1: Find store
            $store_information = sellerStoreInformation::with('seller_information')->find($data->store_id);
            // seller profile generate Qr Code 
            Generate_SellerQrCode($store_information->seller_id,$data->store_id);
            
            // If store not found
            if (!$store_information) {
                return [
                    'status' => 'success',
                    'message' => 'No Store Found',
                    'data'   => []
                ];
            }

            $wishlistIds = wishlist::where('user_id', $data->user_id)
                       ->pluck('product_id')
                       ->toArray();

                    // Step 2: Product query
            $products = $store_information->All_product()
                ->with([
                    'brand',
                    'category',
                    'subcategory',
                    'product_specifications',
                    'product_variants.color',
                    'product_variants.size',
                    'review',
                    'review.user_details'
                ]);
    
            // Step 3: Search
            if (!empty($data->search)) {
                $products->where('product_name_en', 'LIKE', '%' . $data->search . '%');
            }

            if (!empty($data->category_id) && is_array($data->category_id)) {

                $products->whereIn('category_id', $data->category_id);
            }

            if (!empty($data->subcategory_id)) {
                $products->where('subcategory_id', $data->subcategory_id);
            }

            if (!empty($data->brand_id) && is_array($data->brand_id)) {

                $products->whereIn('brand_id', $data->brand_id);
            }

            //price filter

            if (!empty($data->price_min) || !empty($data->price_max)) {

                $products->whereHas('product_variants', function ($query) use ($data) {

                    // minimum price
                    if (!empty($data->price_min)) {
                        $query->where('final_price', '>=', $data->price_min);
                    }

                    // maximum price
                    if (!empty($data->price_max)) {
                        $query->where('final_price', '<=', $data->price_max);
                    }
                });
            }

            //dicount
            if (!empty($data->discount)) {

                $products->whereHas('product_variants', function ($query) use ($data) {

                    $query->where('discount_value', '<=', $data->discount);
                });
            }

            //size filter
            if (!empty($data->size_id) && is_array($data->size_id)) {

                $products->whereHas('product_variants', function ($query) use ($data) {

                    $query->whereIn('size_id', $data->size_id);
                });
            }

            if (!empty($data->rating)) {

                $products->where(function ($q) use ($data) {

                    $q->whereHas('review', function ($query) use ($data) {

                        $query->where('product_rating', '<=', $data->rating);

                    })
                    ->orWhereDoesntHave('review');
                });
            }

            //delivery time
            if (!empty($data->delivery_time)) {

                $products->reorder()->inRandomOrder();
            }

            //delivery option
            if (!empty($data->delivery_option)) {
                $deliveryOptions = (array) $data->delivery_option;

                if (in_array('2', $deliveryOptions)) {

                    $products = $products->select('products.*')
                        ->addSelect([
                            'total_sales' => orderdetail::selectRaw('COUNT(*)')
                                ->whereColumn('orderdetails.product_id', 'products.id')
                                ->where('payment_status', '1')
                                ->where('delivery_status', '3')
                        ])
                        ->orderByDesc('total_sales');
                }

                elseif (in_array('1', $deliveryOptions)) {

                    $products->reorder()->inRandomOrder();
                }

            }

            

            // Step 4: Pagination (convert stdClass to array)
            $products = $products->paginate()
            ->through(function ($product) use ($wishlistIds) {
                $product->wishlist = in_array($product->id, $wishlistIds) ? 1 : 0;
                $reviews = $product->review ?? [];
                if (count($reviews) > 0) {

                    $totalRating = 0;
                    $count = 0;

                    foreach ($reviews as $review) {
                        if (!empty($review->product_rating)) {
                            $totalRating += (float) $review->product_rating;
                            $count++;
                        }
                    }

                    $product->average_rating = $count > 0 ? round($totalRating / $count, 1) : 0;

                } else {
                    $product->average_rating = 0;
                }
                return $product;
            })
            ->appends((array) $data);

            $allProducts = $store_information->All_product()->with('review')->get();

                $totalStoreRating = 0;
                $storeRatingCount = 0;
                $reviewCount = 0;

                foreach ($allProducts as $product) {
                    foreach ($product->review as $review) {
                        if (!empty($review->store_rating)) {
                            $totalStoreRating += (float)$review->store_rating;
                            $storeRatingCount++;
                        }
                        $reviewCount++;
                    }
                }

                $store_information->average_store_rating = $storeRatingCount > 0
                    ? round($totalStoreRating / $storeRatingCount, 1)
                    : 0;

                $store_information->total_review_count = $reviewCount;


            // Step 5: Response
            $response = [
                'store'       => $store_information,
                'All_Product' => $products,
            ];
    
            return [
                'status'  => 'success',
                'message' => "single Store Information fetch Successfully",
                'data'    => $response
            ];
    
        } catch (\Exception $e) {
    
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }

public function TopRatingList($data)
{
    try {

        $wishlistIds = wishlist::where('user_id', $data->user_id)
            ->pluck('product_id')
            ->toArray();


        $topRated = productRatings::pluck('product_id')
            ->unique()
            ->values();


        $products = product::with([
            'brand',
            'category',
            'subcategory',
            'product_specifications',
            'product_variants.color',
            'product_variants.size',
            'review',
            'review.user_details',
            'store.seller_information'
        ])
        ->whereIn('id', $topRated)
        ->withAvg('review as product_avg_rating', 'product_rating')
        ->withCount('review')
        ->orderByDesc('product_avg_rating');



        // Search
        if (!empty($data->search)) {

            $products->where('product_name_en', 'LIKE', '%' . $data->search . '%');

        }



        // Category
        if (!empty($data->category_id) && is_array($data->category_id)) {

            $products->whereIn('category_id', $data->category_id);

        }



        // Sub Category
        if (!empty($data->subcategory_id)) {

            $products->where('subcategory_id', $data->subcategory_id);

        }



        // Brand
        if (!empty($data->brand_id) && is_array($data->brand_id)) {

            $products->whereIn('brand_id', $data->brand_id);

        }



        // Price
        if (!empty($data->price_min) || !empty($data->price_max)) {

            $products->whereHas('product_variants', function ($query) use ($data) {


                if (!empty($data->price_min)) {

                    $query->where('final_price', '>=', $data->price_min);

                }


                if (!empty($data->price_max)) {

                    $query->where('final_price', '<=', $data->price_max);

                }


            });

        }




        // Discount
        if (!empty($data->discount)) {

            $products->whereHas('product_variants', function ($query) use ($data) {

                $query->where('discount_value', '<=', $data->discount);

            });

        }




        // Size
        if (!empty($data->size_id) && is_array($data->size_id)) {

            $products->whereHas('product_variants', function ($query) use ($data) {

                $query->whereIn('size_id', $data->size_id);

            });

        }




        // Rating Filter
        if (!empty($data->rating)) {

            $products->where(function ($q) use ($data) {


                $q->whereHas('review', function ($query) use ($data) {


                    $query->where('product_rating', '>=', $data->rating);


                })
                ->orWhereDoesntHave('review');


            });

        }




        // Delivery Time
        if (!empty($data->delivery_time)) {

            $products->inRandomOrder();

        }





        // Delivery Option
        if (!empty($data->delivery_option)) {


            $deliveryOptions = (array)$data->delivery_option;


            if (in_array('2', $deliveryOptions)) {


                // keep highest rated order

                $products->orderByDesc('product_avg_rating');


            } 
            elseif (in_array('1', $deliveryOptions)) {


                $products->inRandomOrder();


            }


        }





        // Pagination
        $products = !empty($data->limit)
            ? $products->paginate($data->limit)
            : $products->paginate();





        // Wishlist + Average Rating
        $products->through(function ($product) use ($wishlistIds) {


            $product->wishlist = in_array($product->id, $wishlistIds) ? 1 : 0;



            $reviews = $product->review ?? [];



            if (count($reviews) > 0) {


                $totalRating = 0;
                $count = 0;



                foreach ($reviews as $review) {


                    if (!empty($review->product_rating)) {


                        $totalRating += (float)$review->product_rating;
                        $count++;


                    }


                }



                $product->average_rating = $count > 0
                    ? round($totalRating / $count, 1)
                    : 0;



            } else {


                $product->average_rating = 0;


            }



            return $product;


        });




        $products->appends((array)$data);




        return [

            'status' => 'success',

            'message' => 'Top Rating Products fetched Successfully',

            'data' => [

                'All_Product' => $products

            ]

        ];



    } catch (\Exception $e) {


        return [

            'status' => 'error',

            'message' => 'Failed: ' . $e->getMessage(),

            'data' => (object)[]

        ];

    }
}

public function bestSellingList($data)
{

    try {

        $wishlistIds = wishlist::where('user_id', $data->user_id)
            ->pluck('product_id')
            ->toArray();

        $bestSeller = orderdetail::where('payment_status', '1')
            ->pluck('product_id')
            ->unique()
            ->values();

        $products = product::with([
            'brand',
            'category',
            'subcategory',
            'product_specifications',
            'product_variants.color',
            'product_variants.size',
            'review',
            'review.user_details',
            'store.seller_information'
        ])
        ->whereIn('id', $bestSeller)
        ->select('products.*')
        ->addSelect([
            'total_sales' => orderdetail::selectRaw('COUNT(*)')
                ->whereColumn('orderdetails.product_id', 'products.id')
                ->where('payment_status', '1')
                ->where('delivery_status', '3')
        ])
        ->orderByDesc('total_sales');

        // Search
        if (!empty($data->search)) {
            $products->where('product_name_en', 'LIKE', '%' . $data->search . '%');
        }

        // Category
        if (!empty($data->category_id) && is_array($data->category_id)) {
            $products->whereIn('category_id', $data->category_id);
        }

        // Sub Category
        if (!empty($data->subcategory_id)) {
            $products->where('subcategory_id', $data->subcategory_id);
        }

        // Brand
        if (!empty($data->brand_id) && is_array($data->brand_id)) {
            $products->whereIn('brand_id', $data->brand_id);
        }

        // Price
        if (!empty($data->price_min) || !empty($data->price_max)) {

            $products->whereHas('product_variants', function ($query) use ($data) {

                if (!empty($data->price_min)) {
                    $query->where('final_price', '>=', $data->price_min);
                }

                if (!empty($data->price_max)) {
                    $query->where('final_price', '<=', $data->price_max);
                }
            });
        }

        // Discount
        if (!empty($data->discount)) {

            $products->whereHas('product_variants', function ($query) use ($data) {
                $query->where('discount_value', '<=', $data->discount);
            });
        }

        // Size
        if (!empty($data->size_id) && is_array($data->size_id)) {

            $products->whereHas('product_variants', function ($query) use ($data) {
                $query->whereIn('size_id', $data->size_id);
            });
        }

        // Rating
        if (!empty($data->rating)) {

            $products->where(function ($q) use ($data) {

                $q->whereHas('review', function ($query) use ($data) {

                    $query->where('product_rating', '<=', $data->rating);

                })->orWhereDoesntHave('review');
            });
        }

        // Delivery Time
        if (!empty($data->delivery_time)) {
            $products->inRandomOrder();
        }

        // Delivery Option
        if (!empty($data->delivery_option)) {

            $deliveryOptions = (array) $data->delivery_option;

            if (in_array('2', $deliveryOptions)) {

                $products->orderByDesc('total_sales');

            } elseif (in_array('1', $deliveryOptions)) {

                $products->inRandomOrder();
            }
        }

        // Pagination
        $products = !empty($data->limit)
            ? $products->paginate($data->limit)
            : $products->paginate();

        $products->through(function ($product) use ($wishlistIds) {

            $product->wishlist = in_array($product->id, $wishlistIds) ? 1 : 0;

            $reviews = $product->review ?? [];

            if (count($reviews) > 0) {

                $totalRating = 0;
                $count = 0;

                foreach ($reviews as $review) {

                    if (!empty($review->product_rating)) {
                        $totalRating += (float) $review->product_rating;
                        $count++;
                    }
                }

                $product->average_rating = $count > 0
                    ? round($totalRating / $count, 1)
                    : 0;

            } else {

                $product->average_rating = 0;
            }

            return $product;
        });

        $products->appends((array) $data);


        return [
            'status' => 'success',
            'message' => 'All Best Selling Products fetched Successfully',
            'data' => [
                'All_Product' => $products
            ]
        ];

    } catch (\Exception $e) {

        return [
            'status' => 'error',
            'message' => 'Failed: ' . $e->getMessage(),
            'data' => (object)[]
        ];
    }
}



}



