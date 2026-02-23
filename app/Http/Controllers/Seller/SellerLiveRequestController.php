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

    public function getTimeslots(Request $request)
    {

            $seller_details=  Auth::guard('seller')->user();
            $seller_store_details = sellerStoreInformation::where('seller_id',$seller_details->id)->first();
            $seller_store_country = $seller_store_details->country;
            //dd($seller_store_country);
            //$country = country::where('dial_code',$seller_details->country_code)->first();
            //dd($country);

            $request_data=(object )[
                'country_id'=>$seller_store_country,
                "date"=>$request->date
            ];
        $result = $this->SellerLiveRequestService->getTimeslots($request);

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

    public function sendLiveRequest(Request $request)
    {
        $result = $this->SellerLiveRequestService->sendLiveRequest($request);

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