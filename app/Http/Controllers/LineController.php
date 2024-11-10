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
        $request->validate([
            'nameLine' => 'required|string|max:255',
        ]);

        line::create($request->all());
        return redirect()->route('lines.index');
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