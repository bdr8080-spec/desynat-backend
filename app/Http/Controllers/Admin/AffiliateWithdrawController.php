<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\WithdrawRequestManagementService;
use App\Services\CountryService;
use Illuminate\Support\Facades\Log;

 
class AffiliateWithdrawController extends Controller
{

    public function __construct(WithdrawRequestManagementService $WithdrawRequestManagementService, CountryService $CountryService)
    {
        $this->WithdrawRequestManagementService = $WithdrawRequestManagementService;
        $this->CountryService = $CountryService;
    }

    public function affiliateWithdrawRequestManagement(Request $request){
         $countries = $this->CountryService->getCountries()['data'];
         $request_data = (object)[
                'req_type' => '0',
                'limit' => $request->limit??null,
                'country' => $request->country??null,
                'from_date' => $request->from_date??null,
                'to_date' => $request->to_date??null,
                'search' => $request->search??null,
            ];
         $newRequest = $this->WithdrawRequestManagementService->getWithdrawRequests($request_data)['data'];
         //dd($newRequest);
         $request_data1 = (object)[
                'req_type' => '1',
                'limit' => $request->limit??null,
                'country' => $request->country1??null,
                'from_date' => $request->from_date1??null,
                'to_date' => $request->to_date1??null,
                'search' => $request->search1??null,
                'status' => $request->status??null,
            ];
        $approvedRequest = $this->WithdrawRequestManagementService->getWithdrawRequests($request_data1)['data'];
        $request_data2 = (object)[
                'req_type' => '2',
                'limit' => $request->limit??null,
                'country' => $request->country2??null,
                'from_date' => $request->from_date2??null,
                'to_date' => $request->to_date2??null,
                'search' => $request->search2??null,
            ];
         $rejectedRequest = $this->WithdrawRequestManagementService->getWithdrawRequests($request_data2)['data'];
        return view('admin.affiliate-withdraw-management.index',compact('countries','newRequest','approvedRequest','rejectedRequest'));
    }


    public function rejectWithdrawRequest(Request $request, $reqId)
    {


        $result = $this->WithdrawRequestManagementService->rejectWithdrawRequest($reqId, $rejectReason);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }

    public function approveWithdrawRequest(Request $request)
    {
            $validate = Validator::make($request->all(), [
            'req_id' => 'required|exists:withdraw_requests,id',
            // 'transaction_id' => 'required',
            // 'payment_status' => 'required|in:1,2',//1-paid,2-fail
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $result = $this->WithdrawRequestManagementService->rejectWithdrawRequest($request);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }


    // public function transferWithdrawRequest(Request $request)
    // {
    //     $request_data = (object)[
    //         'withdraw_request_id' => $request->withdraw_request_id
    //     ];

    //     $result = $this->WithdrawRequestManagementService
    //         ->transferWithdrawRequest($request_data);

    //     if ($result['status'] === 'error') {

    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $result['message'] ?? 'Something went wrong'
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'payment_url' => $result['payment_url']
    //     ]);
    // }



    // public function paymentSuccess(Request $request)
    // {
    //     //Log::info('MyFatoorah Success Callback', $request->all());

    //     $paymentId = $request->paymentId;

    //     if (!$paymentId) {
    //         return redirect()->route('admin.affiliateWithdrawRequestManagement')
    //             ->with('error','Payment ID not found');
    //     }

    //     $result = $this->WithdrawRequestManagementService
    //         ->verifyWithdrawPayment($paymentId,'PaymentId');

    //     if ($result['status'] === 'success') {
    //         return redirect()->route('admin.affiliateWithdrawRequestManagement')
    //             ->with('success',$result['message']);
    //     }

    //     return redirect()->route('admin.affiliateWithdrawRequestManagement')
    //         ->with('error',$result['message']);
    // }

    // public function paymentError(Request $request)
    // {
    //     $paymentId = $request->paymentId ?? null;

    //     if($paymentId){

    //         $this->WithdrawRequestManagementService
    //             ->verifyWithdrawPayment($paymentId,'PaymentId');
    //     }

    //     return redirect()->route('admin.affiliateWithdrawRequestManagement')
    //         ->with('error','Payment failed or cancelled.');
    // }

    public function transferWithdrawRequest(Request $request)
    {
        $request_data = (object)[
            'withdraw_request_id' => $request->withdraw_request_id
        ];

        $result = $this->WithdrawRequestManagementService->transferWithdrawRequest($request_data);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message'],
            'transaction_id' => $result['transaction_id']
        ]);
    }





    



}