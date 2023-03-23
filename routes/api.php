<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarbersController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Public routes

Route::post('/loginUser', [AuthController::class, 'loginUser']);
Route::post('/registerUser', [AuthController::class, 'registerUser']);


//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/tasks', TasksController::class);
    Route::apiResource('/barbers', BarbersController::class);
    Route::apiResource('/users', UsersController::class);
});
