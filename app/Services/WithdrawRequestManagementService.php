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

            $query = WithdrawRequest::with('bank_details','affiliate__details.country_details')
                        ->where('type', '1')
                        ->where('admin_verify', $request_data->req_type); 

            if (!empty($request_data->country_id)) {
                $query->whereHas('affiliate__details.country_details', function ($q) use ($request_data) {
                    $q->where('id', $request_data->country_id);
                });
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
                $data->transaction_id = $request->transaction_id;
                $data->payment_status = $request->payment_status;
                $data->save();

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
    //                     ->where('id', $request_data->withdraw_request_id)
    //                     ->where('admin_verify', '0')
    //                     ->first();

    //         if (!$withdraw) {
    //             return [
    //                 'status' => 'error',
    //                 'message' => 'Withdraw request not found or already processed',
    //                 'data' => (object)[]
    //             ];
    //         }

    //         $bank = $withdraw->bank_details;

    //         if (!$bank || empty($bank->iban)) {
    //             return [
    //                 'status' => 'error',
    //                 'message' => 'Bank IBAN not available',
    //                 'data' => (object)[]
    //             ];
    //         }

    //         $amount = $withdraw->amount;

    //         $payload = [
    //             "NotificationOption" => "LNK",
    //             "CustomerName" => $bank->account_holder_name,
    //             "DisplayCurrencyIso" => $withdraw->affiliate__details->country_details->currency_code ?? "KWD",
    //             "MobileCountryCode" => $withdraw->affiliate__details->country_code ?? "+965",
    //             "CustomerMobile" => $withdraw->affiliate__details->mobile ?? "0000000000",
    //             "CustomerEmail" => $withdraw->affiliate__details->email,
    //             "InvoiceValue" => $amount,
    //             "CallBackUrl" => url('/api/myfatoorah/success'),
    //             "ErrorUrl" => url('/api/myfatoorah/error'),
    //             "CustomerReference" => $withdraw->request_id,
    //             "Language" => "en"
    //         ];

    //         $base_url = config('myfatoorah.test_mode')
    //             ? 'https://apitest.myfatoorah.com'
    //             : 'https://api.myfatoorah.com';

    //         $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . config('myfatoorah.api_key'),
    //             'Content-Type' => 'application/json'
    //         ])->post($base_url . '/v2/SendPayment', $payload);

    //         $result = $response->json();

    //         Log::info('MyFatoorah Withdraw Transfer', [
    //             'withdraw_id' => $withdraw->id,
    //             'payload' => $payload,
    //             'response' => $result
    //         ]);

    //         if (!$response->successful() || !isset($result['IsSuccess']) || $result['IsSuccess'] == false) {

    //             return [
    //                 'status' => 'error',
    //                 'message' => $result['Message'] ?? 'Transfer failed',
    //                 'data' => $result
    //             ];
    //         }

    //         $withdraw->admin_verify = 1;
    //         $withdraw->save();

    //         return [
    //             'status' => 'success',
    //             'message' => 'Commission transferred successfully',
    //             'data' => $result
    //         ];

    //     } catch (\Exception $e) {

    //         Log::error('Withdraw Transfer Error', [
    //             'error' => $e->getMessage()
    //         ]);

    //         return [
    //             'status' => 'error',
    //             'message' => 'Transfer failed: ' . $e->getMessage(),
    //             'data' => (object)[]
    //         ];
    //     }
    // }




    














}
    