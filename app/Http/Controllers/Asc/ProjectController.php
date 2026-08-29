<?php

namespace App\Http\Controllers\Asc;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('roles')->orderBy('name')->paginate(15);
        return view('asc.projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:projects,name',
            'description' => 'required|string',
        ]);

        Project::create($validated);
        return redirect()->back()->with('success', 'Project created successfully.');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:projects,name,' . $project->id,
            'description' => 'required|string',
        ]);

        $project->update($validated);
        return redirect()->back()->with('success', 'Project details updated.');
    }
    
    public function storeRole(Request $request, Project $project)
    {
        $validated = $request->validate([
            'role_name' => 'required|string|max:255',
        ]);

        $project->roles()->create($validated);
        return redirect()->back()->with('success', 'Project Role binding created.');
    }

    public function destroyRole(\App\Models\ProjectRole $projectRole)
    {
        $projectRole->delete();
        return redirect()->back()->with('success', 'Project Role mapping destroyed.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('success', 'Project and cascading roles destroyed totally.');
    }
}
