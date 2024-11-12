<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\typeDefect;

class TypeDefectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeDefects = typeDefect::all();

        return view('type_defects.index', compact('typeDefects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|array',
            'type.*' => 'required|string|max:255',
        ]);

        // Insert multiple entries
        $types = array_map(fn($type) => ['type' => $type], $request->type);
        TypeDefect::insert($types);

        return redirect()->route('type_defects.index')->with('success', 'Defect types added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $typeDefect = typeDefect::findOrFail($id);
        $typeDefect->update([
            'type' => $request->type,
        ]);

        return redirect()->route('type_defects.index');
    }

    public function destroy($id)
    {
        $typeDefect = typeDefect::findOrFail($id);
        $typeDefect->delete();

        return redirect()->route('type_defects.index');
    }
}