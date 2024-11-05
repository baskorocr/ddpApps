<?php

namespace Database\Seeders;

use App\Models\itemDefects;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class itemDefact extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["idTypeDefact" => "1", "itemDefact" => "BINTIK KOTOR"],
            ["idTypeDefact" => "1", "itemDefact" => "SCRATCH"],
            ["idTypeDefact" => "1", "itemDefact" => "DUST SPRAY"],
            ["idTypeDefact" => "1", "itemDefact" => "ORANGE PEEL"],
            ["idTypeDefact" => "1", "itemDefact" => "SANDING MARK"],
            ["idTypeDefact" => "1", "itemDefact" => "ABSORB"],
            ["idTypeDefact" => "1", "itemDefact" => "OTHERS"],
            ["idTypeDefact" => "2", "itemDefact" => "BINTIK KOTOR"],
            ["idTypeDefact" => "2", "itemDefact" => "SCRATCH"],
            ["idTypeDefact" => "2", "itemDefact" => "DUST SPRAY"],
            ["idTypeDefact" => "2", "itemDefact" => "ORANGE PEEL"],
            ["idTypeDefact" => "2", "itemDefact" => "SANDING MARK"],
            ["idTypeDefact" => "2", "itemDefact" => "ABSORB"],
            ["idTypeDefact" => "2", "itemDefact" => "DISCOLOR"],
            ["idTypeDefact" => "2", "itemDefact" => "TIPIS"],
            ["idTypeDefact" => "2", "itemDefact" => "MELER"],
            ["idTypeDefact" => "2", "itemDefact" => "WATERMARK"],
            ["idTypeDefact" => "2", "itemDefact" => "CRATTER OIL"],
            ["idTypeDefact" => "2", "itemDefact" => "POPPING"],
            ["idTypeDefact" => "2", "itemDefact" => "UNPAINTING"],
            ["idTypeDefact" => "2", "itemDefact" => "OTHERS"],
            ["idTypeDefact" => "3", "itemDefact" => "DEFORMASI"],
            ["idTypeDefact" => "3", "itemDefact" => "OVERCUT"],
            ["idTypeDefact" => "3", "itemDefact" => "FLASHING"],
            ["idTypeDefact" => "3", "itemDefact" => "SCRATCH"],
            ["idTypeDefact" => "3", "itemDefact" => "OTHER"],



        ];

        foreach ($data as $entry) {
            itemDefects::create([
                'idTypeDefact' => $entry['idTypeDefact'],
                'itemDefact' => $entry['itemDefact'],
            ]);
        }
    }
}