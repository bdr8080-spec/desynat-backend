<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use MyFatoorah\Library\MyFatoorah;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use Exception;



Use Auth;
use Validator;
use App\Models\{seller,UserGiftCards,Order,Addtocart,sellerBanner,UserWalletHistory};
use Illuminate\Support\Facades\Cache;
use App\Models\SellerSubcriptionPlanBuy;


class MyFatoorahController extends Controller {

    /**
     * @var array
     */
    public $mfConfig = [];

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Initiate MyFatoorah Configuration
     */
    public function __construct() {
        $this->mfConfig = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Redirect to MyFatoorah Invoice URL
     * Provide the index method with the order id and (payment method id or session id)
     *
     * @return Response
     */
    public function index(request $request,$id) {
        try {

      if($request->type=='addMoneyinWallet'){

         $checkOrder=UserWalletHistory::with('user_details')->where('unique_id', $id)->first();

            //For example: pmid=0 for MyFatoorah invoice or pmid=1 for Knet in test mode
            $paymentId = request('pmid') ?: 0;
            $sessionId = request('sid') ?: null;
            $orderId  = $id ?: 147;

            $order_array=[
                'amount'=>$checkOrder->amount,
                'CustomerName'       => $checkOrder->user_details->full_name,
                'InvoiceValue'       => $checkOrder->amount,
                'CustomerEmail'      => $checkOrder->user_details->email,
                'MobileCountryCode'  => $checkOrder->user_details->country_code,
                'CustomerMobile'     => $checkOrder->user_details->mobile,
                'Language'           => 'en',
                'CustomerReference'  => $orderId,
            ];
            
        }

     if($request->type=='bannerBuy'){

         $checkOrder=sellerBanner::with('seller_details')->where('order_id', $id)->first();

            //For example: pmid=0 for MyFatoorah invoice or pmid=1 for Knet in test mode
            $paymentId = request('pmid') ?: 0;
            $sessionId = request('sid') ?: null;
            $orderId  = $id ?: 147;

            $order_array=[
                'amount'=>$checkOrder->price,
                'CustomerName'       => $checkOrder->seller_details->first_name. $checkOrder->seller_details->last_name ,
                'InvoiceValue'       => $checkOrder->price,
                'CustomerEmail'      => $checkOrder->seller_details->email,
                'MobileCountryCode'  => $checkOrder->seller_details->country_code,
                'CustomerMobile'     => $checkOrder->seller_details->mobile,
                'Language'           => 'en',
                'CustomerReference'  => $orderId,
            ];
            
        }


     if($request->type=='order'){

         $checkOrder=Order::with('User_details')->where('order_id', $id)->first();

            //For example: pmid=0 for MyFatoorah invoice or pmid=1 for Knet in test mode
            $paymentId = request('pmid') ?: 0;
            $sessionId = request('sid') ?: null;
            $orderId  = $id ?: 147;

            $order_array=[
                'amount'=>$checkOrder->total_amount,
                'CustomerName'       => $checkOrder->user_details->full_name ,
                'InvoiceValue'       => $checkOrder->total_amount,
                'CustomerEmail'      => $checkOrder->user_details->email,
                'MobileCountryCode'  => $checkOrder->user_details->country_code,
                'CustomerMobile'     => $checkOrder->user_details->mobile,
                'Language'           => 'en',
                'CustomerReference'  => $orderId,
            ];
            
        }


        if($request->type=='giftCard'){
                
    
            $giftCardDetails= UserGiftCards::with('gift_details','user_details')->where('order_id',$id)->first();
        
            //For example: pmid=0 for MyFatoorah invoice or pmid=1 for Knet in test mode
            $paymentId = request('pmid') ?: 0;
            $sessionId = request('sid') ?: null;
            $orderId  = $id ?: 147;

            $order_array=[
                'amount'=>$giftCardDetails->amount,
                'CustomerName'       => $giftCardDetails->user_details->full_name ,
                'InvoiceValue'       => $giftCardDetails->amount,
                'CustomerEmail'      => $giftCardDetails->user_details->email,
                'MobileCountryCode'  => $giftCardDetails->user_details->country_code,
                'CustomerMobile'     => $giftCardDetails->user_details->mobile,
                'Language'           => 'en',
                'CustomerReference'  => $orderId,
            ];
            
        }


        if($request->type=='subcription'){
                
        $subcription_order=SellerSubcriptionPlanBuy::with('seller_details')->where('transaction_id',$id)->first();

        SellerSubcriptionPlanBuy::where('seller_id', $subcription_order->seller_id)
                    ->where('status', '1')
                    ->where('payment_status', '1')
                    ->where('is_expired', '0')
                    ->update([
                        'status' => '0',
                        'is_expired' => '1'
                    ]);

        
            //For example: pmid=0 for MyFatoorah invoice or pmid=1 for Knet in test mode
            $paymentId = request('pmid') ?: 0;
            $sessionId = request('sid') ?: null;
            $orderId  = $subcription_order->transaction_id ?: 147;


            $order_array=[
                'amount'=>$subcription_order->amount,
                'CustomerName'       => $subcription_order->seller_details->first_name.' '.$subcription_order->seller_details->last_name  ,
                'InvoiceValue'       => $subcription_order->amount,
                'CustomerEmail'      => $subcription_order->seller_details->email,
                'MobileCountryCode'  => $subcription_order->seller_details->country_code,
                'CustomerMobile'     => $subcription_order->seller_details->mobile,
                'Language'           => 'en',
                'CustomerReference'  => $orderId,
            ];

        }


            $curlData = $this->getPayLoadData($order_array);

            $mfObj   = new MyFatoorahPayment($this->mfConfig);


            $payment = $mfObj->getInvoiceURL($curlData, $paymentId, $orderId, $sessionId);
            

            return redirect($payment['invoiceURL']);
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return response()->json(['IsSuccess' => 'false', 'Message' => $exMessage]);
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Example on how to map order data to MyFatoorah
     * You can get the data using the order object in your system
     * 
     * @param int|string $orderId
     * 
     * @return array
     */
    private function getPayLoadData($orderId = null) {
        $callbackURL = route('myfatoorah.callback');


        //You can get the data using the order object in your system
        $order = $this->getTestOrderData($orderId); // send order array

        return [
            'CustomerName'       => $orderId['CustomerName'],
            'InvoiceValue'       => $orderId['amount'],
            'DisplayCurrencyIso' => $order['currency'],
            'CustomerEmail'      => $orderId['CustomerEmail'],
            'CallBackUrl'        => $callbackURL,
            'ErrorUrl'           => $callbackURL,
            'MobileCountryCode'  => $orderId['MobileCountryCode'],
            'CustomerMobile'     => $orderId['CustomerMobile'],
            'Language'           => 'en',
            'CustomerReference'  => $orderId['CustomerReference'],
            'SourceInfo'         => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION
        ];
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Get MyFatoorah Payment Information
     * Provide the callback method with the paymentId
     * 
     * @return Response
     */
    public function callback() {
        try {
            $paymentId = request('paymentId');

            $mfObj = new MyFatoorahPaymentStatus($this->mfConfig);
            $data  = $mfObj->getPaymentStatus($paymentId, 'PaymentId');

            $message = $this->getTestMessage($data->InvoiceStatus, $data->InvoiceError);

            $response = ['IsSuccess' => true, 'Message' => $message, 'Data' => $data];




            // Check Order Table Data 

            $transaction_id=$data->CustomerReference;
            $onlineReturnTransaction_id=$data->InvoiceReference;


            $subcription_order=SellerSubcriptionPlanBuy::with('seller_details')->where('transaction_id',$transaction_id)->first();

            if($subcription_order){

            if($data->InvoiceStatus=='Paid'){
                
              $transaction_id=$data->CustomerReference;
              $subcription_data =SellerSubcriptionPlanBuy::with('seller_details')->where('transaction_id',$transaction_id)->first();
           
              if($subcription_data){

                $subcription_data->update(['payment_status'=>'1','status'=>'1','online_transaction_id'=>$data->InvoiceId]);
                
                session()->flash('success', 'You have successfully purchased a plan!');
                // return  redirect()->to('seller/dashboard?payment=yes');
                
                $url="seller/single-plans/$subcription_data->plan_id?payment=yes";

                return  redirect()->to($url);

            }

            }else{

                $url="seller/all-plans?payment=no";
                return  redirect()->to($url);

                // return redirect()->route('seller.all_plans')->with('error','Your Payment is Failed');
            }

        }


        // check gift Card Payment 
            $giftCardDetails= UserGiftCards::with('gift_details','user_details')->where('order_id',$transaction_id)->first();
        
            if($giftCardDetails){

                if($data->InvoiceStatus=='Paid'){
                    $giftCardDetails->update(['payment_status'=>'1','transaction_id'=>$onlineReturnTransaction_id]);
                    $msg="Gift Card Payment Paid Successfully";
                    $url="user/gift-cards?payment=yes&orderid=".$transaction_id;

                }else{
                    
                    $giftCardDetails->update(['payment_status'=>'2','transaction_id'=>$onlineReturnTransaction_id]);
                    $msg="Gift Card Payment Cancelled Successfully";
                    $url="user/gift-cards?payment=no&orderid=".$transaction_id;
                
                }

                
                // return  redirect()->to($url);

                return redirect()->to($url)->with([
                'message' => $msg,
                'status' => $data->InvoiceStatus == 'Paid' ? 'success' : 'error'
                ]);


            }

            // Check Order Payment Code 

            $checkOrderStatus=Order::with('User_details')->where('order_id', $transaction_id)->first();

            if($checkOrderStatus){

                if($data->InvoiceStatus=='Paid'){
                    $checkOrderStatus->update(['payment_status'=>'1','transaction_id'=>$onlineReturnTransaction_id,'payment_id'=> $paymentId]);
                    $msg="Order Payment Paid Successfully";
                    $url="user/order-details/$transaction_id?payment=yes";

                    AddtocartRemoveData($checkOrderStatus->id);
                    OrderGiftCardConditionCheck($checkOrderStatus->id); // order inside Giftcard Check 

                    Order_detailsPaidStatusChange($checkOrderStatus->id,'1'); // order details complete order

                    Addtocart::where('user_id',$checkOrderStatus->user_id)->delete();

                }else{
                    
                    $checkOrderStatus->update(['payment_status'=>'2','transaction_id'=>$onlineReturnTransaction_id,'payment_id'=> $paymentId]);
                    $msg="Order Payment Cancelled Successfully";
                    if ($checkOrderStatus->type == '1') {
                        $url = "user/view-cart?payment=no";
                    } elseif ($checkOrderStatus->type == '2') {
                        $url = "user/chat-details/" . $checkOrderStatus->unique_id . "?payment=no";
                    }
                    
                    // delete order when Payment is failed 

                     delete_Order_Data($checkOrderStatus->id); // Delete order When Payment is failed 
                     
                    // Order_detailsPaidStatusChange($checkOrderStatus->id,'2'); // order details complete order


                }
                
                // return  redirect()->to($url);

                return redirect()->to($url)->with([
                'message' => $msg,
                'status' => $data->InvoiceStatus == 'Paid' ? 'success' : 'error'
                ]);
                
            }

            // Buy Seller banner Online 

            $checkBannerOrderStatus=sellerBanner::with('seller_details')->where('order_id', $transaction_id)->first();


            if($checkBannerOrderStatus){

                if($data->InvoiceStatus=='Paid'){
                    $checkBannerOrderStatus->update(['payment_status'=>'1','transaction_id'=>$onlineReturnTransaction_id]);
                    $msg="Banner Payment Paid Successfully";
                    $url="Seller/show-banner?payment=yes";

                }else{
                    
                    $checkBannerOrderStatus->update(['payment_status'=>'2','transaction_id'=>$onlineReturnTransaction_id]);
                    $msg="Banner Payment Cancelled Successfully";
                    $url="/Seller/show-banner?payment=no";
                }
                
                // return  redirect()->to($url);

                return redirect()->to($url)->with([
                'message' => $msg,
                'status' => $data->InvoiceStatus == 'Paid' ? 'success' : 'error'
                ]);
                
            }

            // Wallet Add to Money Code 

            $CheckAddMoneyInWalletStatus=UserWalletHistory::with('user_details')->where('unique_id', $transaction_id)->first();


            if($CheckAddMoneyInWalletStatus){

                if($data->InvoiceStatus=='Paid'){
                    $CheckAddMoneyInWalletStatus->update(['payment_status'=>'1','transaction_id'=>$onlineReturnTransaction_id]);
                    $msg="Add Money in Wallet Successfully";
                    $url="user/add-wallet-money?payment=yes";

                }else{
                    
                    $CheckAddMoneyInWalletStatus->update(['payment_status'=>'2','transaction_id'=>$onlineReturnTransaction_id]);
                    $msg="Banner Payment Cancelled Successfully";
                    $url="user/add-wallet-money?payment=no";
                }
                
                // return  redirect()->to($url);

                return redirect()->to($url)->with([
                'message' => $msg,
                'status' => $data->InvoiceStatus == 'Paid' ? 'success' : 'error'
                ]);
                
            }




            

        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            $response  = ['IsSuccess' => 'false', 'Message' => $exMessage];
        }
        return response()->json($response);
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Example on how to Display the enabled gateways at your MyFatoorah account to be displayed on the checkout page
     * Provide the checkout method with the order id to display its total amount and currency
     * 
     * @return View
     */
    public function checkout() {
        try {
            //You can get the data using the order object in your system
            $orderId = request('oid') ?: 147;
            $order   = $this->getTestOrderData($orderId);

            //You can replace this variable with customer Id in your system
            $customerId = request('customerId');

            //You can use the user defined field if you want to save card
            $userDefinedField = config('myfatoorah.save_card') && $customerId ? "CK-$customerId" : '';

            //Get the enabled gateways at your MyFatoorah acount to be displayed on checkout page
            $mfObj          = new MyFatoorahPaymentEmbedded($this->mfConfig);
            $paymentMethods = $mfObj->getCheckoutGateways($order['total'], $order['currency'], config('myfatoorah.register_apple_pay'));

            if (empty($paymentMethods['all'])) {
                throw new Exception('noPaymentGateways');
            }

            //Generate MyFatoorah session for embedded payment
            $mfSession = $mfObj->getEmbeddedSession($userDefinedField);

            //Get Environment url
            $isTest = $this->mfConfig['isTest'];
            $vcCode = $this->mfConfig['countryCode'];

            $countries = MyFatoorah::getMFCountries();
            $jsDomain  = ($isTest) ? $countries[$vcCode]['testPortal'] : $countries[$vcCode]['portal'];

            return view('myfatoorah.checkout', compact('mfSession', 'paymentMethods', 'jsDomain', 'userDefinedField'));
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return view('myfatoorah.error', compact('exMessage'));
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Example on how the webhook is working when MyFatoorah try to notify your system about any transaction status update
     */
    public function webhook(Request $request) {
        try {
            //Validate webhook_secret_key
            $secretKey = config('myfatoorah.webhook_secret_key');
            if (empty($secretKey)) {
                return response(null, 404);
            }

            //Validate MyFatoorah-Signature
            $mfSignature = $request->header('MyFatoorah-Signature');
            if (empty($mfSignature)) {
                return response(null, 404);
            }

            //Validate input
            $body  = $request->getContent();
            $input = json_decode($body, true);
            if (empty($input['Data']) || empty($input['EventType']) || $input['EventType'] != 1) {
                return response(null, 404);
            }

            //Validate Signature
            if (!MyFatoorah::isSignatureValid($input['Data'], $secretKey, $mfSignature, $input['EventType'])) {
                return response(null, 404);
            }

            //Update Transaction status on your system
            $result = $this->changeTransactionStatus($input['Data']);

            return response()->json($result);
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return response()->json(['IsSuccess' => false, 'Message' => $exMessage]);
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------
    private function changeTransactionStatus($inputData) {
        //1. Check if orderId is valid on your system.
        $orderId = $inputData['CustomerReference'];

        //2. Get MyFatoorah invoice id
        $invoiceId = $inputData['InvoiceId'];

        //3. Check order status at MyFatoorah side
        if ($inputData['TransactionStatus'] == 'SUCCESS') {
            $status = 'Paid';
            $error  = '';
        } else {
            $mfObj = new MyFatoorahPaymentStatus($this->mfConfig);
            $data  = $mfObj->getPaymentStatus($invoiceId, 'InvoiceId');

            $status = $data->InvoiceStatus;
            $error  = $data->InvoiceError;
        }

        $message = $this->getTestMessage($status, $error);

        //4. Update order transaction status on your system
        return ['IsSuccess' => true, 'Message' => $message, 'Data' => $inputData];
    }

//-----------------------------------------------------------------------------------------------------------------------------------------
    private function getTestOrderData($orderId) {
        return [
            'total'    => 15,
            'currency' => 'KWD'
        ];
    }

//-----------------------------------------------------------------------------------------------------------------------------------------
    private function getTestMessage($status, $error) {
        if ($status == 'Paid') {
            return 'Invoice is paid.';
        } else if ($status == 'Failed') {
            return 'Invoice is not paid due to ' . $error;
        } else if ($status == 'Expired') {
            return $error;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------
}