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

            $query = Promocode::query();

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('name_english', 'like', '%' . $search . '%');
            }

            $query->orderBy('id', 'desc');

            $data = $query->paginate($limit);

            if ($data->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Promocode found',
                    'data' => (object) []
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
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'image' => $request->image,
            ]);

            return [
                'status' => 'success',
                'message' => 'Gift Card created successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to create gift card',
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
                'message' => 'Gift Card not found',
                'data' => []
            ];
        }

        try {
            $data->update([
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'image' => $request->image,  
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
    