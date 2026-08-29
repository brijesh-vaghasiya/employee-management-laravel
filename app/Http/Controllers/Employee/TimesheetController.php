<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimesheetController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            return redirect()->route('employee.dashboard')->with('error', 'Employee record not found.');
        }

        $today = Carbon::today()->format('Y-m-d');
        $todayTimesheet = Timesheet::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        $timesheets = Timesheet::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('employee.timesheets.index', compact('todayTimesheet', 'timesheets'));
    }

    public function clockIn(Request $request)
    {
        $employee = Auth::user()->employee;
        if (!$employee) return back()->with('error', 'Profile not linked.');
        
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $timesheet = Timesheet::firstOrCreate(
            ['employee_id' => $employee->id, 'date' => $today],
            ['in_time' => $now, 'reason_late' => $request->input('reason_late')]
        );

        return redirect()->back()->with('success', 'Clocked in successfully at ' . Carbon::parse($now)->format('h:i A'));
    }
    
    public function startIntermediate(Request $request)
    {
        $employee = Auth::user()->employee;
        if (!$employee) return back()->with('error', 'Profile not linked.');
        
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $timesheet = Timesheet::where('employee_id', $employee->id)->where('date', $today)->first();
        if ($timesheet && !$timesheet->intermediate_start) {
            $timesheet->update([
                'intermediate_start' => $now,
                'reason_intermediate' => $request->input('reason_intermediate')
            ]);
            return redirect()->back()->with('success', 'Break started at ' . Carbon::parse($now)->format('h:i A'));
        }

        return redirect()->back()->with('error', 'Unable to start break. You must be clocked in first and cannot take multiple breaks.');
    }

    public function endIntermediate(Request $request)
    {
        $employee = Auth::user()->employee;
        if (!$employee) return back()->with('error', 'Profile not linked.');
        
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $timesheet = Timesheet::where('employee_id', $employee->id)->where('date', $today)->first();
        if ($timesheet && $timesheet->intermediate_start && !$timesheet->intermediate_end) {
            $timesheet->update([
                'intermediate_end' => $now
            ]);
            return redirect()->back()->with('success', 'Break ended at ' . Carbon::parse($now)->format('h:i A'));
        }

        return redirect()->back()->with('error', 'Unable to end break.');
    }

    public function clockOut(Request $request)
    {
        $employee = Auth::user()->employee;
        if (!$employee) return back()->with('error', 'Profile not linked.');
        
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now();

        $timesheet = Timesheet::where('employee_id', $employee->id)->where('date', $today)->first();
        if ($timesheet && $timesheet->in_time && !$timesheet->out_time) {
            
            // Calculate Worked Hours
            $inTime = Carbon::parse($timesheet->in_time);
            $totalMinutes = $inTime->diffInMinutes($now);
            
            // Subtract break time if any
            if ($timesheet->intermediate_start && $timesheet->intermediate_end) {
                $breakStart = Carbon::parse($timesheet->intermediate_start);
                $breakEnd = Carbon::parse($timesheet->intermediate_end);
                $breakMinutes = $breakStart->diffInMinutes($breakEnd);
                $totalMinutes -= $breakMinutes;
            }

            // Fallback in case of missing break end
            if ($timesheet->intermediate_start && !$timesheet->intermediate_end) {
                 // Auto-end the break at clock-out time
                 $timesheet->intermediate_end = $now->format('Y-m-d H:i:s');
                 $breakStart = Carbon::parse($timesheet->intermediate_start);
                 $breakMinutes = $breakStart->diffInMinutes($now);
                 $totalMinutes -= $breakMinutes;
            }

            $decimalHours = round($totalMinutes / 60, 2);

            $timesheet->update([
                'out_time' => $now->format('Y-m-d H:i:s'),
                'reason_early' => $request->input('reason_early'),
                'worked_hours' => $decimalHours
            ]);

            return redirect()->back()->with('success', 'Clocked out successfully at ' . $now->format('h:i A'));
        }

        return redirect()->back()->with('error', 'Unable to clock out. Please check if you are clocked in today.');
    }
}
