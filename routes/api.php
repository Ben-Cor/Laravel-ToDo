<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'all']);
Route::get('/users/{user}', [UserController::class, 'find']);
Route::post('/users', [UserController::class, 'add']);
Route::delete('/users/{user}', [UserController::class, 'delete']);
Route::post('/tasks', [TaskController::class, 'addTask']);
Route::put('/tasks/{task}', [TaskController::class, 'updateTask']);
Route::delete('/tasks/{task}', [TaskController::class, 'deleteTask']);
