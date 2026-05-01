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

    public function export_new_tickets_data(Request $request)
    {
        $request_data = (object)[
            'from_date' => $request->from_date ?? null,
            'to_date' => $request->to_date ?? null,
            'ticket_type_filter' => $request->ticket_type_filter ?? null,
            'sender_type_filter' => $request->sender_type_filter ?? null,
        ];

        $response = $this->TicketService->getNewTicketsOnAdmin($request_data);

        $data = $response['data'] ?? collect();

        $tickets = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'new_tickets_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($tickets) {

            $file = fopen('php://output', 'w');

            // UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'Sr No',
                'Ticket Id',
                'Submitted By',
                'Raised Date & Time',
                'User Name',
                'Title',
                'Description',
                'Attachment',
                'Type',
                'Status'
            ]);

            foreach ($tickets as $index => $ticket) {

                // Submitted By
                $submittedBy = match ($ticket->sender_type) {
                    1 => 'User',
                    2 => 'Seller',
                    3 => 'Affiliate User',
                    default => 'Delivery Boy',
                };

                // Name (safe handling)
                $sender = $ticket->sender_details ?? null;

                $userName = '-';

                if ($sender) {
                    $userName = trim(
                        ($sender->full_name ?? '') . ' ' .
                        ($sender->first_name ?? '') . ' ' .
                        ($sender->last_name ?? '')
                    );

                    $userName = $userName ?: ($sender->full_name_english ?? '-');
                }

                // Date
                $raisedDate = $ticket->created_at
                    ? \Carbon\Carbon::parse($ticket->created_at)->format('d M Y | h:i A')
                    : '-';

                // Type
                $type = $ticket->ticket_type_details->name ?? '-';

                // Status
                $status = $ticket->status == 1 ? 'Resolved' : 'Pending';

                // Attachment
                $attachment = $ticket->file ?? 'N/A';

                fputcsv($file, [
                    $index + 1,
                    $ticket->ticket_id,
                    $submittedBy,
                    $raisedDate,
                    $userName,
                    $ticket->title ?? '-',
                    strip_tags($ticket->description ?? '-'),
                    $attachment,
                    $type,
                    $status
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_ongoing_tickets_data(Request $request)
    {
        $request_data1=(object)[
            'from_date'=>$request->from_date1??null,
            'to_date'=>$request->to_date1??null,
            'ticket_type_filter'=>$request->ticket_type_filter1??null,
            'sender_type_filter'=>$request->sender_type_filter1??null,
            ];

        $response=$this->TicketService->getOngoingTicketsOnAdmin($request_data1);

        $data = $response['data'] ?? collect();

        $tickets = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'ongoing_tickets_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($tickets) {

            $file = fopen('php://output', 'w');

            // UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'Sr No',
                'Ticket Id',
                'Submitted By',
                'Raised Date & Time',
                'User Name',
                'Title',
                'Description',
                'Attachment',
                'Type',
                'Status'
            ]);

            foreach ($tickets as $index => $ticket) {

                // Submitted By
                $submittedBy = match ($ticket->sender_type) {
                    1 => 'User',
                    2 => 'Seller',
                    3 => 'Affiliate User',
                    default => 'Delivery Boy',
                };

                // Name (safe handling)
                $sender = $ticket->sender_details ?? null;

                $userName = '-';

                if ($sender) {
                    $userName = trim(
                        ($sender->full_name ?? '') . ' ' .
                        ($sender->first_name ?? '') . ' ' .
                        ($sender->last_name ?? '')
                    );

                    $userName = $userName ?: ($sender->full_name_english ?? '-');
                }

                // Date
                $raisedDate = $ticket->created_at
                    ? \Carbon\Carbon::parse($ticket->created_at)->format('d M Y | h:i A')
                    : '-';

                // Type
                $type = $ticket->ticket_type_details->name ?? '-';

                // Status
                $status = $ticket->status == 1 ? 'Resolved' : 'Pending';

                // Attachment
                $attachment = $ticket->file ?? 'N/A';

                fputcsv($file, [
                    $index + 1,
                    $ticket->ticket_id,
                    $submittedBy,
                    $raisedDate,
                    $userName,
                    $ticket->title ?? '-',
                    strip_tags($ticket->description ?? '-'),
                    $attachment,
                    $type,
                    $status
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_past_tickets_data(Request $request)
    {
        $request_data2=(object)[
            'from_date'=>$request->from_date2??null,
            'to_date'=>$request->to_date2??null,
            'ticket_type_filter'=>$request->ticket_type_filter2??null,
            'sender_type_filter'=>$request->sender_type_filter2??null,
            ];

        $response=$this->TicketService->getResolvedTicketsOnAdmin($request_data2);

        $data = $response['data'] ?? collect();

        $tickets = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'past_tickets_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($tickets) {

            $file = fopen('php://output', 'w');

            // UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'Sr No',
                'Ticket Id',
                'Submitted By',
                'Raised Date & Time',
                'User Name',
                'Title',
                'Description',
                'Attachment',
                'Type',
                'Status'
            ]);

            foreach ($tickets as $index => $ticket) {

                // Submitted By
                $submittedBy = match ($ticket->sender_type) {
                    1 => 'User',
                    2 => 'Seller',
                    3 => 'Affiliate User',
                    default => 'Delivery Boy',
                };

                // Name (safe handling)
                $sender = $ticket->sender_details ?? null;

                $userName = '-';

                if ($sender) {
                    $userName = trim(
                        ($sender->full_name ?? '') . ' ' .
                        ($sender->first_name ?? '') . ' ' .
                        ($sender->last_name ?? '')
                    );

                    $userName = $userName ?: ($sender->full_name_english ?? '-');
                }

                // Date
                $raisedDate = $ticket->created_at
                    ? \Carbon\Carbon::parse($ticket->created_at)->format('d M Y | h:i A')
                    : '-';

                // Type
                $type = $ticket->ticket_type_details->name ?? '-';

                // Status
                $status = $ticket->status == 1 ? 'Resolved' : 'Pending';

                // Attachment
                $attachment = $ticket->file ?? 'N/A';

                fputcsv($file, [
                    $index + 1,
                    $ticket->ticket_id,
                    $submittedBy,
                    $raisedDate,
                    $userName,
                    $ticket->title ?? '-',
                    strip_tags($ticket->description ?? '-'),
                    $attachment,
                    $type,
                    $status
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }








    



}