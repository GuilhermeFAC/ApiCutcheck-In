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

    Route::apiResource('/barbers', BarbersController::class);
    Route::patch('/barbers/availability/{availabilityId}', [BarbersController::class, 'updateAvailability']); //ok
    Route::get('/barbers/{barber}/availability', [BarbersController::class, 'getAvailabilities']); //ok
    Route::post('/barbers/services', [BarbersController::class, 'addServices']); //ok
    Route::get('/barbers/{barber}/services', [BarbersController::class, 'getServices']); //ok
    Route::patch('/barbers/services/{serviceId}', [BarbersController::class, 'updateService']); //ok
    Route::delete('/barbers/services/{serviceId}', [BarbersController::class, 'destroyaService']); //ok
    Route::post('/barbers/{barber}/appointments', [BarbersController::class, 'setAppointments']); //ok
    Route::get('/barbers/{barber}/appointments', [BarbersController::class, 'getAppointmentsBarbers'])->name('users.getAppointments'); //ok
    Route::get('/barbers/search', [BarbersController::class, 'search']);

    Route::apiResource('/users', UsersController::class);
    Route::get('/users/{user}/favorites', [UsersController::class, 'getFavorites']); //ok
    Route::post('/users/favorite', [UsersController::class, 'addFavorite']); //ok
    Route::get('/users/{user}/appointments', [UsersController::class, 'getAppointments']); //ok
});
