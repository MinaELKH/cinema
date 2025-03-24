<?php


namespace App\Jobs;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class CancelPendingReservationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Exécute le Job.
     */
    public function handle()
    {
        // Déterminer la date limite (15 minutes avant maintenant)
        $limit = Carbon::now()->subMinutes(15);

        // Trouver les réservations en attente qui ont dépassé les 15 minutes
        $reservations = Reservation::where('status', 'pending')
            ->where('created_at', '<', $limit)
            ->update(['status' => 'cancelled']);

        // Afficher le nombre de réservations annulées dans les logs
        if ($reservations > 0) {
            \Log::info("{$reservations} réservations en attente annulées après 15 minutes.");
        }
    }
}
