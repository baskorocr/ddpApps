<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parts;

class part extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $data = [
            ["idType" => "1", "item" => "SHELL"],
            ["idType" => "2", "item" => "SHELL"],
            ["idType" => "3", "item" => "FENDER, FR"],
            ["idType" => "3", "item" => "COVER, FR"],
            ["idType" => "3", "item" => "COVER, L BODY"],
            ["idType" => "3", "item" => "COVER, R BODY"],
            ["idType" => "3", "item" => "COVER, SPEEDOMETER"],
            ["idType" => "4", "item" => "COVER FR TOP"],
            ["idType" => "4", "item" => "CVR RR CENTER"],
            ["idType" => "4", "item" => "COVER METER"],
            ["idType" => "4", "item" => "FENDER A,FR"],
            ["idType" => "4", "item" => "COVER FR"],
            ["idType" => "5", "item" => "COWL, L UNDER"],
            ["idType" => "5", "item" => "COWL, R UNDER"],
            ["idType" => "6", "item" => "SEAT FRONT COVER"],
            ["idType" => "6", "item" => "SIDE FAIRING L"],
            ["idType" => "6", "item" => "SIDE FAIRING R"],
            ["idType" => "6", "item" => "LOWER FRONT FAIRING"],
            ["idType" => "6", "item" => "FRONT FAIRING TRIM"]
        ];
        ////

        foreach ($data as $entry) {
            Parts::create([
                'idType' => $entry['idType'],
                'item' => $entry['item'],
            ]);
        }
    }
}