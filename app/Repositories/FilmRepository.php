<?php
namespace App\Repositories;

use App\Models\Film;
use App\Repositories\Contracts\FilmRepositoryInterface;

class FilmRepository implements FilmRepositoryInterface
{
    public function getAll()
    {
        return Film::all();
    }

    public function findById($id)
    {
        return Film::findOrFail($id);
    }

    public function create(array $data)
    {
        return Film::create($data);
    }

    public function update($id, array $data)
    {
        $film = $this->findById($id);
        $film->update($data);
        return $film;
    }

    public function delete($id)
    {
        return Film::destroy($id);
    }
}
