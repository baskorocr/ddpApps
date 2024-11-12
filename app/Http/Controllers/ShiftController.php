<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\shift;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = shift::all();
        return view('shifts.index', compact('shifts'));
    }


    public function store(Request $request)
    {
        // Validate the input to ensure it's an array of shift names
        $request->validate([
            'shift' => 'required|array',
            'shift.*' => 'required|string|max:255',
        ]);

        // Loop through each shift name and create a new Shift entry
        foreach ($request->shift as $shiftName) {
            Shift::create(['shift' => $shiftName]);
        }

        return redirect()->route('shifts.index')->with('success', 'Shifts added successfully.');
    }
    public function edit(shift $shift)
    {
        return view('shifts.edit', compact('shift'));
    }

    public function update(Request $request, shift $shift)
    {
        $request->validate([
            'shift' => 'required|string|max:255',
        ]);

        $shift->update([
            'shift' => $request->shift,
        ]);

        return redirect()->route('shifts.index');
    }

    public function destroy(shift $shift)
    {
        $shift->delete();
        return redirect()->route('shifts.index');
    }
}