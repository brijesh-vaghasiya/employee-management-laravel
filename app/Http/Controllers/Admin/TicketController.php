<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with('employee');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('replies.user', 'employee.user');
        return view('admin.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate(['status' => 'required|in:Open,In Progress,Resolved,Closed']);
        $ticket->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Ticket status updated.');
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate(['message' => 'required|string']);
        
        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);
        
        // Auto-progress status if admin replies
        if ($ticket->status === 'Open') {
            $ticket->update(['status' => 'In Progress']);
        }
        
        return redirect()->back()->with('success', 'Reply posted successfully.');
    }
}
