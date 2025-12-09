<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\PromocodeService;
use App\Services\CountryService;

 
class PromoCodeController extends Controller
{

    public function __construct(PromocodeService $PromocodeService, CountryService $CountryService)
    {
        $this->PromocodeService = $PromocodeService;
        $this->CountryService = $CountryService;
    }

    public function promoCodeManagement(Request $request){
        $promoCodes = $this->PromocodeService->getPromoCodes($request)['data'];
        $countries = $this->CountryService->getCountries()['data'];
        return view('admin.promocode-management.index',compact('promoCodes','countries'));
    }

    public function deletePromocode($id)
    {
        $result = $this->PromocodeService->deletePromoCode($id);

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

    public function updatePromoCodeStatus($promoCodeId)
    {
        $data = $this->PromocodeService->changePromoCodeStatus($promoCodeId);
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

    public function add_promocode(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'description_english' => 'required|string',
            'description_arabic' => 'required|string',
            'applicable_for' => 'required|in:1,2', // 1-first order, 2-all order
            'discount_percent' => 'required|integer',
            'min_order_value' => 'required|integer',
            'upto_discount' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first()
            ], 422);
        }

        try {
            $result = $this->PromocodeService->addPromoCode($request);

            if ($result['status'] === 'error') {
                return response()->json([
                    'status' => 'error',
                    'message' => $result['message']
                ], 400);
            }

            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
                'data' => $result['data']
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update_promocode(Request $request)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'promocode_id' => 'required|exists:promocodes,id',
            'country_id' => 'required|exists:countries,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'description_english' => 'required|string',
            'description_arabic' => 'required|string',
            'applicable_for' => 'required|in:1,2', // 1-first order, 2-all order
            'discount_percent' => 'required|integer',
            'min_order_value' => 'required|integer',
            'upto_discount' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first()
            ], 422);
        }

        try {
            $result = $this->PromocodeService->updatePromoCode($request);

            if ($result['status'] === 'error') {
                return response()->json([
                    'status' => 'error',
                    'message' => $result['message']
                ], 400);
            }

            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
                'data' => $result['data']
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addPromocode(Request $request){
         $countries = $this->CountryService->getCountries()['data'];
        return view('admin.promocode-management.add',compact('countries'));

    }




    



}