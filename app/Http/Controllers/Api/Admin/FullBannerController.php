<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\FullBannerService;


use Validator;

class FullBannerController extends Controller
{

    public function __construct(FullBannerService $FullBannerService){

        $this->FullBannerService=$FullBannerService;

    }


    public function get_full_banners(Request $req)
    {

        try {
            $data = $this->FullBannerService->getFullBanners($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }



    public function add_full_banner(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'image' => 'required',
            'country_id' => 'required|exists:all_countries,id',
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|in:1,2',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->FullBannerService->addFullBanner($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function update_full_banner(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'banner_id' => 'required|exists:full_banners,id',
            'image' => 'required',
            'country_id' => 'required|exists:all_countries,id',
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|in:1,2'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->FullBannerService->updateFullBanner($request, $request->banner_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function delete_full_banner(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'banner_id' => 'required|exists:full_banners,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->FullBannerService->deleteFullBanner($request->banner_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_banner_detail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'banner_id' => 'required|exists:full_banners,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->FullBannerService->bannerDetails($request->banner_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function add_promotional_banner(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'banner_position' => 'required|in:1,2,3', // 1 homeTop 2 home Banner 3 category
            'category'        => 'nullable|required_if:banner_position,3|exists:categories,id',
            'subcatgory'      => 'nullable|required_if:banner_position,3|exists:sub_categories,id',
            
            "start_date"=>"required|date",
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days'=>'required|integer',
            "upload_banner"=>"required",
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $request_data=(object) [
                'banner_position'=>$request->banner_position,
                'category'=>$request->category,
                'subcatgory'=>$request->subcatgory,


                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'total_days'=>$request->total_days,
                'upload_banner'=>$request->upload_banner,

            ];

            $result= $this->FullBannerService->addPromotionalBanner($request_data);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function update_promotional_banner(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'banner_id'      =>  'required|exists:seller_banners,id',
            'banner_position' => 'required|in:1,2,3',
            'category'        => 'nullable|required_if:banner_position,3|exists:categories,id',
            'subcatgory'      => 'nullable|required_if:banner_position,3|exists:sub_categories,id',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'total_days'      => 'required|integer',
            'upload_banner'   => 'nullable', // optional on update
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse(
                'error',
                'Validation error',
                $validate->errors()->first(),
                422
            );
        }

        try {
            $request_data = (object)[
                'id'              => $request->banner_id,
                'banner_position' => $request->banner_position,
                'category'        => $request->category,
                'subcatgory'      => $request->subcatgory,
                'start_date'      => $request->start_date,
                'end_date'        => $request->end_date,
                'total_days'      => $request->total_days,
                'upload_banner'   => $request->upload_banner,
            ];

            $result = $this->FullBannerService->updatePromotionalBanner($request_data);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse(
                'error',
                'Something went wrong: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    public function delete_promotional_banner(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'banner_id' => 'required|exists:seller_banners,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->FullBannerService->deletePromotionalBanner($request->banner_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_promotional_banners(Request $req)
    {

        try {
            $data = $this->FullBannerService->getPromotionalBanners($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_promotional_banner_detail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'banner_id' => 'required|exists:seller_banners,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->FullBannerService->promotionalBannerDetails($request->banner_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }





    

    


      






}
