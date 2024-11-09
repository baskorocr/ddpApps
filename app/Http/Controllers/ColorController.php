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
        $validated = $request->validate([
            'color' => 'required|string|max:255',
        ]);

        // Store the color
        Colors::create($validated);

        return response()->json(['success' => true, 'message' => 'Color added successfully']);
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

        return response()->json(['success' => true, 'message' => 'Color updated successfully']);
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