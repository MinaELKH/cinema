<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\SeanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiegeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('salles', SalleController::class);
Route::apiResource('films', FilmController::class);
Route::apiResource('seances', SeanceController::class);


Route::apiResource('sieges', SiegeController::class);


//Route::middleware('auth:sanctum')->post('/reservations', [ReservationController::class, 'create']);



Route::middleware('auth:api')->group(function () {
    Route::resource('reservations', ReservationController::class);

    // Méthodes personnalisées en dehors de resource
    Route::post('/reservations/{id}/confirm', [ReservationController::class, 'confirm']);
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);
});

