<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\ShippingTaxService;
use App\Models\country;

 
class ShippingController extends Controller
{

    public function __construct(ShippingTaxService $ShippingTaxService)
    {
        $this->ShippingTaxService = $ShippingTaxService;
    }

    public function shippingManagement(Request $request){
        $getCountries = $this->ShippingTaxService->getCountriesWithTaxShipping($request)['data'];
        //dd($getTaxes);
        return view('admin.shipping-charge-tax-management.index',compact('getCountries'));
    }

    public function manageShippingCharges(Request $request, $id){
        $country = country::find($id);
        $shippingCharges = $this->ShippingTaxService->getShippingChargesByCountryId($id)['data'];
        $defaultShippingCharge = $this->ShippingTaxService->getDefaultShippingFeeByCountryId($id)['data'];
        //dd($shippingCharges);
        return view('admin.shipping-charge-tax-management.manage',compact('country','shippingCharges','defaultShippingCharge'));
    }

    public function update_tax(Request $request)
    {
        $request->validate([
            'tax' => 'required',
            'tax_id'          => 'required|integer',
        ]);

        try {
            $updatedTax = $this->ShippingTaxService->updateTaxById($request);
            $message = $updatedTax['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $updatedTax
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update tax',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteShippingCharge($id)
    {
        $result = $this->ShippingTaxService->deleteShippingCharge($id);

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

    public function updateShippingChargeStatus($shippingId)
    {
        $data = $this->ShippingTaxService->blockUnblockShipping($shippingId);
        //dd($result);

        if ($data['status'] == 'success') {
            $statusText = $data['data']->status == 1 ? 'Activated' : 'Deactivated';
  
            return response()->json([
                'success' => true,
                'status' => $data['data']->status,
                'message' => $data['message']
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400); 
        }
    }

    public function add_shipping_fee(Request $request)
    {
        $result = $this->ShippingTaxService->addShippingFee($request);

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

    public function update_shipping_fee(Request $request)
    {
        $result = $this->ShippingTaxService->updateShippingFee($request);

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

    public function update_default_shipping_fee(Request $request)
    {
        $result = $this->ShippingTaxService->updateDefaultShippingFee($request);

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