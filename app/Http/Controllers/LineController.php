<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\line;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lines = line::all();
        return view('lines.index', compact('lines'));
    }

    public function create()
    {
        return view('lines.create');
    }

    public function store(Request $request)
    {
        // Validate the input to ensure it's an array of line names
        $request->validate([
            'nameLine' => 'required|array',
            'nameLine.*' => 'required|string|max:255',
        ]);

        // Loop through each name in the 'nameLine' array and create a new Line
        foreach ($request->nameLine as $name) {
            Line::create(['nameLine' => $name]);
        }

        return redirect()->route('lines.index')->with('success', 'Lines added successfully.');
    }

    public function edit(line $line)
    {
        return view('lines.edit', compact('line'));
    }

    public function update(Request $request, line $line)
    {
        $request->validate([
            'nameLine' => 'required|string|max:255',
        ]);

        $line->update($request->all());
        return redirect()->route('lines.index');
    }

    public function destroy(line $line)
    {
        $line->delete();
        return redirect()->route('lines.index');
    }

    


}