<?php

namespace App\Repositories\Contracts;

interface SeanceRepositoryInterface
{
    public function getAvailableSalles();
    public function create(array $data);
    public function find($id);
    public function update( array $data ,$id);
    public function delete($id);
}

