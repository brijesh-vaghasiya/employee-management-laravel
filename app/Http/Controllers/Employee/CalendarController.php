<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Leave;
use App\Models\Holiday;
use App\Models\Employee;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            return redirect()->route('employee.dashboard')->with('error', 'Profile not linked.');
        }

        $events = [];

        // 1. Fetch Holidays
        $holidays = Holiday::all();
        foreach ($holidays as $holiday) {
            $events[] = [
                'title' => 'Holiday: ' . $holiday->name,
                'start' => $holiday->holiday_date,
                'allDay' => true,
                'color' => '#198754', // green
                'display' => 'background'
            ];
        }

        // 2. Fetch My Leaves
        $leaves = Leave::where('employee_id', $employee->id)->get();
        foreach ($leaves as $leave) {
            $end = Carbon::parse($leave->to_date)->addDay()->format('Y-m-d');
            $color = $leave->status == 'Approved' ? '#0d6efd' : ($leave->status == 'Pending' ? '#6c757d' : '#dc3545');
            $events[] = [
                'title' => 'My Leave (' . $leave->status . ')',
                'start' => $leave->from_date,
                'end' => $end,
                'allDay' => true,
                'color' => $color,
            ];
        }

        // 3. Fetch Birthdays globally for team awareness
        $employees = Employee::where('is_active', true)->whereNotNull('dob')->get();
        $currentYear = Carbon::now()->year;
        foreach ($employees as $emp) {
            $dob = Carbon::parse($emp->dob);
            $birthdayDate = Carbon::createFromDate($currentYear, $dob->month, $dob->day)->format('Y-m-d');
            
            $events[] = [
                'title' => '🎂 ' . $emp->first_name . ' ' . substr($emp->last_name, 0, 1) . '.',
                'start' => $birthdayDate,
                'allDay' => true,
                'color' => '#ffc107',
                'textColor' => '#000'
            ];
        }

        return view('employee.calendar.index', compact('events'));
    }
}
