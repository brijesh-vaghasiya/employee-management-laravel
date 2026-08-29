<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) abort(403);
        
        $tickets = Ticket::where('employee_id', $employee->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('employee.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('employee.tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:IT Support,HR Query,Payroll,Facilities,Other',
            'priority' => 'required|in:Low,Medium,High,Critical',
            'subject' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $employee = Auth::user()->employee;

        Ticket::create([
            'employee_id' => $employee->id,
            'category' => $request->category,
            'priority' => $request->priority,
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'Open'
        ]);

        return redirect()->route('employee.tickets.index')->with('success', 'Support ticket opened successfully.');
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->employee_id !== Auth::user()->employee->id) abort(403);
        
        $ticket->load('replies.user');
        return view('employee.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        if ($ticket->employee_id !== Auth::user()->employee->id) abort(403);
        
        $request->validate(['message' => 'required|string']);
        
        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);
        
        return redirect()->route('employee.tickets.show', $ticket)->with('success', 'Reply posted.');
    }
}
