<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colors;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Colors::all();
        return view('colors.index', compact('colors'));
    }

    public function create()
    {
        return view('colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'color' => 'required|string|max:255',
        ]);

        Colors::create($request->all());
        return redirect()->route('colors.index');
    }

    public function show(Colors $color)
    {
        return view('colors.show', compact('color'));
    }

    public function edit(Colors $color)
    {
        return view('colors.edit', compact('color'));
    }

    public function update(Request $request, Colors $color)
    {
        $request->validate([
            'color' => 'required|string|max:255',
        ]);

        $color->update($request->all());
        return redirect()->route('colors.index');
    }

    public function destroy(Colors $color)
    {
        $color->delete();
        return redirect()->route('colors.index');
    }
}