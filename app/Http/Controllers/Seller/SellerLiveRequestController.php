<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sellerStoreInformation;


use App\Models\LiveRequest;


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
        'from' => $request->from??null, 
                'to' => $request->to??null, 
                'filter' => $request->filter??null 
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
                'seller_id' => $seller_details->id, 
                'country_id'=>$seller_store_country,
                "date"=>$request->date
            ];
            //dd($request_data);
        $result = $this->SellerLiveRequestService->getTimeslots($request_data);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message'],
            'data' => $result['data'] 
        ], 200);
    }
//     public function getTimeslots(Request $request)
// {
//     $seller_details = Auth::guard('seller')->user();

//     if (!$seller_details) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Seller not authenticated'
//         ], 401);
//     }

//     $seller_store_details = sellerStoreInformation::where('seller_id', $seller_details->id)->first();

//     if (!$seller_store_details) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Store information not found'
//         ], 400);
//     }

//     $request_data = (object)[
//         'seller_id' => $seller_details->id,
//         'country_id' => $seller_store_details->country,
//         'date' => $request->date
//     ];

//     $result = $this->SellerLiveRequestService->getTimeslots($request_data);

//     return response()->json($result);
// }

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

    

      public function seller_live(Request $request)
    {
     
        $seller_details=  Auth::guard('seller')->user();
    
        $request_data=(object )[
            'seller_id' => $seller_details->id, 
        ];

        $result = $this->SellerLiveRequestService->live_room_records($request_data);

        if ($result['status'] === 'error') {
        $liverequest['current_requests']=[];
        $liverequest['future_requests']=[];

        }elseif(empty($result['data'])){
           $liverequest['current_requests']=[];
           $liverequest['future_requests']=[];
        }else{
        $liverequest=$result['data'];

        }


        $otherSellerdetails = $this->SellerLiveRequestService->otherSellerLiveRoomRecords($request_data);

        $otherSellerdetails=$otherSellerdetails['data'];



    $AllLiverequest= collect($liverequest['current_requests'] ?? [])
    ->map(fn($v) => [
        'id' => $v->id,
        'channel_id' => $v->channel_id,
        'type' => 'live'
    ])
    ->concat(
        collect($otherSellerdetails ?? [])
            ->map(fn($v) => [
                'id' => $v->id,
                'channel_id' => $v->channel_id,
                'type' => 'other'
            ])
            );
        
        return view('dealer/liverequest/LiveJoin' ,compact('liverequest','otherSellerdetails','AllLiverequest'));
        
        // return response()->json([
        //     'status' => 'success',
        //     'message' => $result['message']
        // ], 200);
    }



      public function sellerliveview(Request $request)
    {
    
     $liveRequest=LiveRequest::where('channel_id', $request->channel_id)->first();

    return view('dealer/liverequest/Live',compact('liveRequest'));
        
    }

      public function sellerLiveCount(Request $request)
    {

    //  $liveRequest=LiveRequest::where('channel_id', $request->channel_id)->first();


   $url="https://api.agora.io/dev/v1/channel/user/".env('AGORA_APP_ID')."/".$request->channel_id;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic MGRkZjAzNTkzMDJjNGUzYjk5NTI4MmI0NDQ3MGUyNWU6YzI1OGMyZTBlNTc4NDIwZmJkYjBlNDNiYWY1YjFlZTM=',
            'Cookie: connect.sid=s%3AIHsEXiokm0y1tARxfvvQ0Lt1.NB3704XkND6lcnAe8C%2FumE6wrpb62SqmgsPH3Ja7aL0'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;


        $agora_response=json_decode($response,1);

        if(isset($agora_response)){

            if($agora_response['success']==true){
               $count_user=$agora_response['data']['audience_total'];
            }
        }else{
            $count_user=0;
        }


      return response()->json([
            'status' => 'success',
            'data' => $count_user
        ], 200);
        
    }

    

    public function OthersellerLive(Request $request)
    {
    
     $liveRequest=LiveRequest::where('channel_id', $request->channel_id)->first();

    return view('dealer/liverequest/OtherSellerLiveJoin',compact('liveRequest'));
        
    }

    
    



    

}