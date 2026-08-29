<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReviewCycle;

class ReviewCycleController extends Controller
{
    public function index()
    {
        $cycles = ReviewCycle::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.review_cycles.index', compact('cycles'));
    }

    public function create()
    {
        return view('admin.review_cycles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean'
        ]);

        ReviewCycle::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.review_cycles.index')->with('success', 'Review Cycle created successfully.');
    }

    public function edit(ReviewCycle $reviewCycle)
    {
        return view('admin.review_cycles.edit', compact('reviewCycle'));
    }

    public function update(Request $request, ReviewCycle $reviewCycle)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean'
        ]);

        $reviewCycle->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.review_cycles.index')->with('success', 'Review Cycle updated.');
    }

    public function destroy(ReviewCycle $reviewCycle)
    {
        $reviewCycle->delete();
        return redirect()->route('admin.review_cycles.index')->with('success', 'Review Cycle deleted.');
    }
}
