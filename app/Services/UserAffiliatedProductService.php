<?php
namespace App\Services;

use App\Models\product;
use App\Models\{AffiliateProduct,UserContactChangeHistory,orderdetail};
use App\Models\ProductLink;
use App\Models\AffiliateRecentSearch;
use App\Models\wishlist;
use App\Models\Brand;
use App\Models\sortFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Str;


class UserAffiliatedProductService
{
   

    public function getAllProducts($request)
    {


        try {
            $limit = (int) $request->input('limit', 10);

            $query = Product::with([
                'brand',
                'category',
                'subcategory',
                'product_specifications',
                'product_variants.color',
                'product_variants.size',
                'seller_details.country_details',
                'store.country_info',
                'review' 
            ])
            ->withAvg('review as product_avg_rating', 'product_rating')
            ->withAvg('review as store_avg_rating', 'store_rating')
            ->where('category_id', $request->category_id)
            ->where('subcategory_id', $request->subcategory_id);

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('product_name_en', 'like', '%' . $search . '%');
            }

            // if ($request->filled('country')) {
            //     $countries = $request->input('country'); // array
            //     $query->whereHas('store.country_info', function ($q) use ($countries) {
            //         $q->whereIn('id', $countries);
            //     });
            // }

            // if ($request->filled('category')) {
            //     $query->where('category_id', $request->input('category'));
            // }

            // if ($request->filled('subcategory')) {
            //     $subcategories = $request->input('subcategory'); // array
            //     $query->whereIn('subcategory_id', $subcategories);
            // }

            // if ($request->filled('brand')) {
            //     $brands = $request->input('brand'); // array
            //     $query->whereIn('brand_id', $brands);
            // }

            
            $query->orderBy('id', 'desc');

            $data = $query->paginate($limit);

            if ($data->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Product found',
                    'data' => (object) []
                ];
            }

            $data->getCollection()->transform(function ($product) {
                $averageRating = [
                    'product' => round($product->product_avg_rating ?? 0, 0),
                    'store'   => round($product->store_avg_rating ?? 0, 0),
                ];

                unset($product->product_avg_rating);
                unset($product->store_avg_rating);

                $productArray = $product->toArray();
                $productArray['average_rating'] = $averageRating;

                return $productArray;
            });

