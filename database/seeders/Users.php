<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'npk' => '1123',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'supervisor',
            'depts' => '1',
            'NoWa' => '089654825055'
        ]);

        User::create([
            'npk' => '1124',
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
            'role' => 'users',
            'depts' => '2',
            'NoWa' => '089654825055'
        ]);

        User::create([
            'npk' => '1125',
            'name' => 'John Doe',
            'email' => 'john1@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'depts' => '2',
            'NoWa' => '089654825055'
        ]);
    }
}