<?php

namespace App\Http\Controllers\Api\DeliveryBoy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryBoy;
use App\Helpers\ApiResponse;


use Validator;


use App\Services\DeliveryBoyAuthService;
use App\Services\TicketService;


class DeliveryBoyDashboardController extends Controller
{

    public function __construct(DeliveryBoyAuthService $DeliveryBoyAuthService, TicketService $TicketService){

        $this->DeliveryBoyAuthService=$DeliveryBoyAuthService;
        $this->TicketService=$TicketService;

    }


    public function index(Request $request){

        $user_details=$request->user();


        $deliveryboy_details=DeliveryBoy::with('vehicle_image','identity_proof','driving_license','vehicle_insurance','pollution_paper','registration_certificate','zone_info','country_info')->where('id',$user_details->id)->first();
        
        return ApiResponse::generateResponse('success','Delivery Boy Dashboard fetch Successfully',$deliveryboy_details, 200);


    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::generateResponse('success','Logged out successfully',(object)[], 200);
    }

    public function delivery_boy_profile(Request $request){

        $user_details=$request->user();
        $deliveryboy_details=DeliveryBoy::with('vehicle_image','identity_proof','driving_license','vehicle_insurance','pollution_paper','registration_certificate','zone_info','country_info')->where('id',$user_details->id)->first();
        
        return ApiResponse::generateResponse('success','Delivery Boy Dashboard fetch Successfully',$deliveryboy_details, 200);


    }

    public function raise_ticket(Request $request){
  
        $validate = Validator::make($request->all(), [
            'ticket_type_id' => 'required|integer|exists:ticket_types,id',
            'title' => 'required',
            'description' => 'required',
            ]);
        
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        $user_id=$request->user()->id;
        $request_data=(object)[
            'sender_id'=>$user_id,
            'sender_type'=> 4,
            'file'=>$request->file??null,
            'ticket_type_id'=>$request->ticket_type_id,
            'title'=>$request->title,
            'description'=>$request->description,

            ];

        $data=$this->TicketService->raiseTicket($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function get_raised_tickets(Request $request){
    

        $user_id=$request->user()->id;
        $request_data=(object)[
            'sender_id'=>$user_id,
            'sender_type'=> 4,
            'sender_id'=>$user_id,
            'limit'=>$request->limit??null,
            'search'=>$request->search??null,

            ];

        $data=$this->TicketService->getTickets($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

}


    

    

    
