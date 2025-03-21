<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = [
        'film_id', 'salle_id', 'start_time', 'session', 'langue', 'type_seance'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }
}
