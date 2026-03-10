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
        //dd(123);
        // $countries = $this->CountryService->getCountries()['data'];
        // $newUsers = $this->WithdrawRequestManagementService->getNewAffiliatedUers($request)['data'];
        // //dd($newUsers);
        // $approvedUsers = $this->WithdrawRequestManagementService->getApprovedAffiliatedUers($request)['data'];
        // $rejectedUsers = $this->WithdrawRequestManagementService->getRejectedAffiliatedUers($request)['data'];
        return view('admin.affiliate-withdraw-management.index');
    }


    // public function rejectAffiliateUser(Request $request, $userId)
    // {
    //     $rejectReason = $request->input('reject_reason');
    //     $rejectType = $request->input('reject_type');

    //     if (empty($rejectReason)) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Reject reason is required.'
    //         ], 400);
    //     }
    //     if (empty($rejectType)) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Reject type is required.'
    //         ], 400);
    //     }

    //     $result = $this->AffiliatedUserManagementService->rejectAffiliateUser($userId, $rejectReason, $rejectType);

    //     if ($result['status'] === 'error') {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $result['message']
    //         ], 400);
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => $result['message']
    //     ], 200);
    // }





    



}