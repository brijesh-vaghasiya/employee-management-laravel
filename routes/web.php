<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\CalendarController as AdminCalendar;
use App\Http\Controllers\Admin\TimesheetController as AdminTimesheet;
use App\Http\Controllers\Admin\LeaveController as AdminLeave;
use App\Http\Controllers\Admin\HolidayController as AdminHoliday;
use App\Http\Controllers\Admin\RuleController as AdminRule;
use App\Http\Controllers\Admin\DocumentController as AdminDocument;
use App\Http\Controllers\Admin\EmployeeDocumentController as AdminEmployeeDocument;
use App\Http\Controllers\Admin\InterviewCategoryController;
use App\Http\Controllers\Admin\InterviewQuestionController;
use App\Http\Controllers\Admin\InterviewController;
use App\Http\Controllers\Admin\TshirtController;
use App\Http\Controllers\Admin\TshirtAssignController;
use App\Http\Controllers\Admin\RequestOptionController;
use App\Http\Controllers\Admin\EmployeeRequestController;
use App\Http\Controllers\Admin\ParkingCardController;
use App\Http\Controllers\Employee\AuthController as EmployeeAuth;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboard;
use App\Http\Controllers\Employee\CalendarController as EmployeeCalendar;
use App\Http\Controllers\Employee\ProfileController as EmployeeProfile;
use App\Http\Controllers\Employee\TimesheetController as EmployeeTimesheet;
use App\Http\Controllers\Employee\LeaveController as EmployeeLeave;
use App\Http\Controllers\Employee\HolidayController as EmployeeHoliday;
use App\Http\Controllers\Employee\DocumentController as EmployeeDocument;
use App\Http\Controllers\Employee\RequestController as EmployeeRequest;
use App\Http\Controllers\Employee\AssetController as EmployeeAsset;
use App\Http\Controllers\Employee\RuleController as EmployeeRule;
use App\Http\Controllers\Asc\AuthController as AscAuth;
use App\Http\Controllers\Asc\DashboardController as AscDashboard;
use App\Http\Controllers\Asc\LogController as AscLog;
use App\Http\Controllers\Asc\ProjectController as AscProject;

Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'employee') return redirect()->route('employee.dashboard');
        if ($role === 'asc') return redirect()->route('asc.dashboard');
    }
    return view('welcome');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuth::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuth::class, 'login']);
    Route::post('/logout', [AdminAuth::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('/calendar', [AdminCalendar::class, 'index'])->name('calendar.index');
        Route::resource('employees', EmployeeController::class);
        Route::get('/timesheets', [AdminTimesheet::class, 'index'])->name('timesheets.index');
        Route::get('/leaves', [AdminLeave::class, 'index'])->name('leaves.index');
        Route::put('/leaves/{leave}/status', [AdminLeave::class, 'updateStatus'])->name('leaves.updateStatus');
        Route::resource('holidays', AdminHoliday::class);
        Route::resource('rules', AdminRule::class);
        Route::resource('documents', AdminDocument::class);
        Route::resource('employee_documents', AdminEmployeeDocument::class);
        
        // Interview Management
        Route::resource('interview_categories', InterviewCategoryController::class)->except(['create', 'show', 'edit']);
        Route::resource('interview_questions', InterviewQuestionController::class)->except(['create', 'show', 'edit']);
        Route::get('interviews/{interview}/evaluate', [InterviewController::class, 'evaluate'])->name('interviews.evaluate');
        Route::post('interviews/{interview}/evaluate', [InterviewController::class, 'saveEvaluation'])->name('interviews.save_evaluation');
        Route::resource('interviews', InterviewController::class);

        // Phase 9 Subsystems - Admin
        Route::resource('tshirts', TshirtController::class)->except(['create', 'show', 'edit']);
        Route::resource('tshirt_assigns', TshirtAssignController::class)->only(['index', 'store', 'destroy']);
        Route::resource('request_options', RequestOptionController::class)->except(['create', 'show', 'edit']);
        Route::resource('employee_requests', EmployeeRequestController::class)->only(['index', 'update', 'destroy']);
        Route::resource('parking_cards', ParkingCardController::class)->only(['index', 'store', 'destroy']);
        // Removed duplicate announcements route
        
        // Phase 8 Subsystems - Payroll
        Route::resource('payslips', \App\Http\Controllers\Admin\PayslipController::class);
        
        // Phase 9 Subsystems - Expenses
        Route::resource('expense_claims', \App\Http\Controllers\Admin\ExpenseClaimController::class)->except(['create', 'store', 'edit']);
        Route::put('expense_claims/{expense_claim}/status', [\App\Http\Controllers\Admin\ExpenseClaimController::class, 'updateStatus'])->name('expense_claims.updateStatus');

        // Phase 10 Subsystems - Projects & Tasks
        Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class);
        Route::resource('tasks', \App\Http\Controllers\Admin\TaskController::class);
        
        // Phase 11 - Performance Appraisals
        Route::resource('review_cycles', \App\Http\Controllers\Admin\ReviewCycleController::class)->except(['show']);
        Route::resource('appraisals', \App\Http\Controllers\Admin\AppraisalController::class)->except(['create', 'store', 'edit']);
        
        // Phase 12 - Ticketing
        Route::resource('tickets', \App\Http\Controllers\Admin\TicketController::class)->only(['index', 'show']);
        Route::put('tickets/{ticket}/status', [\App\Http\Controllers\Admin\TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
        Route::post('tickets/{ticket}/reply', [\App\Http\Controllers\Admin\TicketController::class, 'reply'])->name('tickets.reply');
        
        // Phase 13 - Daily Reporting (Admin)
        Route::resource('daily_reports', \App\Http\Controllers\Admin\DailyReportController::class)->only(['index', 'show']);
        Route::put('daily_reports/{daily_report}/status', [\App\Http\Controllers\Admin\DailyReportController::class, 'updateStatus'])->name('daily_reports.updateStatus');
    });
});

