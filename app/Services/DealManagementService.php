<?php
namespace App\Services;

use App\Models\Deal;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;


class DealManagementService
{
   
    public function getActiveDeals($request)
    {
        try {
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = Deal::with([
                'category_details',
                'subCategory_details',
                'seller_enrolled'
            ]);
            $query->whereDate('to', '>=', Carbon::today());

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('name_english', 'like', '%' . $search . '%');
            }

            $query->orderBy('id', 'desc');

            $deal_details = $query->paginate($limit);
           // dd($deal_details);

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

    public function getExpireDeals($request)
    {
        try {
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = Deal::with([
                'category_details',
                'subCategory_details',
                'seller_enrolled'
            ]);
            $query->whereDate('to', '<=', Carbon::today());

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('name_english', 'like', '%' . $search . '%');
            }

            $query->orderBy('id', 'desc');

            $deal_details = $query->paginate($limit);

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
                'sub_category_id' => $request->sub_category_id,
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
                'sub_category_id' => $request->sub_category_id,
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

    // public function dealDetails($dealId)
    // {
    //     try {
            
    //     //    $data = Deal::with(
    //     //     'category_details',
    //     //     'subCategory_details',
    //     //     'sellerDealrecord.product_added',
    //     //     'sellerDealrecord.seller_details',
    //     //     'sellerDealrecord.seller_details.country_details',
    //     //     'sellerDealrecord.product_details',
    //     //     )->find($dealId);

    //     $data = Deal::with(
    //             'category_details',
    //             'subCategory_details',
    //             'sellerDealrecords.seller_details.country_details',
    //             'sellerDealrecords.products.product_details.product_variants',
    //             'sellerDealrecords.products.product_details.brand'
    //         )->find($dealId);

    //         if (!$data) {
    //             return [
    //                 'status' => 'error',
    //                 'message' => 'Deal not found',
    //                 'data' => (object)[]
    //             ];
    //         }

    //         return [
    //             'status' => 'success',
    //             'message' => 'Deal details fetched successfully',
    //             'data' => $data
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to fetch deal details',
    //             'data' => []
    //         ];
    //     }
    // }



    public function dealDetails(Request $request)
    {
        try {
            $dealId = $request->input('deal_id');

            // Base query
            $query = Deal::with([
                'category_details',
                'subCategory_details',
                'sellerDealrecords.seller_details.country_details',
                'sellerDealrecords.products' => function ($q) use ($request, $dealId) {
                    // Only products of this deal
                    $q->where('deal_id', $dealId);

                    // Filter by search
                    if ($request->filled('search')) {
                        $search = $request->input('search');
                        $q->whereHas('product_details', function ($qq) use ($search) {
                            $qq->where('product_name_en', 'like', '%' . $search . '%');
                        });
                    }

                    // Filter by brand
                    if ($request->filled('filter')) {
                        $brand = $request->input('filter');
                        $q->whereHas('product_details.brand', function ($qq) use ($brand) {
                            $qq->where('name_english', 'like', '%' . $brand . '%');
                        });
                    }

                    // Eager load details & variants
                    $q->with([
                        'product_details.product_variants',
                        'product_details.brand'
                    ]);
                }
            ]);

            // Filter sellerDealrecords to only include sellers who have matching products
            if ($request->filled('search') || $request->filled('filter')) {
                $query->with(['sellerDealrecords' => function ($q) use ($request, $dealId) {
                    $q->whereHas('products', function ($qq) use ($request, $dealId) {
                        $qq->where('deal_id', $dealId);

                        if ($request->filled('search')) {
                            $search = $request->input('search');
                            $qq->whereHas('product_details', function ($q) use ($search) {
                                $q->where('product_name_en', 'like', '%' . $search . '%');
                            });
                        }

                        if ($request->filled('filter')) {
                            $brand = $request->input('filter');
                            $qq->whereHas('product_details.brand', function ($q) use ($brand) {
                                $q->where('name_english', 'like', '%' . $brand . '%');
                            });
                        }
                    });
                }]);
            }

            // Find the deal
            $data = $query->find($dealId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Deal not found',
                    'data' => (object)[]
                ];
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
                'data' => []
            ];
        }
    }




    





    

            
        


}
    