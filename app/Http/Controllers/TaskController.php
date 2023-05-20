<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $tasks = $user->tasks;

        return Inertia::render('Task/calendar', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Task/create', [
            'tagOptions' => Tag::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|min:2',
            'description' => 'nullable|string|max:500',
            'venciment' => 'required',
            'tags' => 'array',
        ]);
        $user = Auth::user();
        $task = $user->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'venciment' => $request->venciment,
            'status' => 'Nueva',
        ]);

        $task->tags()->sync($request->tags);

        return Redirect::route('dashboard')->with('message', 'Tarea creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {

        return Inertia::render('Task/show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return Inertia::render('Task/edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    { 
        $requestData = $request->all();
        if (empty($requestData)) {
            $task->update(["status" => "Completada"]);
            return back()->with('message', 'Tarea Completada');
        } else {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'venciment' => 'required',
            ]);
            $task->update($data);

            return Redirect::route('tasks.show', $task)->with('message', 'Tarea guardada');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return Redirect::route('dashboard')->with('message', 'Tarea eliminada exitosamente');
    }

    public function calendar()
    {
        $user = Auth::user();
        $tasks = $user->tasks;

        return response()->json(['tasks' => $tasks]);
    }

    public function listing(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);

        $user = Auth::user();

        if ($page === 'all') {
            $tasks = $user->tasks()->with('tags')->get();
            $totalTasks = $tasks->count();
        } else {
            $skip = ($page - 1) * $pageSize;
            $tasks = $user->tasks()->with('tags')->skip($skip)->take($pageSize)->get();
            $totalTasks = $user->tasks()->count();
        }

        return response()->json([
            'tasks' => $tasks,
            'totalTasks' => $totalTasks,
        ]);
    }
}
