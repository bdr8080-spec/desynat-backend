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
        return view('admin.shipping-charge-tax-management.manage',compact('country'));
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


    



}