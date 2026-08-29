<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) abort(403);

        $tasks = Task::with('project')->where('employee_id', $employee->id)->orderBy('due_date', 'asc')->paginate(12);
        return view('employee.tasks.index', compact('tasks'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->employee_id !== Auth::user()->employee->id) abort(403);
        
        $request->validate([
            'status' => 'required|in:To Do,In Progress,Review,Done'
        ]);

        $task->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Task status updated.');
    }

}
