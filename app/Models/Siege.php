<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siege extends Model
{
    use HasFactory;
    protected $fillable=['numero' , 'type' , 'salle_id'];
    public function salle(){
        return $this->belongsTo(Salle::class);

    }
}
