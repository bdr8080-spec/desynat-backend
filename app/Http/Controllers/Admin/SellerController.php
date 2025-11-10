<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\seller;
use Validator;
use App\Http\Controllers\CommonController;
use App\Services\SellerManagementService;
use App\Services\CountryService;
 
class SellerController extends Controller
{
    public function __construct(SellerManagementService $SellerManagementService, CountryService $CountryService)
    {
        $this->SellerManagementService = $SellerManagementService;
        $this->CountryService = $CountryService;
    }

    public function sellerManagement(Request $request){
        $countries = $this->CountryService->getCountries()['data'];
        $newSellers = $this->SellerManagementService->getNewSellers($request)['data'];
        $approvedSellers = $this->SellerManagementService->getApprovedSellers($request)['data'];
        $rejectedSellers = $this->SellerManagementService->getRejectedSellers($request)['data'];
        //dd($newSellers);
        return view('admin.seller-management.index',compact('newSellers','countries','approvedSellers','rejectedSellers'));
    }

    public function blockUnblockSeller($sellerId)
    {
        $result = $this->SellerManagementService->blockUnblockSeller($sellerId);

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

    public function acceptSeller($sellerId)
    {
        $result = $this->SellerManagementService->acceptSeller($sellerId);

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

    public function rejectSeller(Request $request, $sellerId)
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

        $result = $this->SellerManagementService->rejectSeller($sellerId, $rejectReason, $rejectType);

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