<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\itemDefects;
use App\Models\typeParts;
use Carbon\Carbon;

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

class ProsesController extends Controller
{
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


        $idItemDefactsArray = explode(', ', $group[0]->idItemDefacts);
        $idItemDefactsArrayGroup1 = explode(', ', $group[1]->idItemDefacts);
        $idItemDefactsArrayGroup2 = explode(', ', $group[2]->idItemDefacts);



        foreach ($group as $item) {
            // Memecah string menjadi array
            $item->itemDefacts = explode(', ', $item->itemDefacts);
        }

        return view('user.q2', compact('types', 'lines', 'group', 'typeDefacts', 'colors', 'shifts', 'idItemDefactsArray', 'idItemDefactsArrayGroup1', 'idItemDefactsArrayGroup2'));

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

            'idShift' => 'required|integer',
            'nameTypeDefact' => 'required|string',


            // 'line' => 'required|string', // Ensure line is validated
        ]);




        if ($request->input('nameTypeDefact') == 'ok') { //jika ok masuk table fix utk rsp

            fixProses::create([

                'idPart' => $request->input('idPart'),
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'typeDefact' => "OK",
                'keterangan' => 'ok',
                'role' => 'Q1',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);

        }
        // elseif($request->input('idTypeDefact')){ //jika out total masuk ke table

        // }
        elseif ($request->input('nameTypeDefact') == 'REPAINT') {



            fixProses::create([

                'idPart' => $request->input('idPart'),
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'typeDefact' => $request->input('nameTypeDefact'),
                'keterangan' => $request->input('itemDefact'),
                'role' => 'Q1',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);

        } elseif ($request->input('nameTypeDefact') == 'BUFFING') {



            tempDefact::create([
                'idPart' => $request->input('idPart'),
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'typeDefact' => $request->input('nameTypeDefact'),
                'role' => 'Q1',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);

        } else {


            fixProses::create([

                'idPart' => $request->input('idPart'),
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'typeDefact' => $request->input('nameTypeDefact'),
                'keterangan' => $request->input('itemDefact'),
                'role' => 'Q1',
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
            'idColor' => 'required|string',
            'inspector_npk' => 'required|string',

            'idShift' => 'required|integer',
            'nameTypeDefact' => 'required|string',


            // 'line' => 'required|string', // Ensure line is validated
        ]);






        $temp = tempDefact::where('idPart', $validator['idPart'])
            ->where('idColor', $validator['idColor'])
            ->first();



        if (is_null($temp)) { // Akan masuk ke kondisi ini jika $temp bernilai null
            return response()->json(['message' => 'Table Proses Buffing is Null']);
        }

        if ($request->input('nameTypeDefact') == 'ok') { //jika ok masuk table fix utk rsp

            fixProses::create([

                'idPart' => $request->input('idPart'),
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'typeDefact' => "OK_BUFFING",
                'keterangan' => 'ok_buffing',
                'role' => 'Q1',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);
            $temp->delete();

        }
        // elseif($request->input('idTypeDefact')){ //jika out total masuk ke table

        // }
        elseif ($request->input('nameTypeDefact') == 'REPAINT') {


            fixProses::create([

                'idPart' => $request->input('idPart'),
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'typeDefact' => $request->input('nameTypeDefact'),
                'keterangan' => $request->input('itemDefact'),
                'role' => 'Q1',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);

            $temp->delete();

        } else {


            fixProses::create([

                'idPart' => $request->input('idPart'),
                'idColor' => $request->input('idColor'),
                'idShift' => $request->input('idShift'),
                'idNPK' => $request->input('inspector_npk'),
                'idLine' => $request->input('line'),
                'typeDefact' => $request->input('nameTypeDefact'),
                'keterangan' => $request->input('itemDefact'),
                'role' => 'Q1',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s')


            ]);
            $temp->delete();

        }

        // Process the data (e.g., save to the database)
        // Example: Defact::create($request->all());

        // Simulate successful response
        return response()->json(['message' => 'Data submitted successfully!']);


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


    public function countShift()
    {


        $data = DB::table('fix_proses')
            ->select('typeDefact', DB::raw('count(*) as total'))
            ->whereIn('typeDefact', ['OK', 'REPAINT', 'OUT_TOTAL', 'OK_BUFFING'])
            ->whereDate('created_at', Carbon::today()) // Using Carbon to get today's date
            ->groupBy('typeDefact')
            ->pluck('total', 'typeDefact');
        // Ambil data dari pluck atau berikan nilai default 0 jika tidak ada
        $totalTypeOK = $data['OK'] ?? 0;
        $totalTypeRepaint = $data['REPAINT'] ?? 0;
        $totalTypeOutTotal = $data['OUT_TOTAL'] ?? 0;
        $totalTypeOkBuffing = $data['OK_BUFFING'] ?? 0;
        $totalData = $totalTypeOK + $totalTypeRepaint + $totalTypeOutTotal + $totalTypeOkBuffing;

        //presentase
        $rsp = ($totalTypeOK / $totalData) * 100;
        $fsp = ($rsp + (($totalTypeOkBuffing / $totalData) * 100));
        $percentTypeOutTotal = ($totalTypeOutTotal / $totalData) * 100;
        $percentTypaRepaint = ($totalTypeRepaint / $totalData) * 100;

        // Gabungkan data dalam format array
        $response = [
            'totalTypeOK' => $totalTypeOK,
            'totalTypeRepaint' => $totalTypeRepaint,
            'totalTypeOutTotal' => $totalTypeOutTotal,
            'totalTypeOkBuffing' => $totalTypeOkBuffing,
            'rsp' => number_format($rsp, 2),
            'fsp' => number_format($fsp, 2),
            'percentTypeOutTotal' => number_format($percentTypeOutTotal, 2),
            'percentRepaint' => number_format($percentTypaRepaint, 2),

        ];

        // Konversi array ke JSON
        echo json_encode($response);


    }


    public function countPart(Request $request)
    {



        // $result = DB::table('fix_proses as fp')
        //     ->join('parts as p', 'fp.idPart', '=', 'p.id')
        //     ->join('type_parts as tp', 'p.idType', '=', 'tp.id')
        //     ->join('customers as c', 'tp.idCustomer', '=', 'c.id')
        //     ->join('colors as cl', 'fp.idColor', '=', 'cl.id')
        //     ->select(
        //         'c.name as Customer_Name',
        //         'tp.type as Part_Type',
        //         'cl.color as Color',
        //         'p.item as Item',
        //         DB::raw('COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) as Total_OK_Count'),
        //         DB::raw('COUNT(CASE WHEN fp.typeDefact = "OK_BUFFING" THEN 1 END) as Total_OK_Buffing_Count'),
        //         DB::raw('COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END) as Total_Count_OutTotal'),
        //         DB::raw('COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END) as Total_Count_Repaint'),
        //         DB::raw('COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) + 
        //          COUNT(CASE WHEN fp.typeDefact = "OK_BUFFING" THEN 1 END) + 
        //          COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END) + 
        //          COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END) as TotalAll'),
        //         DB::raw('
        //     (COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) / 
        //     (COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) + 
        //      COUNT(CASE WHEN fp.typeDefact = "OK_BUFFING" THEN 1 END) + 
        //      COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END) + 
        //      COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END)) ) * 100 as rsp'),
        //         DB::raw('
        //     ((COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) / 
        //     (COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) + 
        //      COUNT(CASE WHEN fp.typeDefact = "OK_BUFFING" THEN 1 END) + 
        //      COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END) + 
        //      COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END)) ) * 100) + 
        //     ((COUNT(CASE WHEN fp.typeDefact = "OK_BUFFING" THEN 1 END) / 
        //     (COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) + 
        //      COUNT(CASE WHEN fp.typeDefact = "OK_BUFFING" THEN 1 END) + 
        //      COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END) + 
        //      COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END)) ) * 100) as fsp')
        //     )
        //     ->whereDate('fp.created_at', '=', \Carbon\Carbon::today()->toDateString()) // Filter by today's date
        //     ->groupBy('c.name', 'tp.type', 'cl.color', 'p.item')
        //     ->orderByDesc('fp.created_at')  // Order by the most recent creation date
        //     ->orderBy('c.name')              // Secondary sort by customer name
        //     ->orderBy('tp.type')             // Tertiary sort by part type
        //     ->orderBy('cl.color')            // Quaternary sort by color
        //     ->orderBy('p.item')              // Final sort by part item
        //     ->get();

        // $result = DB::table('fix_proses as fp')
        //     ->join('parts as p', 'fp.idPart', '=', 'p.id')
        //     ->join('type_parts as tp', 'p.idType', '=', 'tp.id')
        //     ->join('customers as c', 'tp.idCustomer', '=', 'c.id')
        //     ->join('colors as cl', 'fp.idColor', '=', 'cl.id')
        //     ->select(
        //         'c.name as Customer_Name',
        //         'tp.type as Part_Type',
        //         'cl.color as Color',
        //         'p.item as Item',
        //         DB::raw('COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) as Total_OK_Count'),
        //         DB::raw('COUNT(CASE WHEN fp.typeDefact = "OK_BUFFING" THEN 1 END) as Total_OK_Buffing_Count'),
        //         DB::raw('COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END) as Total_Count_OutTotal'),
        //         DB::raw('COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END) as Total_Count_Repaint'),
        //         DB::raw('COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) + 
        //          COUNT(CASE WHEN fp.typeDefact = "OK_BUFFING" THEN 1 END) + 
        //          COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END) + 
        //          COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END) as TotalAll'),
        //         DB::raw('
        //     CASE 
        //         WHEN COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END) > COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END) 
        //         THEN MAX(CASE WHEN fp.typeDefact = "REPAINT" THEN fp.keterangan END) 
        //         ELSE MAX(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN fp.keterangan END) 
        //     END as Most_Frequent_Description')
        //     )
        //     ->whereDate('fp.created_at', '=', \Carbon\Carbon::today()->toDateString()) // Filter by today's date
        //     ->groupBy('c.name', 'tp.type', 'cl.color', 'p.item')
        //     ->orderByDesc('fp.created_at')  // Order by the most recent creation date
        //     ->orderBy('c.name')              // Secondary sort by customer name
        //     ->orderBy('tp.type')             // Tertiary sort by part type
        //     ->orderBy('cl.color')            // Quaternary sort by color
        //     ->orderBy('p.item')              // Final sort by part item
        //     ->get();

        $lineId = $request->query('line');

        try {
            $result = DB::table('fix_proses as fp')
                ->join('parts as p', 'fp.idPart', '=', 'p.id')
                ->join('type_parts as tp', 'p.idType', '=', 'tp.id')
                ->join('customers as c', 'tp.idCustomer', '=', 'c.id')
                ->join('colors as cl', 'fp.idColor', '=', 'cl.id')
                ->select(
                    'c.name as Customer_Name',
                    'tp.type as Part_Type',
                    'cl.color as Color',
                    'p.item as Item',
                    DB::raw('COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) as Total_OK_Count'),
                    DB::raw('COUNT(CASE WHEN fp.typeDefact = "OK_BUFFING" THEN 1 END) as Total_OK_Buffing_Count'),
                    DB::raw('COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END) as Total_Count_OutTotal'),
                    DB::raw('COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END) as Total_Count_Repaint'),
                    DB::raw('COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) + 
                     COUNT(CASE WHEN fp.typeDefact = "OK_BUFFING" THEN 1 END) + 
                     COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END) + 
                     COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END) as TotalAll'),
                    DB::raw('
                CASE 
                    WHEN COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END) > COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END)
                    THEN "Repaint Dominates"
                    ELSE "Out Total Dominates"
                END as Dominant_Type'
                    ),
                    DB::raw('
                CASE 
                    WHEN COUNT(CASE WHEN fp.typeDefact = "REPAINT" THEN 1 END) > COUNT(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN 1 END) 
                    THEN MAX(CASE WHEN fp.typeDefact = "REPAINT" THEN fp.keterangan END) 
                    ELSE MAX(CASE WHEN fp.typeDefact = "OUT_TOTAL" THEN fp.keterangan END) 
                END as Most_Frequent_Description'
                    )
                )
                ->whereDate('fp.created_at', Carbon::today())
                ->when($lineId, function ($query) use ($lineId) {
                    // Jika `lineId` ada, filter berdasarkan line
                    return $query->where('fp.idLine', $lineId);
                })
                ->groupBy('c.name', 'tp.type', 'cl.color', 'p.item')
                ->orderByDesc('fp.created_at')
                ->orderBy('c.name')
                ->orderBy('tp.type')
                ->orderBy('cl.color')
                ->orderBy('p.item')
                ->get();

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }









        return response()->json($result);


    }
}