            return [
                'status' => 'success',
                'message' => 'Products fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch products: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function getProductDetail($request)
    {
        try {

            $data = Product::with([
                    'brand',
                    'category',
                    'subcategory',
                    'product_specifications',
                    'product_variants.color',
                    'product_variants.size',
                    'seller_details.country_details',
                    'store.country_info.affiliate_commission_info', 
                    'review'
                ])
                ->withAvg('review as product_avg_rating', 'product_rating')
                ->withAvg('review as store_avg_rating', 'store_rating')
                ->withCount('review')
                ->where('id', $request->id)
                ->first();

            if (!$data) {
                return [
                    'status' => 'success',
                    'message' => 'No Product found',
                    'data' => (object) []
                ];
            }

            $averageRating = [
                'product' => round($data->product_avg_rating ?? 0),
                'store'   => round($data->store_avg_rating ?? 0),
            ];

            $commission = $data->store?->country_info?->affiliate_commission_info?->commission;

            $affiliateCommission = round((float) ($commission ?? 0));

            unset($data->product_avg_rating);
            unset($data->store_avg_rating);

            $dataArray = $data->toArray();

            if (isset($dataArray['store']['country_info']['affiliate_commission_info'])) {
                unset($dataArray['store']['country_info']['affiliate_commission_info']);
            }

            $dataArray['average_rating'] = $averageRating;
            $dataArray['affiliate_commission'] = $affiliateCommission;

            return [
                'status' => 'success',
                'message' => 'Product details fetched successfully',
                'data' => $dataArray
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch product detail: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getMyProductDetail($request)
    {
        try {

            $data = AffiliateProduct::with([
                    'affiliate_details',
                    'affiliate_product_link',
                    'affiliate_product_click_records',
                    'product' => function ($q) {
                        $q->with([
                            'brand',
                            'category',
                            'subcategory',
                            'product_specifications',
                            'product_variants.color',
                            'product_variants.size',
                            'seller_details.country_details',
                            'store.country_info.affiliate_commission_info', // ✅ Nested under product
                            'review'
                        ])
                        ->withAvg('review as product_avg_rating', 'product_rating')
                        ->withAvg('review as store_avg_rating', 'store_rating')
                        ->withCount('review');
                    }
                ])
                ->withcount('affiliate_product_click_records')
                ->where('product_id', $request->id)
                ->where('affiliate_id', $request->user_id)
                ->first();

            if (!$data) {
                return [
                    'status' => 'success',
                    'message' => 'No Product found',
                    'data' => (object) []
                ];
            }

            $product = $data->product;


            // Amount and commision records 

        $refer_affilatelink=$data->affiliate_product_link->link;

        $orderStats = orderdetail::where('reference_link', $refer_affilatelink)
    ->selectRaw('COUNT(*) as total_order, SUM(amount) as total_revenue, SUM(affiliate_commission) as my_earning')
    ->first();

        $data->Total_order   = $orderStats->total_order;
        $data->Total_revenue = $orderStats->total_revenue;
        $data->my_earning    = $orderStats->my_earning;
   


            // Amount and commision records End here 


            // Get product and store ratings
            $averageRating = [
                'product' => round($product->product_avg_rating ?? 0),
                'store'   => round($product->store_avg_rating ?? 0),
            ];

            // Affiliate commission from store
            $commission = $product->store?->country_info?->affiliate_commission_info?->commission;
            $affiliateCommission = round((float) ($commission ?? 0));

            unset($product->product_avg_rating, $product->store_avg_rating);

            $dataArray = $data->toArray();

            // Remove nested commission info from store
            if (isset($dataArray['product']['store']['country_info']['affiliate_commission_info'])) {
                unset($dataArray['product']['store']['country_info']['affiliate_commission_info']);
            }

            $dataArray['average_rating'] = $averageRating;
            $dataArray['affiliate_commission'] = $affiliateCommission;

            return [
                'status' => 'success',
                'message' => 'Product details fetched successfully',
                'data' => $dataArray
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch product detail: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function getMyProducts($request)
    {
        try {

            $limit = !empty($request->limit) ? (int) $request->limit : 10;

            $query = AffiliateProduct::with([
                    'affiliate_details',
                    'affiliate_product_link',
                    'product' => function ($q) {
                        $q->with([
                            'brand',
                            'category',
                            'subcategory',
                            'product_specifications',
                            'product_variants.color',
                            'product_variants.size',
                            'seller_details.country_details',
                            'store.country_info.affiliate_commission_info',
                            'review'
                        ])
                        ->withAvg('review as product_avg_rating', 'product_rating')
                        ->withAvg('review as store_avg_rating', 'store_rating')
                        ->withCount('review');
                    }
                ])
                ->where('affiliate_id', $request->user_id);

            if (!empty($request->search)) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->where('product_name_en', 'like', '%' . $request->search . '%');
                });
            }

              if (!empty($request->category_id)) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->where('category_id', 'like', '%' . $request->category_id . '%');
                });
            }

              if (!empty($request->subcategory_id)) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->where('subcategory_id', 'like', '%' . $request->subcategory_id . '%');
                });
            }

