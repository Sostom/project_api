<?php

namespace App\Models;

use App\Models\Picture;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
		'picture_id'
    ];

    // Relation avec les quartiers
    public function quartiers()
    {
        return $this->hasMany(Quartier::class);
    }

	public function picture()
	{	
		return $this->belongsTo(Picture::class );
	}

    	        /**
     * @var array - Form validation rules
     */
    public static $CreateRule = [
        'name' => 'required',
		'image' => 'nullable'
    ];

	public static $UpdateRule = [
        'name' => 'required'
    ];
}