<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserManagementService;


class CartController extends Controller
{
 
    public function __construct(UserManagementService $UserManagementService)
    {
        $this->UserManagementService = $UserManagementService;
    }

    public function view_cart(Request $request){
        $user = auth()->user();  
        $data = (object)[
            'user_id' => $user->id,
        ];
        $cartData = $this->UserManagementService->product_view_cart_details($data)['data'];
        //dd($cartData);
        return view('user.carts.cartlist',compact('cartData'));

    }


}
