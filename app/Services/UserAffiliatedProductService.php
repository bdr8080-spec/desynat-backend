<?php
namespace App\Services;

use App\Models\product;
use App\Models\AffiliateProduct;
use App\Models\ProductLink;
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


   public function getMyProducts($request)
    {
        try {

            $limit = !empty($request->limit) ? (int) $request->limit : 10;

            $query = AffiliateProduct::with([
                    'affiliate_details',
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

            $data->getCollection()->transform(function ($product) {

                $averageRating = [
                    'product' => round($product->product_avg_rating ?? 0),
                    'store'   => round($product->store_avg_rating ?? 0),
                ];

                $commission = $product->store?->country_info?->affiliate_commission_info?->commission;

                $affiliateCommission = round((float) ($commission ?? 0));

                unset($product->product_avg_rating);
                unset($product->store_avg_rating);

                $productArray = $product->toArray();

                if (isset($productArray['store']['country_info']['affiliate_commission_info'])) {
                    unset($productArray['store']['country_info']['affiliate_commission_info']);
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
                    'status' => 'error',
                    'message' => 'Product Link already added to this affiliate',
                    'data' => $alreadyAdded
                ];
            }

            $data = ProductLink::create([
                'affiliate_id' => $request->user_id,
                'product_id'   => $product->id,
                'link'   => url("/user/product/detail-page/{$product->id}?ref={$request->user_id}")
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













    

            
        


}
    