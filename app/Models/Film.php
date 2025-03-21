<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable=['titre' , 'description' , 'image' , 'duree' , 'age_minimum' , 'bande_annonce' , 'genre'  ];
    protected $casts = [
        'acteurs' => 'array',
    ];
    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
