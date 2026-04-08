<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\TicketService;
use App\Services\CountryService;
use App\Models\Ticket;
use App\Http\Controllers\CommonController;

 
class TicketController extends Controller
{

    public function __construct(TicketService $TicketService, CountryService $CountryService)
    {
        $this->TicketService = $TicketService;
        $this->CountryService = $CountryService;
    }

    public function ticketManagement(Request $request){
        $request_data=(object)[
            'from_date'=>$request->from_date??null,
            'to_date'=>$request->to_date??null,
            ];

        $newTickets=$this->TicketService->getNewTicketsOnAdmin($request_data);
        $request_data1=(object)[
            'from_date'=>$request->from_date1??null,
            'to_date'=>$request->to_date1??null,
            ];

        $ongoingTickets=$this->TicketService->getOngoingTicketsOnAdmin($request_data1);
        $request_data2=(object)[
            'from_date'=>$request->from_date2??null,
            'to_date'=>$request->to_date2??null,
            ];

        $resolvedTickets=$this->TicketService->getResolvedTicketsOnAdmin($request_data2);
        return view('admin.ticket-management.index',compact('newTickets','ongoingTickets','resolvedTickets'));
    }

    public function update_ticket_status(Request $request){
    
        $request_data=(object)[
            'ticket_id'=>$request->ticket_id,
            'status'=>$request->status,
            ];

        $data=$this->TicketService->updateTicketStatus($request_data);

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