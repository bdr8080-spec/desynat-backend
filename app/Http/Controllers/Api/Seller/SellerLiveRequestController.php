<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\country;
use App\Helpers\ApiResponse;

use Validator;


use App\Services\SellerLiveRequestService;


class SellerLiveRequestController extends Controller
{

    public function __construct(SellerLiveRequestService $SellerLiveRequestService){
        $this->SellerLiveRequestService=$SellerLiveRequestService;
    }


    public function get_timeslots(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'date' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $seller_details=$request->user();
            //dd($seller_details);
            $country = country::where('dial_code',$seller_details->country_code)->first();
            //dd($country);

            $request_data=(object )[
                'country_id'=>$country->id,
                "date"=>$request->date
            ];

            $data = $this->SellerLiveRequestService->getTimeslots($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_live_requests(Request $request)
    {

        try {
            $seller_details=$request->user();
            $request_data=(object )[
                'seller_id'=>$seller_details->id,
                "limit"=>$request->limit??10,
                "search"=>$request->search??null,
                "filter"=>$request->filter??null,
                "from"=>$request->from??null,
                "to"=>$request->to??null,

            ];

            $data = $this->SellerLiveRequestService->getLiveRequests($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function cancel_live_request(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:live_requests,id',
            'cancel_reason' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->SellerLiveRequestService->cancelLiveRequest($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function send_live_request(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'timeslot_id' => 'required|exists:live_request_timeslots,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $seller_details=$request->user();
            $request_data=(object )[
                'timeslot_id'=>$request->timeslot_id,
                'seller_id'=>$seller_details->id
            ];

            $result = $this->SellerLiveRequestService->sendLiveRequest($request_data);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }







}