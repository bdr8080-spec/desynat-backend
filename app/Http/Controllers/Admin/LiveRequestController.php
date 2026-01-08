<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\LiveRequestService;
use App\Services\CountryService;

 
class LiveRequestController extends Controller
{

    public function __construct(LiveRequestService $LiveRequestService, CountryService $CountryService)
    {
        $this->LiveRequestService = $LiveRequestService;
        $this->CountryService = $CountryService;
    }

    public function liveRequestManagement(Request $req){
        $countries = $this->CountryService->getCountries()['data'];
        $timeslots = $this->LiveRequestService->getTimeslots($req)['data'];
       // dd($timeslots);
        return view('admin.live-request-management.index',compact('countries','timeslots'));
    }

    public function deleteTimeslot($id)
    {
        $result = $this->LiveRequestService->deleteTimeslot($id);

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

    public function blockUnblockTimeslot($id)
    {
        $result = $this->LiveRequestService->blockUnblockTimeslot($id);

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

    public function addTimeslot(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'date' => 'required',
            'from' => 'required',
            'to' => 'required'
        ]);

        try {

            $data = $this->LiveRequestService->addTimeslot($request);
            $message = $data['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create timeslot',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateTimeslot(Request $request,$id)
    {
        $request->validate([
            'country_id' => 'required',
            'date' => 'required',
            'from' => 'required',
            'to' => 'required'
        ]);

        try {

            $data = $this->LiveRequestService->updateTimeslot($request,$id);
            $message = $data['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create timeslot',
                'error' => $e->getMessage()
            ], 500);
        }
    }




    



}