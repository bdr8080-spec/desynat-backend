<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\ReasonService;

 
class ReasonController extends Controller
{
   public function __construct(ReasonService $ReasonService)
    {
        $this->ReasonService = $ReasonService;
    }

    public function reasonManagement(Request $request){
        $request->merge(['type' => 1]);
        $exchangeReason = $this->ReasonService->getReason($request)['data'];
        //dd($exchangeReason);

        $request->merge(['type' => 2]);
        $returnReason = $this->ReasonService->getReason($request)['data'];

        $request->merge(['type' => 3]);
        $cancelReason = $this->ReasonService->getReason($request)['data'];
        return view('admin.reason-management.index',compact('exchangeReason','returnReason','cancelReason'));
    }

    public function blockUnblockReason($reasonId)
    {
        $result = $this->ReasonService->changeReasonStatus($reasonId);

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

    public function deleteReason($id)
    {
        $result = $this->ReasonService->deleteReason($id);

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

    public function add_reason(Request $request)
    {
        $request->validate([
            'reason_english' => 'required|string',
            'reason_arabic' => 'required|string',
            'type'          => 'required|integer|in:1,2,3',
        ]);

        try {

            $reason = $this->ReasonService->createReason($request);
            $message = $reason['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $reason
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create reason',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update_reason(Request $request)
    {
        $request->validate([
            'reason_english' => 'required|string',
            'reason_arabic' => 'required|string',
            'reason_id'          => 'required|integer',
        ]);

        $reasonId = $request->input('reason_id');

        try {
            $updatedReason = $this->ReasonService->updateReason($request, $reasonId);
            $message = $updatedReason['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $updatedReason
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update reason',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    



}