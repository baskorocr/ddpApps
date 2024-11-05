<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Colors;

class color extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        $colors = [
            'BLACK',
            'G-214',
            'NH-1',
            'NH-436',
            'PB-406',
            'R-378',
            'NH-196',
            'PB-432',
            'R-258',
            'HL WH C2',
            'MR CP J1',
            'MT BL A2',
            'NB GR H1',
            'PN BL 12',
            'ST SL 00',
            'TQ BU E1',
            'VR GN H3'
        ];

        foreach ($colors as $color) {
            Colors::create(['color' => $color]);
        }
    }
}