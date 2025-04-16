<?php

namespace App\Http\Controllers;

use App\Services\FilmService;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    protected $filmService;

    public function __construct(FilmService $filmService)
    {
        $this->filmService = $filmService;
    }

    public function index()
    {
        return response()->json($this->filmService->getAll());
    }

    public function show($id)
    {
        return response()->json($this->filmService->get($id));
    }

    public function store(Request $request)
    {
        $filmPayload = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('films', 'public');
            $filmPayload['image'] =  $imagePath;
        }

        return response()->json($this->filmService->create($filmPayload), 201);
    }

    public function update(Request $request, $id)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('films', 'public'); // stockage dans storage/app/public/films
            $validated['image_url'] = $imagePath;
        }

        return response()->json($this->filmService->update($id, $request->all()));
    }

    public function destroy($id)
    {
        return response()->json($this->filmService->delete($id));
    }
}
