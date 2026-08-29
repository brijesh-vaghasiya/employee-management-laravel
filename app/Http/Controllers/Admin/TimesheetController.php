<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use App\Models\Employee;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function index(Request $request)
    {
        $query = Timesheet::with(['employee' => function($q) {
            $q->select('id', 'first_name', 'last_name', 'employee_code');
        }]);

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $timesheets = $query->orderBy('date', 'desc')->orderBy('in_time', 'desc')->paginate(15);
        $employees = Employee::orderBy('first_name')->get(['id', 'first_name', 'last_name', 'employee_code']);

        return view('admin.timesheets.index', compact('timesheets', 'employees'));
    }
}
