<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\TshirtAssign;
use App\Models\ParkingCard;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        if (!$employee) return redirect()->route('employee.dashboard')->with('error', 'Profile not linked.');
        $employeeId = $employee->id;
        
        $tshirts = TshirtAssign::with('tshirt')
            ->where('employee_id', $employeeId)
            ->orderBy('assigned_date', 'desc')
            ->get();
            
        $parkingCards = ParkingCard::where('employee_id', $employeeId)
            ->orderBy('assigned_date', 'desc')
            ->get();
            
        return view('employee.assets.index', compact('tshirts', 'parkingCards'));
    }
}
