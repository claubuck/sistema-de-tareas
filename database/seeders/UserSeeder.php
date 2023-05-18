<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Claudio',
            'last_name' => 'Campos',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
        ]);
    }
}
