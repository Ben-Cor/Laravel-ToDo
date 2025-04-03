<?php

namespace App\Http\Controllers;

use App\Models\Task;

class TaskController extends Controller
{
    public function addTask()
    {
        $task = request()->validate([
            'content' => 'required|string|max:255',
            'completed' => 'boolean',
            'user_id' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create($task);

        return response()->json([
            'message' => 'Task successfully created',
            'data' => $task,
        ], 201);
    }
}
