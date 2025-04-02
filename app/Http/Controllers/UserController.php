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
}
