<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function loginForm()
    {
        // If already logged in, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard()
    {
        $tickets = collect();
        foreach (Ticket::$typeConnectionMap as $type => $connection) {
            try {
                // Fetch tickets from each connection
                $dbTickets = Ticket::on($connection)->orderBy('created_at', 'desc')->get();
                $tickets = $tickets->merge($dbTickets);
            } catch (\Exception $e) {
                // Ignore connection errors if a DB is missing or down
            }
        }

        return view('admin.dashboard', compact('tickets'));
    }

    public function show($type, $id)
    {
        $connection = Ticket::$typeConnectionMap[$type] ?? null;
        if (!$connection) abort(404);

        $ticket = Ticket::on($connection)->findOrFail($id);

        return view('admin.show', compact('ticket', 'type'));
    }

    public function update(Request $request, $type, $id)
    {
        $request->validate([
            'admin_note' => 'nullable|string',
            'action' => 'required|in:save_note,close_ticket'
        ]);

        // Determine connection
        $connection = Ticket::$typeConnectionMap[$type] ?? null;

        if (!$connection) {
            return back()->with('error', 'Invalid ticket type');
        }

        $ticket = Ticket::on($connection)->findOrFail($id);
        
        $action = $request->input('action');
        
        if ($action === 'close_ticket') {
            // Close the ticket
            $ticket->status = 'Closed';
            $ticket->save();
            
            return redirect()->route('admin.dashboard')->with('success', 'Ticket closed successfully');
        } else {
            // Save note and mark as noted
            $newNote = $request->input('admin_note');
            
            if ($newNote) {
                if ($ticket->admin_note) {
                    $ticket->admin_note .= "<br><hr class='my-2'><br>" . $newNote;
                } else {
                    $ticket->admin_note = $newNote;
                }
            }
            
            $ticket->status = 'Noted';
            $ticket->save();
            
            return back()->with('success', 'Note saved and ticket marked as noted');
        }
    }
}
