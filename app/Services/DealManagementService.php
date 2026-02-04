<?php
namespace App\Services;

use App\Models\Deal;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;


class DealManagementService
{
   
    // public function getActiveDeals($request)
    // {
    //     try {
    //         $limit = $request->input('limit');
    //         $limit = (int)$limit;

    //         $query = Deal::with([
    //             'category_details',
    //             'subCategory_details',
    //             'seller_enrolled'
    //         ]);
    //         $query->whereDate('to', '>=', Carbon::today());

    //         if ($request->filled('search')) {
    //             $search = $request->input('search');
    //             $query->where('name_english', 'like', '%' . $search . '%');
    //         }

    //         $query->orderBy('id', 'desc');

    //         $deal_details = $query->paginate($limit);
    //        // dd($deal_details);

    //         if ($deal_details->isEmpty()) {
    //             return [
    //                 'status' => 'success',
    //                 'message' => 'No Deal found',
    //                 'data' =>  (object)[]
    //             ];
    //         }

    //         return [
    //             'status' => 'success',
    //             'message' => 'Active Deals fetched successfully',
    //             'data' => $deal_details
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to fetch deals: ' . $e->getMessage(),
    //             'data' => []
    //         ];
    //     }
    // }

    public function getActiveDeals($request)
    {
        try {
            $limit = (int) $request->input('limit', 10);

            // Only eager load real relationships
            $query = Deal::with(['category_details', 'seller_enrolled'])
                ->whereDate('to', '>=', Carbon::today());

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('name_english', 'like', '%' . $search . '%');
            }

            $query->orderBy('id', 'desc');

            $deal_details = $query->paginate($limit);

            // Attach subcategories manually
            $deal_details->getCollection()->transform(function ($deal) {
                $deal->subCategory_details = $deal->subCategory_details(); // Call the model method
                return $deal;
            });

            if ($deal_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Deal found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Active Deals fetched successfully',
                'data' => $deal_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch deals: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function getExpireDeals($request)
    {
        try {
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = Deal::with([
                'category_details',
                'seller_enrolled'
            ]);
            $query->whereDate('to', '<=', Carbon::today());

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('name_english', 'like', '%' . $search . '%');
            }

            $query->orderBy('id', 'desc');

            $deal_details = $query->paginate($limit);
            $deal_details->getCollection()->transform(function ($deal) {
                $deal->subCategory_details = $deal->subCategory_details(); // Call the model method
                return $deal;
            });

            if ($deal_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Deal found',
                    'data' =>  (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Active Deals fetched successfully',
                'data' => $deal_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch brands: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    public function blockUnblockDeal($dealId)
    {
        try {
            $deal = Deal::find($dealId);

            if (!$deal) {
                return [
                    'status' => 'error',
                    'message' => 'Deal not found',
                    'data' => []
                ];
            }

            $deal->status = $deal->status == 1 ? 0 : 1;
            $deal->save();

            $message = $deal->status == 1
                        ? 'Deal Unblocked successfully'
                        : 'Deal Blocked successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $deal
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update deal status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function addDeal(Request $request)
    {

        try {
            $deal = Deal::create([
                'image' => $request->image,
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'category_id' => $request->category_id,
                'sub_category_id' => implode(',', $request->sub_category_id),
                'discount' => $request->discount,
                'from' => $request->from,
                'to' => $request->to,
            ]);

            return [
                'status' => 'success',
                'message' => 'Deal added successfully',
                'data' => $deal
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to add deal',
                'data' => []
            ];
        }
    }

    public function updateDeal(Request $request, $dealId)
    {
        $deal = Deal::find($dealId);

        if (!$deal) {
            return [
                'status' => 'error',
                'message' => 'Deal not found',
                'data' => []
            ];
        }

        try {
            $deal->update([
                'image' => $request->image,
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'category_id' => $request->category_id,
                'sub_category_id' => implode(',', $request->sub_category_id),
                'discount' => $request->discount,
                'from' => $request->from,
                'to' => $request->to,  
            ]);

            return [
                'status' => 'success',
                'message' => 'Deal updated successfully',
                'data' => $deal
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update deal',
                'data' => []
            ];
        }
    }

    public function deleteDeal($dealId)
    {
        try {
            $deal = Deal::find($dealId);

            if (!$deal) {
                return [
                    'status' => 'error',
                    'message' => 'Deal not found',
                    'data' => []
                ];
            }
            $deal->delete();

            return [
                'status' => 'success',
                'message' => 'Deal deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete deal',
                'data' => []
            ];
        }
    }


    // public function dealDetails(Request $request, $dealId)
    // {
    //     try {
    //         $data = Deal::with([
    //             'category_details',
    //             'subCategory_details',
    //             'sellerDealrecords.seller_details.country_details'
    //         ])->find($dealId);

    //         if (!$data) {
    //             return [
    //                 'status' => 'error',
    //                 'message' => 'Deal not found',
    //                 'data' => (object)[] // return empty object, NOT false
    //             ];
    //         }

    //         // Only apply filter if country is present in the request
    //         if ($request->filled('country')) {
    //             $country = $request->country;

    //             $data->sellerDealrecords = $data->sellerDealrecords->filter(function ($record) use ($country) {
    //                 if (!$record->seller_details || !$record->seller_details->country_details) {
    //                     return false;
    //                 }
    //                 return stripos($record->seller_details->country_details->name, $country) !== false;
    //             })->values();
    //         }

    //         return [
    //             'status' => 'success',
    //             'message' => 'Deal details fetched successfully',
    //             'data' => $data
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to fetch deal details: ' . $e->getMessage(),
    //             'data' => (object)[] 
    //         ];
    //     }
    // }

    public function dealDetails(Request $request, $dealId)
    {
        try {
            // Only eager load real relationships
            $data = Deal::with([
                'category_details',
                'sellerDealrecords.seller_details.country_details'
            ])->find($dealId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Deal not found',
                    'data' => (object)[] // return empty object
                ];
            }

            // Attach subcategories manually
            $data->subCategory_details = $data->subCategory_details(); // Collection of SubCategory

            // Apply country filter if provided
            if ($request->filled('country')) {
                $country = $request->country;

                $data->sellerDealrecords = $data->sellerDealrecords->filter(function ($record) use ($country) {
                    if (!$record->seller_details || !$record->seller_details->country_details) {
                        return false;
                    }
                    return stripos($record->seller_details->country_details->name, $country) !== false;
                })->values(); // Re-index the collection
            }

            return [
                'status' => 'success',
                'message' => 'Deal details fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch deal details: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }










    // public function dealDetailsSellerProductList(Request $request)
    // {
    //     try {
    //         $dealId = $request->input('deal_id');
    //         $sellerId = $request->input('seller_id');

    //         if (!$dealId || !$sellerId) {
    //             return [
    //                 'status' => 'error',
    //                 'message' => 'Deal ID and Seller ID are required',
    //                 'data' => (object)[]
    //             ];
    //         }

    //         // Fetch deal with only the requested seller
    //         $deal = Deal::with([
    //             'category_details',
    //             'subCategory_details',
    //             'sellerDealrecords' => function ($q) use ($sellerId, $dealId, $request) {
    //                 $q->where('seller_id', $sellerId)
    //                 ->where('deal_id', $dealId)
    //                 ->with(['seller_details.country_details'])
    //                 ->with(['products' => function ($q) use ($dealId, $sellerId, $request) {
    //                     $q->where('deal_id', $dealId)
    //                         ->where('seller_id', $sellerId);

    //                     // Search filter
    //                     if ($request->filled('search')) {
    //                         $search = $request->input('search');
    //                         $q->whereHas('product_details', function ($qq) use ($search) {
    //                             $qq->where('product_name_en', 'like', '%' . $search . '%');
    //                         });
    //                     }

    //                     // Brand filter
    //                     if ($request->filled('filter')) {
    //                         $brand = $request->input('filter');
    //                         $q->whereHas('product_details.brand', function ($qq) use ($brand) {
    //                             $qq->where('name_english', 'like', '%' . $brand . '%');
    //                         });
    //                     }

    //                     // Eager load product details, variants, brand
    //                     $q->with(['product_details.product_variants', 'product_details.brand']);
    //                 }]);
    //             }
    //         ])->find($dealId);

    //         if (!$deal) {
    //             return [
    //                 'status' => 'error',
    //                 'message' => 'Deal not found',
    //                 'data' => (object)[]
    //             ];
    //         }

    //         // Apply deal discount to each variant
    //         $dealDiscount = $deal->discount; // e.g., 15 for 15%
    //         foreach ($deal->sellerDealrecords as $sellerRecord) {
    //             foreach ($sellerRecord->products as $product) {
    //                 foreach ($product->product_details->product_variants as $variant) {
    //                     $finalPrice = floatval($variant->final_price);
    //                     $variant->deal_discount_price = round($finalPrice - ($finalPrice * $dealDiscount / 100), 2);
    //                 }
    //             }
    //         }

    //         return [
    //             'status' => 'success',
    //             'message' => 'Deal details fetched successfully',
    //             'data' => $deal
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to fetch deal details: ' . $e->getMessage(),
    //             'data' => []
    //         ];
    //     }
    // }

    public function dealDetailsSellerProductList(Request $request)
    {
        try {
            $dealId = $request->input('deal_id');
            $sellerId = $request->input('seller_id');

            if (!$dealId || !$sellerId) {
                return [
                    'status' => 'error',
                    'message' => 'Deal ID and Seller ID are required',
                    'data' => (object)[]
                ];
            }

            // Fetch deal without subCategory_details in 'with'
            $deal = Deal::with([
                'category_details',
                'sellerDealrecords' => function ($q) use ($sellerId, $dealId, $request) {
                    $q->where('seller_id', $sellerId)
                    ->where('deal_id', $dealId)
                    ->with(['seller_details.country_details'])
                    ->with(['products' => function ($q) use ($dealId, $sellerId, $request) {
                        $q->where('deal_id', $dealId)
                            ->where('seller_id', $sellerId);

                        // Search filter
                        if ($request->filled('search')) {
                            $search = $request->input('search');
                            $q->whereHas('product_details', function ($qq) use ($search) {
                                $qq->where('product_name_en', 'like', '%' . $search . '%');
                            });
                        }

                        // Brand filter
                        if ($request->filled('filter')) {
                            $brand = $request->input('filter');
                            $q->whereHas('product_details.brand', function ($qq) use ($brand) {
                                $qq->where('name_english', 'like', '%' . $brand . '%');
                            });
                        }

                        // Eager load product details, variants, brand
                        $q->with(['product_details.product_variants', 'product_details.brand']);
                    }]);
                }
            ])->find($dealId);

            if (!$deal) {
                return [
                    'status' => 'error',
                    'message' => 'Deal not found',
                    'data' => (object)[]
                ];
            }

            // Attach subcategories manually
            $deal->subCategory_details = $deal->subCategory_details(); // Collection of SubCategory

            // Apply deal discount to each variant
            $dealDiscount = floatval($deal->discount); // e.g., 15 for 15%
            foreach ($deal->sellerDealrecords as $sellerRecord) {
                foreach ($sellerRecord->products as $product) {
                    foreach ($product->product_details->product_variants as $variant) {
                        $finalPrice = floatval($variant->final_price);
                        $variant->deal_discount_price = round($finalPrice - ($finalPrice * $dealDiscount / 100), 2);
                    }
                }
            }

            return [
                'status' => 'success',
                'message' => 'Deal details fetched successfully',
                'data' => $deal
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch deal details: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }








    





    

            
        


}
    