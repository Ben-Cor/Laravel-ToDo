<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    public function addTask(TaskRequest $request)
    {
        $task = new Task();
        $task->content = $request->input('content');
        $task->completed = $request->input('completed', false);
        $task->user_id = $request->input('user_id');
        $task->due_date = $request->input('due_date');
        $task->save();

        if (! $task->save()) {
            return response()->json([
                'message' => 'Task creation failed',
            ], 500);
        }

        return response()->json([
            'message' => 'Task successfully created'
        ], 201);
    }
}
