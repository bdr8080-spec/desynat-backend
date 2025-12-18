<?php
namespace App\Services;

use App\Models\Promocode;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class PromocodeService
{
   
    public function getPromoCodes($request)
    {
        try {
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = Promocode::with('country_info');

            if ($request->filled('country_id')) {
                $query->where('country_id', $request->country_id);
            }

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('name_english', 'like', '%' . $search . '%');
            }

            if ($request->filled('from_date')) {
                $query->where('created_at', '>=', $request->from_date);
            }
            if ($request->filled('to_date')) {
                $query->where('created_at', '<=', $request->to_date);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $query->orderBy('id', 'desc');

            $data = $query->paginate($limit);

            if ($data->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Promocode found',
                    'data' =>  []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Promocodes fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch promocode: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }




    public function changePromoCodeStatus($promoCodeId)
    {
        try {
            $data = Promocode::find($promoCodeId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Promocode not found',
                    'data' => []
                ];
            }

            $data->status = $data->status == 1 ? 0 : 1;
            $data->save();

            $message = $data->status == 1
                ? 'Promocode Unblocked Successfully'
                : 'Promocode blocked Successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch promocode: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function addPromoCode(Request $request)
    {

        try {
            $data = Promocode::create([
                'country_id' => $request->country_id,
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'description_english' => $request->description_english,
                'description_arabic' => $request->description_arabic,
                'applicable_for' => $request->applicable_for,
                'discount_percent' => $request->discount_percent,
                'min_order_value' => $request->min_order_value,
                'upto_discount' => $request->upto_discount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return [
                'status' => 'success',
                'message' => 'Promocode added successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to add promocode',
                'data' => []
            ];
        }
    }

    public function updatePromoCode(Request $request)
    {
        $id = $request->promocode_id;
        $data = Promocode::find($id);

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Promocode not found',
                'data' => []
            ];
        }

        try {
            $data->update([
                'country_id' => $request->country_id,
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'description_english' => $request->description_english,
                'description_arabic' => $request->description_arabic,
                'applicable_for' => $request->applicable_for,
                'discount_percent' => $request->discount_percent,
                'min_order_value' => $request->min_order_value,
                'upto_discount' => $request->upto_discount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,  
            ]);

            return [
                'status' => 'success',
                'message' => 'Promocode updated successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update promocode',
                'data' => []
            ];
        }
    }

    public function deletePromoCode($promoCodeId)
    {
        try {
            $data = Promocode::find($promoCodeId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Promocode not found',
                    'data' => []
                ];
            }
            $data->delete();

            return [
                'status' => 'success',
                'message' => 'Promocode deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete promocode',
                'data' => []
            ];
        }
    }





    

            
        


}
    