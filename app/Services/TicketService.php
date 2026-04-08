<?php
namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketType;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;
use Illuminate\Support\Str;


class TicketService
{
   
    public function getTickets($request)
    {
        try {
            $limit = $request->limit;

            $query = Ticket::with([
                'ticket_type_details' 
            ]);

            if (!empty($request->search)) {
                $search = $request->search;
                $query->where('ticket_id', 'like', '%' . $search . '%');
            }

            $query->where('sender_type', $request->sender_type)
                ->where('sender_id', $request->sender_id)
                ->orderBy('id', 'desc');

            if (empty($limit)) {
                $data = $query->get();
            } else {
                $data = $query->paginate((int)$limit);
            }

            if ($data->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Tickets found',
                    'data' =>  (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Tickets fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch tickets: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function raiseTicket($request)
    {
        try {

            $ticketId = strtoupper(Str::random(8));
            $data = Ticket::create([
                'ticket_id' => $ticketId,
                'ticket_type_id' => $request->ticket_type_id,
                'title' => $request->title,
                'description' => $request->description,
                'sender_id' => $request->sender_id,
                'sender_type' => $request->sender_type,
                'file' => $request->file??null,
                
            ]);

            return [
                'status' => 'success',
                'message' => 'Ticket added successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function updateTicketStatus($request_data)
    {
        try {
            $data = Ticket::find($request_data->ticket_id);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Ticket not found',
                    'data' => []
                ];
            }

            $data->status = $request_data->status;
            $data->updated_at = now();
            $data->save();


            return [
                'status' => 'success',
                'message' => 'Ticket status updated successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update ticket status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    public function getNewTicketsOnAdmin($request)
    {
        try {
            $limit  = !empty($request->limit) ? (int)$request->limit : null;
            $search = strtolower(trim($request->search ?? ''));

            $query = Ticket::with(['ticket_type_details']);

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            if (empty($request->from_date) && empty($request->to_date)) {
                $query->whereDate('created_at', Carbon::today());
            }

            if (!empty($request->ticket_type_filter)) {
                $query->where('ticket_type_id', $request->ticket_type_filter);
            }

            if (!empty($request->sender_type_filter)) {
                $query->where('sender_type', $request->sender_type_filter);
            }

            $query->where('status', '0');
            $query->orderBy('id', 'desc');

            $tickets = $limit ? $query->paginate($limit) : $query->get();

            if ($tickets->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Tickets found',
                    'data' => (object)[]
                ];
            }

            if (!empty($search)) {
                $tickets = $tickets->filter(function ($ticket) use ($search) {
                    // Check ticket_id first
                    if (stripos($ticket->ticket_id, $search) !== false) {
                        return true;
                    }

                    $sender = $ticket->sender_details;
                    if (!$sender) return false;

                    switch ($ticket->sender_type) {
                        case 1: // User
                        case 3: // Affiliate
                            $name = $sender->full_name ?? '';
                            break;
                        case 2: // Seller
                            $name = trim(($sender->first_name ?? '') . ' ' . ($sender->last_name ?? ''));
                            break;
                        case 4: // Driver
                            $name = $sender->full_name_english ?? '';
                            break;
                        default:
                            $name = '';
                    }

                    return stripos($name, $search) !== false;
                })->values();
            }

            // Append sender details
            $tickets->each(function ($ticket) {
                $ticket->sender_details; // ensure accessor runs
            });

            return [
                'status' => 'success',
                'message' => 'Tickets fetched successfully',
                'data' => $tickets
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch tickets: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getOngoingTicketsOnAdmin($request)
    {
        try {
            $limit  = !empty($request->limit) ? (int)$request->limit : null;
            $search = strtolower(trim($request->search ?? ''));

            $query = Ticket::with(['ticket_type_details']);

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            if (!empty($request->ticket_type_filter)) {
                $query->where('ticket_type_id', $request->ticket_type_filter);
            }

            if (!empty($request->sender_type_filter)) {
                $query->where('sender_type', $request->sender_type_filter);
            }


            $query->where('status', '0');
            $query->whereDate('created_at', '<', Carbon::today());
            $query->orderBy('id', 'desc');

            $tickets = $limit ? $query->paginate($limit) : $query->get();

            if ($tickets->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Tickets found',
                    'data' => (object)[]
                ];
            }

            if (!empty($search)) {
                $tickets = $tickets->filter(function ($ticket) use ($search) {
                    // Check ticket_id first
                    if (stripos($ticket->ticket_id, $search) !== false) {
                        return true;
                    }

                    $sender = $ticket->sender_details;
                    if (!$sender) return false;

                    switch ($ticket->sender_type) {
                        case 1: // User
                        case 3: // Affiliate
                            $name = $sender->full_name ?? '';
                            break;
                        case 2: // Seller
                            $name = trim(($sender->first_name ?? '') . ' ' . ($sender->last_name ?? ''));
                            break;
                        case 4: // Driver
                            $name = $sender->full_name_english ?? '';
                            break;
                        default:
                            $name = '';
                    }

                    return stripos($name, $search) !== false;
                })->values();
            }

            // Append sender details
            $tickets->each(function ($ticket) {
                $ticket->sender_details; // ensure accessor runs
            });

            return [
                'status' => 'success',
                'message' => 'Tickets fetched successfully',
                'data' => $tickets
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch tickets: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getResolvedTicketsOnAdmin($request)
    {
        try {
            $limit  = !empty($request->limit) ? (int)$request->limit : null;
            $search = strtolower(trim($request->search ?? ''));

            $query = Ticket::with(['ticket_type_details']);

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            if (!empty($request->ticket_type_filter)) {
                $query->where('ticket_type_id', $request->ticket_type_filter);
            }

            if (!empty($request->sender_type_filter)) {
                $query->where('sender_type', $request->sender_type_filter);
            }


            $query->where('status', '1');
            $query->orderBy('id', 'desc');

            $tickets = $limit ? $query->paginate($limit) : $query->get();

            if ($tickets->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Tickets found',
                    'data' => (object)[]
                ];
            }

            if (!empty($search)) {
                $tickets = $tickets->filter(function ($ticket) use ($search) {
                    // Check ticket_id first
                    if (stripos($ticket->ticket_id, $search) !== false) {
                        return true;
                    }

                    $sender = $ticket->sender_details;
                    if (!$sender) return false;

                    switch ($ticket->sender_type) {
                        case 1: // User
                        case 3: // Affiliate
                            $name = $sender->full_name ?? '';
                            break;
                        case 2: // Seller
                            $name = trim(($sender->first_name ?? '') . ' ' . ($sender->last_name ?? ''));
                            break;
                        case 4: // Driver
                            $name = $sender->full_name_english ?? '';
                            break;
                        default:
                            $name = '';
                    }

                    return stripos($name, $search) !== false;
                })->values();
            }

            // Append sender details
            $tickets->each(function ($ticket) {
                $ticket->sender_details; // ensure accessor runs
            });

            return [
                'status' => 'success',
                'message' => 'Tickets fetched successfully',
                'data' => $tickets
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch tickets: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }





    

            
        


}
    