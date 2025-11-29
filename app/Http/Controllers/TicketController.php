<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketSubmitted;

class TicketController extends Controller
{
    /**
     * Generate unique alphanumeric ticket reference
     */
    private function generateTicketRef()
    {
        do {
            // Generate format: TKT-XXXXXX (6 random alphanumeric characters)
            $ref = 'TKT-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));
            
            // Check if this ref exists in any database
            $exists = false;
            foreach (Ticket::$typeConnectionMap as $connection) {
                try {
                    if (Ticket::on($connection)->where('ticket_ref', $ref)->exists()) {
                        $exists = true;
                        break;
                    }
                } catch (\Exception $e) {
                    // Continue if database doesn't exist yet
                }
            }
        } while ($exists);
        
        return $ref;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticketType' => 'required|string',
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phoneNumber' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $ticketType = $data['ticketType'];

        // Determine connection
        $connection = Ticket::$typeConnectionMap[$ticketType] ?? null;

        if (!$connection) {
            return response()->json(['message' => 'Invalid ticket type'], 400);
        }

        // Generate unique ticket reference
        $ticketRef = $this->generateTicketRef();
        
        // Create ticket on the specific connection
        // We need to set the connection explicitly before creating
        $ticket = new Ticket();
        $ticket->setConnection($connection);
        $ticket->fill([
            'ticket_ref' => $ticketRef,
            'ticket_type' => $ticketType,
            'full_name' => $data['fullName'],
            'email' => $data['email'],
            'phone' => $data['phoneNumber'] ?? null,
            'subject' => $data['subject'],
            'description' => $data['description'],
            'status' => 'Open',
        ]);
        $ticket->save();

        // Send email notification
        try {
            Mail::to($data['email'])->send(new TicketSubmitted($ticket));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Illuminate\Support\Facades\Log::error('Failed to send ticket email: ' . $e->getMessage());
        }

        return response()->json(['message' => 'Ticket submitted successfully!', 'ticket_ref' => $ticketRef], 201);
    }

    public function checkStatusForm()
    {
        return view('check-status');
    }

    public function checkStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'ticket_ref' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $email = $request->input('email');
        $ticketRef = $request->input('ticket_ref');
        $ticket = null;

        // Search across all department databases
        foreach (Ticket::$typeConnectionMap as $type => $connection) {
            try {
                $foundTicket = Ticket::on($connection)
                    ->where('ticket_ref', $ticketRef)
                    ->where('email', $email)
                    ->first();
                
                if ($foundTicket) {
                    $ticket = $foundTicket;
                    break;
                }
            } catch (\Exception $e) {
                // Continue searching other databases
            }
        }

        if (!$ticket) {
            return back()->withErrors(['error' => 'Ticket not found. Please check your email and ticket reference.'])->withInput();
        }

        return view('ticket-status', compact('ticket'));
    }
}
