<?php

namespace App\Models;

use App\Models\Picture;
use App\Models\Propriete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProprietePicture extends Model
{
    use HasFactory;

    protected $table = 'propriete_pictures';

	protected $fillable = [
		'propriete_id',
		'picture_id'
	];

    public function propriete()
	{
		return $this->belongsTo(Propriete::class);
	}

	public function picture()
	{
		return $this->belongsTo(Picture::class);
	}
}
