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
        //dd($orderData);

        return view('user.orders.my-order',compact('orderData'));

    }



    public function create_order(Request $request)
    {
        //dd($request->all());

        try {
              $user=  $request->user();
            $userId = $user->id; 

            $request_data = (object)[
                'user_id'           => $userId,
                'total_mrp'         => $request->cartSummary['totalMRP'] ?? null,
                'discount_mrp'      => $request->cartSummary['discountOnMRP'] ?? null,
                'promocode_status' => $request->promo ? 'yes' : 'no',
                'promocode_id'      => $request->promo['promoId'] ?? null,
                'promocode_value'   => $request->promo['discountValue'] ?? null,
                'shipping_fees'     => $request->cartSummary['shippingFee'] ?? 0,
                'tax'               => $request->cartSummary['tax'] ?? 0,
                'total_amount'      => $request->cartSummary['totalAmount'] ?? null,
                'giftcard_id'       => $request->giftCard['giftCardId'] ?? null,
                'giftcard_amount'   => $request->giftCard['giftCardAmount'] ?? 0,
                'Payment_method'    => $request->Payment_method,
                'delivery_address'    => $request->deliveryAddressId,
            ];

           // dd($request_data);

            $data = $this->UserOrderService->User_Create_Order($request_data);
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
                'message' => 'Failed create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function orderDetails(Request $request,$id){
        $orderId = $id;
        //dd($orderId);
        $data = (object)[
            'order_id' => $orderId,
        ];
        $orderData = $this->UserOrderService->singleOrderDetails($data);
        //dd($orderData);
        return view('user.carts.orderplace',compact('orderData'));

    }




}