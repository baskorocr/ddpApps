<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\typeParts;

class typePart extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['type' => 'TRX3', 'idCustomer' => 1],
            ['type' => 'TRX3.2', 'idCustomer' => 1],
            ['type' => 'K1AL', 'idCustomer' => 1],
            ['type' => 'K2S', 'idCustomer' => 1],
            ['type' => 'K64', 'idCustomer' => 1],
            ['type' => '1X0', 'idCustomer' => 2],
        ];


        // Insert types into the database
        foreach ($types as $type) {
            TypeParts::create($type);
        }


    }
}