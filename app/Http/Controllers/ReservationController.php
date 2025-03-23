<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
        $this->middleware('auth:api'); // Assure-toi que l'utilisateur est authentifié avant d'accéder aux actions
    }

    // Pour créer une réservation
    public function store(Request $request)
    {
        $userId = Auth::id();  // Récupérer l'ID de l'utilisateur authentifié
        Log::debug('Un message de debug', ['userId' =>  $userId]);
        $data = $request->all(); // Récupérer les données de la requête
        $data['user_id'] = $userId; // Ajouter l'ID de l'utilisateur aux données de la réservation

        return $this->reservationService->createReservation($data); // Appeler la méthode pour créer la réservation
    }

    // Pour confirmer une réservation après paiement
    public function confirm($id)
    {
        $userId = Auth::id();  // Vérifier l'utilisateur authentifié
        return $this->reservationService->confirmReservation($id, $userId); // Confirmer la réservation
    }

    // Pour annuler une réservation si le paiement n'a pas été effectué dans les 15 minutes
    public function cancel($id)
    {
        $userId = Auth::id();  // Récupérer l'ID de l'utilisateur authentifié
        return $this->reservationService->cancelReservation($id, $userId); // Annuler la réservation
    }

//    public function getReservations($userId)
//    {
//        $user = User::with('reservations.siege', 'reservations.seance')->find($userId);
//
//        if (!$user) {
//            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
//        }
//
//        return response()->json($user->reservations);
//    }


}
