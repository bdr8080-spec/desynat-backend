<?php
namespace App\Services;


use App\Models\WithdrawRequest;
use App\Models\orderdetail;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class WithdrawRequestManagementService
{
   
    public function getWithdrawRequests($request_data)
    {
        try {
            $limit = (int)($request_data->limit); 

            $query = WithdrawRequest::with('bank_details','affiliate__details.address_details.country_details')
                        ->where('type', '1')
                        ->where('admin_verify', $request_data->req_type); 

            if (!empty($request_data->country)) {
                $query->whereHas('affiliate__details.address_details.country_details', function ($q) use ($request_data) {
                    $q->where('name', $request_data->country);
                });
            }

            if (!empty($request_data->status)) {
                if ($request_data->status == 1) {
                    $query->where('admin_verify', '1');
                } elseif ($request_data->status == 2) {
                    $query->where('admin_verify', '2');
                }
            }

            if (!empty($request_data->from_date) && !empty($request_data->to_date)) {
                $query->whereBetween('created_at', [
                    $request_data->from_date . ' 00:00:00',
                    $request_data->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request_data->from_date)) {
                $query->whereDate('created_at', '>=', $request_data->from_date);
            } elseif (!empty($request_data->to_date)) {
                $query->whereDate('created_at', '<=', $request_data->to_date);
            }

            if (!empty($request_data->search)) {
                $search = $request_data->search;

                $query->where(function ($q) use ($search) {

                    $q->where('request_id', 'like', "%{$search}%")
                    ->orWhereHas('affiliate__details', function ($q2) use ($search) {
                        $q2->where('full_name', 'like', "%{$search}%");
                    });

                });
            }

            $req_details = $query->orderBy('id', 'desc')->paginate($limit);

            $req_details->getCollection()->transform(function ($item) {

            $item->total_earning = number_format(
                    orderdetail::where('affiliate_id', $item->user_id)
                        ->where('delivery_status', '3')
                        ->sum('affiliate_commission'),
                    2,
                    '.',
                    ''
                );

                return $item;
            });


            if ($req_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No withdrraw requests found',
                    'data' => (object) []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Withdraw Requests fetched successfully',
                'data' => $req_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch withdraw requests: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function rejectWithdrawRequest($reqId, $rejectReason)
    {
        try {
            $data = WithdrawRequest::find($reqId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Withdraw Request not found',
                    'data' => (object) []
                ];
            }

            if ($data->admin_verify != '0') {

                if ($data->admin_verify == '1') {
                    $msg = 'Withdraw request already approved';
                } elseif ($data->admin_verify == '2') {
                    $msg = 'Withdraw request already rejected';
                } else {
                    $msg = 'Withdraw request already processed';
                }

                return [
                    'status' => 'error',
                    'message' => $msg,
                    'data' => (object)[]
                ];
            }

                $data->admin_verify = '2';
               $data->reject_reason = $rejectReason;
               $data->save();

               if ($data->type == 1) {
                    $receiverType = 4;
                } elseif ($data->type == 2) {
                    $receiverType = 2;
                } elseif ($data->type == 3) {
                    $receiverType = 3;
                }

               CreateNotification([
                    'sender_id' => 1,
                    'sender_type' => 1,

                    'receiver_id' => $data->user_id,
                    'receiver_type' => $receiverType,

                    'title_english' => 'Withdraw Request',
                    'title_arabic' => 'طلب السحب',

                    'description_english' => "Your withdraw request with request id: #{$data->request_id} is rejected, Reason:{$rejectReason}",
                    'description_arabic' => "تم رفض طلب السحب الخاص بك برقم الطلب: #{$data->request_id}، السبب: {$rejectReason}",

                    'notification_type' => 'withdraw_req_rejected'
                ]);

            return [
                'status' => 'success',
                'message' => 'Withdraw Request Rejected Successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to reject request: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }

    public function approveWithdrawRequest($request)
    {
        try {
            $data = WithdrawRequest::find($request->req_id);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Withdraw Request not found',
                    'data' => (object) []
                ];
            }

            if ($data->admin_verify != '0') {

                if ($data->admin_verify == '1') {
                    $msg = 'Withdraw request already approved';
                } elseif ($data->admin_verify == '2') {
                    $msg = 'Withdraw request already rejected';
                } else {
                    $msg = 'Withdraw request already processed';
                }

                return [
                    'status' => 'error',
                    'message' => $msg,
                    'data' => (object)[]
                ];
            }

                $data->admin_verify = '1';
                // $data->transaction_id = $request->transaction_id;
                // $data->payment_status = $request->payment_status;
                $data->save();

                if ($data->type == 1) {
                    $receiverType = 4;
                } elseif ($data->type == 2) {
                    $receiverType = 2;
                } elseif ($data->type == 3) {
                    $receiverType = 3;
                }

               CreateNotification([
                    'sender_id' => 1,
                    'sender_type' => 1,

                    'receiver_id' => $data->user_id,
                    'receiver_type' => $receiverType,

                    'title_english' => 'Withdraw Request',
                    'title_arabic' => 'طلب السحب',

                    'description_english' => "Your withdraw request with request id: #{$data->request_id} is approved",
                    'description_arabic' => "تمت الموافقة على طلب السحب الخاص بك برقم الطلب: #{$data->request_id}",

                    'notification_type' => 'withdraw_req_approved'
                ]);

            return [
                'status' => 'success',
                'message' => 'Withdraw Request Approved Successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to approve request: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }



    // public function transferWithdrawRequest($request_data)
    // {
    //     try {

    //         $withdraw = WithdrawRequest::with('bank_details','affiliate__details.country_details')
    //             ->where('id',$request_data->withdraw_request_id)
    //             ->where('admin_verify',0)
    //             ->first();

    //         if(!$withdraw){
    //             return [
    //                 'status'=>'error',
    //                 'message'=>'Withdraw request not found'
    //             ];
    //         }

    //         $bank = $withdraw->bank_details;

    //         if(!$bank || empty($bank->iban)){
    //             return [
    //                 'status'=>'error',
    //                 'message'=>'Bank IBAN not available'
    //             ];
    //         }

    //         $payload = [

    //             "NotificationOption"=>"LNK",

    //             "CustomerName"=>$bank->account_holder_name,

    //             "DisplayCurrencyIso"=>$withdraw->affiliate__details->country_details->currency_code ?? "KWD",

    //             "MobileCountryCode"=>$withdraw->affiliate__details->country_code ?? "+965",

    //             "CustomerMobile"=>$withdraw->affiliate__details->mobile ?? "0000000000",

    //             "CustomerEmail"=>$withdraw->affiliate__details->email,

    //             "InvoiceValue"=>$withdraw->amount,

    //             "CallBackUrl"=>route('admin.payment.success'),

    //             "ErrorUrl"=>route('admin.payment.error'),

    //             "CustomerReference"=>$withdraw->request_id,

    //             "Language"=>"en"
    //         ];

    //         $base_url = config('myfatoorah.test_mode')
    //             ? 'https://apitest.myfatoorah.com'
    //             : 'https://api.myfatoorah.com';

    //         $response = Http::withHeaders([
    //             'Authorization'=>'Bearer '.config('myfatoorah.api_key'),
    //             'Content-Type'=>'application/json'
    //         ])->post($base_url.'/v2/SendPayment',$payload);

    //         $result = $response->json();

    //         Log::info('MyFatoorah SendPayment',$result);

    //         if(!$response->successful() || $result['IsSuccess']==false){
    //             return [
    //                 'status'=>'error',
    //                 'message'=>$result['Message'] ?? 'Payment failed'
    //             ];
    //         }

    //         return [
    //             'status' => 'success',
    //             'message' => 'Redirecting to payment gateway',
    //             'payment_url' => $result['Data']['InvoiceURL']
    //         ];

    //     }catch(\Exception $e){

    //         Log::error('Withdraw Transfer Error',$e->getMessage());

    //         return [
    //             'status'=>'error',
    //             'message'=>$e->getMessage()
    //         ];
    //     }
    // }

    // public function verifyWithdrawPayment($key,$keyType='PaymentId')
    // {
    //     try{

    //         $base_url = config('myfatoorah.test_mode')
    //             ? 'https://apitest.myfatoorah.com'
    //             : 'https://api.myfatoorah.com';

    //         $response = Http::withHeaders([
    //             'Authorization'=>'Bearer '.config('myfatoorah.api_key'),
    //             'Content-Type'=>'application/json'
    //         ])->post($base_url.'/v2/GetPaymentStatus',[
    //             'Key'=>$key,
    //             'KeyType'=>$keyType
    //         ]);

    //         $result = $response->json();

    //         if(!$response->successful() || !isset($result['Data'])){
    //             return [
    //                 'status'=>'error',
    //                 'message'=>'Payment verification failed'
    //             ];
    //         }

    //         $customerReference = $result['Data']['CustomerReference'] ?? null;

    //         $transaction = $result['Data']['InvoiceTransactions'][0] ?? null;

    //         $transactionId = $transaction['TransactionId'] ?? null;
    //         $transactionStatus = $transaction['TransactionStatus'] ?? null;

    //         if(!$customerReference){
    //             return [
    //                 'status'=>'error',
    //                 'message'=>'Invalid payment response'
    //             ];
    //         }

    //         //  PAYMENT SUCCESS
    //         if($transactionStatus == 'Succss' || $transactionStatus == 'Success'){

    //             WithdrawRequest::where('request_id',$customerReference)
    //                 ->update([
    //                     'transaction_id'=>$transactionId,
    //                     'payment_status'=>1,
    //                     'admin_verify'=>1
    //                 ]);

    //             return [
    //                 'status'=>'success',
    //                 'message'=>'Payment completed successfully'
    //             ];
    //         }

    //         //  PAYMENT FAILED
    //         WithdrawRequest::where('request_id',$customerReference)
    //             ->update([
    //                 'transaction_id'=>$transactionId,
    //                 'payment_status'=>2,
    //                 'admin_verify'=>1
    //             ]);

    //         return [
    //             'status'=>'error',
    //             'message'=>'Payment failed'
    //         ];

    //     }catch(\Exception $e){

    //         return [
    //             'status'=>'error',
    //             'message'=>$e->getMessage()
    //         ];
    //     }
    // }

    
    public function transferWithdrawRequest($request_data)
    {
        try {

            $withdraw = WithdrawRequest::with(
                'bank_details',
                'affiliate__details.country_details'
            )
            ->where('id',$request_data->withdraw_request_id)
           // ->where('admin_verify','0')
            ->first();

            // if(!$withdraw){
            //     return [
            //         'status'=>'error',
            //         'message'=>'Withdraw request not found'
            //     ];
            // }
            if ($withdraw->admin_verify == '1') {
                return [
                    'status' => 'error',
                    'message' => 'Withdraw request already paid'
                ];
            }

            if ($withdraw->admin_verify == '2') {
                return [
                    'status' => 'error',
                    'message' => 'Withdraw request was already rejected'
                ];
            }

            $bank = $withdraw->bank_details;

            if(!$bank || empty($bank->iban)){
                return [
                    'status'=>'error',
                    'message'=>'Bank IBAN not available'
                ];
            }

            $affiliate = $withdraw->affiliate__details;

            $supplierCode = "AFF_" . $affiliate->id;

            /* STEP 1 : CREATE SUPPLIER */
            $this->createSupplier($affiliate,$bank,$supplierCode);

            /* STEP 2 : SEND PAYMENT */
            return $this->sendSupplierPayment($withdraw,$supplierCode);

        }
        catch(\Exception $e){

            Log::error("Withdraw payout error : ".$e->getMessage());

            return [
                'status'=>'error',
                'message'=>$e->getMessage()
            ];
        }
    }

    private function createSupplier($affiliate,$bank,$supplierCode)
    {

        $base_url = config('myfatoorah.test_mode')
            ? 'https://apitest.myfatoorah.com'
            : 'https://api.myfatoorah.com';

        $payload = [

            "SupplierName" => $bank->account_holder_name,

            "SupplierCode" => $supplierCode,

            "Email" => $affiliate->email,

            "MobileCountryCode" => $affiliate->country_code ?? "+965",

            "Mobile" => $affiliate->mobile,

            "BankAccount" => $bank->iban

        ];

        $response = Http::withHeaders([
            'Authorization'=>'Bearer '.config('myfatoorah.api_key'),
            'Content-Type'=>'application/json'
        ])->post($base_url.'/v2/InitiateSupplier',$payload);

        $result = $response->json();

        Log::info('MyFatoorah Supplier Create',$result);
    }

    private function sendSupplierPayment($withdraw,$supplierCode)
    {

        $base_url = config('myfatoorah.test_mode')
            ? 'https://apitest.myfatoorah.com'
            : 'https://api.myfatoorah.com';

        $currency = $withdraw->affiliate__details
            ->country_details
            ->currency_code ?? "KWD";

        $payload = [

            "SupplierCode" => $supplierCode,

            "Amount" => $withdraw->amount,

            "CurrencyIso" => $currency,

            "Description" => "Affiliate Withdraw ".$withdraw->request_id

        ];

        $response = Http::withHeaders([
            'Authorization'=>'Bearer '.config('myfatoorah.api_key'),
            'Content-Type'=>'application/json'
        ])->post($base_url.'/v2/SendSupplierPayment',$payload);

        $result = $response->json();

        Log::info('MyFatoorah Supplier Payment',$result);

        if(!$response->successful() || ($result['IsSuccess'] ?? false) == false){

            return [
                'status'=>'error',
                'message'=>$result['Message'] ?? 'Payment failed'
            ];
        }

        $transactionId = $result['Data']['TransactionId'] ?? null;

        WithdrawRequest::where('id',$withdraw->id)
        ->update([
            'transaction_id'=>$transactionId,
            'payment_status'=>1,
            'admin_verify'=>1
        ]);

        return [
            'status'=>'success',
            'message'=>'Withdraw paid successfully',
            'transaction_id'=>$transactionId
        ];
    }




    














}
    