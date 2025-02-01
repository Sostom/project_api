<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CautionType extends Model
{
    use HasFactory;

    // Liste des champs qui peuvent être mass-assignés
    protected $fillable = [
        'type',
    ];
}
