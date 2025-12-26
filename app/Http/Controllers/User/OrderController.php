<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserOrderService;
use App\Helpers\ApiResponse;

use Validator;

class OrderController extends Controller
{
 
    public function __construct(UserOrderService $UserOrderService)
    {
        $this->UserOrderService = $UserOrderService;
    }

    public function myOrders(Request $request){ 

         $user=  $request->user();

        $data = (object)[
            'user_id' => $user->id,
            'search' => $request->search ?? null,
            'filter' => $request->filter ?? null
        ];

        $orderData = $this->UserOrderService->AllOrderDetailsNew($data)['data'];
        //dump($orderData);

        return view('user.orders.my-order',compact('orderData'));

    }

    public function order_details(Request $request, $id){ 


        $data = (object)[
            'order_id' => $id,
             'orderdetails_id' => $request->orderdetails_id
        ];

        $orderData = $this->UserOrderService->singleOrderDetailsNew($data)['data'];
       //dd($orderData);

        return view('user.orders.order-details',compact('orderData'));

    }



    public function cancel_order(Request $request)
    {
        //dd($request->all());

        try {
              $request_data = (object)[
                'order_id' => $id,
                'orderdetails_id' => $request->orderdetails_id
              ];

            $data = $this->UserOrderService->cancelledSingleProduct($request_data);
            //dd($data);
            
            if ($data['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => $data['message'],
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $data['message'],
                    'data' => (object)[]
                ], 422); 
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed cancel order',
                'error' => $e->getMessage()
            ], 500);
        }
    }





}