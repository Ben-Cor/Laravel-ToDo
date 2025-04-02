<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function all()
    {
        $users = User::with('tasks')->get();

        return response()->json([
            'message' => 'Users successfully returned',
            'data' => $users,
        ], 200);
    }

    public function find(int $id)
    {
        $user = User::with('tasks')->find($id);
        if (! $user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'message' => 'User successfully returned',
            'data' => $user,
        ], 200);
    }
}
