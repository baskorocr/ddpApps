<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\itemDefects;
use App\Models\typeParts;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Colors;
use Illuminate\Http\RedirectResponse;
use App\Models\Dept;
use App\Models\endRepaint;
use App\Models\fixDefact;
use App\Models\fixProses;
use App\Models\line;
use App\Models\outTotal;
use App\Models\Parts;
use App\Models\shift;
use App\Models\tempDefact;
use App\Models\typeDefect;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::All();

        return view('supervisor.user', compact('user')); // Make sure this view exists
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dept = Dept::all();

        return view('supervisor.usermanagement.create', compact('dept')); // Return view for creating user
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'npk' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|max:50', // Include role in validation
            'noWa' => 'nullable|string|max:15', // Make WhatsApp number optional
        ]);

        User::create([
            'npk' => $request->npk,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role, // Include role in creation
            'noWa' => $request->noWa, // Store the WhatsApp number (nullable)
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Hapus user dari database
        $user->delete();

        // Redirect kembali ke halaman daftar user dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }

    public function home()
    {

        return view('user.home', );
    }

    public function q1()
    {
        $types = typeParts::all();
        $lines = line::all();
        $colors = Colors::all();
        $shifts = shift::all();
        $group = itemDefects::select('item_defects.idTypeDefact', 'type_defects.type as nameType')
            ->selectRaw('GROUP_CONCAT(item_defects.id SEPARATOR ", ") AS idItemDefacts')
            ->selectRaw('GROUP_CONCAT(item_defects.itemDefact SEPARATOR ", ") AS itemDefacts')
            ->join('type_defects', 'item_defects.idTypeDefact', '=', 'type_defects.id')
            ->groupBy('item_defects.idTypeDefact', 'type_defects.type')
            ->get();


        $idItemDefactsArray = explode(', ', $group[0]->idItemDefacts);
        $idItemDefactsArrayGroup1 = explode(', ', $group[1]->idItemDefacts);
        $idItemDefactsArrayGroup2 = explode(', ', $group[2]->idItemDefacts);



        foreach ($group as $item) {
            // Memecah string menjadi array
            $item->itemDefacts = explode(', ', $item->itemDefacts);
        }
        return view('user.q1', compact('types', 'lines', 'colors', 'group', 'shifts', 'idItemDefactsArray', 'idItemDefactsArrayGroup1', 'idItemDefactsArrayGroup2'));
    }
    public function q2()
    {

        $types = typeParts::all();
        $lines = line::all();
        $colors = Colors::all();
        $shifts = shift::all();
        $group = itemDefects::select('item_defects.idTypeDefact', 'type_defects.type as nameType')
            ->selectRaw('GROUP_CONCAT(item_defects.id SEPARATOR ", ") AS idItemDefacts')
            ->selectRaw('GROUP_CONCAT(item_defects.itemDefact SEPARATOR ", ") AS itemDefacts')
            ->join('type_defects', 'item_defects.idTypeDefact', '=', 'type_defects.id')
            ->groupBy('item_defects.idTypeDefact', 'type_defects.type')
            ->get();
        $typeDefacts = typeDefect::all();
        $tempData = tempDefact::get()->first();

        $idItemDefactsArray = explode(', ', $group[0]->idItemDefacts);
        $idItemDefactsArrayGroup1 = explode(', ', $group[1]->idItemDefacts);
        $idItemDefactsArrayGroup2 = explode(', ', $group[2]->idItemDefacts);



        foreach ($group as $item) {
            // Memecah string menjadi array
            $item->itemDefacts = explode(', ', $item->itemDefacts);
        }

        return view('user.q2', compact('types', 'lines', 'group', 'typeDefacts', 'colors', 'shifts', 'idItemDefactsArray', 'idItemDefactsArrayGroup1', 'idItemDefactsArrayGroup2', 'tempData'));

    }

    public function getItemDefactsByType($typeId)
    {
        $itemDefacts = itemDefects::where('idTypeDefact', $typeId)->get();
        return response()->json($itemDefacts);
    }

    public function getPartNames($typeId)
    {

        $items = Parts::where('idType', $typeId)->get(['id', 'item']); // Adjust the fields as necessary

        return response()->json($items);
    }

    public function storeReqQ1(Request $request)
    {



        $validator = $request->validate([

            'idPart' => 'required|integer',
            'idColor' => 'required|string',
            'inspector_npk' => 'required|string',
            'date' => 'required|date',
            'idShift' => 'required|integer',


            // 'line' => 'required|string', // Ensure line is validated
        ]);



        if ($request->input('nameTypeDefact') == 'ok') { //jika ok masuk table fix utk rsp

            fixProses::create([
                'idStatusOK' => 1,
                'idPart' => $request->input('idPart'),
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'keterangan_OK' => $request->input('nameTypeDefact'),
                'role' => 'Q1',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);

        }
        // elseif($request->input('idTypeDefact')){ //jika out total masuk ke table

        // }
        elseif ($request->input('nameTypeDefact') == 'REPAIR') {


            endRepaint::create([
                'idItemDefact' => $request->input('idItemDefact'),
                'idPart' => $request->input('idPart'),
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'role' => 'Q1',
                'keterangan_defact' => $request->input('nameTypeDefact'),
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);

        } elseif ($request->input('nameTypeDefact') == 'BUFFING') {



            tempDefact::create([
                'idItemDefact' => $request->input('idItemDefact'),
                'idPart' => $request->input('idPart'),
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'role' => 'Q1',
                'keterangan_defact' => $request->input('nameTypeDefact'),
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);

        } else {


            outTotal::create([
                'idItemDefact' => $request->input('idItemDefact'),
                'idPart' => $request->input('idPart'),
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'role' => 'Q1',
                'keterangan_defact' => $request->input('nameTypeDefact'),
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')

            ]);

        }

        // Process the data (e.g., save to the database)
        // Example: Defact::create($request->all());

        // Simulate successful response
        return response()->json(['message' => 'Data submitted successfully!']);
    }

    public function storeReqQ2(Request $request)
    {

        $validator = $request->validate([

            'idPart' => 'required|integer',
            'idProses' => 'required|integer'


            // 'line' => 'required|string', // Ensure line is validated
        ]);




        if ($request->input('idProses') == null) {
            return "Dasdas";
        }

        $temp = tempDefact::findOrFail($request->input('idProses'));


        if ($request->input('nameTypeDefact') == 'ok') { //jika ok masuk table fix utk rsp

            fixProses::create([
                'idStatusOK' => 2,
                'idPart' => $temp->idPart,
                'role' => 'Q2',
                'idColor' => $temp->idColor,
                'idShift' => $temp->idShift,
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'keterangan_OK' => 'ok_buffing',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);
            $temp->delete();

        }
        // elseif($request->input('idTypeDefact')){ //jika out total masuk ke table

        // }
        elseif ($request->input('nameTypeDefact') == 'REPAINT') {


            endRepaint::create([
                'idItemDefact' => $temp->idItemDefact,
                'idPart' => $temp->idPart,
                'idColor' => $temp->idColor,
                'idShift' => $temp->idShift,
                'role' => 'Q2',
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'keterangan_defact' => $request->input('nameTypeDefact'),
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);
            $temp->delete();

        } else {


            outTotal::create([
                'idItemDefact' => $request->input('idItemDefact'),
                'idPart' => $request->input('idPart'),
                'role' => 'Q2',
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'keterangan_defact' => $request->input('nameTypeDefact'),
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);
            $temp->delete();

        }

        // Process the data (e.g., save to the database)
        // Example: Defact::create($request->all());

        // Simulate successful response
        return redirect()->url('/users/q2');


    }

    public function getData(Request $request)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'idcolor' => 'required|integer', // color
            'idItemDefact' => 'required|string', // item defact
            'idPart' => 'required|integer', // id part
            'keterangan_defact' => 'required|string' // fixed typo
        ]);



        try {
            // Fetch defect groups based on typeId and itemId
            $tempDefact = tempDefact::with('color', 'part', 'part.type', 'itemDefact')
                ->where('keterangan_defact', $validatedData['keterangan_defact'])
                ->where('idPart', $validatedData['idPart'])
                ->where('idColor', $validatedData['idcolor'])
                ->where('idItemDefact', $validatedData['idItemDefact'])
                ->get();




            // Format the response data
            $data = $tempDefact->map(function ($group) {
                return [
                    'id' => $group->id,  // Assuming 'title' is a column in DefectGroup
                    'keterangan_defact' => $group->keterangan_defact,
                    'idPart' => $group->idPart,
                    'partName' => $group->part->item,
                    'idTypePart' => $group->part->type->id,
                    'nameItemDefact' => $group->itemDefact->itemDefact,
                    'itemDefacts' => $group->itemDefact,  // Assuming 'name' is the attribute of defectItems
                    'idcolor' => $group->idColor,
                    'color' => $group->color->color,
                    'idShift' => $group->idShift
                ];
            });


            return \Response::json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return \Response::json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }

    }



}