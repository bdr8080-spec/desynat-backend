<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\WithdrawRequestManagementService;
use App\Models\country;


use Validator;

class WithdrawRequestController extends Controller
{

    public function __construct(WithdrawRequestManagementService $WithdrawRequestManagementService){

        $this->WithdrawRequestManagementService=$WithdrawRequestManagementService;

    }


    public function get_withdraw_requests(Request $request)
    {
         $validate = Validator::make($request->all(), [
            'req_type' => 'required|in:0,1,2',//0-pending,1-approved,2-rejected
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data = (object)[
                'req_type' => $request->req_type,
                'limit' => $request->limit??null,
                'country' => $request->country??null,
                'from_date' => $request->from_date??null,
                'to_date' => $request->to_date??null,
                'search' => $request->search??null,
                'status' => $request->status??null,
            ];
            $data = $this->WithdrawRequestManagementService->getWithdrawRequests($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function get_seller_payouts(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'req_type' => 'nullable|in:0,1,2', // 0-pending, 1-approved, 2-rejected
            'seller_id' => 'nullable|integer|exists:sellers,id',
            'countryId' => 'nullable|integer|exists:countries,id',
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
                'req_type' => $request->req_type,
                'seller_id' => $request->seller_id,
                'countryId' => $request->countryId,
                'limit' => $request->limit ?? 20,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'search' => $request->search,
            ];

            $data = $this->WithdrawRequestManagementService->getSellerPayouts($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], $data['data'] ?? [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
        } catch (\Throwable $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    // public function accept_seller(Request $request)
    // {
    //     $validate = Validator::make($request->all(), [
    //         'seller_id' => 'required|exists:sellers,id',
    //     ]);

    //     if ($validate->fails()) {
    //         return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
    //     }

    //     try {
    //         $data = $this->SellerManagementService->acceptSeller($request->seller_id);

    //         if (isset($data['status']) && $data['status'] === 'error') {
    //             return ApiResponse::generateResponse('error', $data['message'], [], 400);
    //         }

    //         return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

    //     } catch (\Exception $e) {
    //         return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
    //     }
    // }


    public function reject_withdraw_request(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'req_id' => 'required|exists:withdraw_requests,id',
            'reject_reason' => 'required|string|max:1000',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->WithdrawRequestManagementService->rejectWithdrawRequest($request->req_id,$request->reject_reason);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function approve_withdraw_request(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'req_id' => 'required|exists:withdraw_requests,id',
            // 'transaction_id' => 'required',
            // 'payment_status' => 'required|in:1,2',//1-paid,2-fail
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->WithdrawRequestManagementService->approveWithdrawRequest($request);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function transfer_withdraw_request(Request $request)
{
    try {

        $validate = Validator::make($request->all(), [
            'withdraw_request_id' => 'required|exists:withdraw_requests,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse(
                'error',
                'Validation error',
                $validate->errors()->first(),
                422
            );
        }

        $data = $this->WithdrawRequestManagementService
            ->transferWithdrawRequest($request);

        if (isset($data['status']) && $data['status'] === 'error') {
            return ApiResponse::generateResponse(
                'error',
                $data['message'],
                $data['data'] ?? (object)[],
                400
            );
        }

        return ApiResponse::generateResponse(
            'success',
            $data['message'],
            $data['data'] ?? (object)[],
            200
        );

    } catch (\Throwable $e) {

        Log::error('Transfer Withdraw Request Error', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'request' => $request->all()
        ]);

        return ApiResponse::generateResponse(
            'error',
            'Something went wrong: '.$e->getMessage(),
            [],
            500
        );
    }
}

 public function transfer_seller_commission(Request $request)
{
    try {

        $validate = Validator::make($request->all(), [
            'orderdetail_id' => 'required|exists:orderdetails,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse(
                'error',
                'Validation error',
                $validate->errors()->first(),
                422
            );
        }

        $data = $this->WithdrawRequestManagementService
            ->transferSellerCommission($request);

        if (isset($data['status']) && $data['status'] === 'error') {
            return ApiResponse::generateResponse(
                'error',
                $data['message'],
                $data['data'] ?? (object)[],
                400
            );
        }

        return ApiResponse::generateResponse(
            'success',
            $data['message'],
            $data['data'] ?? (object)[],
            200
        );

    } catch (\Throwable $e) {

        Log::error('Transfer Withdraw Request Error', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'request' => $request->all()
        ]);

        return ApiResponse::generateResponse(
            'error',
            'Something went wrong: '.$e->getMessage(),
            [],
            500
        );
    }
}











    

    


      






}
