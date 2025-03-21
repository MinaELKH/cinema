<?php

use App\Http\Controllers\FilmController;
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

Route::apiResource('salles', SalleController::class);
Route::apiResource('films', FilmController::class);
Route::apiResource('seances', SeanceController::class);


Route::apiResource('sieges', SiegeController::class);
