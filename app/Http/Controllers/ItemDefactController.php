<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\itemDefects;
use App\Models\typeDefect;

class ItemDefactController extends Controller
{
    public function index()
    {
        $itemDefacts = itemDefects::with('typeDefact')->get();
        $typeDefacts = typeDefect::all();
        return view('item_defacts.index', compact('itemDefacts', 'typeDefacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idTypeDefact' => 'required|exists:type_defects,id',
            'itemDefact' => 'required|string|max:255',
        ]);

        itemDefects::create($request->all());

        return redirect()->route('item_defacts.index')->with('success', 'Item Defact created successfully.');
    }

    public function edit(itemDefects $itemDefact)
    {
        $typeDefacts = typeDefect::all();
        return view('item_defacts.edit', compact('itemDefact', 'typeDefacts'));
    }

    public function update(Request $request, itemDefects $itemDefact)
    {
        $request->validate([
            'idTypeDefact' => 'required|exists:type_defects,id',
            'itemDefact' => 'required|string|max:255',
        ]);

        $itemDefact->update($request->all());

        return redirect()->route('item_defacts.index')->with('success', 'Item Defact updated successfully.');
    }

    public function destroy(itemDefects $itemDefact)
    {
        $itemDefact->delete();
        return redirect()->route('item_defacts.index')->with('success', 'Item Defact deleted successfully.');
    }
}