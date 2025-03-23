<?php
namespace App\Http\Controllers;

use App\Repositories\Contracts\FilmRepositoryInterface;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    protected $filmRepo;

    public function __construct(FilmRepositoryInterface $filmRepo)
    {
        $this->filmRepo = $filmRepo;
    }

    public function index()
    {
        return response()->json($this->filmRepo->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'duree' => 'required|integer',
            'age_minimum' => 'required|integer',
            'bande_annonce' => 'nullable|string',
            'genre' => 'required|string',
            'acteurs' => 'nullable|array',
        ]);


        return response()->json($this->filmRepo->create($validated), 201);
    }

    public function show($id)
    {
        return response()->json($this->filmRepo->findById($id));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titre' => 'string|max:255',
            'description' => 'string',
            'image' => 'nullable|string',
            'duree' => 'integer',
            'age_minimum' => 'integer',
            'bande_annonce' => 'nullable|string',
            'genre' => 'string',
            'acteurs' => 'nullable|array',
        ]);

        return response()->json($this->filmRepo->update($id, $validated));
    }

    public function destroy($id)
    {
        return response()->json($this->filmRepo->delete($id), 204);
    }
}
