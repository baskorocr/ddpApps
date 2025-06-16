<?php

namespace App\Http\Controllers;
use App\Models\fixProses;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;


class reports extends Controller
{
    public function filterDefact(Request $request){
       
     
        
       $date_from =Carbon::parse($request->date_from)->startOfDay();
       $date_to = Carbon::parse($request->date_to)->startOfDay();


      
        // Fetch the filtered data based on selected criteria
        $results = $this->fetchDefact($date_from, $date_to);

        // Return the view with the results
        return view('reports.detailDefact', compact('results'));

    }
    public function exportData2(Request $request)
    {
        $date_from = $request->date_from;
    $date_to = $request->date_to;

    $fileName = "DataExport.xlsx";

    $results = $this->fetchDefact($date_from, $date_to)->map(fn ($row) => (array) $row);


    $sheets = new SheetCollection([
        'Export Data' => $results,
    ]);

    return (new FastExcel($sheets))->download($fileName);
    }

    private function exportMonthlyData2($month, $year)
    {
        $data = $this->fetchDefact($month, $year, 'daily');
        $fileName = "Monthly_Data_{$month}_{$year}.xlsx";

        
        // Ensure the data is formatted for FastExcel and export the file
        return (new FastExcel($data))->download($fileName);
    }
   

    private function fetchDefact($date_from, $date_to)
    {
           // Ambil nilai keterangan unik untuk BUFFING dan REPAINT saja (OK_BUFFING tidak dipakai lagi di sini)
    $buffingKeterangan = DB::table('temp_defacts')
    ->select('keterangan')
    ->where('typeDefact', 'BUFFING')
    ->whereBetween('created_at', [$date_from, $date_to])
    ->distinct()
    ->pluck('keterangan')
    ->unique()
    ->values();

$repaintKeterangan = DB::table('fix_proses')
    ->select('keterangan')
    ->where('typeDefact', 'REPAINT')
    ->whereBetween('created_at', [$date_from, $date_to])
    ->distinct()
    ->pluck('keterangan')
    ->unique()
    ->values();

// Query fix_proses
$fixProses = DB::table('fix_proses as fp')
    ->join('parts as p', 'fp.idPart', '=', 'p.id')
    ->join('type_parts as tp', 'p.idType', '=', 'tp.id')
    ->join('customers as c', 'tp.idCustomer', '=', 'c.id')
    ->join('colors as cl', 'fp.idColor', '=', 'cl.id')
    ->select(
        'p.item as Part',
        'tp.type as Part_Type',
        'c.name as Customer_Name',
        'cl.color as Color',
        'fp.keterangan',
        'fp.typeDefact',
        DB::raw('count(*) as jumlah')
    )
    ->whereBetween('fp.created_at', [$date_from, $date_to])
    ->groupBy('p.item', 'tp.type', 'c.name', 'cl.color', 'fp.keterangan', 'fp.typeDefact');

// Query temp_defacts
$tempDefacts = DB::table('temp_defacts as td')
    ->join('parts as p', 'td.idPart', '=', 'p.id')
    ->join('type_parts as tp', 'p.idType', '=', 'tp.id')
    ->join('customers as c', 'tp.idCustomer', '=', 'c.id')
    ->join('colors as cl', 'td.idColor', '=', 'cl.id')
    ->select(
        'p.item as Part',
        'tp.type as Part_Type',
        'c.name as Customer_Name',
        'cl.color as Color',
        'td.keterangan',
        DB::raw('"BUFFING" as typeDefact'),
        DB::raw('count(*) as jumlah')
    )
    ->where('td.typeDefact', 'BUFFING')
    ->whereBetween('td.created_at', [$date_from, $date_to])
    ->groupBy('p.item', 'tp.type', 'c.name', 'cl.color', 'td.keterangan');

// Union kedua query
$union = $fixProses->unionAll($tempDefacts);

// Kolom utama
$selects = [
    'Part',
    'Part_Type',
    'Customer_Name',
    'Color',
    DB::raw('SUM(jumlah) as Total'),
    DB::raw('SUM(CASE WHEN typeDefact = "OK" THEN jumlah ELSE 0 END) as OK'),
    DB::raw('SUM(CASE WHEN typeDefact = "OK_BUFFING" THEN jumlah ELSE 0 END) as OK_BUFFING'),
    DB::raw('SUM(CASE WHEN typeDefact = "OUT_TOTAL" THEN jumlah ELSE 0 END) as OUT_TOTAL'),
];

// Tambahan kolom dinamis BUFFING
foreach ($buffingKeterangan as $buffing) {
    $alias = strtoupper(str_replace([' ', '/', '-', '.'], '_', $buffing));
    $selects[] = DB::raw("SUM(CASE WHEN keterangan = '$buffing' AND typeDefact = 'BUFFING' THEN jumlah ELSE 0 END) as BUFFING_$alias");
}

// Tambahan kolom dinamis REPAINT
foreach ($repaintKeterangan as $repaint) {
    $alias = strtoupper(str_replace([' ', '/', '-', '.'], '_', $repaint));
    $selects[] = DB::raw("SUM(CASE WHEN keterangan = '$repaint' AND typeDefact = 'REPAINT' THEN jumlah ELSE 0 END) as REPAINT_$alias");
}

// Tambah kolom persentase
$selects[] = DB::raw('ROUND((SUM(CASE WHEN typeDefact = "OK" THEN jumlah ELSE 0 END) * 100.0) / NULLIF(SUM(jumlah), 0), 2) as RSP');
$selects[] = DB::raw('ROUND((SUM(CASE WHEN typeDefact IN ("OK", "OK_BUFFING") THEN jumlah ELSE 0 END) * 100.0) / NULLIF(SUM(jumlah), 0), 2) as FSP');

// Eksekusi query akhir
$data = DB::table(DB::raw("({$union->toSql()}) as defects"))
    ->mergeBindings($union)
    ->select($selects)
    ->groupBy('Part', 'Part_Type', 'Customer_Name', 'Color')
    ->orderBy('Part')
    ->get();

return $data;

   

       

    }


    
    

}


