<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use Validator;

use App\Services\PaymentService;

use App\Models\{ seller,sellerStoreInformation,sellerDocument,Bankdetails,Plan };


class PaymentController extends Controller
{

    public function __Construct(PaymentService $PaymentService){
        $this->PaymentService=$PaymentService;
    }



    public function get_order_payments(Request $request){
    
        $request_data=(object)[
            'limit'=>$request->limit??null,
            'search'=>$request->search??null,
            'country'=>$request->country??null,
            'from_date'=>$request->from_date??null,
            'to_date'=>$request->to_date??null,
            'country_id'=>$request->country_id??null,
            ];

        $data=$this->PaymentService->getOrderPaymentData($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

        }

        return ApiResponse::generateResponse('success', $data['message'], [
            'orders' => $data['data'],
            'total_revenue' => $data['total_revenue'],
            'total_custom_order_revenue' => $data['total_custom_order_revenue'],
            'total_commission' => $data['total_commission'],
        ], 200);

    }






}