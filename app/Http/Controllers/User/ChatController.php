<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserFirebaseService;
use App\Helpers\ApiResponse;
use App\Http\Controllers\CommonController;
use App\Models\userAddress;
use App\Services\UserOrderService;

use App;


use App\Services\GoogletranslateService;

use Validator;

class ChatController extends Controller
{
 
    public function __construct(UserFirebaseService $UserFirebaseService, UserOrderService $UserOrderService,GoogletranslateService $GoogletranslateService)
    {
        $this->UserFirebaseService = $UserFirebaseService;
        $this->UserOrderService = $UserOrderService;
        $this->GoogletranslateService = $GoogletranslateService;
    }

    public function allChats(Request $request){ 

         $user=  $request->user();

        $data = (object)[
            'user_id' => $user->id,
            'filters' => $request->filters,
            'search' => $request->search,
        ];

        $chatData = $this->UserFirebaseService->userGetAllChatsRecords($data)['data'];
        // dd($chatData);

        return view('user.chat.chatlists',compact('chatData'));

    }

    public function userChat(Request $request, $id){ 
        $user=  $request->user();

        $data = (object)[
            //'unique_id' => $user->id,
            'unique_id' => $id,
        ];

        $chatData = $this->UserFirebaseService->userGetSingleChatsRecords($data)['data'];
        // dd($chatData);
        $userAddress = userAddress::where('user_id', $user->id)
                              ->where('set_as_default', '1')
                              ->first();
       //dd($userAddress);

        return view('user.chat.userChat',compact('chatData','userAddress'));

    }

    public function chatDetails(Request $request, $id){ 
        $data = (object)[
            //'unique_id' => $user->id,
            'unique_id' => $id,
        ];

        $chatData = $this->UserFirebaseService->userGetSingleChatsRecords($data)['data'];
       // dd($chatData);
       $user=  $request->user();

        $data1 = (object)[
            'user_id' => $user->id,
        ];
       $userBalanceget=$this->UserOrderService->userBalanceget($data1);

        $walletBalance=$userBalanceget['data']['balance'];

        $userAddressId = userAddress::where('user_id',$user->id)->where('set_as_default','1')->value('id');
        //dd($cartData);
        $data2 = (object)[
            'delivery_address' => $userAddressId,
            'user_id' => $user->id,
        ];
        $promoCodes = $this->UserOrderService->User_View_Promocode_list($data2)['data'];

        return view('user.chat.detailsChat',compact('chatData','walletBalance','promoCodes'));

    }

    public function customRequest(Request $request){ 

        return view('user.chat.custom-request');

    }

    public function sendNormalMessage(Request $request)
    {
        try {

            $userId   = auth()->id();
            $sellerId = $request->seller_id;
            $uniqueId = $request->unique_id;

            // 0 = text, 1 = image
            $type = $request->hasFile('image') ? 1 : 0;

            $message = null;

            $TextInArbic='';

            if ($type === 1) {

                $commonController = new CommonController();
                $uploadResult = $commonController->upload($request);
                $uploadResultArray = $uploadResult->getData(true);

                if ($uploadResultArray['status'] === 'error') {
                    return response()->json([
                        'status' => 'error',
                        'message' => $uploadResultArray['message']
                    ], 422);
                }

                $message = $uploadResultArray['data']['url'];


              $SendchatDataArray=(object)[
                'unique_id' => $uniqueId,
                'user_id'   => $userId,
                'seller_id' => $sellerId,
                'type'      => $type,
                'message'   => $message,
                "messageAr" => '',
                'by'        => 'user',
              ];

            } else {

                if(App::getLocale()=='en'){

                $message = $request->message;
                $TextInArbic= $this->GoogletranslateService->translate($message,'ar');

            $SendchatDataArray=(object)[
                'unique_id' => $uniqueId,
                'user_id'   => $userId,
                'seller_id' => $sellerId,
                'type'      => $type,
                'message'   => $message,
                "messageAr" => $TextInArbic,
                'by'        => 'user',
              ];

                }else{

                $message = $request->message;
                $TextInenglish= $this->GoogletranslateService->translate($message,'en');

                 $SendchatDataArray=(object)[
                'unique_id' => $uniqueId,
                'user_id'   => $userId,
                'seller_id' => $sellerId,
                'type'      => $type,
                'message'   => $TextInenglish,
                "messageAr" => $message,
                'by'        => 'user',
              ];

                }


            }

            $chatData = (object)[
                'user_id'   => $userId,
                'seller_id' => $sellerId,
            ];

            $this->UserFirebaseService->CreateNormalChatFirebase($chatData);

            $this->UserFirebaseService->userSendChatsMessage($SendchatDataArray);

            return response()->json([
                'status'    => 'success',
                'type'      => $type,
                'message'   => $message,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to send message',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function createCustomOrder(Request $request)
    {
        //dd($request->all());
        $user=  $request->user();

        try {
              $request_data = (object)[
                'product_id' => $request->product_id,
                'variation_id' => $request->variation_id,
                'user_id' => $user->id,
              ];

            $data = $this->UserFirebaseService->CreatecustomOrder($request_data);
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

    public function sendCustomOrderRequest(Request $request)
    {
        //dd($request->all());
        $user=  $request->user();

        try {
              $request_data = (object)[
                'unique_id' => $request->unique_id,
                'quantity' => $request->quantity,
                'custom_details' => $request->custom_details,
                'delivery_address' => $request->delivery_address,
                'quantity' => $request->quantity,
              ];

            $data = $this->UserFirebaseService->sendCustomOrderRequest($request_data);
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

    public function acceptRejectCustOrder(Request $request)
    {
        //dd($request->all());
        $user=  $request->user();

        try {
              $request_data = (object)[
                'unique_id' => $request->unique_id,
                'status' => $request->status,
              ];

            $data = $this->UserFirebaseService->UserCustomOrderAcceptAndReject($request_data);
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

    public function create_custom_order(Request $request)
    {
        //dd($request->all());

        try {
              $user=  $request->user();
            $userId = $user->id; 

            $request_data = (object)[
                'user_id'           => $userId,
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
                'unique_id'    => $request->unique_id,
            ];

           // dd($request_data);

            $data = $this->UserFirebaseService->CustomCreateOrder($request_data);
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

    public function get_all_messages(Request $request, $id)
    {
        try {
            // Firebase returns messages directly
            $messages = $this->UserFirebaseService->getMessages($id);

            if (empty($messages)) {
                return response()->json([
                    'status' => 'success',
                    'data' => []
                ]);
            }

            // Convert Firebase keys to normal array
            $formattedMessages = array_values($messages);

            return response()->json([
                'status' => 'success',
                'data' => $formattedMessages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch messages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function get_all_custom_messages(Request $request, $id)
    {
        try {
            // Firebase returns messages directly
            $messages = $this->UserFirebaseService->getMessages($id);

            if (empty($messages)) {
                return response()->json([
                    'status' => 'success',
                    'data' => []
                ]);
            }

            // Convert Firebase keys to normal array
            $formattedMessages = array_values($messages);

            return response()->json([
                'status' => 'success',
                'data' => $formattedMessages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch messages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create_normal_chat(Request $request)
    {
        try {

            $userId   = auth()->id();
            $sellerId = $request->seller_id;

            $chatData = (object)[
                'user_id'   => $userId,
                'seller_id' => $sellerId,
            ];

            $data = $this->UserFirebaseService->CreateNormalChatFirebase($chatData);


            return response()->json([
                'status'    => 'success',
                'message' => $data['message'],
                'data' => $data
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to send message',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
















}