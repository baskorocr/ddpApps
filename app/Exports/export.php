<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DefectsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $date_from;
    protected $date_to;

    public function __construct($date_from, $date_to)
    {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function collection()
    {
        return app()->make('App\Http\Controllers\YourController')->fetchDefact($this->date_from, $this->date_to);
    }

    public function headings(): array
    {
        return [
            'Customer',
            'Part Type', 
            'Color',
            'Part Name',
            'Total Units',
            'OK Units',
            'OK Buffing',
            'Out Total',
            // Buffing Defects
            'Buffing: Bintik Kotor',
            'Buffing: Absorb',
            'Buffing: Others',
            'Buffing: Scratch',
            'Buffing: Sanding Mark',
            'Buffing: Orange Peel',
            'Buffing: Dust Spray',
            // Repaint Defects
            'Repaint: Unpainting',
            'Repaint: Scratch',
            'Repaint: Meler',
            'Repaint: Others',
            'Repaint: Orange Peel',
            'Repaint: Cratter Oil',
            'Repaint: Bintik Kotor',
            'Repaint: Absorb',
            'Repaint: Tipis',
            'Repaint: Dust Spray',
            // OK Buffing
            'OK Buffing',
            // Percentages
            'RSP (%)',
            'FSP (%)'
        ];
    }

    public function map($defect): array
    {
        return [
            $defect->Customer_Name,
            $defect->Part_Type,
            $defect->Color,
            $defect->Part,
            $defect->Total,
            $defect->Ok,
            $defect->Ok_Buffing ?? 0,
            $defect->Out_Total ?? 0,
            // Buffing defects
            $defect->BUFFING_BINTIK_KOTOR ?? 0,
            $defect->BUFFING_ABSORB ?? 0,
            $defect->BUFFING_OTHERS ?? 0,
            $defect->BUFFING_SCRATCH ?? 0,
            $defect->BUFFING_SANDING_MARK ?? 0,
            $defect->BUFFING_ORANGE_PEEL ?? 0,
            $defect->BUFFING_DUST_SPRAY ?? 0,
            // Repaint defects
            $defect->REPAINT_UNPAINTING ?? 0,
            $defect->REPAINT_SCRATCH ?? 0,
            $defect->REPAINT_MELER ?? 0,
            $defect->REPAINT_OTHERS ?? 0,
            $defect->REPAINT_ORANGE_PEEL ?? 0,
            $defect->REPAINT_CRATTER_OIL ?? 0,
            $defect->REPAINT_BINTIK_KOTOR ?? 0,
            $defect->REPAINT_ABSORB ?? 0,
            $defect->REPAINT_TIPIS ?? 0,
            $defect->REPAINT_DUST_SPRAY ?? 0,
            // OK Buffing
            $defect->OK_BUFFING ?? 0,
            // Percentages
            number_format($defect->RSP, 2),
            number_format($defect->FSP, 2)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Style percentages columns
            'AA:AB' => [
                'numberFormat' => [
                    'formatCode' => '0.00%'
                ]
            ],
            
            // Add borders
            'A1:AB'.($this->collection()->count()+1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]
        ];
    }
}