<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            // Failsafe in case employee data doesn't exist for user
            return view('employee.dashboard', [
                'error' => 'Employee record not found for this user. Please contact HR to link your Employee Profile.',
                'employee' => null,
                'todayTimesheet' => null,
                'activeLeaves' => collect(),
                'upcomingHolidays' => collect(),
                'upcomingBirthdays' => collect(),
            ]);
        }

        $today = Carbon::today()->format('Y-m-d');
        
        $todayTimesheet = Timesheet::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        $activeLeaves = Leave::where('employee_id', $employee->id)
            ->where('status', 'Approved')
            ->where('from_date', '<=', $today)
            ->where('to_date', '>=', $today)
            ->get();

        $upcomingHolidays = \App\Models\Holiday::whereDate('holiday_date', '>=', $today)
            ->orderBy('holiday_date', 'asc')
            ->take(4)->get();

        $employeesWithDob = \App\Models\Employee::where('is_active', true)->whereNotNull('dob')->get();
        $upcomingBirthdays = $employeesWithDob->filter(function($emp) {
            $todayCarbon = Carbon::today();
            $dob = Carbon::parse($emp->dob);
            $nextBirthday = Carbon::createFromDate($todayCarbon->year, $dob->month, $dob->day);
            if ($nextBirthday->isPast() && !$nextBirthday->isToday()) {
                $nextBirthday->addYear();
            }
            $emp->next_birthday = $nextBirthday;
            return true;
        })->sortBy('next_birthday')->values()->take(4);
        
        return view('employee.dashboard', compact('employee', 'todayTimesheet', 'activeLeaves', 'upcomingHolidays', 'upcomingBirthdays'));
    }
}
