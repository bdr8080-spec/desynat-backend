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
            'ticket_type_filter'=>$request->ticket_type_filter??null,
            'sender_type_filter'=>$request->sender_type_filter??null,
            ];

        $newTickets=$this->TicketService->getNewTicketsOnAdmin($request_data);
        //dd($newTickets);
        $request_data1=(object)[
            'from_date'=>$request->from_date1??null,
            'to_date'=>$request->to_date1??null,
            'ticket_type_filter'=>$request->ticket_type_filter1??null,
            'sender_type_filter'=>$request->sender_type_filter1??null,
            ];

        $ongoingTickets=$this->TicketService->getOngoingTicketsOnAdmin($request_data1);
        $request_data2=(object)[
            'from_date'=>$request->from_date2??null,
            'to_date'=>$request->to_date2??null,
            'ticket_type_filter'=>$request->ticket_type_filter2??null,
            'sender_type_filter'=>$request->sender_type_filter2??null,
            ];

        $resolvedTickets=$this->TicketService->getResolvedTicketsOnAdmin($request_data2);

        $commonController = new CommonController();
        $ticketTypesResponse = $commonController->ticket_types($request);
        $ticketTypes = $ticketTypesResponse->original['data'];

        return view('admin.ticket-mgt.index',compact('newTickets','ongoingTickets','resolvedTickets','ticketTypes'));
    }

    public function update_ticket_status(Request $request)
    {
        try {
            $request_data = (object)[
                'ticket_id' => $request->ticket_id,
                'status' => $request->status,
            ];

            $data = $this->TicketService->updateTicketStatus($request_data);

            if ($data['status'] === 'error') {
                return response()->json([
                    'status' => 'error',
                    'message' => $data['message']
                ], 400);
            }

            return response()->json([
                'status' => 'success',
                'message' => $data['message']
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }








    



}