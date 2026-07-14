<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\BannerService;


use Validator;

class BannerController extends Controller
{

    public function __construct(BannerService $BannerService){

        $this->BannerService=$BannerService;

    }

    public function get_banners(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'type' => 'required|in:1,2,3'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->BannerService->getBanners($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }
    
    public function add_update_banner(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'type' => 'required|in:1,2,3', //1-top,2-bottom,3-subcategory
            'per_day_price' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->BannerService->addUpdateBanner($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 200);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    //Banner request functions

    public function get_banner_request(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'type' => 'required|in:0,1,2'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->BannerService->getBannersReq($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function approve_banner_request(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'banner_id' => 'required|exists:seller_banners,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->BannerService->approveBannerReq($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function reject_banner_request(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'banner_id' => 'required|exists:seller_banners,id',
            "reason" =>'required|string',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->BannerService->rejectBannerReq($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function block_unblock_banner_req(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:seller_banners,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->BannerService->blockUnblockBannerReq($request->id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_seller_story_price(Request $req)
    {

        try {
            $data = $this->BannerService->getSellerStoryPrice($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }
    
    public function add_update_seller_story_price(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'per_day_price' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->BannerService->addUpdateSellerStoryPrice($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 200);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }









    

    


      






}
