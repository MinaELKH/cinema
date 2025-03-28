<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\PaymentController;
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



Route::get('/seances/films', [SeanceController::class, 'getAllSeancesWithFilms']);
Route::get('/seances', [SeanceController::class, 'showByType']);  // avec query ?type=VIP

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


    //paiment
    Route::post('/payment', [PaymentController::class, 'createCheckoutSession'])->name('payment.create');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::post('/stripe/webhook', [PaymentController::class, 'handleWebhook']);
});


Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
//Quand tu ouvres le lien de paiement Stripe dans le navigateur, Laravel ne sait pas que tu es authentifié sur Postman. L'authentification est stockée dans une session ou via un token, mais quand Stripe redirige après le paiement, le navigateur ne transmet pas l'authentification.
//
//👉 Résultat : Laravel pense que tu n'es pas connecté et essaie de te rediriger vers /login, mais cette route n'existe pas.
