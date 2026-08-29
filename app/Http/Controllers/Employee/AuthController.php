<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('employee.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'role' => 'employee'])) {
            $request->session()->regenerate();
            
            // Check if employee is strictly active, if not log them out immediately
            $employee = Auth::user()->employee;
            if ($employee && !$employee->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your employee account is currently inactive. Please contact HR.']);
            }

            return redirect()->intended(route('employee.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or you do not have Employee access.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('employee.login');
    }
}
