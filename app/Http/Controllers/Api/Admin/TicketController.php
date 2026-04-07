<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use Validator;

use App\Services\TicketService;

use App\Models\{ seller,sellerStoreInformation,sellerDocument,Bankdetails,Plan };


class TicketController extends Controller
{

    public function __Construct(TicketService $TicketService){
        $this->TicketService=$TicketService;
    }



    public function get_new_tickets(Request $request){
    
        $request_data=(object)[
            'limit'=>$request->limit??null,
            'search'=>$request->search??null,
            'country'=>$request->country??null,
            'from_date'=>$request->from_date??null,
            'to_date'=>$request->to_date??null,
            ];

        $data=$this->TicketService->getNewTicketsOnAdmin($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function get_ongoing_tickets(Request $request){
    
        $request_data=(object)[
            'limit'=>$request->limit??null,
            'search'=>$request->search??null,
            'country'=>$request->country??null,
            'from_date'=>$request->from_date??null,
            'to_date'=>$request->to_date??null,
            ];

        $data=$this->TicketService->getOngoingTicketsOnAdmin($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function get_resolved_tickets(Request $request){
    
        $request_data=(object)[
            'limit'=>$request->limit??null,
            'search'=>$request->search??null,
            'country'=>$request->country??null,
            'from_date'=>$request->from_date??null,
            'to_date'=>$request->to_date??null,
            ];

        $data=$this->TicketService->getResolvedTicketsOnAdmin($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function update_ticket_status(Request $request){

       $validate = Validator::make($request->all(), [
           'ticket_id' => 'required|exists:tickets,id',
            'status' => 'required|integer|in:0,1',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }
    
        $request_data=(object)[
            'ticket_id'=>$request->ticket_id,
            'status'=>$request->status,
            ];

        $data=$this->TicketService->updateTicketStatus($request_data);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }





}