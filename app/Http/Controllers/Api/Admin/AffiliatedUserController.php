<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\AffiliatedUserManagementService;


use Validator;

class AffiliatedUserController extends Controller
{

    public function __construct(AffiliatedUserManagementService $AffiliatedUserManagementService){

        $this->AffiliatedUserManagementService=$AffiliatedUserManagementService;

    }


    public function get_new_affilaited_users(Request $req)
    {
        try {
            $data = $this->AffiliatedUserManagementService->getNewAffiliatedUers($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_approved_affilaited_users(Request $req)
    {
        try {
            $data = $this->AffiliatedUserManagementService->getApprovedAffiliatedUers($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_rejected_affilaited_users(Request $req)
    {
        try {
            $data = $this->AffiliatedUserManagementService->getRejectedAffiliatedUers($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }




    public function get_affiliate_user_details(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:affilated_users,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->AffiliatedUserManagementService->getAffiliateUserDetailsById($request->user_id);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function accept_affiliate_user(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:affilated_users,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->AffiliatedUserManagementService->acceptAffiliateUser($request->user_id);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function reject_affiliate_user(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:affilated_users,id',
            'reject_reason' => 'required|string|max:1000',
            'reject_type' => 'required|string',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->AffiliatedUserManagementService->rejectAffiliateUser($request->user_id,$request->reject_reason,$request->reject_type);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function block_unblock_affiliate_user(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:affilated_users,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->AffiliatedUserManagementService->blockUnblockAffiliateUser($request->user_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }









    

    


      






}
