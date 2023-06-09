<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarbersController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Public routes

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/tasks', TasksController::class);

    Route::apiResource('/barbers', BarbersController::class);
    Route::patch('/barbers/availability/{availabilityId}', [BarbersController::class, 'updateAvailability']);
    Route::get('/barbers/{barber}/availability', [BarbersController::class, 'getAvailabilities']);
    Route::post('/barbers/services', [BarbersController::class, 'addServices']);

    //Route::get('/barbers/search', BarbersController::class, 'search');

    Route::apiResource('/users', UsersController::class);
    Route::get('/users/favorites', [UsersController::class, 'getFavorites']);
    Route::post('/users/favorite', [UsersController::class, 'addFavorite']);
    Route::get('/users/appointments', [UsersController::class, 'getAppointments']);
});
