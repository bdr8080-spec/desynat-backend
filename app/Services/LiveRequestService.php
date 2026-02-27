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





    

            
        


}
    