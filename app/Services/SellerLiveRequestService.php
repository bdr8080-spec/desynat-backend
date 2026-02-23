<?php
namespace App\Services;

use App\Models\LiveRequestTimeslot;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;
use App\Models\LiveRequest;


class SellerLiveRequestService
{
   
    public function getTimeslots($request_data)
    {
        try {

            $query = LiveRequestTimeslot::with('country_info')
                ->where('country_id', $request_data->country_id)
                ->whereDate('date', $request_data->date)
                ->where('status','1')
                ->orderBy('id', 'desc');

            $timeslot_details = $query->get();

            if ($timeslot_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Timeslot found',
                    'data' =>  []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Timeslot Details fetched successfully',
                'data' => $timeslot_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch timeslots: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    // public function getLiveRequests($request_data)
    // {
    //     try {
    //         $limit = isset($request_data->limit) ? (int)$request_data->limit : 10;

    //         $query = LiveRequest::with([
    //             'timeslot_details',
    //             'timeslot_details.country_info',
    //             //'seller_details',
    //             //'seller_details.country_details'
    //         ]);
    //         $query->where('seller_id', $request_data->seller_id);

    //         if (!empty($request->from) && empty($request->to)) {
    //             $query->whereDate('created_at', '>=', $request->from);
    //         }

    //         if (empty($request->from) && !empty($request->to)) {
    //             $query->whereDate('created_at', '<=', $request->to);
    //         }

    //         if (!empty($request->from) && !empty($request->to)) {
    //             $query->whereBetween('created_at', [
    //                 $request->from,
    //                 $request->to
    //             ]);
    //         }

    //         $query->orderBy('id', 'desc');

    //         $req_details = $query->paginate($limit);

    //         if ($req_details->isEmpty()) {
    //             return [
    //                 'status' => 'success',
    //                 'message' => 'No Request found',
    //                 'data' =>  (object)[]
    //             ];
    //         }

    //         return [
    //             'status' => 'success',
    //             'message' => 'Requests fetched successfully',
    //             'data' => $req_details
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to fetch request: ' . $e->getMessage(),
    //             'data' => []
    //         ];
    //     }
    // }

    

    public function getLiveRequests($request_data)
    {
        try {
            $limit = isset($request_data->limit) ? (int)$request_data->limit : 10;

            $query = LiveRequest::with([
                'timeslot_details',
                'timeslot_details.country_info',
            ]);

            $query->where('seller_id', $request_data->seller_id);

            if (!empty($request_data->search)) {
                $query->whereHas('timeslot_details', function ($q) use ($request_data) {
                    $q->whereDate('date', $request_data->search);
                });
            }

            if (!empty($request_data->from) && empty($request_data->to)) {
                $query->whereHas('timeslot_details', function ($q) use ($request_data) {
                    $q->whereDate('date', '>=', $request_data->from);
                });
            }

            if (empty($request_data->from) && !empty($request_data->to)) {
                $query->whereHas('timeslot_details', function ($q) use ($request_data) {
                    $q->whereDate('date', '<=', $request_data->to);
                });
            }

            if (!empty($request_data->from) && !empty($request_data->to)) {
                $query->whereHas('timeslot_details', function ($q) use ($request_data) {
                    $q->whereBetween('date', [
                        $request_data->from,
                        $request_data->to
                    ]);
                });
            }

            if (isset($request_data->filter)) {

                //  Pending
                if ($request_data->filter == 1) {
                    $query->where('admin_verify', '0');
                }

                //  Completed (date + to < now)
                if ($request_data->filter == 2) {

                    $now = Carbon::now();

                    $query->whereHas('timeslot_details', function ($q) use ($now) {
                        $q->whereRaw("
                            STR_TO_DATE(
                                CONCAT(date, ' ', `to`),
                                '%Y-%m-%d %h:%i %p'
                            ) < ?
                        ", [$now]);
                    });
                }

                //  Cancelled
                if ($request_data->filter == 3) {
                    $query->where('admin_verify', '3');
                }

                //  Rejected
                if ($request_data->filter == 4) {
                    $query->where('admin_verify', '2');
                }
            }

            $query->orderBy('id', 'desc');

            $req_details = $query->paginate($limit);

            if ($req_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Request found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Requests fetched successfully',
                'data' => $req_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch request: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function cancelLiveRequest(Request $request)
    {
        $data = LiveRequest::find($request->id);

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Request not found',
                'data' => []
            ];
        }

        try {
            $data->update([
                'admin_verify' => '3',
                'cancel_reason' => $request->cancel_reason,
            ]);

            return [
                'status' => 'success',
                'message' => 'Live Request cancelled successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to cancel live request',
                'data' => []
            ];
        }
    }

    public function sendLiveRequest($request_data)
    {
        try {

            $orderId = mt_rand(100000, 999999);
            $data = LiveRequest::create([
                'timeslot_id' => $request_data->timeslot_id,
                'seller_id'   => $request_data->seller_id,
                'order_id'    => $orderId,
            ]);

            return [
                'status' => 'success',
                'message' => 'Live Request sent successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to send live request: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function deleteLiveRequest($requestId)
    {
        $data = LiveRequest::find($requestId);

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Live Request not found',
                'data' => []
            ];
        }

        try {
            $data->delete();

            return [
                'status' => 'success',
                'message' => 'Live Request deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete live request: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }







    

            
        


}
    