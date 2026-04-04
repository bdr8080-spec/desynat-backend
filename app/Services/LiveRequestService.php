<?php
namespace App\Services;

use App\Models\LiveRequestTimeslot;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;
use App\Models\LiveRequest;


class LiveRequestService
{
   
    public function getTimeslots($req)
    {
        try {

            $query = LiveRequestTimeslot::with('country_info')
                ->where('country_id', $req->country_id)
                ->whereDate('date', $req->date)
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



    public function blockUnblockTimeslot($timeslotId)
    {
        try {
            $data = LiveRequestTimeslot::find($timeslotId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Timeslot not found',
                    'data' => []
                ];
            }

            $data->status = $data->status == 1 ? 0 : 1;
            $data->save();

            $message = $data->status == 1
                        ? 'Timeslot Unblocked successfully'
                        : 'Timeslot Blocked successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update timeslot status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    // public function addTimeslot(Request $request)
    // {

    //     try {
    //         $data = LiveRequestTimeslot::create([
    //             'country_id' => $request->country_id,
    //             'date' => $request->date,
    //             'from' => $request->from,
    //             'to' => $request->to,
    //         ]);

    //         return [
    //             'status' => 'success',
    //             'message' => 'Timeslot added successfully',
    //             'data' => $data
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to add timeslot',
    //             'data' => []
    //         ];
    //     }
    // }

    public function addTimeslot(Request $request)
    {
        try {
            $from = \Carbon\Carbon::createFromFormat('h:i A', strtoupper($request->from));
            $to   = \Carbon\Carbon::createFromFormat('h:i A', strtoupper($request->to));

            if ($from->diffInMinutes($to) < 30) {
                return [
                    'status' => 'error',
                    'message' => 'Please select a minimum 30-minute timeslot',
                    'data' => (object)[]
                ];
            }

            $exists = LiveRequestTimeslot::where('country_id', $request->country_id)
                ->where('date', $request->date)
                ->whereRaw("
                    STR_TO_DATE(`from`, '%h:%i %p') < ?
                    AND
                    STR_TO_DATE(`to`, '%h:%i %p') > ?
                ", [
                    $to->format('H:i:s'),
                    $from->format('H:i:s')
                ])
                ->exists();


            if ($exists) {
                return [
                    'status' => 'error',
                    'message' => 'This timeslot is already exist',
                    'data' => (object)[]
                ];
            }

            $data = LiveRequestTimeslot::create([
                'country_id' => $request->country_id,
                'date' => $request->date,
                'from' => $request->from,
                'to' => $request->to,
            ]);

            return [
                'status' => 'success',
                'message' => 'Timeslot added successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            \Log::error('Add timeslot error: '.$e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Failed to add timeslot',
                'data' => []
            ];
        }
    }





    // public function updateTimeslot(Request $request, $dealId)
    // {
    //     $data = LiveRequestTimeslot::find($dealId);

    //     if (!$data) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Timeslot not found',
    //             'data' => []
    //         ];
    //     }

    //     try {
    //         $data->update([
    //             'country_id' => $request->country_id,
    //             'date' => $request->date,
    //             'from' => $request->from,
    //             'to' => $request->to, 
    //         ]);

    //         return [
    //             'status' => 'success',
    //             'message' => 'Timeslot updated successfully',
    //             'data' => $data
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to update timeslot',
    //             'data' => []
    //         ];
    //     }
    // }

    public function updateTimeslot(Request $request, $dealId)
    {
        $data = LiveRequestTimeslot::find($dealId);

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Timeslot not found',
                'data' => (object)[]
            ];
        }

        try {
            $from = \Carbon\Carbon::createFromFormat('h:i A', strtoupper($request->from));
            $to   = \Carbon\Carbon::createFromFormat('h:i A', strtoupper($request->to));

            if ($from->diffInMinutes($to) < 30) {
                return[
                    'status' => 'error',
                    'message' => 'Please select a minimum 30-minute timeslot',
                    'data' =>(object) []
                ];
            }

            $exists = LiveRequestTimeslot::where('country_id', $request->country_id)
                ->where('date', $request->date)
                ->where('id', '!=', $dealId)
                 ->whereRaw("
                    STR_TO_DATE(`from`, '%h:%i %p') < ?
                    AND
                    STR_TO_DATE(`to`, '%h:%i %p') > ?
                ", [
                    $to->format('H:i:s'),
                    $from->format('H:i:s')
                ])
                ->exists();

            if ($exists) {
                return[
                    'status' => 'error',
                    'message' => 'This timeslot is already exists',
                    'data' => (object)[]
                ];
            }

            $data->update([
                'country_id' => $request->country_id,
                'date' => $request->date,
                'from' => $request->from,
                'to' => $request->to,
            ]);

            return[
                'status' => 'success',
                'message' => 'Timeslot updated successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            \Log::error('Update timeslot error: '.$e->getMessage());
            return[
                'status' => 'error',
                'message' => 'Failed to update timeslot: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    public function deleteTimeslot($timeslotId)
    {
        try {
            $data = LiveRequestTimeslot::find($timeslotId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Timeslot not found',
                    'data' => (object)[]
                ];
            }
            $data->delete();

            return [
                'status' => 'success',
                'message' => 'Timeslot deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete Timeslot',
                'data' => []
            ];
        }
    }

    public function getLiveRequests($req)
    {
        try {
            $limit = $req->input('limit');
            $limit = (int)$limit;

            $query = LiveRequest::with([
                'timeslot_details',
                'timeslot_details.country_info',
                'seller_details',
                'seller_details.country_details',
                'seller_details.store_info.country_info'
            ]);
            $query->where('admin_verify', $req->type);

             if ($req->filled('search')) {
                $search = $req->input('search');

                $query->where(function ($q) use ($search) {
                    $q->where('order_id', 'like', '%' . $search . '%')
                    ->orWhereHas('seller_details', function ($sellerQ) use ($search) {
                        $sellerQ->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%')
                                ->orWhereRaw(
                                    "CONCAT(first_name, ' ', last_name) LIKE ?",
                                    ['%' . $search . '%']
                                );
                    });
                });
            }

            if ($req->filled('country')) {
                $country = $req->input('country');

                $query->whereHas('seller_details.store_info.country_info', function ($q) use ($country) {
                    $q->where('name', 'like', '%' . $country . '%');
                });
            }

            $query->orderBy('id', 'desc');

            $req_details = $query->paginate($limit);
            //dd($req_details);

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

    public function acceptLiveRequest(Request $request)
    {
        $data = LiveRequest::find($request->request_id);

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Request not found',
                'data' => []
            ];
        }

        try {
            $data->update([
                'admin_verify' => '1',
            ]);
            CreateNotification([
                    'sender_id' => 1, 
                    'sender_type' => 1, 

                    'receiver_id' => $data->seller_id,
                    'receiver_type' => 3, 

                    'title_english' => 'Live Request',
                    'description_english' => "Your live request with request id: #{$data->order_id} is approved",

                    'notification_type' => 'live_req_accepted'
                ]);

            return [
                'status' => 'success',
                'message' => 'Live Request Accepted successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to accept live request',
                'data' => []
            ];
        }
    }

    public function rejectLiveRequest(Request $request)
    {
        $data = LiveRequest::find($request->request_id);

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Request not found',
                'data' => []
            ];
        }

        try {
            $data->update([
                'admin_verify' => '2',
                'reject_reason' => $request->reject_reason,
            ]);

            CreateNotification([
                    'sender_id' => 1, 
                    'sender_type' => 1, 

                    'receiver_id' => $data->seller_id,
                    'receiver_type' => 3, 

                    'title_english' => 'Live Request',
                    'description_english' => "Your live request with request id: #{$data->order_id} is rejected, Reason: {$request->reject_reason}",

                    'notification_type' => 'live_req_rejected'
                ]);

            return [
                'status' => 'success',
                'message' => 'Live Request Rejected successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to reject live request',
                'data' => []
            ];
        }
    }



