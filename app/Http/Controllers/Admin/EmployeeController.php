<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('id', 'desc')->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email|unique:employees,email',
            'password' => 'required|min:6',
            'employee_code' => 'required|unique:employees,employee_code',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string',
            'department' => 'nullable|string',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'employee',
            ]);

            Employee::create([
                'user_id' => $user->id,
                'employee_code' => $validated['employee_code'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'designation' => $validated['designation'] ?? null,
                'department' => $validated['department'] ?? null,
                'salary' => $validated['salary'] ?? null,
                'joining_date' => $validated['joining_date'] ?? null,
                'is_active' => $validated['is_active'],
            ]);

            SystemLog::create([
                'action' => 'Employee Created',
                'description' => "Admin created employee account for {$validated['first_name']} {$validated['last_name']} ({$validated['email']})",
                'user_id' => auth()->id() ?? null,
            ]);
        });

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,'.$employee->user_id.'|unique:employees,email,'.$employee->id,
            'password' => 'nullable|min:6',
            'employee_code' => 'required|unique:employees,employee_code,'.$employee->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string',
            'department' => 'nullable|string',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        DB::transaction(function () use ($validated, $employee) {
            if ($employee->user_id) {
                $userData = [
                    'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                    'email' => $validated['email'],
                ];
                if (!empty($validated['password'])) {
                    $userData['password'] = Hash::make($validated['password']);
                }
                User::where('id', $employee->user_id)->update($userData);
            }

            $employee->update([
                'employee_code' => $validated['employee_code'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'designation' => $validated['designation'] ?? null,
                'department' => $validated['department'] ?? null,
                'salary' => $validated['salary'] ?? null,
                'joining_date' => $validated['joining_date'] ?? null,
                'is_active' => $validated['is_active'],
            ]);
        });

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        DB::transaction(function () use ($employee) {
            $employeeName = $employee->first_name . ' ' . $employee->last_name;
            
            if ($employee->user_id) {
                User::destroy($employee->user_id);
            }
            $employee->delete();

            SystemLog::create([
                'action' => 'Employee Deleted',
                'description' => "Admin deleted employee account for {$employeeName}",
                'user_id' => auth()->id() ?? null,
            ]);
        });

        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }
}
