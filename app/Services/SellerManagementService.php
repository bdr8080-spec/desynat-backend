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
            $limit = (int)($request->input('limit', 10)); 

            $query = seller::where('admin_verify', '1')
                ->with([
                    'store_info',
                    'owner_document',
                    'store_document',
                    'seller_bank_details',
                ]);

            if (!empty($request->country_id)) {
                $query->whereHas('store_info', function ($q) use ($request) {
                    $q->where('country', $request->country_id);
                });
            }

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

            if (!empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
                });
            }

            $seller_details = $query->orderBy('id', 'desc')->paginate($limit);

            $seller_details->getCollection()->transform(function ($seller) {
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
            $limit = (int)($request->input('limit', 10)); 

            $query = seller::where('admin_verify', '2')
                ->with([
                    'store_info',
                    'owner_document',
                    'store_document',
                    'seller_bank_details',
                ]);

            if (!empty($request->country_id)) {
                $query->whereHas('store_info', function ($q) use ($request) {
                    $q->where('country', $request->country_id);
                });
            }

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

            if (!empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
                });
            }

            $seller_details = $query->orderBy('id', 'desc')->paginate($limit);

            $seller_details->getCollection()->transform(function ($seller) {
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
                'message' => 'Failed to fetch approved sellers: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function getRejectedSellers($request)
    {
        try {
            $limit = (int)($request->input('limit', 10)); 

            $query = seller::where('admin_verify', '3')
                ->with([
                    'store_info',
                    'owner_document',
                    'store_document',
                    'seller_bank_details',
                ]);

            if (!empty($request->country_id)) {
                $query->whereHas('store_info', function ($q) use ($request) {
                    $q->where('country', $request->country_id);
                });
            }

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

            if (!empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
                });
            }

            $seller_details = $query->orderBy('id', 'desc')->paginate($limit);

            $seller_details->getCollection()->transform(function ($seller) {
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
                'message' => 'Failed to fetch rejected sellers: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getSellerDetailsById($sellerId)
    {
        try {
            $seller = seller::with([
                'store_info',
                'owner_document',
                'store_document',
                'seller_bank_details',
            ])->find($sellerId);

            if (!$seller) {
                return [
                    'status' => 'error',
                    'message' => 'Seller not found',
                    'data' => []
                ];
            }

            $data = $seller->toArray();
            $data['store_info'] = $seller->store_info ? $seller->store_info->toArray() : [];
            $data['owner_document'] = $seller->owner_document ? $seller->owner_document->toArray() : [];
            $data['store_document'] = $seller->store_document ? $seller->store_document->toArray() : [];
            $data['seller_bank_details'] = $seller->seller_bank_details ? $seller->seller_bank_details->toArray() : [];

            return [
                'status' => 'success',
                'message' => 'Seller details fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch seller details: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function acceptSeller($sellerId)
    {
        try {
            $seller = seller::find($sellerId);

            if (!$seller) {
                return [
                    'status' => 'error',
                    'message' => 'Seller not found',
                    'data' => []
                ];
            }

            $seller->admin_verify = '2'; 
            $seller->save();

            return [
                'status' => 'success',
                'message' => 'Seller accepted successfully',
                'data' => $seller
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to accept seller: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function rejectSeller($sellerId, $rejectReason)
    {
        try {
            $seller = seller::find($sellerId);

            if (!$seller) {
                return [
                    'status' => 'error',
                    'message' => 'Seller not found',
                    'data' => []
                ];
            }

            $seller->admin_verify = '3';
            $seller->reject_reason = $rejectReason; 
            $seller->save();

            return [
                'status' => 'success',
                'message' => 'Seller rejected successfully',
                'data' => $seller
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to reject seller: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }













}
    