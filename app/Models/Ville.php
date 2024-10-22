<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    // Relation avec les quartiers
    public function quartiers()
    {
        return $this->hasMany(Quartier::class);
    }
}