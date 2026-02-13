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


    public function getLiveRequests($request_data)
    {
        try {
            $limit = isset($request_data->limit) ? (int)$request_data->limit : 10;

            $query = LiveRequest::with([
                'timeslot_details',
                'timeslot_details.country_info',
                //'seller_details',
                //'seller_details.country_details'
            ]);
            $query->where('seller_id', $request_data->seller_id);

            $query->orderBy('id', 'desc');

            $req_details = $query->paginate($limit);

            if ($req_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Request found',
                    'data' =>  (object)[]
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







    

            
        


}
    