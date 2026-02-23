<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;





use App\Services\SellerLiveRequestService;

use Auth;

use Validator;

use App\Helpers\ApiResponse;

use Illuminate\Validation\Rule;




class SellerLiveRequestController extends Controller
{

    public function __construct(SellerLiveRequestService $SellerLiveRequestService){
        $this->SellerLiveRequestService=$SellerLiveRequestService;
    }

    public function liveRequests(Request $request){

        $seller_details=  Auth::guard('seller')->user();
        $seller_id=$seller_details->id;
        //dd($seller_id);
        
        $request_data=(object) [
        'seller_id'=>$seller_id,
        ];
    
      $all_records= $this->SellerLiveRequestService->getLiveRequests($request_data);

      
      $data=$all_records['data'];
      //dd($data);

    return view('dealer.liverequest.live-request',compact('data'));

    }


    public function deleteLiveRequest($id)
    {
        $result = $this->SellerLiveRequestService->deleteLiveRequest($id);

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

    public function cancelLiveRequest(Request $request)
    {
        $result = $this->SellerLiveRequestService->cancelLiveRequest($request);

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


    

}