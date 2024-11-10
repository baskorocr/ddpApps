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
        $request->validate([
            'shift' => 'required|string|max:255',
        ]);

        shift::create([
            'shift' => $request->shift,
        ]);

        return redirect()->route('shifts.index');
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