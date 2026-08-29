<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReport;
use Carbon\Carbon;

class DailyReportController extends Controller
{
    public function index(Request $request)
    {
        $query = DailyReport::with('employee');
        
        $date = $request->input('date', Carbon::today()->toDateString());
        
        if ($date) {
            $query->whereDate('date', $date);
        }
        
        $reports = $query->orderBy('status', 'desc')->paginate(25);
        return view('admin.daily_reports.index', compact('reports', 'date'));
    }

    public function show(DailyReport $dailyReport)
    {
        $dailyReport->load('employee');
        return view('admin.daily_reports.show', compact('dailyReport'));
    }

    public function updateStatus(Request $request, DailyReport $dailyReport)
    {
        $request->validate(['status' => 'required|in:Pending,Verified']);
        $dailyReport->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Report verification status updated.');
    }
}
