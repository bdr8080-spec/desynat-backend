<?php
namespace App\Services;

use App\Models\Reason;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class ReasonService
{
   
    public function getReason($request)
    {
        try {
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = Reason::where('type', $request->type);

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('reason_english', 'like', '%' . $search . '%');
            }

            $query->orderBy('id', 'desc');

            $reason_details = $query->paginate($limit);

            if ($reason_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Reason found',
                    'data' => (object) []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Reasons fetched successfully',
                'data' => $reason_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch brands: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    public function changeReasonStatus($reasonId)
    {
        try {
            $reason = Reason::find($reasonId);

            if (!$reason) {
                return [
                    'status' => 'error',
                    'message' => 'Reason not found',
                    'data' => []
                ];
            }

            $reason->status = $reason->status == 1 ? 0 : 1;
            $reason->save();
            $message = $reason->status == 1 ? 'Reason unblock successfully' : 'Reason block successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $reason
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch Reason: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function createReason(Request $request)
    {

        try {
            $reason = Reason::create([
                'reason_english' => $request->reason_english,
                'reason_arabic' => $request->reason_arabic,
                'type' => $request->type,
            ]);

            return [
                'status' => 'success',
                'message' => 'Reason created successfully',
                'data' => $reason
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to create Reason' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function updateReason(Request $request, $reasonId)
    {
        $reason = Reason::find($reasonId);

        if (!$reason) {
            return [
                'status' => 'error',
                'message' => 'Reason not found',
                'data' => (object)[]
            ];
        }

        try {
            $reason->update([
                'reason_english' => $request->reason_english,
                'reason_arabic' => $request->reason_arabic, 
            ]);

            return [
                'status' => 'success',
                'message' => 'Reason updated successfully',
                'data' => $reason
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update reason',
                'data' => (object)[]
            ];
        }
    }

    public function deleteReason($reasonId)
    {
        try {
            $reason = Reason::find($reasonId);

            if (!$reason) {
                return [
                    'status' => 'error',
                    'message' => 'Reason not found',
                    'data' => (object)[]
                ];
            }
            $reason->delete();

            return [
                'status' => 'success',
                'message' => 'Reason deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete reason',
                'data' => (object)[]
            ];
        }
    }





    

            
        


}
    