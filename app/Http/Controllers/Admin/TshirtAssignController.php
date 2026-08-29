<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TshirtAssign;
use App\Models\Tshirt;
use App\Models\Employee;
use Illuminate\Http\Request;

class TshirtAssignController extends Controller
{
    public function index()
    {
        $assignments = TshirtAssign::with(['employee', 'tshirt'])->orderBy('assigned_date', 'desc')->paginate(15);
        $tshirts = Tshirt::where('stock', '>', 0)->get();
        $employees = Employee::where('is_active', true)->orderBy('first_name')->get();
        return view('admin.tshirt_assigns.index', compact('assignments', 'tshirts', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tshirt_id' => 'required|exists:tshirts,id',
            'assigned_date' => 'required|date'
        ]);

        $tshirt = Tshirt::findOrFail($validated['tshirt_id']);
        if ($tshirt->stock <= 0) {
            return redirect()->back()->with('error', 'Selected T-Shirt is out of stock.');
        }

        TshirtAssign::create($validated);
        $tshirt->decrement('stock');

        return redirect()->back()->with('success', 'T-Shirt assigned successfully. Stock updated.');
    }

    public function destroy(TshirtAssign $tshirtAssign)
    {
        $tshirt = $tshirtAssign->tshirt;
        if ($tshirt) {
            $tshirt->increment('stock');
        }
        $tshirtAssign->delete();
        return redirect()->back()->with('success', 'Assignment revoked and stock returned.');
    }
}
