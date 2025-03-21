<?php
namespace App\Repositories;
use App\Models\Salle;
use App\Repositories\Contracts\SalleRepositoryInterface;

class SeanceRepository implements SalleRepositoryInterface
{
    public function getAll()
    {
        return Salle::all();
    }
    public function getAvailableSalles()
    {
        // TODO: Implement getAvailableSalles() method.
    }

    public function find($id)
    {
        return salle::find() ;
    }

    public function create(array $data){
        return Salle::create($data);
    }
    public function update(array $data, $id){
        $salle = Salle::find($id) ;
        if($salle){
             $salle->updated($data);
        }
        return $salle;
    }
    public function delete($id){
        $salle = Salle::find($id);
        if($salle){
            $salle->delete();
        }
    }
}
