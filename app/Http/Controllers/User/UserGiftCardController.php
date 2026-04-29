<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserGiftCardService;

use App\Models\all_countrie;
use App\Models\User;

use Illuminate\Support\Facades\Session;
use App\Helpers\ApiResponse;


class UserGiftCardController extends Controller
{

    public function __construct(UserGiftCardService $UserGiftCardService)
    {
        $this->UserGiftCardService = $UserGiftCardService;
    }
    
    public function gift_cards(Request $request) {
        $user = auth()->user();        
        $data = (object)[
            'user_id' => $user->id,
            'email' => $user->email ?? null,
            'search' => $request->search ?? null
        ];


        $giftCards = $this->UserGiftCardService->User_view_giftCard_details($data)['data'];
        
        // when i get data from Paymwnt gateway
        if($request->payment=='yes'){
        $msg="Payment Paid Successfully";
        $status='success';

        Session::flash('message', $msg);
        Session::flash('status', $status);
         return redirect()->route('user.gift_cards');

        }elseif($request->payment=='no'){

        $msg="Payment Cancalled";
        $status='error';

        Session::flash('message', $msg);
        Session::flash('status', $status);
         return redirect()->route('user.gift_cards');

        }

        return view('user.giftcard.all_giftcard', compact('giftCards'));
    }


    public function add_gift_cards(Request $request)
    {
        $token      = config('myfatoorah.api_key');
        $isTest     = config('myfatoorah.test_mode');
        // $countryIso = config('myfatoorah.country_iso');  
        $countryIso = "KWD";  


        $baseUrl = $isTest
            ? 'https://apitest.myfatoorah.com'
            : 'https://api.myfatoorah.com';

            // dd($baseUrl);

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'Content-Type'  => 'application/json',
        ])->post("$baseUrl/v2/InitiateSession", [
            "CustomerIdentifier" => "cust_".Now(),
            "CountryCode"        => $countryIso,
        ]);

        if ($response->failed()) {
           // dd("MyFatoorah ERROR", $response->status(), $response->body());
        }

        $sessionId = $response->json()['Data']['SessionId'];
        // dd($sessionId);

        $giftCardCategory = $this->UserGiftCardService->giftCard($request)['data'];

         $request_data = (object)[
            'user_id' => $request->user()->id,
        ];
        
        $userBalanceget=userBalanceget($request_data);

        $walletBalance=$userBalanceget['data']['balance'];



        $country =   all_countrie::all();

       // dd($giftCardCategory);
        return view('user.giftcard.add_giftcard', compact('sessionId','giftCardCategory','baseUrl','walletBalance','country'));
    }

    public function view_gift_card($id) {
       // dd($id);
        $giftCard = $this->UserGiftCardService->single_view_giftCard_by_id($id)['data'];
        //dd($giftCard);
        return view('user.giftcard.view_giftcard', compact('giftCard'));
    }

    public function buyGiftCard(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gift_card_id' => 'required|exists:gift_cards,id',
            'amount'          => 'required',
            'receiver_name'          => 'required',
            'receiver_email'         => 'required',
            'sender_name'           => 'required',
            'sender_email'          => 'required',
            'wish_message'          => 'required',
            "country_code"          => 'required',
            "mobile"                =>'required'
        ]);

        try {

            $user = User::find($request->user_id);
            $currencyData = all_countrie::find($user->selected_currency);
            $rate = $currencyData->exchange_rate_to_kwd ?? 1;
            $rawAmount = str_replace(',', '', $request->amount);
            $amount = round(((float)$rawAmount) / $rate, 2);
            //dd($amount);

            $request_data=(object)[
                'user_id'=>$request->user_id,
                'amount' => $amount,
                "gift_card_id"=>$request->gift_card_id,
                "receiver_name"=>$request->receiver_name,
                "receiver_email"=>$request->receiver_email,
                "sender_name"=>$request->sender_name,
                "sender_email"=>$request->sender_email,
                "wish_message"=>$request->wish_message,
                "country_code"=>$request->country_code,
                "mobile"=>$request->mobile,
                "notes"=>$request->notes,
            ];

           // dd($request_data);


            $data = $this->UserGiftCardService->AddgiftCard($request_data);
            
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




    public function giftcard_complete_Payment(Request $request){

        try{
    
        //     $validate = Validator::make($request->all(), [
        //         // "profile_image"=>"required",
        //         'order_id' => 'required|exists:user_gift_cards,order_id',
        //         'payment_status'=>'required|in:1,2',// 1 paid 2 cancel
        //         'transaction_id'=>'required'
        //         ]);
            
        //    if($validate->fails()){
        //     return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        //    }
    
    
           $user_id= $request->user()->id;
    
           $request_data=(object)[
            'user_id'=>$user_id,
            'order_id' => $request->order_id,
            'payment_status' =>"1",
            'transaction_id'=>"333",
            "Payment_method"=>"2"??null
            
           ];
               
    
            $data=$this->UserGiftCardService->complete_giftCard_Payment($request_data);
    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }

              $url="user/gift-cards?payment=yes&orderid=".$request->order_id;

            $msg="Gift Card Payment Paid Successfully";


                return redirect()->to($url)->with([
                'message' => $msg,
                'status' => 'success'
                ]);

    

            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
           
    
    
        }



}