<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserGiftCardService;


class UserGiftCardController extends Controller
{

    public function __construct(UserGiftCardService $UserGiftCardService)
    {
        $this->UserGiftCardService = $UserGiftCardService;
    }
    
    public function gift_cards(){

        return view('user.giftcard.all_giftcard');

    }


    public function add_gift_cards(Request $request)
    {
        $token      = config('myfatoorah.api_key');
        $isTest     = config('myfatoorah.test_mode');
        $countryIso = config('myfatoorah.country_iso');  

        $baseUrl = $isTest
            ? 'https://apitest.myfatoorah.com'
            : 'https://api.myfatoorah.com';

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'Content-Type'  => 'application/json',
        ])->post("$baseUrl/v2/InitiateSession", [
            "CustomerIdentifier" => auth()->id(),
            "CountryCode"        => $countryIso,
        ]);

        if ($response->failed()) {
            dd("MyFatoorah ERROR", $response->status(), $response->body());
        }

        $sessionId = $response->json()['Data']['SessionId'];
        //dd($sessionId);
        $giftCardCategory = $this->UserGiftCardService->giftCard($request)['data'];
       // dd($giftCardCategory);
        return view('user.giftcard.add_giftcard', compact('sessionId','giftCardCategory'));
    }

    public function view_gift_card(Request $request){

        return view('user.giftcard.view_giftcard');

    }

    public function buyGiftCard(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gift_card_id' => 'required|exists:gift_cards,id',
            'amount'          => 'required',
            'receiver_name'          => 'required',
            'receiver_email'          => 'required',
            'sender_name'          => 'required',
            'sender_email'          => 'required',
            'wish_message'          => 'required',
        ]);

        try {

            $data = $this->UserGiftCardService->AddgiftCard($request);
            $message = $data['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create reason',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
