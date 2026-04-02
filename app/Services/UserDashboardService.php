<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\{RecentSearch,sellerStoreInformation,wishlist,product,Brand,User,all_countrie,FullBanner,sellerBanner,Deal,LiveRequest};


use Carbon\Carbon;


class UserDashboardService
{


public function HomePageSearch($data)
    {
        try {

    if($data->search){

        $search=[
            'user_id'=>$data->user_id,
            'name'=>$data->search
        ];
        // Store Search Data 
        RecentSearch::UpdateOrCreate($search);
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

$country_code=all_countrie::where('dial_code', $user_details->country_code)->first();

$all_Banners= FullBanner::where('country_id',$country_code->id)
->whereDate('start_date','<=',date('Y-m-d'))
->whereDate('end_date','>=',date('Y-m-d'))
->where('type',$request->type)
->where('status','1')->get();

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
->whereHas('seller_details')
->whereDate('start_date', '<=', now())
->whereDate('end_date', '>=', now())
->where('payment_status','1')
->where('Admin_verify','1')
->where('status','1');

if($request->type=='3'){
    $homeScreenBanner=$homeScreenBanner->where('category',$request->category);
}elseif($request->type=='3' && isset($request->subcatgory)){
    $homeScreenBanner=$homeScreenBanner->where('subcatgory',$request->subcatgory);
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
    ->whereRaw("STR_TO_DATE(`to`, '%h:%i %p') > ?", [$currentTime]);
    // ->where('to','>', )

});

$current_requests = $currentQuery->get();

/**
 * ✅ Future
 */
$futureQuery = clone $baseQuery;
$futureQuery->whereHas('timeslot_details', function ($q) use ($today) {
    $q->whereDate('date', '>', $today);
});

$future_requests = $futureQuery->get();


// ❌ If both empty
if ($current_requests->isEmpty() && $future_requests->isEmpty()) {
    return [
        'status' => 'success',
        'message' => 'No Request found',
        'data' => (object)[]
    ];
}

// ✅ Final response
return [
    'status' => 'success',
    'message' => 'Requests fetched successfully',
    'data' => [
        'current_requests' => $current_requests,
        'future_requests' => $future_requests,
    ]
];


        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch request: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }




}