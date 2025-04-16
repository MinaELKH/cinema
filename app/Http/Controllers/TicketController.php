<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\ReservationService;
use Barryvdh\DomPDF\Facade\PDF;

class TicketController extends Controller
{
    private $reservationService;

    public function __construct(ReservationService $reservationService){
        $this->reservationService = $reservationService;
    }

    public function generateTicket($reservationId)
    {
        // Récupération de la réservation
        $reservation = Reservation::findOrFail($reservationId);
        $detailleRes = $this->reservationService->ReservationDetaille($reservationId);

        // Préparer les données du PDF
        $data = [
            'customer_name'     => 'Cher spectateur/spectatrice',
            'Film'              => $detailleRes['film']->titre,
            'Seance'            => $detailleRes['seance']->start_time,
            'Siege'             => $detailleRes['siege']->siege_number,
            'Prix'              => $detailleRes['seance']->prix,
            'reservation_code'  => $reservation->reservation_code,
        ];

        // Génération du PDF
        $pdf = PDF::loadView('pdf.ticket', $data);
        return $pdf->download('ticket-' . $reservation->reservation_code . '.pdf');
    }
}
