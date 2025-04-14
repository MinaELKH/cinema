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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
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



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');




/***************************  admin  ******************************/

//Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::get('/seances/films', [SeanceController::class, 'getAllSeancesWithFilms']);
    Route::get('/seances/type', [SeanceController::class, 'showByType']);  // avec query ?type=VIP

    Route::apiResource('salles', SalleController::class);
    Route::apiResource('films', FilmController::class);

    Route::apiResource('seances', SeanceController::class);

    Route::get('/admin/dashboard', [DashboardController::class, 'getDashboardStats']);
//});


/***************************  sepctateur ******************************/

//Route::middleware(['auth:sanctum', 'role:spectateur'])->group(function () {
    Route::resource('reservations', ReservationController::class);

    // Méthodes personnalisées en dehors de resource
    Route::post('/reservations/{id}/confirm', [ReservationController::class, 'confirm']);
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);


    //paiment
    Route::post('/payment', [PaymentController::class, 'createCheckoutSession'])->name('payment.create');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::post('/stripe/webhook', [PaymentController::class, 'handleWebhook']);

//});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::get('/seances/{seanceId}/sieges-disponibles', [ReservationController::class, 'getAvailableSieges']);
Route::get('seances/{seanceId}/sieges-disponibles', [SeanceController::class, 'getSiegesForSeance']);
Route::get('/films/{film}/seances', [SeanceController::class, 'getSeancesByFilm']);



//Route::get('/seances/films', [SeanceController::class, 'getAllSeancesWithFilms']);
//Route::get('/seances/type', [SeanceController::class, 'showByType']);  // avec query ?type=VIP
//
//Route::apiResource('salles', SalleController::class);
//Route::apiResource('films', FilmController::class);
//
//Route::apiResource('seances', SeanceController::class);







Route::apiResource('sieges', SiegeController::class);

//Route::middleware('auth:sanctum')->post('/reservations', [ReservationController::class, 'create']);

//Route::middleware('auth:api')->group(function () {
//    Route::resource('reservations', ReservationController::class);
//
//    // Méthodes personnalisées en dehors de resource
//    Route::post('/reservations/{id}/confirm', [ReservationController::class, 'confirm']);
//    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);
//
//
//    //paiment
//    Route::post('/payment', [PaymentController::class, 'createCheckoutSession'])->name('payment.create');
//    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
//    Route::post('/stripe/webhook', [PaymentController::class, 'handleWebhook']);
//});


Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
//Quand tu ouvres le lien de paiement Stripe dans le navigateur, Laravel ne sait pas que tu es authentifié sur Postman. L'authentification est stockée dans une session ou via un token, mais quand Stripe redirige après le paiement, le navigateur ne transmet pas l'authentification.
//
//👉 Résultat : Laravel pense que tu n'es pas connecté et essaie de te rediriger vers /login, mais cette route n'existe pas.


// genere pdf  test

use Barryvdh\DomPDF\Facade\Pdf;

//Route::get('/generate-pdf', function () {
//    $data = [
//        'title' => 'Test PDF',
//        'content' => 'This is a PDF generated from Laravel'
//    ];
//
//    $pdf = PDF::loadView('pdf.template', $data);
//    return $pdf->download('generated-file.pdf');
//} ;


//generer pdf ticket




Route::get('/generate-ticket/{reservationId}', [TicketController::class, 'generateTicket']);


//statistique





