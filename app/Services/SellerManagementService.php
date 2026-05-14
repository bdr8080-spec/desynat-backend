<?php
namespace App\Services;

use App\Models\seller;
use App\Models\country;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class SellerManagementService
{
   
    public function getNewSellers($request)
    {
        try {
            $limit = (int)($request->input('limit')); 

            $query = seller::where('admin_verify', '1')
            ->where('type', '0')
                ->with([
                    'store_info.country_info',
                    'owner_document',
                    'store_document',
                    'seller_bank_details',
                    'subcription_plan'
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
                $data['store_info'] = $seller->store_info ? $seller->store_info->toArray() : null;
                $data['owner_document'] = $seller->owner_document ? $seller->owner_document->toArray() : null;
                $data['store_document'] = $seller->store_document ? $seller->store_document->toArray() : null;
                $data['seller_bank_details'] = $seller->seller_bank_details ? $seller->seller_bank_details->toArray() : null;
                $data['subcription_plan'] = $seller->subcription_plan && !$seller->subcription_plan->isEmpty()
                    ? $seller->subcription_plan->toArray()
                    : null;

                return $data;
            });


            if ($seller_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_data_found'),
                    'data' => (object) []
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
            $limit = (int)($request->input('limit')); 

            $query = seller::where('admin_verify', '2')
            ->where('type', '0')
                ->with([
                    'store_info.country_info',
                    'owner_document',
                    'store_document',
                    'seller_bank_details',
                    'subcription_plan'
                ]);

            // ✅ Country filter
            if (!empty($request->country_id1)) {
                $query->whereHas('store_info', function ($q) use ($request) {
                    $q->where('country', $request->country_id1);
                });
            }

            // ✅ Date filter
            if (!empty($request->from_date1) && !empty($request->to_date1)) {
                $query->whereBetween('created_at', [
                    $request->from_date1 . ' 00:00:00',
                    $request->to_date1 . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date1)) {
                $query->whereDate('created_at', '>=', $request->from_date1);
            } elseif (!empty($request->to_date1)) {
                $query->whereDate('created_at', '<=', $request->to_date1);
            }

            // ✅ Search filter
            if (!empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
                });
            }

            // ✅ Order
            $query->orderBy('id', 'desc');

            // ============================================
            // ✅ PAGINATE OR GET ALL
            // ============================================

            if ($limit > 0) {

                // 👉 PAGINATED
                $seller_details = $query->paginate($limit);

                $seller_details->getCollection()->transform(function ($seller) {

                    $data = $seller->toArray();

                    $data['store_info'] = $seller->store_info ? $seller->store_info->toArray() : null;
                    $data['owner_document'] = $seller->owner_document ? $seller->owner_document->toArray() : null;
                    $data['store_document'] = $seller->store_document ? $seller->store_document->toArray() : null;
                    $data['seller_bank_details'] = $seller->seller_bank_details ? $seller->seller_bank_details->toArray() : null;
                    $data['subcription_plan'] = ($seller->subcription_plan && !$seller->subcription_plan->isEmpty())
                        ? $seller->subcription_plan->toArray()
                        : null;

                    return $data;
                });

            } else {

                // 👉 GET ALL
                $seller_details = $query->get()->map(function ($seller) {

                    $data = $seller->toArray();

                    $data['store_info'] = $seller->store_info ? $seller->store_info->toArray() : null;
                    $data['owner_document'] = $seller->owner_document ? $seller->owner_document->toArray() : null;
                    $data['store_document'] = $seller->store_document ? $seller->store_document->toArray() : null;
                    $data['seller_bank_details'] = $seller->seller_bank_details ? $seller->seller_bank_details->toArray() : null;
                    $data['subcription_plan'] = ($seller->subcription_plan && !$seller->subcription_plan->isEmpty())
                        ? $seller->subcription_plan->toArray()
                        : null;

                    return $data;
                });
            }

            // ✅ Empty check
            if ($seller_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_data_found'),
                    'data' => (object)[]
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
            $limit = (int)($request->input('limit')); 

            $query = seller::whereIn('admin_verify', ['3', '4'])
            ->where('type', '0')
                ->with([
                    'store_info.country_info',
                    'owner_document',
                    'store_document',
                    'seller_bank_details',
                    'subcription_plan'
                ]);

            if (!empty($request->country_id2)) {
                $query->whereHas('store_info', function ($q) use ($request) {
                    $q->where('country', $request->country_id2);
                });
            }

            if (!empty($request->from_date2) && !empty($request->to_date2)) {
                $query->whereBetween('created_at', [
                    $request->from_date2 . ' 00:00:00',
                    $request->to_date2 . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date2)) {
                $query->whereDate('created_at', '>=', $request->from_date2);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date2);
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
                $data['store_info'] = $seller->store_info ? $seller->store_info->toArray() : null;
                $data['owner_document'] = $seller->owner_document ? $seller->owner_document->toArray() : null;
                $data['store_document'] = $seller->store_document ? $seller->store_document->toArray() : null;
                $data['seller_bank_details'] = $seller->seller_bank_details ? $seller->seller_bank_details->toArray() : null;
                $data['subcription_plan'] = $seller->subcription_plan && !$seller->subcription_plan->isEmpty()
                    ? $seller->subcription_plan->toArray()
                    : null;

                return $data;
            });

            if ($seller_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_data_found'),
                    'data' => (object) []
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
            $seller = seller::where('type', '0')
                    ->with([
                        'store_info.country_info',
                        'owner_document',
                        'store_document',
                        'seller_bank_details',
                        'subcription_plan.plan_info',
                    ])
                    ->find($sellerId);

            if (!$seller) {
                return [
                    'status' => 'error',
                    'message' => 'Seller not found',
                    'data' => (object) []
                ];
            }

            $data = $seller->toArray();
            $data['store_info'] = $seller->store_info ? $seller->store_info->toArray() : null;
            $data['owner_document'] = $seller->owner_document ? $seller->owner_document->toArray() : null;
            $data['store_document'] = $seller->store_document ? $seller->store_document->toArray() : null;
            $data['seller_bank_details'] = $seller->seller_bank_details ? $seller->seller_bank_details->toArray() : null;
            $data['subcription_plan'] = $seller->subcription_plan && !$seller->subcription_plan->isEmpty()
                ? $seller->subcription_plan->toArray()
                : null;


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
                    'data' => (object) []
                ];
            }

            $seller->admin_verify = '2'; 
            $seller->save();
           
            //send push notification
           CreateNotification([
                'sender_id' => 1,
                'sender_type' => 1,

                'receiver_id' => $seller->id,
                'receiver_type' => 3,

                'title_english' => 'New Account Request',
                'title_arabic' => 'طلب حساب جديد',

                'description_english' => 'Your account approved successfully',
                'description_arabic' => 'تمت الموافقة على حسابك بنجاح',

                'notification_type' => 'account_approved'
            ]);

            return [
                'status' => 'success',
                // 'message' => 'Seller Approve Successfully',
                'message' => __('admin_messages.seller_approved_successfully'),
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

    public function rejectSeller($sellerId, $rejectReason, $rejectType)
    {
        try {
            $seller = seller::find($sellerId);

            if (!$seller) {
                return [
                    'status' => 'error',
                    'message' => 'Seller not found',
                    'data' => (object) []
                ];
            }

            if ($rejectType === 'complete') {
                $seller->admin_verify = '3';
            } elseif ($rejectType === 'document') {
                $seller->admin_verify = '4';
                $seller->bank_information = '0';
            }

            $seller->reject_reason = $rejectReason;
            $seller->save();
            //send notification
            CreateNotification([
                'sender_id' => 1,
                'sender_type' => 1,

                'receiver_id' => $seller->id,
                'receiver_type' => 3,

                'title_english' => 'New Account Request',
                'title_arabic' => 'طلب حساب جديد',

                'description_english' => "Your account rejected, Reason: {$rejectReason}",
                'description_arabic' => "تم رفض حسابك، السبب: {$rejectReason}",

                'notification_type' => 'account_rejected'
            ]);

            return [
                'status' => 'success',
                // 'message' => 'Seller Rejected Successfully',
                'message' => __('admin_messages.seller_rejected_successfully'),
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


    public function blockUnblockSeller($sellerId)
    {
        try {
            $seller = seller::find($sellerId);

            if (!$seller) {
                return [
                    'status' => 'error',
                    'message' => 'Seller not found',
                    'data' => (object)[]
                ];
            }

            $previousStatus = $seller->is_block; 
            $seller->is_block = $seller->is_block == 0 ? 1 : 0;
            $seller->save();

            // $message = $seller->is_block == 1
            //     ? 'Seller Blocked Successfully'
            //     : 'Seller Unblocked Successfully';
            $message = $seller->is_block == 1
                    ? __('admin_messages.seller_blocked_successfully')
                    : __('admin_messages.seller_unblocked_successfully');

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $seller
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    














}
    