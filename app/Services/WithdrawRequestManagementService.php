<?php
namespace App\Services;


use App\Models\WithdrawRequest;
use App\Models\orderdetail;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class WithdrawRequestManagementService
{
    public function getSellerPayouts($request_data)
    {
        try {
            $query = WithdrawRequest::with([
                'bank_details',
                'seller__details.store_info',
                'seller__details.country_details',
            ])
                ->where('type', '3');

            if ($request_data->req_type !== null && $request_data->req_type !== '') {
                $query->where('admin_verify', $request_data->req_type);
            }

            if (!empty($request_data->seller_id)) {
                $query->where('user_id', $request_data->seller_id);
            }

            if (!empty($request_data->countryId)) {
                $query->whereHas('seller__details.store_info', function ($storeQuery) use ($request_data) {
                    $storeQuery->where('country', $request_data->countryId);
                });
            }

            if (!empty($request_data->from_date) && !empty($request_data->to_date)) {
                $query->whereBetween('created_at', [
                    $request_data->from_date . ' 00:00:00',
                    $request_data->to_date . ' 23:59:59',
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
                        ->orWhereHas('seller__details', function ($sellerQuery) use ($search) {
                            $sellerQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%")
                                ->orWhereHas('store_info', function ($storeQuery) use ($search) {
                                    $storeQuery->where('store_name', 'like', "%{$search}%");
                                });
                        });
                });
            }

            $requests = $query->orderByDesc('id')->paginate((int) $request_data->limit);

            return [
                'status' => 'success',
                'message' => $requests->isEmpty() ? 'No seller withdraw requests found' : 'Seller withdraw requests fetched successfully',
                'data' => $requests,
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch seller withdraw requests: ' . $e->getMessage(),
                'data' => [],
            ];
        }
    }

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
                    $msg = __('Service_messages.withdraw_request_already_approved');
                } elseif ($data->admin_verify == '2') {
                    $msg = __('Service_messages.withdraw_request_already_rejected');
                } else {
                    $msg = __('Service_messages.withdraw_request_already_processed');
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
                'message' => __('Service_messages.withdraw_request_rejected_successfully'),
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
                    $msg = __('Service_messages.withdraw_request_already_approved');
                } elseif ($data->admin_verify == '2') {
                    $msg = __('Service_messages.withdraw_request_already_rejected');
                } else {
                    $msg = __('Service_messages.withdraw_request_already_processed');
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
                'message' => __('Service_messages.withdraw_request_approved_successfully'),
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

public function transferSellerCommission($request)
{
    try {

        $withdraw = orderdetail::with([
            'order_details',
            'product_details',
            'store_info'
        ])
        ->find($request->orderdetail_id);


        if (!$withdraw) {

            return [
                'status'=>'error',
                'message'=>'Order not found.'
            ];
        }


        if ($withdraw->payment_status !== 1 && $withdraw->delivery_status !== 3 ) {

            return [
                'status'=>'error',
                'message'=>'order not paid or delivered.'
            ];
        }

        $amount = $withdraw->amount - $withdraw->admin_commission;

        if ($withdraw->amount <= 0) {

            return [
                'status'=>'error',
                'message'=>'Invalid transfer amount.'
            ];
        }

        
        // $bank = $withdraw->bank_details;


        // if (!$bank || empty($bank->iban)) {

        //     return [
        //         'status'=>'error',
        //         'message'=>'Affiliate bank IBAN not available.'
        //     ];
        // }


        $affiliate = $withdraw->product_details->seller_id;


        if (!$affiliate) {

            return [
                'status'=>'error',
                'message'=>'Affiliate not found.'
            ];
        }


        if (empty($affiliate->supplier_code)) {


            $supplierResponse = $this->createSupplier(
                $affiliate,
                $bank
            );


            if ($supplierResponse['status'] == 'error') {

                return $supplierResponse;

            }


            $affiliate->update([
                'supplier_code' => (int)$supplierResponse['supplier_code']
            ]);

            $affiliate->refresh();


        }



        if (empty($affiliate->supplier_code)) {

            return [
                'status'=>'error',
                'message'=>'Supplier code not available.'
            ];

        }


        DB::beginTransaction();



        $affiliate->refresh();

        Log::info('Supplier Code Before Transfer', [
            'supplier_code' => $affiliate->supplier_code
        ]);



        $paymentResponse = $this->sendSupplierPayment(
            $withdraw,
            $affiliate->supplier_code
        );



        if ($paymentResponse['status']=='error') {

            DB::rollBack();

            return $paymentResponse;

        }



        // $withdraw->admin_verify = 1;

        // $withdraw->payment_status = 1;

        // $withdraw->transaction_id =
        //     $paymentResponse['transaction_id'] ?? null;


        // $withdraw->payment_response =
        //     json_encode($paymentResponse);


        $withdraw->save();



        DB::commit();



        return [

            'status'=>'success',

            'message'=>'Amount transferred successfully.',

            'data'=>[

                'transaction_id'=>$withdraw->transaction_id

            ]

        ];



    } catch(\Exception $e) {


        if (DB::transactionLevel() > 0) {

            DB::rollBack();

        }


        Log::error('Affiliate withdraw error', [

            'message'=>$e->getMessage(),

            'line'=>$e->getLine(),

            'file'=>$e->getFile()

        ]);


        return [

            'status'=>'error',

            'message'=>$e->getMessage()

        ];

    }
}

    
    public function transferWithdrawRequest($request)
{
    try {

        $withdraw = WithdrawRequest::with([
            'bank_details',
            'affiliate__details.country_details'
        ])
        ->find($request->withdraw_request_id);


        if (!$withdraw) {

            return [
                'status'=>'error',
                'message'=>'Withdraw request not found.'
            ];
        }


        if ($withdraw->admin_verify == 0) {

            return [
                'status'=>'error',
                'message'=>'Withdraw request not approved by admin.'
            ];
        }


        if ($withdraw->admin_verify == 2) {

            return [
                'status'=>'error',
                'message'=>'Withdraw request rejected.'
            ];
        }


        if ($withdraw->amount <= 0) {

            return [
                'status'=>'error',
                'message'=>'Invalid withdrawal amount.'
            ];
        }


        $bank = $withdraw->bank_details;


        if (!$bank || empty($bank->iban)) {

            return [
                'status'=>'error',
                'message'=>'Affiliate bank IBAN not available.'
            ];
        }


        $affiliate = $withdraw->affiliate__details;


        if (!$affiliate) {

            return [
                'status'=>'error',
                'message'=>'Affiliate not found.'
            ];
        }


        if (empty($affiliate->supplier_code)) {


            $supplierResponse = $this->createSupplier(
                $affiliate,
                $bank
            );


            if ($supplierResponse['status'] == 'error') {

                return $supplierResponse;

            }


            $affiliate->update([
                'supplier_code' => (int)$supplierResponse['supplier_code']
            ]);

            $affiliate->refresh();


            Log::info('Supplier Code Saved', [
                'affiliate_id' => $affiliate->id,
                'supplier_code' => $affiliate->supplier_code
            ]);

        }



        if (empty($affiliate->supplier_code)) {

            return [
                'status'=>'error',
                'message'=>'Supplier code not available.'
            ];

        }


        DB::beginTransaction();



        $affiliate->refresh();

        Log::info('Supplier Code Before Transfer', [
            'supplier_code' => $affiliate->supplier_code
        ]);



        $paymentResponse = $this->sendSupplierPayment(
            $withdraw,
            $affiliate->supplier_code
        );



        if ($paymentResponse['status']=='error') {

            DB::rollBack();

            return $paymentResponse;

        }



        $withdraw->admin_verify = 1;

        $withdraw->payment_status = 1;

        $withdraw->transaction_id =
            $paymentResponse['transaction_id'] ?? null;


        // $withdraw->payment_response =
        //     json_encode($paymentResponse);


        $withdraw->save();



        DB::commit();



        return [

            'status'=>'success',

            'message'=>'Withdraw transferred successfully.',

            'data'=>[

                'transaction_id'=>$withdraw->transaction_id

            ]

        ];



    } catch(\Exception $e) {


        if (DB::transactionLevel() > 0) {

            DB::rollBack();

        }


        Log::error('Affiliate withdraw error', [

            'message'=>$e->getMessage(),

            'line'=>$e->getLine(),

            'file'=>$e->getFile()

        ]);


        return [

            'status'=>'error',

            'message'=>$e->getMessage()

        ];

    }
}

    private function createSupplier($affiliate,$bank)
{
    $baseUrl = config('myfatoorah.test_mode')
        ? 'https://apitest.myfatoorah.com'
        : 'https://api.myfatoorah.com';


    $payload = [

        'SupplierName' =>
            $bank->account_holder_name,

        'Email' =>
            $affiliate->email,

        'Mobile' =>
            $affiliate->mobile,

        'MobileCountryCode' =>
            $affiliate->country_code ?? '+965',

        'IBAN' =>
            $bank->iban

    ];


    Log::info('MyFatoorah Create Supplier Request', [
        'url'=>$baseUrl.'/v2/CreateSupplier',
        'payload'=>$payload
    ]);


    $response = Http::timeout(60)
        ->withHeaders([

            'Authorization'=>
                'Bearer '.config('myfatoorah.api_key'),

            'Content-Type'=>
                'application/json'

        ])
        ->post(
            $baseUrl.'/v2/CreateSupplier',
            $payload
        );


    $result = $response->json();


    Log::info('MyFatoorah Create Supplier Response', [
        'status'=>$response->status(),
        'response'=>$result
    ]);



    if(
        !$response->successful()
        ||
        ($result['IsSuccess'] ?? false) == false
    ){

        return [

            'status'=>'error',

            'message'=>
                $result['Message']
                ??
                'Supplier creation failed.',

            'response'=>$result

        ];

    }


    return [
        'status'=>'success',
        'supplier_code'=>(int)$result['Data']['SupplierCode'],
        'response'=>$result
    ];
}

    private function sendSupplierPayment($withdraw, $supplierCode)
{
    Log::info('MyFatoorah Environment', [
        'test_mode' => config('myfatoorah.test_mode'),
        'base_url' => config('myfatoorah.test_mode')
            ? 'https://apitest.myfatoorah.com'
            : 'https://api.myfatoorah.com',
    ]);
    $baseUrl = config('myfatoorah.test_mode')
        ? 'https://apitest.myfatoorah.com'
        : 'https://api.myfatoorah.com';


    $payload = [

        "SupplierCode" => (int)$supplierCode,

        "TransferAmount" => (float)$withdraw->amount,

        "TransferType" => "push",

        "InternalNotes" => "Affiliate Withdraw ".$withdraw->request_id

    ];


    Log::info('MyFatoorah Transfer Request', [
        'url'=>$baseUrl.'/v2/TransferBalance',
        'payload'=>$payload
    ]);


    $response = Http::withOptions([
        'curl' => [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ],
    ])
    ->timeout(60)
    ->connectTimeout(30)
    ->withHeaders([
        'Authorization' => 'Bearer '.config('myfatoorah.api_key'),
        'Content-Type' => 'application/json'
    ])
    ->post(
        $baseUrl.'/v2/TransferBalance',
        $payload
    );


    $result = $response->json();


    Log::info('MyFatoorah Transfer Response', [
        'status'=>$response->status(),
        'response'=>$result
    ]);


    if(
        !$response->successful()
        ||
        ($result['IsSuccess'] ?? false) == false
    ){

        return [

            'status'=>'error',

            'message'=>$result['Message'] ?? 'Transfer failed',

            'response'=>$result

        ];

    }


    return [

        'status'=>'success',

        'transaction_id'=>$result['Data']['InvoiceId'] ?? null,

        'response'=>$result

    ];
}




    














}
    