// Employee Routes
Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('/login', [EmployeeAuth::class, 'showLogin'])->name('login');
    Route::post('/login', [EmployeeAuth::class, 'login']);
    Route::post('/logout', [EmployeeAuth::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'employee'])->group(function () {
        Route::get('/dashboard', [EmployeeDashboard::class, 'index'])->name('dashboard');
        Route::get('/calendar', [EmployeeCalendar::class, 'index'])->name('calendar.index');
        Route::get('/profile', [EmployeeProfile::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [EmployeeProfile::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [EmployeeProfile::class, 'update'])->name('profile.update');
        Route::get('/profile/password', [EmployeeProfile::class, 'changePasswordForm'])->name('password.change');
        Route::put('/profile/password', [EmployeeProfile::class, 'updatePassword'])->name('password.update');
        Route::get('/timesheets', [EmployeeTimesheet::class, 'index'])->name('timesheets.index');
        Route::post('/timesheets/clock-in', [EmployeeTimesheet::class, 'clockIn'])->name('timesheets.clockIn');
        Route::post('/timesheets/intermediate-start', [EmployeeTimesheet::class, 'startIntermediate'])->name('timesheets.startIntermediate');
        Route::post('/timesheets/intermediate-end', [EmployeeTimesheet::class, 'endIntermediate'])->name('timesheets.endIntermediate');
        Route::post('/timesheets/clock-out', [EmployeeTimesheet::class, 'clockOut'])->name('timesheets.clockOut');
        Route::get('/leaves', [EmployeeLeave::class, 'index'])->name('leaves.index');
        Route::get('/leaves/create', [EmployeeLeave::class, 'create'])->name('leaves.create');
        Route::post('/leaves', [EmployeeLeave::class, 'store'])->name('leaves.store');
        
        Route::get('holidays', [EmployeeHoliday::class, 'index'])->name('holidays.index');
        Route::get('documents', [EmployeeDocument::class, 'index'])->name('documents.index');
        
        // Employee Subsystems
        Route::resource('requests', EmployeeRequest::class)->only(['index', 'store']);
        Route::get('assets', [EmployeeAsset::class, 'index'])->name('assets.index');
        Route::get('/rules', [EmployeeRule::class, 'index'])->name('rules.index');
        Route::resource('payslips', \App\Http\Controllers\Employee\PayslipController::class)->only(['index', 'show']);
        Route::resource('expense_claims', \App\Http\Controllers\Employee\ExpenseClaimController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
        Route::resource('tasks', \App\Http\Controllers\Employee\TaskController::class)->only(['index', 'update']);
        Route::resource('appraisals', \App\Http\Controllers\Employee\AppraisalController::class)->only(['index', 'create', 'store', 'show']);
        
        Route::resource('tickets', \App\Http\Controllers\Employee\TicketController::class)->only(['index', 'create', 'store', 'show']);
        Route::post('tickets/{ticket}/reply', [\App\Http\Controllers\Employee\TicketController::class, 'reply'])->name('tickets.reply');
        
        // Phase 13 - Daily Reporting (Employee)
        Route::resource('daily_reports', \App\Http\Controllers\Employee\DailyReportController::class)->only(['index', 'create', 'store', 'show']);
    });
});

// ASC Routes
Route::prefix('asc')->name('asc.')->group(function () {
    Route::get('/login', [AscAuth::class, 'showLogin'])->name('login');
    Route::post('/login', [AscAuth::class, 'login']);
    Route::post('/logout', [AscAuth::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'asc'])->group(function () {
        Route::get('/dashboard', [AscDashboard::class, 'index'])->name('dashboard');
        
        // Logs
        Route::get('/logs/login', [AscLog::class, 'loginLogs'])->name('logs.login');
        Route::get('/logs/system', [AscLog::class, 'systemLogs'])->name('logs.system');
        
        // Projects
        Route::resource('projects', AscProject::class)->except(['create', 'show', 'edit']);
        Route::post('projects/{project}/roles', [AscProject::class, 'storeRole'])->name('projects.roles.store');
        Route::delete('projects/roles/{projectRole}', [AscProject::class, 'destroyRole'])->name('projects.roles.destroy');
    });
});

// File Download Wrapper Proxy for Windows Local Servers
Route::get('/secure-download/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (file_exists($fullPath)) {
        return response()->file($fullPath);
    }
    abort(404, 'File not found');
})->where('path', '.*')->name('secure.download')->middleware('auth');









