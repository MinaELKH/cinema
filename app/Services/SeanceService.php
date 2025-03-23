<?php

namespace App\Services;

use App\Repositories\Contracts\SeanceRepositoryInterface;

class SeanceService
{
    protected $seanceRepository;

    public function __construct(SeanceRepositoryInterface $seanceRepository)
    {
        $this->seanceRepository = $seanceRepository;
    }

    public function getAllSeances()
    {
        return $this->seanceRepository->getAll();
    }

    public function createSeance(array $data)
    {
        return $this->seanceRepository->create($data);
    }
}
