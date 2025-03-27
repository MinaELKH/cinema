<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Seance;
use App\Models\Siege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;
use App\Models\Reservation;

class PaymentController extends Controller
{
    // Méthode pour créer la session de paiement
    public function createCheckoutSession(Request $request)
    {
        // Définir la clé API Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Utilisateur non authentifié.'], 401);
            }

            // Récupérer la réservation depuis la base de données
            $reservation = Reservation::find($request->reservation_id);
            if (!$reservation) {
                return response()->json(['error' => 'Réservation introuvable.'], 404);
            }

            $seance = Seance::find($reservation->seance_id);
            $film = Film::find($seance->film_id);
            $siege = Siege::find($reservation->siege_id);
            return response()->json(['$film' => $film], 200);
            // Convertir le prix en cents (Stripe attend un montant en cents)
            $priceInCents = intval($reservation->prix * 100);

            // Créer une session de paiement Stripe
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'], // Type de paiement (carte)
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd', // Devise
                            'product_data' => [
                                'name' => 'test', // Utilisation de 'title' ici
                                'description' => "Séance de {$seance->type_seance} pour le film {$film->title} - Siège numéro {$siege->numero} à {$seance->start_time}", // Description détaillée
                            ],
                            'unit_amount' => $priceInCents, // Prix en cents
                        ],
                        'quantity' => 1, // Quantité
                    ],
                ],
                'mode' => 'payment', // Mode de paiement
                'success_url' => route('payment.success', ['reservation_id' => $reservation->id]), // URL de succès
                'cancel_url' => route('payment.cancel'), // URL d'annulation
                'client_reference_id' => $user->id, // Lien avec la réservation
            ]);

            // Retourner l'URL de la session de paiement
            return response()->json(['url' => $session->url], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Méthode pour gérer le succès du paiement
    public function success(Request $request)
    {
        // Logique pour mettre à jour le statut de la réservation
        try {
            // Récupérer la réservation liée à l'utilisateur
            $reservation = Reservation::where('user_id', $request->user_id)->latest()->first();

            if ($reservation) {
                // Mise à jour du statut de la réservation en "paid"
                $reservation->update(['status' => 'reserved']);
                return response()->json(['message' => 'Paiement réussi, réservation confirmée.'], 200);
            }

            return response()->json(['message' => 'Réservation introuvable.'], 404);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour de la réservation.'], 500);
        }
    }

    // Méthode pour gérer l'annulation du paiement
    public function cancel(Request $request)
    {
        return response()->json(['message' => 'Le paiement a été annulé.'], 200);
    }

    // Méthode pour gérer les webhooks de Stripe (confirmer le paiement)
    public function handleStripeWebhook(Request $request)
    {
        // Le secret du webhook Stripe (à obtenir depuis le tableau de bord Stripe)
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        // Récupérer le corps de la requête et la signature
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            // Vérifier le webhook
            $event = Webhook::constructEvent($payload, $sig_header, $endpointSecret);

            // Gérer l'événement reçu (par exemple, un paiement réussi)
            if ($event->type == 'checkout.session.completed') {
                $session = $event->data->object;

                // Mettre à jour le statut de la réservation en base de données
                $reservation = Reservation::where('user_id', $session->client_reference_id)->latest()->first();
                if ($reservation) {
                    $reservation->update(['status' => 'paid']);
                }
            }

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Webhook Error'], 400);
        }
    }
}
