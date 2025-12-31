<?php

namespace App\Http\Controllers\Api\DeliveryBoy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryBoy;
use App\Helpers\ApiResponse;


use Validator;


use App\Services\DeliveryBoyOrderService;


class DeliveryBoyOrderController extends Controller
{

    public function __construct(DeliveryBoyOrderService $DeliveryBoyOrderService){

        $this->DeliveryBoyOrderService=$DeliveryBoyOrderService;

    }


    public function get_all_orders(Request $request)
    {
        $user_details=$request->user();
        $data = (object)[
            'delivery_boy_id' => $user_details->id,
            'search' => $request->search ?? null,
            'filter' => $request->filter ?? null
        ];

        try {
            $data = $this->DeliveryBoyOrderService->AllOrdersNew($data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_new_orders(Request $request)
    {
        $user_details=$request->user();
        $data = (object)[
            'delivery_boy_id' => $user_details->id,
            'search' => $request->search ?? null,
            'filter' => $request->filter ?? null
        ];

        try {
            $data = $this->DeliveryBoyOrderService->NewOrdersNew($data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_ongoing_orders(Request $request)
    {
        $user_details=$request->user();
        $data = (object)[
            'delivery_boy_id' => $user_details->id,
            'search' => $request->search ?? null,
            'filter' => $request->filter ?? null
        ];

        try {
            $data = $this->DeliveryBoyOrderService->OngoingOrdersNew($data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_completed_orders(Request $request)
    {
        $user_details=$request->user();
        $data = (object)[
            'delivery_boy_id' => $user_details->id,
            'search' => $request->search ?? null,
            'filter' => $request->filter ?? null
        ];

        try {
            $data = $this->DeliveryBoyOrderService->CompletedOrdersNew($data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function order_details(Request $request)
    {   
        $validate = Validator::make($request->all(), [

            'id' => 'required|exists:orderdetails,id',
        ]);


        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = (object)[
            'id' => $request->id,
        ];

        try {
            $data = $this->DeliveryBoyOrderService->OrderDetailsNew($data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function update_delivery_status(Request $request)
    {   
        $validate = Validator::make($request->all(), [
            
            'id' => 'required|exists:orderdetails,id',
            'delivery_status' => 'required|in:7,8,3',
            'reason' => 'required_if:delivery_status,8|string',
            'collect_amount' => 'required_if:delivery_status,3|in:1',
        ]);


        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = (object)[
            'id' => $request->id,
            'delivery_status' => $request->delivery_status,
            'reason' => $request->reason,
            'collect_amount' => $request->collect_amount
        ];

        try {
            $data = $this->DeliveryBoyOrderService->UpdateDeliveryStatusNew($data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function pick_order(Request $request)
    {   
        $validate = Validator::make($request->all(), [
            
            'id' => 'required|exists:orderdetails,id',
        ]);


        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = (object)[
            'id' => $request->id
        ];

        try {
            $data = $this->DeliveryBoyOrderService->PickOrderNew($data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_reasons(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|integer|in:1,2,3',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->DeliveryBoyOrderService->getReason($request);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

}


    

    

    
