<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;

use App\Models\typeParts;

class TypePartController extends Controller
{
    public function index()
    {
        $typeParts = typeParts::all();
        $customers = customer::all();


        return view('type_parts.index', compact('typeParts', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'idCustomer' => 'required|integer',
        ]);

        typeParts::create($validated);
        return redirect()->back()->with('success', 'Type Part added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'idCustomer' => 'required|integer',
        ]);

        $typePart = typeParts::findOrFail($id);
        $typePart->update($validated);
        return redirect()->back()->with('success', 'Type Part updated successfully!');
    }

    public function destroy($id)
    {
        typeParts::destroy($id);
        return redirect()->back()->with('success', 'Type Part deleted successfully!');
    }
}