<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::group(['middleware' => ['auth:api']], function() {
    Route::get('/tasks', [TasksController::class, 'index']);
    Route::post('/tasks', [TasksController::class, 'store']);
    Route::put('/tasks/{task}/status', [TasksController::class, 'updateStatus']);
    Route::post('/tasks/{task}/comments', [TasksController::class, 'addComment']);
    Route::get('/tasks/{task}', [TasksController::class, 'show']);
});
