<?php
namespace App\Services;

use App\Models\AffiliateCommission;
use App\Models\country;
use Illuminate\Http\Request;


class AffiliateCommissionService
{
   
    public function getCountriesWithAffiliateCommission()
    {
        try {
            $countries = country::with('affiliate_commission_info')->orderBy('name', 'asc')->get();

            if ($countries->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No countries found',
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Countries fetched successfully',
                'data' => $countries
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch countries: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function addAffiliateCommission(Request $request)
    {

        try {

            $tax = AffiliateCommission::updateOrCreate(
                ['country_id' => $request->country_id], 
                ['commission' => $request->commission]              
            );

            return [
                'status' => 'success',
                'message' => 'Commission Updated successfully',
                'data' => $tax
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update commission',
                'data' => []
            ];
        }
    }

    public function updateAffiliateCommissionByID(Request $request)
    {
        try {
            $banner = AffiliateCommission::find($request->commission_id);

            if (!$banner) {
                return [
                    'status' => 'error',
                    'message' => 'Affiliate Commission not found',
                    'data' => []
                ];
            }

            $banner->update([
                'commission' => $request->commission,
            ]);

            return [
                'status' => 'success',
                'message' => 'Commission updated successfully',
                'data' => $banner
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update commission',
                'data' => []
            ];
        }
    }














    

            
        


}
    