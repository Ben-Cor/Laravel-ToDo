<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
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

    public function add(UserRequest $request)
    {
        $user = User::create($request);

        return response()->json([
            'message' => 'User successfully created',
            'data' => $user,
        ], 201);
    }
}
