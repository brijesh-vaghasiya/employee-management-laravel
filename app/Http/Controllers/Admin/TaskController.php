<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\Employee;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::with(['project', 'employee'])->orderBy('due_date', 'asc')->paginate(15);
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create(Request $request)
    {
        $projects = Project::where('status', 'Active')->get();
        $employees = Employee::where('is_active', true)->get();
        $selectedProject = $request->query('project_id');
        return view('admin.tasks.create', compact('projects', 'employees', 'selectedProject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'employee_id' => 'required|exists:employees,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|string',
            'due_date' => 'nullable|date',
            'status' => 'required|string'
        ]);

        Task::create($request->all());
        return redirect()->route('admin.projects.show', $request->project_id)->with('success', 'Task assigned successfully.');
    }

    public function show(Task $task)
    {
        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::where('status', 'Active')->get();
        $employees = Employee::where('is_active', true)->get();
        return view('admin.tasks.edit', compact('task', 'projects', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'employee_id' => 'required|exists:employees,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|string',
            'due_date' => 'nullable|date',
            'status' => 'required|string'
        ]);

        $task->update($request->all());
        return redirect()->route('admin.projects.show', $request->project_id)->with('success', 'Task updated.');
    }

    public function destroy(Task $task)
    {
        $projectId = $task->project_id;
        $task->delete();
        return redirect()->route('admin.projects.show', $projectId)->with('success', 'Task deleted.');
    }
}
