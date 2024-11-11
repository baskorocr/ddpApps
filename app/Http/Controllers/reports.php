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

    // Filter data based on the selected month, year, and data type
    public function filterData(Request $request)
    {
        $dataType = $request->input('data_type', 'monthly');  // Default is monthly
        $month = $request->input('month', Carbon::now()->month);  // Default to current month
        $year = $request->input('year', Carbon::now()->year);  // Default to current year

        // Fetch the filtered data based on selected criteria
        $results = $this->fetchData($month, $year, $dataType === 'yearly' ? 'yearly' : 'daily');

        // Return the view with the results
        return view('reports.index', compact('results'));
    }

    // Handle export of data based on the selected data type (monthly or yearly)
    public function exportData(Request $request)
    {
        $dataType = $request->input('data_type', 'monthly');  // Default is monthly
        $month = $request->input('month', Carbon::now()->month);  // Default to current month
        $year = $request->input('year', Carbon::now()->year);  // Default to current year

        // Call the appropriate export method based on the selected data type
        if ($dataType === 'monthly') {
            return $this->exportMonthlyData($month, $year);
        } elseif ($dataType === 'yearly') {
            return $this->exportYearlyData($year);
        }
    }

    // Export monthly data to an Excel file
    private function exportMonthlyData($month, $year)
    {
        $data = $this->fetchData($month, $year, 'daily');
        $fileName = "Monthly_Data_{$month}_{$year}.xlsx";

        // Ensure the data is formatted for FastExcel and export the file
        return (new FastExcel($data))->download($fileName);
    }

    // Export yearly data to an Excel file with separate sheets for each month
    private function exportYearlyData($year)
    {
        $sheets = [];

        // Loop through each month to fetch and organize data
        for ($month = 1; $month <= 12; $month++) {
            $data = $this->fetchData($month, $year, 'daily');

            if (!empty($data)) {
                $monthName = Carbon::create()->month($month)->format('F');
                $sheets[$monthName] = collect($data)->map(function ($item) {
                    return [
                        'Customer_Name' => $item->Customer_Name,
                        'Part_Type' => $item->Part_Type,
                        'Color' => $item->Color,
                        'Item' => $item->Item,
                        'Total_OK_Count' => $item->Total_OK_Count,
                        'Total_OK_Buffing_Count' => $item->Total_OK_Buffing_Count,
                        'Total_Count_OutTotal' => $item->Total_Count_OutTotal,
                        'Total_Count_Repaint' => $item->Total_Count_Repaint,
                        'TotalAll' => $item->TotalAll,
                        'rsp' => $item->rsp,
                        'fsp' => $item->fsp,
                    ];
                });
            }
        }

        $fileName = "Yearly_Data_{$year}.xlsx";
        $sheetCollection = new SheetCollection($sheets);

        // Export all sheets in one Excel file
        return (new FastExcel($sheetCollection))->download($fileName);
    }

    // Fetch data based on selected month, year, and data type (daily or yearly)
    private function fetchData($month, $year, $type)
    {
        $query = DB::table('fix_proses as fp')
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
                DB::raw('COUNT(CASE WHEN fp.typeDefact IN ("OK", "OK_BUFFING", "OUT_TOTAL", "REPAINT") THEN 1 END) as TotalAll'),
                DB::raw('(COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) / 
                          COUNT(CASE WHEN fp.typeDefact IN ("OK", "OK_BUFFING", "OUT_TOTAL", "REPAINT") THEN 1 END)) * 100 as rsp'),
                DB::raw('((COUNT(CASE WHEN fp.typeDefact = "OK" THEN 1 END) + 
                           COUNT(CASE WHEN fp.typeDefact = "OK_BUFFING" THEN 1 END)) / 
                          COUNT(CASE WHEN fp.typeDefact IN ("OK", "OK_BUFFING", "OUT_TOTAL", "REPAINT") THEN 1 END)) * 100 as fsp')
            )
            ->whereYear('fp.created_at', $year);

        // If fetching daily data, filter by month as well
        if ($type === 'daily') {
            $query->whereMonth('fp.created_at', $month);
        }

        // Execute the query and return the result as an array
        return $query->groupBy('c.name', 'tp.type', 'cl.color', 'p.item')->get()->toArray();
    }
}