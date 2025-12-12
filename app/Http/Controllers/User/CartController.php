<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserManagementService;
use App\Services\UserOrderService;
use App\Models\userAddress;


class CartController extends Controller
{
 
    public function __construct(UserManagementService $UserManagementService, UserOrderService $UserOrderService)
    {
        $this->UserManagementService = $UserManagementService;
        $this->UserOrderService = $UserOrderService;
    }

    public function view_cart(Request $request){
        $user = auth()->user();  
        $data = (object)[
            'user_id' => $user->id,
        ];
        $cartData = $this->UserManagementService->product_view_cart_details($data)['data'];

        $userAddressId = userAddress::where('user_id',$user->id)->where('set_as_default','1')->value('id');
        //dd($cartData);
        $data1 = (object)[
            'delivery_address' => $userAddressId,
            'user_id' => $user->id,
        ];
        $promoCodes = $this->UserOrderService->User_View_Promocode_list($data1)['data'];
        //dd($promoCodes);
        return view('user.carts.cartlist',compact('cartData','promoCodes'));

    }

    public function apply_promocode(Request $request)
    {
        $request->validate([
            'promo_id' => 'required|exists:promocodes,id',
            'amount'   => 'required|numeric',
        ]);

        try {
            $promoId = $request->promo_id;
            $amount = (int) $request->amount; 

            $data = $this->UserOrderService->User_Apply_PromoCode($request);
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
                'message' => 'Failed to apply promo code',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function apply_giftcard(Request $request)
    {
        $request->validate([
            'giftCardNo' => 'required|numeric',
            'giftCardPin'   => 'required|numeric',
        ]);

        try {
            // $promoId = $request->promo_id;
            // $amount = (int) $request->amount; 

            $data = $this->UserOrderService->User_Apply_giftCardInOrder($request);
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
                'message' => 'Failed to apply promo code',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create_order(Request $request)
    {
        //dd($request->all());

        try {
            $user = auth()->user();
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





    public function Payment_Callback(Request $request){

        dd($request->all());

    }


}