<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index()
    {
        $rules = Rule::orderBy('created_at', 'asc')->paginate(15);
        return view('admin.rules.index', compact('rules'));
    }

    public function create()
    {
        return view('admin.rules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        Rule::create($validated);
        return redirect()->route('admin.rules.index')->with('success', 'Rule created successfully.');
    }

    public function edit(Rule $rule)
    {
        return view('admin.rules.edit', compact('rule'));
    }

    public function update(Request $request, Rule $rule)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $rule->update($validated);
        return redirect()->route('admin.rules.index')->with('success', 'Rule updated successfully.');
    }

    public function destroy(Rule $rule)
    {
        $rule->delete();
        return redirect()->route('admin.rules.index')->with('success', 'Rule removed.');
    }
}
