<?php

namespace App\Repositories;

use App\Models\Film;
use App\Models\Seance;
use App\Repositories\Contracts\SeanceRepositoryInterface;

class SeanceRepository implements SeanceRepositoryInterface
{
    public function getAll()
    {
        return Seance::all();
    }

    public function findById($id)
    {
        return Seance::findOrFail($id);
    }

    public function create(array $data)
    {
        $film = Film::findOrFail($data['film_id']);
        return $film->salles()->attach($data['salle_id'], [
            'start_time' => $data['start_time'],
            'session' => $data['session'],
            'langue' => $data['langue']
        ]);
    }

    public function update($id, array $data)
    {
        $seance = $this->findById($id);
        $seance->update($data);
        return $seance;
    }

    public function delete($id)
    {
        return Seance::destroy($id);
    }
}
