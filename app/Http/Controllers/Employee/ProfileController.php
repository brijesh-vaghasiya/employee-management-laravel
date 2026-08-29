<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            return redirect()->route('employee.dashboard')->with('error', 'Profile not found.');
        }
        return view('employee.profile.show', compact('employee'));
    }

    public function edit()
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            return redirect()->route('employee.dashboard')->with('error', 'Profile not found.');
        }
        return view('employee.profile.edit', compact('employee'));
    }

    public function update(Request $request)
    {
        $employee = Auth::user()->employee;
        
        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            // Only allow updating certain fields; email/code etc are admin controlled usually.
        ]);

        $employee->update([
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('employee.profile.show')->with('success', 'Profile updated successfully.');
    }

    public function changePasswordForm()
    {
        return view('employee.profile.password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('employee.dashboard')->with('success', 'Password changed successfully.');
    }
}
