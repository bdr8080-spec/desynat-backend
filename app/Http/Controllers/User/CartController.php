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


}
