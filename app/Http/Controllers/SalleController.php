<?php
namespace App\Http\Controllers;

use App\Repositories\SalleRepository;
use App\Services\SiegeService;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    protected $salleRepo;
    protected $siegeService;

    public function __construct(SalleRepository $salleRepo, SiegeService $siegeService)
    {
        $this->salleRepo = $salleRepo;
        $this->siegeService = $siegeService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'capacite' => 'required|integer',
            'type' => 'required|in:Normale,VIP',
        ]);

        $salle = $this->salleRepo->create($validated);
        // Générer les sièges automatiquement
        $sieges = $this->siegeService->generateSiegesForSalle($salle);

        return response()->json([
            'salle' => $salle,
            'sieges' => $sieges,
        ], 201);
    }
}


