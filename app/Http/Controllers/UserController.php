<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

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
        $user = User::with('tasks.categories')->find($id);
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

    public function add(UserRequest $request): JsonResponse
    {
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->experience = 0;
        $user->email_verified_at = now();
        $user->save();

        if (! $user->save()) {
            return response()->json([
                'message' => 'User not created',
            ], 500);
        }

        return response()->json([
            'message' => 'User successfully created',
            'data' => $user,
        ], 201);
    }
}
