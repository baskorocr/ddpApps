<?php

namespace App\Http\Controllers;

use App\Models\Colors;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Colors::all();  // Mendapatkan semua warna dari database
        return view('colors.index', compact('colors'));
    }

    // Menyimpan warna baru
    public function store(Request $request)
    {
        $request->validate([
            'color' => 'required|array|min:1',
            'color.*' => 'required|string|max:255',
        ]);

        // Loop through each color entry and create a new Color record
        foreach ($request->color as $colorName) {
            Colors::create(['color' => $colorName]);
        }

        return response()->json(['success' => 'Colors added successfully!'], 200);
    }
    // Mengupdate data warna
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'color' => 'required|string|max:255',
        ]);

        // Update the color
        $color = Colors::findOrFail($id);
        $color->update($validated);

        return redirect()->route('colors.index');


    }

    // Menghapus warna
    public function destroy($id)
    {
        $color = Colors::findOrFail($id);
        $color->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Color deleted successfully!',
            ]);
        }

        return redirect()->route('colors.index');
    }
}