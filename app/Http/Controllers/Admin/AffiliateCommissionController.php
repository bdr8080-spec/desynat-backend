<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\AffiliateCommissionService;

 
class AffiliateCommissionController extends Controller
{

    public function __construct(AffiliateCommissionService $AffiliateCommissionService)
    {
        $this->AffiliateCommissionService = $AffiliateCommissionService;
    }

    public function affiliateCommissionManagement(Request $request){
        $commissionData = $this->AffiliateCommissionService->getCountriesWithAffiliateCommission($request)['data'];
        //dd($commissionData);
        return view('admin.affiliate-commission-management.index',compact('commissionData'));
    }

    public function update_affiliate_commission(Request $request)
    {
        $request->validate([
            'commission' => 'required',
            'commission_id'          => 'required|integer',
        ]);

        try {
            $updatedBanner = $this->AffiliateCommissionService->updateAffiliateCommissionByID($request);
            $message = $updatedBanner['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $updatedBanner
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update banner',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    



}