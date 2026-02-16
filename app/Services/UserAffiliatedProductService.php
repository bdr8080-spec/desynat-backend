<?php
namespace App\Services;

use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


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
                'store.country_info',
                'review'
            ])
            ->withAvg('review as product_avg_rating', 'product_rating')
            ->withAvg('review as store_avg_rating', 'store_rating')
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
                'product' => round($data->product_avg_rating ?? 0, 0),
                'store'   => round($data->store_avg_rating ?? 0, 0),
            ];

            unset($data->product_avg_rating);
            unset($data->store_avg_rating);

            $dataArray = $data->toArray();

            $dataArray['average_rating'] = $averageRating;

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

            $query = Product::with([
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
                ->where('seller_id', $request->user_id)
                ->where('added_by', '2');

            if (!empty($request->search)) {
                $query->where('product_name_en', 'like', '%' . $request->search . '%');
            }

            if (!empty($request->from) && empty($request->to)) {
                $query->whereDate('created_at', '>=', $request->from);
            }

            if (empty($request->from) && !empty($request->to)) {
                $query->whereDate('created_at', '<=', $request->to);
            }

            if (!empty($request->from) && !empty($request->to)) {
                $query->whereBetween('created_at', [
                    $request->from,
                    $request->to
                ]);
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












    

            
        


}
    