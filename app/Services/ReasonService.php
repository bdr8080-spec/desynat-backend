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
                    'message' => __('service_messages.no_data_found'),
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

            switch ($reason->type) {
                case 1:
                    $message = $reason->status == 1
                        ? __('service_messages.exchange_reason_unblocked_successfully')
                        : __('service_messages.exchange_reason_blocked_successfully');
                    break;

                case 2:
                    $message = $reason->status == 1
                        ? __('service_messages.return_reason_unblocked_successfully')
                        : __('service_messages.return_reason_blocked_successfully');
                    break;

                case 3:
                    $message = $reason->status == 1
                        ? __('service_messages.cancel_reason_unblocked_successfully')
                        : __('service_messages.cancel_reason_blocked_successfully');
                    break;

                default:
                    $message = $reason->status == 1
                        ? __('service_messages.reason_unblocked_successfully')
                        : __('service_messages.reason_blocked_successfully');
            }

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

            switch ($reason->type) {
                case 1:
                    $message = __('service_messages.exchange_reason_created_successfully');
                    break;

                case 2:
                    $message = __('service_messages.return_reason_created_successfully');
                    break;

                case 3:
                    $message = __('service_messages.cancel_reason_created_successfully');
                    break;

                default:
                    $message = __('service_messages.reason_created_successfully');
            }

            return [
                'status' => 'success',
                'message' => $message,
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

            switch ($reason->type) {
                case 1:
                    $message = __('service_messages.exchange_reason_updated_successfully');
                    break;

                case 2:
                    $message = __('service_messages.return_reason_updated_successfully');
                    break;

                case 3:
                    $message = __('service_messages.cancel_reason_updated_successfully');
                    break;

                default:
                    $message = __('service_messages.reason_updated_successfully');
            }

            return [
                'status' => 'success',
                'message' => $message,
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

            switch ($reason->type) {
                case 1:
                    $message = __('service_messages.exchange_reason_deleted_successfully');
                    break;

                case 2:
                    $message = __('service_messages.return_reason_deleted_successfully');
                    break;

                case 3:
                    $message = __('service_messages.cancel_reason_deleted_successfully');
                    break;

                default:
                    $message = __('service_messages.reason_deleted_successfully');
            }

            // Delete the reason
            $reason->delete();

            return [
                'status' => 'success',
                'message' => $message,
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
    