<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    public function addTask(TaskRequest $request)
    {
        $task = new Task;
        $task->content = $request->input('content');
        $task->completed = $request->input('completed', false);
        $task->user_id = $request->input('user_id');
        $task->due_date = $request->input('due_date');

        if (! $task->save()) {
            return response()->json([
                'message' => 'Task creation failed',
            ], 500);
        }

        if ($request->has('category_id')) {
            $task->categories()->attach($request->input('category_id'));
        }

        return response()->json([
            'message' => 'Task successfully created',
        ], 201);
    }

    public function updateTask(TaskRequest $request, Task $task)
    {
        $task->content = $request->input('content');
        $task->completed = $request->input('completed', false);
        $task->user_id = $request->input('user_id');
        $task->due_date = $request->input('due_date');
        $task->save();

        if (!$task->save()) {
            return response()->json([
                'message' => 'Task update failed',
            ], 500);
        }

        if ($request->has('category_id')) {
            $task->categories()->sync($request->input('category_id'));
        } else {
            $task->categories()->detach();
        }

        return response()->json([
            'message' => 'Task successfully updated',
        ], 200);
    }

    public function deleteTask(int $id)
    {
        $task = Task::find($id);

        if (! $task) {
            return response()->json([
                'message' => 'Task not found',
            ], 404);
        }

        if (! $task->delete()) {
            return response()->json([
                'message' => 'Task deletion failed',
            ], 500);
        }

        return response()->json([
            'message' => 'Task successfully deleted',
        ], 200);
    }
}
