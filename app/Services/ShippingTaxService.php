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

    public function getShippingChargesByCountryId($id)
    {
        try {
            $countries = country::with('tax_info','shipping_info')->where('id',$id)->orderBy('name', 'asc')->get();

            if ($countries->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No countries found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Country details fetched successfully',
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

    public function blockUnblockShipping($shippingId)
    {
        try {
            $data = ShippingCharge::find($shippingId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Shipping Fee not found',
                    'data' => (object)[]
                ];
            }

            $previousStatus = $data->status; 
            $data->status = $data->status == 0 ? 1 : 0;
            $data->save();

            $message = $data->status == 1
                ? 'Shipping Fee Unblocked Successfully'
                : 'Shipping Fee blocked Successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update shipping fee status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function deleteShippingCharge($shippingId)
    {
        try {
            $data = ShippingCharge::find($shippingId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Shipping Fee not found',
                    'data' => (object)[]
                ];
            }
            $data->delete();

            return [
                'status' => 'success',
                'message' => 'Shipping Fee deleted successfully',
                'data' => null
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete shipping fee',
                'data' => (object)[]
            ];
        }
    }

    public function updateTaxById(Request $request)
    {
        try {
            $tax = Tax::findOrFail($request->tax_id); 
            
            $tax->tax = $request->tax;
            $tax->save();

            return [
                'status' => 'success',
                'message' => 'Tax updated successfully',
                'data' => $tax
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update tax: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }









    

            
        


}
    