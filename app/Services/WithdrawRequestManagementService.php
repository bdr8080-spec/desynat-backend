<?php
namespace App\Services;


use App\Models\WithdrawRequest;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class WithdrawRequestManagementService
{
   
    public function getWithdrawRequests($request_data)
    {
        try {
            $limit = (int)($request_data->limit); 

            $query = WithdrawRequest::with('bank_details','affiliate__details.country_details')
                        ->where('type', '1')
                        ->where('admin_verify', $request_data->req_type); 

            if (!empty($request_data->country_id)) {
                $query->whereHas('affiliate__details.country_details', function ($q) use ($request_data) {
                    $q->where('id', $request_data->country_id);
                });
            }

            if (!empty($request_data->from_date) && !empty($request_data->to_date)) {
                $query->whereBetween('created_at', [
                    $request_data->from_date . ' 00:00:00',
                    $request_data->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request_data->from_date)) {
                $query->whereDate('created_at', '>=', $request_data->from_date);
            } elseif (!empty($request_data->to_date)) {
                $query->whereDate('created_at', '<=', $request_data->to_date);
            }

            if (!empty($request_data->search)) {
                $search = $request_data->search;

                $query->where(function ($q) use ($search) {

                    $q->where('request_id', 'like', "%{$search}%")
                    ->orWhereHas('affiliate__details', function ($q2) use ($search) {
                        $q2->where('full_name', 'like', "%{$search}%");
                    });

                });
            }

            $req_details = $query->orderBy('id', 'desc')->paginate($limit);

            $req_details->getCollection()->transform(function ($item) {

            $item->total_earning = number_format(
                    OrderDetail::where('affiliate_id', $item->user_id)
                        ->where('delivery_status', '3')
                        ->sum('affiliate_commission'),
                    2,
                    '.',
                    ''
                );

                return $item;
            });


            if ($req_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No withdrraw requests found',
                    'data' => (object) []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Withdraw Requests fetched successfully',
                'data' => $req_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch withdraw requests: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    // public function acceptSeller($sellerId)
    // {
    //     try {
    //         $seller = seller::find($sellerId);

    //         if (!$seller) {
    //             return [
    //                 'status' => 'error',
    //                 'message' => 'Seller not found',
    //                 'data' => (object) []
    //             ];
    //         }

    //         $seller->admin_verify = '2'; 
    //         $seller->save();

    //         return [
    //             'status' => 'success',
    //             'message' => 'Seller Approve Successfully',
    //             'data' => $seller
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to accept seller: ' . $e->getMessage(),
    //             'data' => []
    //         ];
    //     }
    // }

    public function rejectWithdrawRequest($sellerId, $rejectReason, $rejectType)
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

            return [
                'status' => 'success',
                'message' => 'Seller Rejected Successfully',
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
    