<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\customer;

class customers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        customer::create([
            'name' => 'AHM',
        ]);
        customer::create([
            'name' => 'EMI',
        ]);
    }
}