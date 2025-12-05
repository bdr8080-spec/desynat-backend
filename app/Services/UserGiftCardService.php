<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;


use App\Models\{UserGiftCards,GiftCard};


class UserGiftCardService
{

    // get gift cards
    public function giftCard(){
        
        $GiftCard = GiftCard::orderBy('id', 'asc')->get();

        if ($GiftCard->isEmpty()) {
             return ['status'=>'success','message'=>"No GiftCard found",'data'=>[]];
        }
        return ['status'=>'success','message'=>"GiftCard list fetched successfully",'data'=>$GiftCard];
    }


    

        // add gift cards
    public function AddgiftCard($request){

        try{

            $orderId="Order". rand('11111111111','999999999999999');

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


            $checkGiftCard = UserGiftCards::where('order_id',$request->order_id)->first();

            if($checkGiftCard->payment_status!=='0'){
                return [
                    'status' => 'error',
                    'message' => 'Gift Card is cancel or Already Paid',
                    'data' => (object)[]
                ];
            }

            $checkGiftCard->update(['payment_status'=>$request->payment_status,'transaction_id'=>$request->transaction_id]);


            if($request->payment_status=='1'){

                $msg="Gift Card Payment paid successfully";

            }else{

                $msg="Gift Card Order Payment Cancelled";

            }

            return ['status'=>'success','message'=>$msg,'data'=>$checkGiftCard];

            
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }

        
        }


        
    




}