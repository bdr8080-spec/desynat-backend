<?php
namespace App\Services;

use App\Models\seller;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class SellerManagementService
{
   
    public function getNewSellers($request)
    {
        try {
            $query = seller::where('admin_verify', '1')
                ->with([
                    'store_info',
                    'owner_document',
                    'store_document',
                    'seller_bank_details',
                ]);

            // Filter by country from  store_info
            if (!empty($request->country_id)) {
                $query->whereHas('store_info', function ($q) use ($request) {
                    $q->where('country', $request->country_id);
                });
            }

            // Filter by date range
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            $seller_details = $query->orderBy('id', 'desc')->get()->map(function ($seller) {
                $data = $seller->toArray();

                $data['store_info'] = $seller->store_info ? $seller->store_info->toArray() : [];
                $data['owner_document'] = $seller->owner_document ? $seller->owner_document->toArray() : [];
                $data['store_document'] = $seller->store_document ? $seller->store_document->toArray() : [];
                $data['seller_bank_details'] = $seller->seller_bank_details ? $seller->seller_bank_details->toArray() : [];


                return $data;
            });

            if ($seller_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No New Seller found',
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'New Sellers fetched successfully',
                'data' => $seller_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch new sellers: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getApprovedSellers($request)
    {
        try {
            $query = seller::where('admin_verify', '2')
                ->with([
                    'store_info',
                    'owner_document',
                    'store_document',
                    'seller_bank_details',
                ]);

            // Filter by country from  store_info
            if (!empty($request->country_id)) {
                $query->whereHas('store_info', function ($q) use ($request) {
                    $q->where('country', $request->country_id);
                });
            }

            // Filter by date range
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            $seller_details = $query->orderBy('id', 'desc')->get()->map(function ($seller) {
                $data = $seller->toArray();

                $data['store_info'] = $seller->store_info ? $seller->store_info->toArray() : [];
                $data['owner_document'] = $seller->owner_document ? $seller->owner_document->toArray() : [];
                $data['store_document'] = $seller->store_document ? $seller->store_document->toArray() : [];
                $data['seller_bank_details'] = $seller->seller_bank_details ? $seller->seller_bank_details->toArray() : [];

                return $data;
            });

            if ($seller_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Approved Seller found',
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Approved Sellers fetched successfully',
                'data' => $seller_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch new sellers: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getRejectedSellers($request)
    {
        try {
            $query = seller::where('admin_verify', '3')
                ->with([
                    'store_info',
                    'owner_document',
                    'store_document',
                    'seller_bank_details',
                ]);

            // Filter by country from  store_info
            if (!empty($request->country_id)) {
                $query->whereHas('store_info', function ($q) use ($request) {
                    $q->where('country', $request->country_id);
                });
            }

            // Filter by date range
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            $seller_details = $query->orderBy('id', 'desc')->get()->map(function ($seller) {
                $data = $seller->toArray();

                $data['store_info'] = $seller->store_info ? $seller->store_info->toArray() : [];
                $data['owner_document'] = $seller->owner_document ? $seller->owner_document->toArray() : [];
                $data['store_document'] = $seller->store_document ? $seller->store_document->toArray() : [];
                $data['seller_bank_details'] = $seller->seller_bank_details ? $seller->seller_bank_details->toArray() : [];


                return $data;
            });

            if ($seller_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Rejected Seller found',
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Rejected Sellers fetched successfully',
                'data' => $seller_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch new sellers: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }







    public function acceptSeller($brandId)
    {
        try {
            $brand = Brand::find($brandId);

            if (!$brand) {
                return [
                    'status' => 'error',
                    'message' => 'Brand not found',
                    'data' => []
                ];
            }

            $brand->status = $brand->status == 1 ? 0 : 1;
            $brand->save();

            return [
                'status' => 'success',
                'message' => 'Brand status updated successfully',
                'data' => $brand
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch Brand: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }







    

            
        


}
    