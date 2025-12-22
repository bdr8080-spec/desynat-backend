<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Services\UserOrderService;

use Validator;


use App\Helpers\ApiResponse;

use Illuminate\Validation\Rule;


class UserOrderController extends Controller
{
    public function __construct(UserOrderService $UserOrderService){
        $this->UserOrderService=$UserOrderService;
    }



        


    public function View_promocode_list(Request $request){

        try{

            $validate = Validator::make($request->all(), [
                'delivery_address' => 'required|exists:user_addresses,id',
                ]);
            
           if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }
    
            $user_id= $request->user()->id;
    
           $request_data=(object)[
            'user_id'=>$user_id,
            'delivery_address'=>$request->delivery_address
           ];
    
            $data=$this->UserOrderService->User_View_Promocode_list($request_data);
    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }
    
            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
           
    
    
        }

        



    public function Apply_promocode(Request $request){

        try{

            $validate = Validator::make($request->all(), [
                // // 'promo_id' => 'required|exists:promocodes,id',
                "amount"=>"required",

                 'promo_id' => 'required_without:search|exists:promocodes,id',
                 'search'   => 'required_without:promo_id',

                ]);
            
           if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }
    
            $user_id= $request->user()->id;
    
           $request_data=(object)[
            'user_id'=>$user_id,
            'promo_id'=>$request->promo_id,
            'amount'=>$request->amount,
            'search'=>$request->search??null
           ];
    
            $data=$this->UserOrderService->User_Apply_PromoCode($request_data);
    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }
    
            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
        
        }


    public function create_order(Request $request){

        try{

            $validate = Validator::make($request->all(), [
                'delivery_address'=>"required|exists:user_addresses,id",
                "total_mrp"=>"required",
                "discount_mrp"=>"required",
                'promocode_status'=>"required|in:yes,no",
                'promocode_id' => [
                Rule::requiredIf($request->promocode_status === 'yes'),
                'integer',
                'exists:promocodes,id'
                ],
                'promocode_value' => [
                Rule::requiredIf($request->promocode_status === 'yes'),
                'numeric',
                'min:1'
                ],
 
                'shipping_fees'=>"required",
                "tax"=>"required",
                "total_amount"=>"required",
                "Payment_method"=>'required|in:1,2,3,4' // 1 myfatoorah 2 wallet 3 Cod
                ]);
            
           if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }
    
            $user_id= $request->user()->id;
    
           $request_data=(object)[
            'user_id'=>$user_id,
            
            'delivery_address'=>$request->delivery_address,
            "total_mrp"=>$request->total_mrp,
            "discount_mrp"=>$request->discount_mrp,
            'promocode_status'=>$request->promocode_status,
            "promocode_id"=>$request->promocode_id??null,
            "promocode_value"=>$request->promocode_value??null,
            'shipping_fees'=>$request->shipping_fees,
            "tax"=>$request->tax,
            "total_amount"=>$request->total_amount,
            'giftcard_id'=>$request->giftcard_id??null,
            'giftcard_amount'=>$request->giftcard_amount??null,
            'Payment_method'=>$request->Payment_method
           ];
    
            $data=$this->UserOrderService->User_Create_Order($request_data);
    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }
    
            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
        
        }




    public function apply_gift_card(Request $request){

        try{

            $validate = Validator::make($request->all(), [
                // 'order_id'=>'required|exists:orders,order_id',
                'giftCardNo' => 'required',
                "giftCardPin"=>"required",

                ]);
            
           if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }
    
            $user_id= $request->user()->id;
    
           $request_data=(object)[
            'user_id'=>$user_id,
            // 'order_id'=>$request->order_id,
            'giftCardNo'=>$request->giftCardNo,
            'giftCardPin'=>$request->giftCardPin,
           ];
    
            $data=$this->UserOrderService->User_Apply_giftCardInOrder($request_data);
    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }
    
            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
        
        }


    public function product_order_complete_payment(Request $request){

        try{

            $validate = Validator::make($request->all(), [
                'order_id'=>'required|exists:orders,order_id',
                'payment_status' => 'required|in:1,2', //  0 pending 1 paid 2 cancel or reject 3 refund
                ]);
            
           if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }
    
         $user_id= $request->user()->id;

           $request_data=(object)[
            'user_id'=>$user_id,
            'order_id'=>$request->order_id,
            'payment_status'=>$request->payment_status
            ];
    
            $data=$this->UserOrderService->productOrderComplete($request_data);
    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }
    
            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
        
        }

        


        public function All_order(Request $request){

            try{
    
             $user_id= $request->user()->id;

    
               $request_data=(object)[
                'user_id'=>$user_id,
                'search'=>$request->search,
                'filter'=>$request->filter,
                ];
        
                $data=$this->UserOrderService->AllOrderDetailsNew($request_data);
        
                if(isset($data['status']) && $data['status']=='error' ){
                    return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
                }
        
                return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
        
        
            } catch (\Exception $e) {
                return [
                    'status' => 'error',
                    'message' => 'Failed to update seller status: ' . $e->getMessage(),
                    'data' => []
                ];
            }
            
            }

            

    public function single_order_summary(Request $request){

        try{

            $validate = Validator::make($request->all(), [
                'order_id'=>'required|exists:orders,order_id',
                ]);
            
           if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }
    
         $user_id= $request->user()->id;

           $request_data=(object)[
            'user_id'=>$user_id,
            'order_id'=>$request->order_id,
            ];
    
            $data=$this->UserOrderService->singleOrderDetails($request_data);
    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }
    
            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
        
        }



        public function waller_balance(Request $request){

        try{
          
         $user_id= $request->user()->id;

           $request_data=(object)[
            'user_id'=>$user_id,
            ];
    
            $data=$this->UserOrderService->userBalanceget($request_data);
    
            if(isset($data['status']) && $data['status']=='error' ){
                return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
            }
    
            return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
    
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }

        }

        




