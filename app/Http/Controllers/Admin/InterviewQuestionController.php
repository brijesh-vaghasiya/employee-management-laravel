<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterviewQuestion;
use App\Models\InterviewCategory;
use Illuminate\Http\Request;

class InterviewQuestionController extends Controller
{
    public function index(Request $request)
    {
        $query = InterviewQuestion::with('category');
        
        if ($request->filled('category_id')) {
            $query->where('interview_category_id', $request->category_id);
        }
        
        $questions = $query->paginate(20);
        $categories = InterviewCategory::orderBy('name')->get();
        
        return view('admin.interview_questions.index', compact('questions', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'interview_category_id' => 'required|exists:interview_categories,id',
            'question' => 'required|string',
        ]);

        InterviewQuestion::create($validated);
        return redirect()->back()->with('success', 'Question created successfully.');
    }

    public function update(Request $request, InterviewQuestion $interviewQuestion)
    {
        $validated = $request->validate([
            'interview_category_id' => 'required|exists:interview_categories,id',
            'question' => 'required|string',
        ]);

        $interviewQuestion->update($validated);
        return redirect()->back()->with('success', 'Question updated successfully.');
    }

    public function destroy(InterviewQuestion $interviewQuestion)
    {
        $interviewQuestion->delete();
        return redirect()->back()->with('success', 'Question deleted successfully.');
    }
}