    public function LiveStreminigRequest($request_data)
    {

        try {
          
 
$limit = isset($request_data->limit) ? (int)$request_data->limit : 10;

$baseQuery = LiveRequest::with([
    'timeslot_details',
    'timeslot_details.country_info',
    'seller_details',
])
->where('admin_verify', '1');

// 🔍 Search
if (!empty($request_data->search)) {
    $baseQuery->where('order_id', 'like', '%' . $request_data->search . '%');
}

$today = Carbon::today()->toDateString();
$currentTime = Carbon::now()->format('H:i:s'); // 24-hour format


/**
 * ✅ Current (Today)
 */
$currentQuery = clone $baseQuery;
// $currentQuery->whereHas('timeslot_details', function ($q) use ($today,$currentTime) {
//     $q->whereDate('date', $today)
//      ->whereRaw("STR_TO_DATE(`to`, '%h:%i %p') > ?", [$currentTime]);
// });

$currentQuery->whereHas('timeslot_details', function ($q) use ($today, $currentTime) {
    $q->where(function ($query) use ($today, $currentTime) {

        // Case 1: Today → check time
        $query->whereDate('date', $today)
              ->whereRaw("STR_TO_DATE(`to`, '%h:%i %p') > ?", [$currentTime]);

    })->orWhere(function ($query) use ($today) {

        // Case 2: Future dates → include all
        $query->whereDate('date', '>', $today);

    });
});


if (!empty($request_data->country_id)) {

$country_id=$request_data->country_id;

$currentQuery->whereHas('timeslot_details', function ($q) use ($country_id) {
    $q->where(function ($query) use ($country_id) {
         $query->where('country_id', $country_id);

    });
});

}




$current_requests = $currentQuery->get();



// ❌ If both empty
if ($current_requests->isEmpty()) {
    return [
        'status' => 'success',
        'message' => 'No Request found',
        'data' => []
    ];
}

// ✅ Final response
return [
    'status' => 'success',
    'message' => 'Requests fetched successfully',
    'data' => $current_requests
];


        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch request: ' . $e->getMessage(),
                'data' => []
            ];
        }

    }



    

            
        


}
    