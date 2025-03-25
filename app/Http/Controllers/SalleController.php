<?php
namespace App\Http\Controllers;

use App\Repositories\SalleRepository;
use App\Services\SalleService;
use App\Services\SiegeService;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    protected $salleService;
    protected $siegeService;

    public function __construct(SalleService $salleSerivce, SiegeService $siegeService)
    {
        $this->salleService = $salleSerivce;
        $this->siegeService = $siegeService;
    }
    public function index(){
        return $this->salleService->getAll();
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

        public function update($id, Request $request){
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'capacite' => 'required|integer',
                'type' => 'required|in:Normale,VIP',
            ]);

            $salle = $this->salleService->update($id  ,$validated );


            return response()->json([
                'salle' => $salle
            ], 201);
      }
    public function destroy($id)
    {
        $this->salleService->delete($id);

    }

    public function s()
    {

    }


}


