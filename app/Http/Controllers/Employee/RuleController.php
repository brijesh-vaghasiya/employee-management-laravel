<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index()
    {
        $rules = Rule::orderBy('created_at', 'asc')->get();
        return view('employee.rules', compact('rules'));
    }
}
