<?php

namespace App\Models;

use App\Models\Ville;
use App\Models\ProprietePicture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Picture extends Model
{
    use HasFactory;

    protected $table = 'pictures';

    protected $fillable = [
		'id',
		'name',
		'path'
	];

	public function product_pictures()
	{
		return $this->hasMany(ProprietePicture::class);
	}

	public function ville()
	{
		return $this->belongsTo(Ville::class);
	}
}
