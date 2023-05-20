<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create([
            'title' => 'Tarea',
            'description' => 'Descripciones',
            'status' => 'Nuevo',
            'user_id' => 1,
            'venciment' => Carbon::now(),
        ]);

        Task::create([
            'title' => 'Tarea2',
            'description' => 'Descripciones2',
            'status' => 'Completada',
            'user_id' => 1,
            'venciment' => Carbon::now(),
        ]);

        Task::create([
            'title' => 'Tarea3',
            'description' => 'Descripciones3',
            'status' => 'Nuevo',
            'user_id' => 1,
            'venciment' => Carbon::now(),
        ]);
    }
}
