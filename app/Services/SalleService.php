<?php

namespace App\Services;

use App\Repositories\Contracts\SalleRepositoryInterface;

class SalleService
{
    protected $salleRepository;

    public function __construct(SalleRepositoryInterface $salleRepository)
    {
        $this->salleRepository = $salleRepository;
    }

    public function getAvailableSalles()
    {
        return $this->salleRepository->getAvailableSalles();
    }

    public function createSalle(array $data)
    {
        return $this->salleRepository->create($data);
    }

    public function updateSalle($id, array $data)
    {
        return $this->salleRepository->update($id, $data);
    }

    public function deleteSalle($id)
    {
        return $this->salleRepository->delete($id);
    }
}
