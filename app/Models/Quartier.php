<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quartier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ville_id'];

    // Relation avec la ville
    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }
}