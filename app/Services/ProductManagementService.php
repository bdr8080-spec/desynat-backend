<?php
namespace App\Services;

use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class ProductManagementService
{
   

    // public function getProducts($request)
    // {
    //     try {
    //         $limit = (int) $request->input('limit', 100000);

    //         $query = Product::with([
    //             'brand',
    //             'category',
    //             'subcategory',
    //             'product_specifications',
    //             'product_variants.color',
    //             'product_variants.size',
    //             'seller_details.country_details',
    //             'store.country_info',
    //             'review'
    //         ])
    //         ->withAvg('review as product_avg_rating', 'product_rating')
    //         ->withAvg('review as store_avg_rating', 'store_rating');

    //         if ($request->filled('search')) {
    //             $search = $request->input('search');
    //             $query->where('product_name_en', 'like', '%' . $search . '%');
    //         }

    //         if ($request->filled('country')) {
    //             $countries = $request->input('country'); // array
    //             $query->whereHas('store.country_info', function ($q) use ($countries) {
    //                 $q->whereIn('id', $countries);
    //             });
    //         }

    //         if ($request->filled('category')) {
    //             $query->where('category_id', $request->input('category'));
    //         }

    //         if ($request->filled('subcategory')) {
    //             $subcategories = $request->input('subcategory'); // array
    //             $query->whereIn('subcategory_id', $subcategories);
    //         }

    //         if ($request->filled('brand')) {
    //             $brands = $request->input('brand'); // array
    //             $query->whereIn('brand_id', $brands);
    //         }

    //         $query->orderBy('id', 'desc');

    //         $data = $query->paginate($limit);

    //         if ($data->isEmpty()) {
    //             return [
    //                 'status' => 'success',
    //                 'message' => 'No Product found',
    //                 'data' => (object) []
    //             ];
    //         }

    //         $data->getCollection()->transform(function ($product) {
    //             $averageRating = [
    //                 'product' => round($product->product_avg_rating ?? 0, 0),
    //                 'store'   => round($product->store_avg_rating ?? 0, 0),
    //             ];

    //             unset($product->product_avg_rating);
    //             unset($product->store_avg_rating);

    //             $productArray = $product->toArray();
    //             $productArray['average_rating'] = $averageRating;

    //             return $productArray;
    //         });

    //         return [
    //             'status' => 'success',
    //             'message' => 'Products fetched successfully',
    //             'data' => $data
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to fetch products: ' . $e->getMessage(),
    //             'data' => []
    //         ];
    //     }
    // }

    public function getProducts($request)
    {
        try {
            $limit = $request->input('limit');

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
            ->withAvg('review as store_avg_rating', 'store_rating');

            // Search filter
            if ($request->filled('search')) {
                $query->where('product_name_en', 'like', '%' . $request->search . '%');
            }

            // ✅ Convert single values to arrays to keep service consistent
            $requestCountries     = $request->country ? (array)$request->country : [];
            $requestSubcategories = $request->subcategory ? (array)$request->subcategory : [];
            $requestBrands        = $request->brand ? (array)$request->brand : [];

            // Country filter
            if (!empty($requestCountries)) {
                $query->whereHas('store.country_info', function ($q) use ($requestCountries) {
                    $q->whereIn('id', $requestCountries);
                });
            }

            // Category filter (single select)
            if (!empty($request->category)) {
                $query->where('category_id', $request->category);
            }

            // Subcategory filter
            if (!empty($requestSubcategories)) {
                $query->whereIn('subcategory_id', $requestSubcategories);
            }

            // Brand filter
            if (!empty($requestBrands)) {
                $query->whereIn('brand_id', $requestBrands);
            }

            $query->orderBy('id', 'desc');

            // ✅ Conditional pagination
            if ($request->filled('limit')) {
                $data = $query->paginate((int)$limit);
                $collection = $data->getCollection();
            } else {
                $data = $query->get();
                $collection = $data;
            }

            if ($collection->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Product found',
                    'data' => []
                ];
            }

            // Transform collection: add average_rating
            $collection->transform(function ($product) {
                $averageRating = [
                    'product' => round($product->product_avg_rating ?? 0, 0),
                    'store'   => round($product->store_avg_rating ?? 0, 0),
                ];

                unset($product->product_avg_rating, $product->store_avg_rating);

                $productArray = $product->toArray();
                $productArray['average_rating'] = $averageRating;

                return $productArray;
            });

            // Set collection back to paginator if paginated
            if ($request->filled('limit')) {
                $data->setCollection($collection);
            } else {
                $data = $collection;
            }

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







    public function blockUnblockProduct($id)
    {
        try {
            $data = product::find($id);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Product not found',
                    'data' => []
                ];
            }

            $data->product_active_status = $data->product_active_status == 1 ? 0 : 1;
            $data->save();

            $message = $data->product_active_status == 1
                ? 'Product Unblocked Successfully'
                : 'Product blocked Successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch product: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }









    

            
        


}
    