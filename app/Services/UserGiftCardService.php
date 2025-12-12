<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;


use App\Models\{UserGiftCards,GiftCard};
use App\Models\{Promocode,userAddress,country,all_countrie};

Use DB;


class UserGiftCardService
{

    // get gift cards
    public function giftCard(){
        
        $GiftCard = GiftCard::where('status','1')->orderBy('id', 'asc')->get();

        if ($GiftCard->isEmpty()) {
             return ['status'=>'success','message'=>"No GiftCard found",'data'=>[]];
        }
        return ['status'=>'success','message'=>"GiftCard list fetched successfully",'data'=>$GiftCard];
    }


    

        // add gift cards
    public function AddgiftCard($request){

        try{

            $orderId="Order". rand('11111111111','999999999999999');


            $giftCardNo=rand('1111111111111111','9999999999999999');
            $giftCardPin=rand('1111','9999');

            // check receiver on Our system

          $c_receiver_on_System=  User::where('email',$request->receiver_email)->first();
          if($c_receiver_on_System){

            $receiver_id=$c_receiver_on_System->id;
          }else{
            $receiver_id=null;
          }
          
            $data=[
                'order_id'=>$orderId,
                'user_id'=>$request->user_id,
                'gift_card_id' => $request->gift_card_id ,
                'giftCardNo'=>$giftCardNo,
                'giftCardPin'=>$giftCardPin,
                'amount' => $request->amount,
                'receiver_id'=>$receiver_id,
                'receiver_name' => $request->receiver_name  ,
                'receiver_email' => $request->receiver_email  ,
                'sender_name' => $request->sender_name,  
                'sender_email' => $request->sender_email,  
                'wish_message' => $request->wish_message,
                'notes' =>$request->notes  
            ];

            $AddGiftCard = UserGiftCards::Create($data);
    
        
            return ['status'=>'success','message'=>"GiftCard Add successfully",'data'=>$AddGiftCard];
        
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }

        
        }



    // complete  gift card Payment
    public function complete_giftCard_Payment($request){

        try{

            DB::beginTransaction();
            $checkGiftCard = UserGiftCards::where('order_id',$request->order_id)->first();

            if($checkGiftCard->payment_status!=='0'){
                return [
                    'status' => 'error',
                    'message' => 'Gift Card is cancel or Already Paid',
                    'data' => (object)[]
                ];
            }


            if($request->payment_status=='1'){

              if($request->Payment_method=='2'){

                $userId=$checkGiftCard->user_id;
                $amount=round($checkGiftCard->amount);
               

                  $request_data=(object)[
                    'user_id'=>$userId,
                    ];

                    // Get User Wallet Balance 
                $userBalance= userBalanceget($request_data);

                if($userBalance['data']['balance'] < round($amount)){
                    // check Wallet AMount 
                    return [
                        'status' => 'error',
                        'message' => "Wallet Amount Is Low Please recharge Your Wallet",
                        'data' => []
                    ];
                }


                // cut Payment From Wallet 
                 $data1= UserBalancePayOrder($userId,round($amount));

                }



                $msg="Gift Card Purchased Successfully";

            }else{

                $msg="Pyment Failed";

            }

            // change status in Db 
            $checkGiftCard->update(['payment_status'=>$request->payment_status,'transaction_id'=>$request->transaction_id]);


             DB::commit();

            return ['status'=>'success','message'=>$msg,'data'=>$checkGiftCard];

            
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }

        
        }


 // View  gift card list
 public function User_view_giftCard_details($request){

    try{

   
$checkGiftCard = UserGiftCards::with('gift_details')->where(function($q) use ($request) {
    $q->where('user_id', $request->user_id);
    //   ->orWhere('receiver_email', $request->email);
})
->where('payment_status', '1');

if($request->search){
    $checkGiftCard = $checkGiftCard->where('order_id','like','%'.$request->search.'%')
    ->Orwhere('sender_email','like','%'.$request->search.'%')
    ->Orwhere('sender_name','like','%'.$request->search.'%')
            ->Orwhere('receiver_email','like','%'.$request->search.'%');
      
}

$checkGiftCard = $checkGiftCard->get();



    return ['status'=>'success','message'=>"Gift Card fatch Successfully",'data'=>$checkGiftCard];

        
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }

    
    }


    public function single_view_giftCard_by_id($id) {
        try {
            $giftCard = UserGiftCards::with('gift_details')
                ->where('id', $id)
                ->first(); 

            if (!$giftCard) {
                return [
                    'status' => 'error',
                    'message' => 'Gift Card not found',
                    'data' => null
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Gift Card fetched successfully',
                'data' => $giftCard
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch gift card: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }







}