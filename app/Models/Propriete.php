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
        'prix',
        'statut',
        'user_id',
    ];

    
    public function getCreationAttribute()
    {
        return date('Y-m-d h:m:s', strtotime($this->created_at));
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville_id');
    }

    public function quartier()
    {
        return $this->belongsTo(Quartier::class, 'quartier_id');
    }

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

    
	public function features()
	{
		return $this->hasMany(Feature::class);
	}

            /**
     * @var array - Form validation rules
     */
    public static $rulesVente = [
        'designation_id' => 'required',
        'ville_id' => 'required',
        'quartier_id' => 'nullable',
        'indication' => 'nullable',
        'prix' => 'required',
        'statut' => 'required',
        'user_id' => 'required',
    ];

    
            /**
     * @var array - Form validation rules
     */
    public static $rulesModifier = [
        'designation_id' => 'required',
        'ville_id' => 'required',
        'quartier_id' => 'nullable',
        'indication' => 'nullable',
        'prix' => 'required',
        'statut' => 'required',
        'user_id' => 'required',
    ];
}