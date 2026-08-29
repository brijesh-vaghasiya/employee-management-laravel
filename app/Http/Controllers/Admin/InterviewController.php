<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\InterviewCategory;
use App\Models\InterviewResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class InterviewController extends Controller
{
    public function index()
    {
        $interviews = Interview::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.interviews.index', compact('interviews'));
    }

    public function create()
    {
        return view('admin.interviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'candidate_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'interview_date' => 'required|date',
            'interviewer' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'experience' => 'nullable|string',
            'previous_company' => 'nullable|string',
            'skills' => 'nullable|string',
            'ctc' => 'nullable|numeric|min:0',
            'expected_ctc' => 'nullable|numeric|min:0',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string'
        ]);

        $data = $validated;
        
        if ($request->hasFile('cv')) {
            $data['cv_path'] = $request->file('cv')->store('resumes', 'public');
        }

        Interview::create($data);
        return redirect()->route('admin.interviews.index')->with('success', 'Interview candidate logged successfully.');
    }

    public function edit(Interview $interview)
    {
        return view('admin.interviews.edit', compact('interview'));
    }

    public function update(Request $request, Interview $interview)
    {
        $validated = $request->validate([
            'candidate_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'interview_date' => 'required|date',
            'interviewer' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'experience' => 'nullable|string',
            'previous_company' => 'nullable|string',
            'skills' => 'nullable|string',
            'ctc' => 'nullable|numeric|min:0',
            'expected_ctc' => 'nullable|numeric|min:0',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'bg_approval' => 'boolean',
            'edu_approval' => 'boolean',
            'salary_approval' => 'boolean'
        ]);

        $data = $validated;
        $data['bg_approval'] = $request->has('bg_approval');
        $data['edu_approval'] = $request->has('edu_approval');
        $data['salary_approval'] = $request->has('salary_approval');

        if ($request->hasFile('cv')) {
            if ($interview->cv_path && Storage::disk('public')->exists($interview->cv_path)) {
                Storage::disk('public')->delete($interview->cv_path);
            }
            $data['cv_path'] = $request->file('cv')->store('resumes', 'public');
        }

        $interview->update($data);
        return redirect()->route('admin.interviews.index')->with('success', 'Candidate details updated successfully.');
    }

    public function evaluate(Interview $interview)
    {
        $categories = InterviewCategory::with('questions')->orderBy('name')->get();
        // Load existing results for this interview
        $existingResults = InterviewResult::where('interview_id', $interview->id)
                            ->get()
                            ->keyBy('interview_question_id');
                            
        return view('admin.interviews.evaluate', compact('interview', 'categories', 'existingResults'));
    }

    public function saveEvaluation(Request $request, Interview $interview)
    {
        $scores = $request->input('scores', []);
        $remarks = $request->input('remarks', []);

        DB::transaction(function () use ($interview, $scores, $remarks) {
            foreach ($scores as $questionId => $score) {
                // Find or create result
                $result = InterviewResult::firstOrNew([
                    'interview_id' => $interview->id,
                    'interview_question_id' => $questionId
                ]);
                $result->score = $score;
                $result->remarks = $remarks[$questionId] ?? null;
                $result->save();
            }
        });

        // Optionally update interview status based on request
        if ($request->has('status')) {
            $interview->update(['status' => $request->input('status')]);
        }

        return redirect()->route('admin.interviews.index')->with('success', 'Candidate evaluation saved successfully.');
    }

    public function destroy(Interview $interview)
    {
        if ($interview->cv_path && Storage::disk('public')->exists($interview->cv_path)) {
            Storage::disk('public')->delete($interview->cv_path);
        }
        $interview->delete();
        return redirect()->route('admin.interviews.index')->with('success', 'Candidate deleted.');
    }
}
