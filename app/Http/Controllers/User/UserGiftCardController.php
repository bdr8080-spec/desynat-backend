<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserGiftCardController extends Controller
{
    
    public function gift_cards(){

    return view('user.giftcard.all_giftcard');

}

public function add_gift_cards(Request $request){

        return view('user.giftcard.add_giftcard');

}

}
