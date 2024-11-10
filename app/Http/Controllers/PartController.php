<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\typeParts;
use App\Models\Parts;

class PartController extends Controller
{
    public function index()
    {
        $parts = Parts::with('typePart')->get();  // assuming there's a relation between Part and typeParts
        $typeParts = typeParts::all();  // Fetch all type parts
        return view('parts.index', compact('parts', 'typeParts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item' => 'required|string|max:255',
            'idType' => 'required|exists:type_parts,id',  // assuming idType is a foreign key referencing typePartss
        ]);

        Parts::create($request->all());
        return redirect()->route('parts.index');
    }

    public function edit(Parts $part)
    {
        $typePartss = typeParts::all();
        return view('parts.edit', compact('part', 'typePartss'));
    }

    public function update(Request $request, Parts $part)
    {
        $request->validate([
            'item' => 'required|string|max:255',
            'idType' => 'required|exists:type_parts,id',
        ]);

        $part->update($request->all());
        return redirect()->route('parts.index');
    }

    public function destroy(Parts $part)
    {
        $part->delete();
        return redirect()->route('parts.index');
    }
}