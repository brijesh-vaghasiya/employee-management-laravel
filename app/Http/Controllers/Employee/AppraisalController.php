<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appraisal;
use App\Models\ReviewCycle;
use Illuminate\Support\Facades\Auth;

class AppraisalController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) abort(403);
        
        $activeCycles = ReviewCycle::where('is_active', true)->orderBy('created_at', 'desc')->get();
        $appraisals = Appraisal::with('reviewCycle')->where('employee_id', $employee->id)->orderBy('created_at', 'desc')->get();
        
        return view('employee.appraisals.index', compact('activeCycles', 'appraisals', 'employee'));
    }

    public function create(Request $request)
    {
        $cycle = ReviewCycle::findOrFail($request->cycle_id);
        return view('employee.appraisals.create', compact('cycle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'review_cycle_id' => 'required|exists:review_cycles,id',
            'self_review' => 'required|string|min:50'
        ]);

        $employee = Auth::user()->employee;

        // Ensure user hasn't already submitted
        if (Appraisal::where('employee_id', $employee->id)->where('review_cycle_id', $request->review_cycle_id)->exists()) {
            return redirect()->route('employee.appraisals.index')->with('error', 'You have already submitted an appraisal for this cycle.');
        }

        Appraisal::create([
            'employee_id' => $employee->id,
            'review_cycle_id' => $request->review_cycle_id,
            'self_review' => $request->self_review,
            'status' => 'Employee Submitted'
        ]);

        return redirect()->route('employee.appraisals.index')->with('success', 'Self Appraisal submitted successfully.');
    }

    public function show(Appraisal $appraisal)
    {
        if ($appraisal->employee_id !== Auth::user()->employee->id) abort(403);
        return view('employee.appraisals.show', compact('appraisal'));
    }}
