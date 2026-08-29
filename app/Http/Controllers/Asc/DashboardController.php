<?php

namespace App\Http\Controllers\Asc;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Models\SystemLog;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $loginCount = LoginLog::count();
        $sysCount = SystemLog::count();
        $projectCount = Project::count();

        $recentLogins = LoginLog::orderBy('login_date', 'desc')->limit(5)->get();
        $recentSystem = SystemLog::orderBy('created_at', 'desc')->limit(5)->get();

        return view('asc.dashboard', compact('loginCount', 'sysCount', 'projectCount', 'recentLogins', 'recentSystem'));
    }
}
