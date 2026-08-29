<?php

namespace App\Http\Controllers\Asc;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Models\SystemLog;

class LogController extends Controller
{
    public function loginLogs()
    {
        $logs = LoginLog::orderBy('login_date', 'desc')->paginate(20);
        return view('asc.logs.login', compact('logs'));
    }

    public function systemLogs()
    {
        $logs = SystemLog::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('asc.logs.system', compact('logs'));
    }
}
