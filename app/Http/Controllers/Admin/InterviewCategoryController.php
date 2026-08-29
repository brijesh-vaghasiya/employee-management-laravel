<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterviewCategory;
use Illuminate\Http\Request;

class InterviewCategoryController extends Controller
{
    public function index()
    {
        $categories = InterviewCategory::orderBy('name')->paginate(15);
        return view('admin.interview_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:interview_categories,name',
        ]);

        InterviewCategory::create($validated);
        return redirect()->route('admin.interview_categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, InterviewCategory $interviewCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:interview_categories,name,' . $interviewCategory->id,
        ]);

        $interviewCategory->update($validated);
        return redirect()->route('admin.interview_categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(InterviewCategory $interviewCategory)
    {
        $interviewCategory->delete();
        return redirect()->route('admin.interview_categories.index')->with('success', 'Category deleted successfully.');
    }
}