public function cancelled_single_product(Request $request){

    $user_id= $request->user()->id;

    $validate = Validator::make($request->all(), [
        'order_id'=>'required|exists:orders,id',
              
        ]);
            
    if($validate->fails()){
       return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $request_data=(object) [
    'user_id'=>$user_id,
    "order_id"=>$request->order_id
    ];

    $data=$this->UserOrderService->cancelledSingleProduct($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    

}




public function get_reject_reason(Request $request){

    $user_id= $request->user()->id;

    $validate = Validator::make($request->all(), [
            'type' =>'required|in:1,2,3' // 	1 - exchange, 2 - return, 3 - cancel	
            ]);
            
    if($validate->fails()){
       return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

     $request_data=(object) [
    'user_id'=>$user_id,
    "type"=>$request->type
    ];


    $data=$this->UserOrderService->getRejectReasonDetails($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    

}


public function return_product_after_delivered(Request $request){

    $user_id= $request->user()->id;

    $validate = Validator::make($request->all(), [
        'order_id'=>'required|exists:orders,id',
        'orderdetails_id'=>'required|exists:orderdetails,id',
        "return_reason" =>"required",
        "type"=>'required:in:1,2' // 1 for return  2 for Exchange 
              
        ]);
            
    if($validate->fails()){
       return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

    $request_data=(object) [
    'user_id'=>$user_id,
    "order_id"=>$request->order_id,
    "orderdetails_id"=>$request->orderdetails_id,
    "return_reason"=>$request->return_reason,
    "return_image"=>$request->return_image??null    
    ];

    $data=$this->UserOrderService->returnProductAfterdelivery($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}


public function exchange_product_after_delivered(Request $request){

    $user_id= $request->user()->id;

    $validate = Validator::make($request->all(), [
        'order_id'=>'required|exists:orders,id',
        'orderdetails_id'=>'required|exists:orderdetails,id',
        "exchange_reason" =>"required",
        "new_size"=>"required",
        "type"=>'required:in:1,2' //  1 for return  2 for Exchange 
        ]);
            
    if($validate->fails()){
       return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

    $request_data=(object) [
    'user_id'=>$user_id,
    "order_id"=>$request->order_id,
    "orderdetails_id"=>$request->orderdetails_id,
    "exchange_reason"=>$request->exchange_reason,
    "new_size"=>$request->new_size??null    
    ];

    $data=$this->UserOrderService->exchnageProductAfterdelivery($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    

}





public function return_exchange_product_after_delivered(Request $request){

    try{

    $user_id= $request->user()->id;


      $validate = Validator::make($request->all(), [
        'order_id'=>'required|exists:orders,id',
        'orderdetails_id'=>'required|exists:orderdetails,id',
        "type"=>'required:in:1,2' // 1 for return  2 for Exchange 
              
        ]);
            
    if($validate->fails()){
       return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

    // if the product is Apply return State
    if($request->type==1){

        $validate = Validator::make($request->all(), [
        "return_reason" =>"required",         
        ]);
            
    if($validate->fails()){
       return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

    }

    // if the product is Apply to Exchange State  
if($request->type==2){

    $validate = Validator::make($request->all(), [
        "exchange_reason" =>"required",
        "new_size"=>"required", 
    ]);
            
    if($validate->fails()){
       return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }
}

 $request_data=(object) [
    'user_id'=>$user_id,
    "order_id"=>$request->order_id,
    "orderdetails_id"=>$request->orderdetails_id,

    "return_reason"=>$request->return_reason??null, // return side
    "return_image"=>$request->return_image??null,  // // return side  

    "exchange_reason"=>$request->exchange_reason??null, // exchange side
    "new_size"=>$request->new_size??null  ,   // exchange side
    'type'=>$request->type

    ];



    $data=$this->UserOrderService->ReturnAndExchnageProductAfterdelivery($request_data);

     if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    



}
 catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Failed to update seller status: ' . $e->getMessage(),
            'data' => []
        ];
    }



}



public function product_rating(Request $request){

    $user_id= $request->user()->id;

    $validate = Validator::make($request->all(), [
        'order_id'=>'required|exists:orders,id',
        'orderdetails_id'=>'required|exists:orderdetails,id',
        "product_rating"=>'required|numeric|min:0|max:5',
        "store_rating"=>"required|numeric|min:0|max:5",
          
        ]);
            
    if($validate->fails()){
       return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }



    $request_data=(object) [
    'user_id'=>$user_id,
    "order_id"=>$request->order_id,
    "orderdetails_id"=>$request->orderdetails_id,
    "product_rating"=>$request->product_rating??null,
    "product_review"=>$request->product_review??null,
    "product_image"=>$request->product_image??null,
    "store_rating"=>$request->store_rating??null,
    "store_review"=>$request->store_review??null,
    "store_image"=>$request->store_image??null,
    ];

    $data=$this->UserOrderService->ProductReviewAndRating($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    
}







}