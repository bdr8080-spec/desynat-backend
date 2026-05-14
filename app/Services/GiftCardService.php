<?php
namespace App\Services;

use App\Models\GiftCard;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class GiftCardService
{
   
    public function getGiftCard($request)
    {
        try {
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = GiftCard::query();

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('name_english', 'like', '%' . $search . '%');
            }

            $query->orderBy('id', 'desc');

            $data = $query->paginate($limit);

            if ($data->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('service_messages.no_data_found'),
                    'data' =>  []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Git Cards fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch gift cards: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    public function changeGiftCardStatus($giftCardId)
    {
        try {
            $data = GiftCard::find($giftCardId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Gift Card not found',
                    'data' => []
                ];
            }

            $data->status = $data->status == 1 ? 0 : 1;
            $data->save();

            $message = $data->status == 1
                ? __('service_messages.gift_card_category_unblocked_successfully')
                : __('service_messages.gift_card_category_blocked_successfully');

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch gift card: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function addGiftCard(Request $request)
    {

        try {
            $data = GiftCard::create([
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'image' => $request->image,
            ]);

            return [
                'status' => 'success',
                'message' => __('service_messages.gift_card_category_added_successfully'),
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

    public function updateGiftCard(Request $request)
    {
        $id = $request->giftCard_id;
        $data = GiftCard::find($id);

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
                'message' => __('service_messages.gift_card_category_updated_successfully'),
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update gift card',
                'data' => []
            ];
        }
    }

    public function deleteGiftCard($giftCardId)
    {
        try {
            $data = GiftCard::find($giftCardId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Gift Card not found',
                    'data' => []
                ];
            }
            $data->delete();

            return [
                'status' => 'success',
                'message' => __('service_messages.gift_card_category_deleted_successfully'),
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete gift card',
                'data' => []
            ];
        }
    }





    

            
        


}
    