<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\AffiliatedUserManagementService;
use App\Services\CountryService;

 
class AffiliateUserController extends Controller
{

    public function __construct(AffiliatedUserManagementService $AffiliatedUserManagementService, CountryService $CountryService)
    {
        $this->AffiliatedUserManagementService = $AffiliatedUserManagementService;
        $this->CountryService = $CountryService;
    }

    public function affiliateUserManagement(Request $request){
        $countries = $this->CountryService->getCountries()['data'];
        $newUsers = $this->AffiliatedUserManagementService->getNewAffiliatedUers($request)['data'];
        //dd($newUsers);
        $approvedUsers = $this->AffiliatedUserManagementService->getApprovedAffiliatedUers($request)['data'];
        $rejectedUsers = $this->AffiliatedUserManagementService->getRejectedAffiliatedUers($request)['data'];
        return view('admin.affiliate-user-management.index',compact('countries','newUsers','approvedUsers','rejectedUsers'));
    }

    public function blockUnblockAffiliateUser($userId)
    {
        $result = $this->AffiliatedUserManagementService->blockUnblockAffiliateUser($userId);

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

    public function acceptAffiliateUser($userId)
    {
        $result = $this->AffiliatedUserManagementService->acceptAffiliateUser($userId);

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

    public function rejectAffiliateUser(Request $request, $userId)
    {
        $rejectReason = $request->input('reject_reason');
        $rejectType = $request->input('reject_type');

        if (empty($rejectReason)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reject reason is required.'
            ], 400);
        }
        if (empty($rejectType)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reject type is required.'
            ], 400);
        }

        $result = $this->AffiliatedUserManagementService->rejectAffiliateUser($userId, $rejectReason, $rejectType);

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