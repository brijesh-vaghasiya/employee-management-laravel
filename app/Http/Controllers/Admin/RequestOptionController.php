<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestOption;
use Illuminate\Http\Request;

class RequestOptionController extends Controller
{
    public function index()
    {
        $options = RequestOption::orderBy('name')->paginate(15);
        return view('admin.request_options.index', compact('options'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:request_options,name',
        ]);

        RequestOption::create($validated);
        return redirect()->back()->with('success', 'Request category added successfully.');
    }

    public function update(Request $request, RequestOption $requestOption)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:request_options,name,' . $requestOption->id,
        ]);

        $requestOption->update($validated);
        return redirect()->back()->with('success', 'Request category updated successfully.');
    }

    public function destroy(RequestOption $requestOption)
    {
        $requestOption->delete();
        return redirect()->back()->with('success', 'Request category deleted.');
    }
}
