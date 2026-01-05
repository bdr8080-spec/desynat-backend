<?php
namespace App\Services;

use App\Models\Deal;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;


class DealManagementService
{
   
    public function getActiveDeals($request)
    {
        try {
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = Deal::with([
                'category_details',
                'subCategory_details'
            ]);
            $query->whereDate('to', '>=', Carbon::today());

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('name_english', 'like', '%' . $search . '%');
            }

            $query->orderBy('id', 'desc');

            $deal_details = $query->paginate($limit);

            if ($deal_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Deal found',
                    'data' =>  []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Active Deals fetched successfully',
                'data' => $deal_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch brands: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getExpireDeals($request)
    {
        try {
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = Deal::with([
                'category_details',
                'subCategory_details'
            ]);
            $query->whereDate('to', '<=', Carbon::today());

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('name_english', 'like', '%' . $search . '%');
            }

            $query->orderBy('id', 'desc');

            $deal_details = $query->paginate($limit);

            if ($deal_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Deal found',
                    'data' =>  []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Active Deals fetched successfully',
                'data' => $deal_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch brands: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    public function blockUnblockDeal($dealId)
    {
        try {
            $deal = Deal::find($dealId);

            if (!$deal) {
                return [
                    'status' => 'error',
                    'message' => 'Deal not found',
                    'data' => []
                ];
            }

            $deal->status = $deal->status == 1 ? 0 : 1;
            $deal->save();

            $message = $deal->status == 1
                        ? 'Deal Unblocked successfully'
                        : 'Deal Blocked successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $deal
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update deal status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function addDeal(Request $request)
    {

        try {
            $deal = Deal::create([
                'image' => $request->image,
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'discount' => $request->discount,
                'from' => $request->from,
                'to' => $request->to,
            ]);

            return [
                'status' => 'success',
                'message' => 'Deal added successfully',
                'data' => $deal
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to add deal',
                'data' => []
            ];
        }
    }

    public function updateDeal(Request $request, $dealId)
    {
        $deal = Deal::find($dealId);

        if (!$deal) {
            return [
                'status' => 'error',
                'message' => 'Deal not found',
                'data' => []
            ];
        }

        try {
            $deal->update([
                'image' => $request->image,
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'discount' => $request->discount,
                'from' => $request->from,
                'to' => $request->to,  
            ]);

            return [
                'status' => 'success',
                'message' => 'Deal updated successfully',
                'data' => $deal
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update deal',
                'data' => []
            ];
        }
    }

    public function deleteDeal($dealId)
    {
        try {
            $deal = Deal::find($dealId);

            if (!$dealId) {
                return [
                    'status' => 'error',
                    'message' => 'Deal not found',
                    'data' => []
                ];
            }
            $deal->delete();

            return [
                'status' => 'success',
                'message' => 'Deal deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete deal',
                'data' => []
            ];
        }
    }





    

            
        


}
    