<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Services\SeanceService;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    protected $seanceService;

    public function __construct(SeanceService $seanceService)
    {
        $this->seanceService = $seanceService;
    }

    public function index()
    {
        return response()->json($this->seanceService->getAllSeances());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'film_id' => 'required|exists:films,id',
            'salle_id' => 'required|exists:salles,id',
            'start_time' => 'required|date',
            'session' => 'required|string',
            'langue' => 'required|string',
            'type_seance' => 'required|in:Normale,VIP',
            'prix' => 'required|numeric',
        ]);

        $seance = $this->seanceService->createSeance($validated);

        return response()->json($seance, 201);
    }

    public function showByType( Request $request){
       // $this->seanceService->showByType($type) ;


        $type = $request->query('type');  // Récupère le paramètre 'type' de la requête

        if (!in_array($type, ['Normale', 'VIP'])) {
            return response()->json(['error' => 'Le type doit être soit "Normale" soit "VIP".'], 400);
        }

        // Utilisation du service pour récupérer les séances filtrées
        $seances = $this->seanceService->getSeancesByType($type);

        if ($seances->isEmpty()) {
            return response()->json(['message' => 'Aucune séance trouvée pour ce type.'], 404);
        }

        return response()->json($seances, 200);

    }
    public function getAllSeancesWithFilms(){
        try {
            $seances = $this->seanceService->getAllSeancesWithFilms();

            if ($seances === null) {
                return response()->json(['error' => 'Pas de séances à afficher.'], 404);
            }

            return response()->json($seances, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur serveur: ' . $e->getMessage()], 500);
        }
    }

    public function getSeancesByFilm($filmId){
        $seances = $this->seanceService->getSeancesByFilm($filmId);
        return response()->json($seances);
    }

}
