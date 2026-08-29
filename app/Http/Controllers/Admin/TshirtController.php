<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tshirt;
use Illuminate\Http\Request;

class TshirtController extends Controller
{
    public function index()
    {
        $tshirts = Tshirt::orderBy('design_name')->paginate(15);
        return view('admin.tshirts.index', compact('tshirts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'design_name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'size' => 'required|string|max:50',
        ]);

        Tshirt::create($validated);
        return redirect()->back()->with('success', 'T-Shirt inventory added successfully.');
    }

    public function update(Request $request, Tshirt $tshirt)
    {
        $validated = $request->validate([
            'design_name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'size' => 'required|string|max:50',
        ]);

        $tshirt->update($validated);
        return redirect()->back()->with('success', 'T-Shirt inventory updated successfully.');
    }

    public function destroy(Tshirt $tshirt)
    {
        $tshirt->delete();
        return redirect()->back()->with('success', 'T-Shirt inventory item deleted.');
    }
}
