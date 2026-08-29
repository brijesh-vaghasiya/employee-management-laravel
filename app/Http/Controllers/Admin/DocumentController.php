<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::orderBy('name')->paginate(15);
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'format_type' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);

        $doc = new Document();
        $doc->name = $validated['name'];
        $doc->format_type = $validated['format_type'];

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents', 'public');
            $doc->file_path = $path;
        }

        $doc->save();
        return redirect()->route('admin.documents.index')->with('success', 'Document format created successfully.');
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'format_type' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);

        $document->name = $validated['name'];
        $document->format_type = $validated['format_type'];

        if ($request->hasFile('file')) {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            $path = $request->file('file')->store('documents', 'public');
            $document->file_path = $path;
        }

        $document->save();
        return redirect()->route('admin.documents.index')->with('success', 'Document format updated successfully.');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();
        return redirect()->route('admin.documents.index')->with('success', 'Document deleted.');
    }
}
