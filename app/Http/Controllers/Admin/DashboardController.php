<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('is_active', true)->count();
        $pendingLeaves = Leave::where('status', 'Pending')->count();
        
        // Placeholder for upcoming birthdays depending on how they're calculated natively
        $upcomingBirthdays = 0;

        return view('admin.dashboard', compact('totalEmployees', 'activeEmployees', 'pendingLeaves', 'upcomingBirthdays'));
    }
}
