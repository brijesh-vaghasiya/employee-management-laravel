<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appraisal;

class AppraisalController extends Controller
{
    public function index(Request $request)
    {
        $query = Appraisal::with(['employee', 'reviewCycle']);
        
        if ($request->has('cycle_id') && $request->cycle_id != '') {
            $query->where('review_cycle_id', $request->cycle_id);
        }
        
        $appraisals = $query->orderBy('created_at', 'desc')->paginate(15);
        $cycles = \App\Models\ReviewCycle::orderBy('created_at', 'desc')->get();
        
        return view('admin.appraisals.index', compact('appraisals', 'cycles'));
    }

    public function show(Appraisal $appraisal)
    {
        return view('admin.appraisals.show', compact('appraisal'));
    }

    public function update(Request $request, Appraisal $appraisal)
    {
        $request->validate([
            'manager_review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $appraisal->update([
            'manager_review' => $request->manager_review,
            'rating' => $request->rating,
            'status' => 'Evaluated'
        ]);

        return redirect()->route('admin.appraisals.index')->with('success', 'Appraisal evaluated successfully.');
    }
    
    public function destroy(Appraisal $appraisal)
    {
        $appraisal->delete();
        return redirect()->route('admin.appraisals.index')->with('success', 'Appraisal record purged.');
    }
}
