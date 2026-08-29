<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingCard;
use App\Models\Employee;
use Illuminate\Http\Request;

class ParkingCardController extends Controller
{
    public function index()
    {
        $cards = ParkingCard::with('employee')->orderBy('assigned_date', 'desc')->paginate(15);
        $employees = Employee::where('is_active', true)->orderBy('first_name')->get();
        return view('admin.parking_cards.index', compact('cards', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'card_number' => 'required|string|max:255|unique:parking_cards,card_number',
            'vehicle_number' => 'required|string|max:255',
            'assigned_date' => 'required|date'
        ]);

        // Optional: restrict 1 active parking card per employee
        $exists = ParkingCard::where('employee_id', $validated['employee_id'])->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'This employee already has an active parking card. Please revoke it before assigning a new one.');
        }

        ParkingCard::create($validated);
        return redirect()->back()->with('success', 'Parking Card mapped and assigned successfully.');
    }

    public function destroy(ParkingCard $parkingCard)
    {
        $parkingCard->delete();
        return redirect()->back()->with('success', 'Parking Card assignment revoked.');
    }
}
