<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\WithdrawRequestManagementService;
use App\Services\CountryService;

 
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
                'country_name' => $request->country_name??null,
                'from_date' => $request->from_date??null,
                'to_date' => $request->to_date??null,
                'search' => $request->search??null,
            ];
         $newRequest = $this->WithdrawRequestManagementService->getWithdrawRequests($request_data)['data'];
         //dd($newRequest);
         $request_data1 = (object)[
                'req_type' => '1',
                'limit' => $request->limit??null,
                'country_id' => $request->country_id1??null,
                'from_date' => $request->from_date1??null,
                'to_date' => $request->to_date1??null,
                'search' => $request->search1??null,
            ];
        $approvedRequest = $this->WithdrawRequestManagementService->getWithdrawRequests($request_data1)['data'];
        $request_data2 = (object)[
                'req_type' => '2',
                'limit' => $request->limit??null,
                'country_id' => $request->country_id2??null,
                'from_date' => $request->from_date2??null,
                'to_date' => $request->to_date2??null,
                'search' => $request->search2??null,
            ];
         $rejectedRequest = $this->WithdrawRequestManagementService->getWithdrawRequests($request_data2)['data'];
        return view('admin.affiliate-withdraw-management.index',compact('countries','newRequest','approvedRequest','rejectedRequest'));
    }


    public function rejectWithdrawRequestr(Request $request, $reqId)
    {
        $rejectReason = $request->input('reject_reason');

        if (empty($rejectReason)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reject reason is required.'
            ], 400);
        }

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





    



}