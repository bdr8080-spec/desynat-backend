<?php
namespace App\Services;

use App\Models\Tax;
use App\Models\country;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;


class ShippingTaxService
{
   
    public function getCountriesWithTaxShipping()
    {
        try {
            $countries = country::with('tax_info','shipping_info')->orderBy('name', 'asc')->get();

            if ($countries->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No countries found',
                    'data' => (object)[]
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

    public function addTax(Request $request)
    {

        try {

            $tax = Tax::updateOrCreate(
                ['country_id' => $request->country_id], 
                ['tax' => $request->tax]              
            );

            return [
                'status' => 'success',
                'message' => 'Tax Updated successfully',
                'data' => $tax
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update tax',
                'data' => (object)[]
            ];
        }
    }

    public function addShippingFee(Request $request)
    {

        try {

            $fee = ShippingCharge::create([
                'country_id' => $request->country_id,
                'range_from' => $request->range_from,
                'range_to' => $request->range_to,
                'shipping_fee' => $request->shipping_fee,
            ]);


            return [
                'status' => 'success',
                'message' => 'Shipping Charge Added successfully',
                'data' => $fee
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to create shipping cahrge',
                'data' => (object)[]
            ];
        }
    }

    public function updateShippingFee(Request $request)
    {
        try {
            $id = $request->shipping_charge_id;
            $fee = ShippingCharge::find($id);

            if (!$fee) {
                return [
                    'status' => 'error',
                    'message' => 'Shipping Charge not found',
                    'data' => (object)[]
                ];
            }

            $fee->update([
                'range_from' => $request->range_from,
                'range_to' => $request->range_to,
                'shipping_fee' => $request->shipping_fee,
            ]);

            return [
                'status' => 'success',
                'message' => 'Shipping Charge updated successfully',
                'data' => $fee
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update shipping charge: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }

    public function blockUnblockSeller($sellerId)
    {
        try {
            $seller = seller::find($sellerId);

            if (!$seller) {
                return [
                    'status' => 'error',
                    'message' => 'Seller not found',
                    'data' => (object)[]
                ];
            }

            $previousStatus = $seller->is_block; 
            $seller->is_block = $seller->is_block == 0 ? 1 : 0;
            $seller->save();

            $message = $seller->is_block == 1
                ? 'Seller Blocked Successfully'
                : 'Seller Unblocked Successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $seller
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update seller status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function deletePlan($planId)
    {
        try {
            $plan = Plan::find($planId);

            if (!$plan) {
                return [
                    'status' => 'error',
                    'message' => 'Plan not found',
                    'data' => (object)[]
                ];
            }
            $plan->delete();

            return [
                'status' => 'success',
                'message' => 'Plan deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete plan',
                'data' => (object)[]
            ];
        }
    }








    

            
        


}
    