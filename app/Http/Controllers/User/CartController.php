<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class CartController extends Controller
{


    public function view_cart(Request $request){

        return view('user.carts.cartlist');

    }


}
