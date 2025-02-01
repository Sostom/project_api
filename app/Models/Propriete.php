<?php

namespace App\Models;

use App\Models\Ville;
use App\Models\Quartier;
use App\Models\Designation;
use App\Models\CautionType;
use App\Models\ProprietePicture;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Propriete extends Model
{
    use HasFactory;

	protected $table = 'proprietes';

	protected $casts = [
		'ville_id' => 'int',
		'quartier_id' => 'int',
		// 'designation' => 'string',
		'user_id' => 'int',
		'caution_type' => 'string',
	];

    protected $fillable = [
        'type',
        // 'designation',
        'ville_id',
        'quartier_id',
        'feature',
        'indication',
        'nbre_habitation',
        // 'nbre_salon',
        // 'nbre_chambre',
        'nbre_cuisine',
        'nbre_douche',
        'loyer',
        'caution_type',
        'caution_eau_electricite',
        'autres',
        'garage',
        'statut',
        'user_id'
    ];

    
    public function getCreationAttribute()
    {
        return date('Y-m-d h:m:s', strtotime($this->created_at));
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function quartier()
    {
        return $this->belongsTo(Quartier::class, 'quartier_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation');
    }

    public function caution_type()
    {
        return $this->belongsTo(CautionType::class, 'caution_type');
    }

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function propriete_pictures()
	{
		return $this->hasMany(ProprietePicture::class);
	}
    
	        /**
     * @var array - Create Products Rule
     */
    public static $CreateRule = [
        'type' => 'required',
        // 'designation' => 'required',
        'ville_id' => 'required',
        'quartier_id' => 'nullable',
        'feature' => 'required',
        'indication' => 'nullable',
        'nbre_habitation' => 'required',
        // 'nbre_salon' => 'required',
        // 'nbre_chambre' => 'required',
        'nbre_cuisine' => 'required',
        'nbre_douche' => 'required',
        'loyer' => 'required',
        'caution_type' => 'required',
        'caution_eau_electricite' => 'required',
        'autres' => 'nullable',
        'garage' => 'nullable',
        'statut' => 'nullable',
        'user_id' => 'required',
        'image' => 'required'
    ];

	public static $updateRule = [
        'type' => 'required',
        // 'designation' => 'required',
        'ville_id' => 'required',
        'quartier_id' => 'nullable',
        'feature' => 'required',
        'indication' => 'nullable',
        'nbre_habitation' => 'required',
        // 'nbre_chambre' => 'required',
        'nbre_cuisine' => 'required',
        'nbre_douche' => 'required',
        'loyer' => 'required',
        'compteur' => 'required',
        'caution_type' => 'required',
        'caution_eau_electricite' => 'required',
        'autres' => 'nullable',
        'garage' => 'nullable',
        'statut' => 'required',
        'user_id' => 'required'
    ];

     
	//Search
	// public function search($keyword){
	// 	$propriete_by_loyer = DB::table('proprietes')->select('proprietes.id','proprietes.ville', 'proprietes.quartier','proprietes.loyer','proprietes.caution_type')
	// 	->where('proprietes.loyer', 'LIKE', '%' . $keyword . '%')
	// 	->inRandomOrder()
	// 	->limit(5)
	// 	->get();
		
	// 	return $propriete_by_loyer;
		
	// }

    // Search
    // public function search($keyword) {
    //     $propriete_by_loyer = DB::table('proprietes')
    //         ->select('proprietes.id', 'proprietes.ville', 'proprietes.quartier', 'proprietes.loyer', 'proprietes.caution_type');

    //     // Vérifier si le mot-clé est un nombre
    //     if (is_numeric($keyword)) {
    //         // Ajouter des conditions pour les champs numériques
    //         $propriete_by_loyer->where('proprietes.nbre_chambre', $keyword)
    //             ->orWhere('proprietes.loyer', $keyword);
    //     } else {
    //         // Ajouter des conditions pour les champs textuels
    //         $propriete_by_loyer->orWhere('proprietes.ville', 'LIKE', '%' . $keyword . '%');
    //     }

    //     $propriete_by_loyer = $propriete_by_loyer->inRandomOrder()
    //         ->limit(5)
    //         ->get();

    //     return $propriete_by_loyer;
    // }


    
}