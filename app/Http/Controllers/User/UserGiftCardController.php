<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class UserGiftCardController extends Controller
{
    
    public function gift_cards(){

        return view('user.giftcard.all_giftcard');

    }


    public function add_gift_cards(Request $request)
    {
        // $token      = config('myfatoorah.api_key');
        // $isTest     = config('myfatoorah.test_mode');
        // $countryIso = config('myfatoorah.country_iso');  

        // $baseUrl = $isTest
        //     ? 'https://apitest.myfatoorah.com'
        //     : 'https://api.myfatoorah.com';

        // $response = Http::withHeaders([
        //     'Authorization' => "Bearer $token",
        //     'Content-Type'  => 'application/json',
        // ])->post("$baseUrl/v2/InitiateSession", [
        //     "CustomerIdentifier" => auth()->id(),
        //     "CountryCode"        => $countryIso,
        // ]);

        // if ($response->failed()) {
        //     dd("MyFatoorah ERROR", $response->status(), $response->body());
        // }

        // $sessionId = $response->json()['Data']['SessionId'];
        //dd($sessionId);

        return view('user.giftcard.add_giftcard');
    }

    public function view_gift_card(Request $request){

        return view('user.giftcard.view_giftcard');

    }


}
