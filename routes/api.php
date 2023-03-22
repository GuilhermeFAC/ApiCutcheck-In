<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Public routes

Route::post('/loginUser', [AuthController::class, 'loginUser']);
Route::post('/registerUser', [AuthController::class, 'registerUser']);
Route::post('/loginBarbers', [AuthController::class, 'loginBarbers']);
Route::post('/registerBarbers', [AuthController::class, 'registerBarbers']);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/tasks', TasksController::class);
});
