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




}
