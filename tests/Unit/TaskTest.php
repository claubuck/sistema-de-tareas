<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function testCreateTask()
    {
        $user = User::factory()->create(); // Crea un usuario de prueba
        $this->actingAs($user); // Simula la autenticación del usuario

        $data = [
            'title' => 'Tarea de prueba',
            'description' => 'Descripción de la tarea de prueba',
            'venciment' => '2023-05-31 12:00:00',
            'tags' => ['tag1', 'tag2'],
        ];

        $response = $this->post(route('tasks.store'), $data);

        $response->assertRedirect(route('dashboard')); // Verifica que se redireccione correctamente
        $response->assertSessionHas('message', 'Tarea creada exitosamente'); // Verifica que el mensaje esté en la sesión

        $this->assertDatabaseHas('tasks', [
            'title' => 'Tarea de prueba',
            'description' => 'Descripción de la tarea de prueba',
            'venciment' => '2023-05-31 12:00:00',
            'status' => 'Nueva',
        ]); // Verifica que los datos se hayan almacenado en la base de datos

        $task = Task::where('title', 'Tarea de prueba')->first();
        $this->assertDatabaseHas('task_tag', [
            'task_id' => $task->id,
            'tag_id' => 1, // ID de la etiqueta "tag1"
        ]); // Verifica que la relación muchos a muchos se haya creado correctamente

        $this->assertDatabaseHas('task_tag', [
            'task_id' => $task->id,
            'tag_id' => 2, // ID de la etiqueta "tag2"
        ]);
    }

}
