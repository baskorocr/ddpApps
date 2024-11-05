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
        $group = itemDefects::select('idTypeDefact')
            ->selectRaw('GROUP_CONCAT(itemDefact SEPARATOR ", ") AS itemDefacts')
            ->groupBy('idTypeDefact')
            ->get();



        foreach ($group as $item) {
            // Memecah string menjadi array
            $item->itemDefacts = explode(', ', $item->itemDefacts);
        }
        return view('user.q1', compact('types', 'lines', 'colors', 'group', 'shifts'));
    }
    public function q2()
    {
        $types = typeParts::all();
        $lines = line::all();
        $colors = Colors::all();

        $group = itemDefects::select('idTypeDefact')
            ->selectRaw('GROUP_CONCAT(itemDefact SEPARATOR ", ") AS itemDefacts')
            ->groupBy('idTypeDefact')
            ->get();
        $typeDefacts = typeDefect::all();

        foreach ($group as $item) {
            // Memecah string menjadi array
            $item->itemDefacts = explode(', ', $item->itemDefacts);
        }

        return view('user.q2', compact('types', 'lines', 'group', 'typeDefacts', 'colors'));

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

        $validator = \Validator::make($request->all(), [
            'itemDefact' => 'required|string',
            'part_type' => 'required|string',
            'idPart' => 'required|integer',
            'idColor' => 'required|string',
            'inspector_npk' => 'required|string',
            'date' => 'required|date',
            'idShift' => 'required|integer'

            // 'line' => 'required|string', // Ensure line is validated
        ]);


        $valid = $validator->validated();





        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()], 422);
        }



        if ($valid['itemDefact'] == 'ok') { //jika ok masuk table fix utk rsp

            fixProses::create([
                'idStatus' => $request->input('idStatus'),
                'idPart' => $valid['idPart'],
                'idColor' => $valid['idColor'],
                'idShift' => $valid['idShift'],
                'idNPK' => $valid['inspector_npk'],
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')



            ]);
        }
        // elseif($request->input('idTypeDefact')){ //jika out total masuk ke table

        // }
        else {


            tempDefact::create([
                'idPart' => $valid['idPart'],
                'idColor' => $valid['idColor'],
                'idTypeDefact' => $request->input('idTypeDefact'),
                'itemDefact' => $request->input('itemDefact'),
                'idShift' => $valid['idShift'],
                'idNPKQ1' => $valid['inspector_npk'],
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

        $validator = \Validator::make($request->all(), [
            'idProses' => 'required|integer',
            'itemDefact' => 'required|string',
            'idShift' => 'required|integer',
        ])->validate();


        $tempData = tempDefact::where('id', $validator['idProses'])->first();

        if ($request->itemDefact == 'ok') {

            fixProses::create([
                'idPart' => $tempData->idPart,
                'idColor' => $tempData->idColor,
                'idStatus' => $request->input('idStatus'),
                'idShift' => $tempData->idShift,
                'idNPK' => auth()->user()->npk,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')
            ]);
            $tempData->delete();
        } elseif ($request->input('idTypeDefact') == '2') {

            try {
                endRepaint::create([
                    'idTempDefact' => $tempData->id,
                    'idShift' => $validator['idShift'],
                    'idTypeDefact' => $request->input('idTypeDefact'),
                    'itemDefact' => $validator['itemDefact'],
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s')

                ]);

            } catch (\Exception $e) {
                dd($e);
            }

            $tempData->idNPKQ2 = auth()->user()->npk;
            $tempData->status = "1";
            $tempData->save();
        } elseif ($request->input('idTypeDefact') == '3') {
            outTotal::create([
                'idPart' => $tempData->idPart,
                'idColor' => $tempData->idColor,
                'idShift' => $tempData->idShift,
                'idNPK' => auth()->user()->npk,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')
            ]);
            $tempData->delete();

        }

        // dd($request);
        // $validator = \Validator::make($request->all(), [
        //     'idTypeDefact' => 'required|integer',
        //     'itemDefact' => 'required|string',
        //     'part_type' => 'required|string',
        //     'part_name' => 'required|string',
        //     'color' => 'required|string',
        //     'inspector_name' => 'required|string',
        //     'date' => 'required|date',
        //     'operator' => 'required|string',
        //     'line' => 'required|string', // Ensure line is validated
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        // // Process the data (e.g., save to the database)
        // // Example: Defact::create($request->all());

        // // Simulate successful response
        // return response()->json(['message' => 'Data submitted successfully!']);
    }

    public function getData(Request $request)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'idcolor' => 'required|integer', //color
            'itemDefact' => 'required|string',//item defact
            'typeId' => 'required|integer', //type defact

            'idPart' => 'required|integer', //id part
        ]);



        try {
            // Fetch defect groups based on typeId and itemId
            $tempDefact = tempDefact::with('color', 'type', 'part', 'part.type')->where('status', '0')->where('idPart', $validatedData['idPart'])->where('idColor', $validatedData['idcolor'])->where('itemDefact', $validatedData['itemDefact'])->get();




            // Format the response data
            $data = $tempDefact->map(function ($group) {
                return [
                    'id' => $group->id,  // Assuming 'title' is a column in DefectGroup
                    'idTypeDefact' => $group->idTypeDefact,
                    'typeDefacts' => $group->type->type,
                    'idPart' => $group->idPart,
                    'partName' => $group->part->item,
                    'idTypePart' => $group->part->type->id,
                    'typePart' => $group->part->type->type,
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