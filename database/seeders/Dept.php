<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Dept extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['nama_dept' => 'IT'],
            ['nama_dept' => 'PPIC'],
            ['nama_dept' => 'MARKETING'],
            ['nama_dept' => 'ACCOUNTING'],
            ['nama_dept' => 'FINANCE'],
            ['nama_dept' => 'ENGINEERING'],
            ['nama_dept' => 'MAINTENANCE'],
            ['nama_dept' => 'Other'],
        ];

        DB::table('depts')->insert($departments);
    }
}