            if (!empty($request->from) && empty($request->to)) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->whereDate('created_at', '>=', $request->from);
                });
            }

            if (empty($request->from) && !empty($request->to)) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->whereDate('created_at', '<=', $request->to);
                });
            }

            if (!empty($request->from) && !empty($request->to)) {
                $query->whereHas('product', function ($q) use ($request) {
                    $q->whereBetween('created_at', [
                        $request->from,
                        $request->to
                    ]);
                });
            }

            $query->orderBy('id', 'desc');

            $data = $query->paginate($limit);

            if ($data->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Product found',
                    'data' => (object) []
                ];
            }

            // Transform each AffiliateProduct
            $data->getCollection()->transform(function ($affiliateProduct) {

                $product = $affiliateProduct->product;

                $averageRating = [
                    'product' => round($product->product_avg_rating ?? 0),
                    'store'   => round($product->store_avg_rating ?? 0),
                ];

                $commission = $product->store?->country_info?->affiliate_commission_info?->commission;
                $affiliateCommission = round((float) ($commission ?? 0));

                unset($product->product_avg_rating, $product->store_avg_rating);

                $productArray = $affiliateProduct->toArray();

                // Remove nested commission info from store
                if (isset($productArray['product']['store']['country_info']['affiliate_commission_info'])) {
                    unset($productArray['product']['store']['country_info']['affiliate_commission_info']);
                }

                $productArray['average_rating'] = $averageRating;
                $productArray['affiliate_commission'] = $affiliateCommission;

                return $productArray;
            });

            return [
                'status' => 'success',
                'message' => 'Products fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to fetch products: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    
    public function ProductSearch($data)
    {
        try {

    if($data->search){

        $search=[
            'user_id'=>$data->user_id,
            'name'=>$data->search
        ];
        // Store Search Data 
        AffiliateRecentSearch::UpdateOrCreate($search);
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


    // get affilated add products list id

$Affilate_listed_products = AffiliateProduct::where('affiliate_id',$data->user_id)->pluck('product_id');

$products = product::
where('affiliated_product','1')->
whereNotIn('id',$Affilate_listed_products)
->with([
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
])
 ->withAvg('review as product_avg_rating', 'product_rating')
                        ->withAvg('review as store_avg_rating', 'store_rating')
                        ->withCount('review');


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

if (!empty($data->subcategory_id) && is_array($data->subcategory_id)) {
    $products->whereIn('subcategory_id', array_map('intval', $data->subcategory_id));
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
               $q->whereRaw('CAST(final_price AS DECIMAL(10,2)) >= ?', [$data->price_min]);
        
        }

        if (!empty($data->price_max)) {
               $q->whereRaw('CAST(final_price AS DECIMAL(10,2)) <= ?', [$data->price_max]);
        }

         if (!empty($data->discount)) {
        $q->where('discount_type','1') 
        ->whereRaw('CAST(discount_value AS DECIMAL(10,2)) = ?', [$data->discount]);
      
        }
        
        // if (!empty($data->price_max)) {
        //     $q->where('final_price', '<=', $data->price_max);
        // }

        // $q->when($data->price_min, function ($query) use ($data) {
        // $q->whereRaw('CAST(final_price AS DECIMAL(10,2)) >= ?', [$data->price_min]);
        // });

        // $q->when($data->price_max, function ($query) use ($data) {
        // $q->whereRaw('CAST(final_price AS DECIMAL(10,2)) <= ?', [$data->price_max]);
        // });

        // $q->when($data->discount, function ($query) use ($data) {

        // $q->where('discount_type','1') 
        // ->whereRaw('CAST(discount_value AS DECIMAL(10,2)) >= ?', [$data->discount]);
        // });
        

        // if (!empty($data->discount)) {
        //     $q->where('discount_value', '<=', $data->discount);
        // }
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


    public function addToMyProducts($request)
    {
        try {

            $product = Product::find($request->product_id);

            if (!$product) {
                return [
                    'status' => 'error',
                    'message' => 'Product not found',
                    'data' => []
                ];
            }

            $alreadyAdded = AffiliateProduct::where('affiliate_id', $request->user_id)
                ->where('product_id', $product->id)
                ->exists();

            if ($alreadyAdded) {
                return [
                    'status' => 'error',
                    'message' => 'Product already added to this affiliate',
                    'data' => []
                ];
            }

            $affiliateProduct = AffiliateProduct::create([
                'affiliate_id' => $request->user_id,
                'product_id'   => $product->id,
            ]);


            return [
                'status' => 'success',
                'message' => 'Product added to affiliate successfully',
                'data' => $affiliateProduct
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to add product: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function generateProductLink($request)
    {
        try {

            $product = Product::find($request->product_id);

            if (!$product) {
                return [
                    'status' => 'error',
                    'message' => 'Product not found',
                    'data' => []
                ];
            }

            $alreadyAdded = ProductLink::where('affiliate_id', $request->user_id)
                ->where('product_id', $product->id)
                ->first();

           // dd($alreadyAdded);

            if ($alreadyAdded) {
                return [
                    'status' => 'success',
                    'message' => 'Product Link already added to this affiliate',
                    'data' => $alreadyAdded
                ];
            }

            $data = ProductLink::create([
                'affiliate_id' => $request->user_id,
                'product_id'   => $product->id,
                'link'   => url("/user/product/detail-page/{$product->id}?ref={$request->user_id}")
                // 'link'   => "https://desynat.com/user/product/detail-page/{$product->id}?ref={$request->user_id}"

                ]);


            return [
                'status' => 'success',
                'message' => 'Link added to affiliate successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to add product link: ' . $e->getMessage(),
                'data' => []
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
        $search_result=AffiliateRecentSearch::where('user_id', $request->user_id)->limit(8)->get();

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

    public function get_store_filter()
    {
        try {
    
            // Step 1: Find store
            $store_information = sortFilter::where('status','1')->get();
    
            // If store not found
            if (!$store_information) {
                return [
                    'status' => 'success',
                    'message' => 'No Store Found',
                    'data'   => []
                ];
            }
    
            return [
                'status'  => 'success',
                'message' => "Store filter Information fetch Successfully",
                'data'    => $store_information
            ];
    
        } catch (\Exception $e) {
    
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }






    // verify otp

    public function verifyOtp($request){
        $userDetails = UserContactChangeHistory::find($request->id);

    
        if (!$userDetails) {
              return ['status'=>'error','message'=>"No User Found",'data'=>(object)[]];
            // return ApiResponse::generateResponse('error', 'No User Found', (object)[], 404);
        }


        // if ($userDetails->otp === $request->otp) {
        //     $userDetails->otp = null;
        //     $userDetails->otp_verify = '1';
        //     $userDetails->status = '1';
        //     $userDetails->save();
        //     $user = request()->user();
        //     $user->country_code = $userDetails->country_code;
        //     $user->mobile = $userDetails->mobile;
        //             // User::where('')
        //     return ['status'=>'success','message'=>"OTP verified successfully",'data'=>$userDetails];
        //     // return ApiResponse::generateResponse('success', 'OTP verified successfully', $userDetails, 201);
        // }


        if ($userDetails && $userDetails->otp === $request->otp) {
            $userDetails->otp = null;
            $userDetails->otp_verify = '1';
            $userDetails->status = '1';
            $userDetails->save();

            $user = request()->user();
            $user->country_code = $userDetails->country_code ?? $user->country_code;
            $user->mobile = $userDetails->mobile ?? $user->mobile;
            $user->email = $userDetails->email ?? $user->email;
            $user->save();

            return ['status' => 'success', 'message' => 'OTP verified successfully', 'data' => $userDetails];
        }



         return ['status'=>'error','message'=>"Invalid OTP. Please try again.",'data'=>(object)[]];
        // return ApiResponse::generateResponse('error', 'Invalid OTP. Please try again.', (object)[], 400);
    }


    
    public function getPerformancewithidProducts($request)
    {
        try {

            $query = AffiliateProduct::with([
                    'affiliate_details',
                    'affiliate_product_link',
                    'product' => function ($q) {
                        $q->with([
                            'brand',
                            'category',
                            'subcategory',
                            'product_specifications',
                            'product_variants.color',
                            'product_variants.size',
                            'seller_details.country_details',
                            'store.country_info.affiliate_commission_info',
                            'review'
                        ])
                        ->withAvg('review as product_avg_rating', 'product_rating')
                        ->withAvg('review as store_avg_rating', 'store_rating')
                        ->withCount('review');
                    }
                ])
                // ->where('affiliate_id', $request->user_id)
                ->where('id', $request->id)
                ->first();

            
            // Transform each AffiliateProduct
          
            return [
                'status' => 'success',
                'message' => 'Products Performace details Fecth successfully',
                'data' => $query
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to fetch products: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }







    

            
        


}
    