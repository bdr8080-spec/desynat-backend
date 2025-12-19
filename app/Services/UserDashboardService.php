<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\{RecentSearch,sellerStoreInformation,wishlist,product};



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
            $q->where('final_price', '>=', $data->price_min);
        }

        if (isset($data->price_max)) {
            $q->where('final_price', '<=', $data->price_max);
        }
    },
    'product_variants.color',
    'product_variants.size'
]);

/**
 * Search filter
 */
if (!empty($data->search)) {
    $products->where('product_name_en', 'LIKE', '%' . $data->search . '%');
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







}