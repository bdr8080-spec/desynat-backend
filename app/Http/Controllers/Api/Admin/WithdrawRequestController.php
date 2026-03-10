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
            'transaction_id' => 'required',
            'payment_status' => 'required|in:1,2',//1-paid,2-fail
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











    

    


      






}
