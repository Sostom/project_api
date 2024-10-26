<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Propriete extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation_id',
        'ville_id',
        'quartier_id',
        'indication',
        'description',
        'prix',
        'picture',
        'statut',
        'user_id',
    ];

    protected $casts = [
        'description' => 'array', // Indiquer que la colonne "description" est un tableau
    ];

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function quartier()
    {
        return $this->belongsTo(Quartier::class);
    }
}