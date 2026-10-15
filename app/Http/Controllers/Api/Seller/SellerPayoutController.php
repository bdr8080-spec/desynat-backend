<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\SellerPayoutService;

use Validator;

class SellerPayoutController extends Controller
{
    public function __construct(SellerPayoutService $SellerPayoutService){

        $this->SellerPayoutService=$SellerPayoutService;

    }

    public function my_payout_list(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'limit' => 'nullable|integer|min:1|max:100',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'search' => 'nullable|string|max:255',
        ]);


        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $request_data = (object) [
                'seller_id' => $this->SellerPayoutService->resolveSellerId($request->user()),
                'limit' => $request->limit ?? 20,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'search' => $request->search,
            ];

            $data = $this->SellerPayoutService->getMyPayouts($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], $data['data'] ?? [], 400);
            }


            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
        } catch (\Throwable $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_all_transactions(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'transaction_type' => 'nullable|in:0,1,2', // 0-all, 1-credit, 2-debit
            'payment_mode' => 'nullable|in:1,2,3', // 1-online, 2-wallet, 3-cash on delivery
            'limit' => 'nullable|integer|min:1|max:100',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'search' => 'nullable|string|max:255',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $request_data = (object) [
                'seller_id' => $this->SellerPayoutService->resolveSellerId($request->user()),
                'transaction_type' => $request->transaction_type ?? '0',
                'payment_mode' => $request->payment_mode,
                'limit' => $request->limit ?? 20,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'search' => $request->search,
            ];

            $data = $this->SellerPayoutService->getAllTransactions($request_data);

            
            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], $data['data'] ?? [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
        } catch (\Throwable $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }
}
