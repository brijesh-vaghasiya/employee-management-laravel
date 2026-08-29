<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReport;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DailyReportController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) abort(403);
        
        $reports = DailyReport::where('employee_id', $employee->id)->orderBy('date', 'desc')->paginate(15);
        return view('employee.daily_reports.index', compact('reports'));
    }

    public function create()
    {
        return view('employee.daily_reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'completed_tasks' => 'required|string',
            'tomorrow_plan' => 'required|string',
            'blockers' => 'nullable|string'
        ]);

        $employee = Auth::user()->employee;
        
        // Ensure no duplicate reports for same day
        $exists = DailyReport::where('employee_id', $employee->id)->where('date', $request->date)->first();
        if ($exists) {
            return redirect()->back()->withErrors(['date' => 'You have already submitted a daily report for this exact date.'])->withInput();
        }

        DailyReport::create([
            'employee_id' => $employee->id,
            'date' => $request->date,
            'completed_tasks' => $request->completed_tasks,
            'tomorrow_plan' => $request->tomorrow_plan,
            'blockers' => $request->blockers,
            'status' => 'Pending'
        ]);

        return redirect()->route('employee.daily_reports.index')->with('success', 'Daily report logged successfully.');
    }

    public function show(DailyReport $dailyReport)
    {
        if ($dailyReport->employee_id !== Auth::user()->employee->id) abort(403);
        return view('employee.daily_reports.show', compact('dailyReport'));
    }
}
