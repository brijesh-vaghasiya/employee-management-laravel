<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Holiday;
use App\Models\Employee;
use App\Models\Announcement;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $events = [];

        // 1. Fetch Holidays
        $holidays = Holiday::all();
        foreach ($holidays as $holiday) {
            $events[] = [
                'title' => 'Holiday: ' . $holiday->name,
                'start' => $holiday->holiday_date,
                'allDay' => true,
                'color' => '#198754', // Bootstrap success
                'display' => 'block'
            ];
        }

        // 2. Fetch Leaves (Approved)
        $leaves = Leave::with('employee')->where('status', 'Approved')->get();
        foreach ($leaves as $leave) {
            // FullCalendar exclusive end datetimes need +1 day if allDay
            $end = Carbon::parse($leave->to_date)->addDay()->format('Y-m-d');
            $events[] = [
                'title' => 'Leave: ' . ($leave->employee->first_name ?? 'Emp') . ' (' . $leave->leave_type . ')',
                'start' => $leave->from_date,
                'end' => $end,
                'allDay' => true,
                'color' => '#dc3545', // Bootstrap danger
            ];
        }

        // 3. Fetch Birthdays for active employees
        $employees = Employee::where('is_active', true)->whereNotNull('dob')->get();
        $currentYear = Carbon::now()->year;
        foreach ($employees as $employee) {
            $dob = Carbon::parse($employee->dob);
            $birthdayDate = Carbon::createFromDate($currentYear, $dob->month, $dob->day)->format('Y-m-d');
            
            $events[] = [
                'title' => '🎂 ' . $employee->first_name . '\'s Birthday',
                'start' => $birthdayDate,
                'allDay' => true,
                'color' => '#ffc107', // Bootstrap warning
                'textColor' => '#000'
            ];
        }

        return view('admin.calendar.index', compact('events'));
    }
}
