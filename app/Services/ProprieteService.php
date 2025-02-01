<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Picture;
use App\Models\Propriete;
use App\Models\Ville;
use App\Models\OrderLine;
use App\Models\Quartier;
use Illuminate\Support\Str;
use App\Models\ProprietePicture;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ImmoApiException;

class ProprieteService{

    //Create propriete
    function CreatePropriete($type, $ville_id, $quartier_id, $feature, $indication, 
    $nbre_habitation, $nbre_cuisine, $nbre_douche, $loyer, $compteur,
    $caution_type, $caution_eau_electricite, $autres, $garage, $statut, $user_id, $request){
        
        $propriete = new Propriete();
        $propriete->type = $type;
        // $propriete->designation = $designation;
        $propriete->ville_id = $ville_id;
        $propriete->quartier_id = $quartier_id;
        $propriete->feature = $feature;
        $propriete->indication = $indication;
        $propriete->nbre_habitation = $nbre_habitation;
        // $propriete->nbre_chambre = $nbre_chambre;
        $propriete->nbre_cuisine = $nbre_cuisine;
        $propriete->nbre_douche = $nbre_douche;
        $propriete->loyer = $loyer;
        $propriete->compteur = $compteur;
        $propriete->caution_type = $caution_type;
        $propriete->caution_eau_electricite = $caution_eau_electricite;
        $propriete->autres = $autres;
        $propriete->garage = $garage;
        $propriete->statut = $statut;
        $propriete->user_id = $user_id;
        $propriete->save();

        //Insert files to database
        if ($request->has('image')) {
            // foreach ($request->file('image') as $image) {
                $image = $request["image"];
                $filename =Str::random(32).".".$image->getClientOriginalExtension();
                $path = $image->move('files/', $filename);

                $picture = Picture::create([
                    'name'=>$filename,
                    'path'=>$path
                ]);

                ProprietePicture::create([
                    'propriete_id'=>$propriete->id,
                    'picture_id'=>$picture->id
                ]);
            // }
        }
        
        return $propriete;
    }
 
    //Update propriete
    function UpdatePropriete($id,$type, $ville_id, $quartier_id, $feature, $indication, 
    $nbre_habitation, $nbre_cuisine, $nbre_douche, $loyer, $compteur,
    $caution_type, $caution_eau_electricite, $autres, $garage, $statut, $user_id){
        $idPropriete = Propriete::where('id', '=', $id)->get();

        if ($idPropriete->isEmpty()) {
            throw new ImmoApiException("Cette propriete n'existe pas. Veuillez corriger puis réessayer");
        }
        $propriete = $idPropriete->first();
        $propriete->id = $id;
        $propriete->type = $type;
        // $propriete->designation = $designation;
        $propriete->ville_id = $ville_id;
        $propriete->quartier_id = $quartier_id;
        $propriete->feature = $feature;
        $propriete->indication = $indication;
        $propriete->nbre_habitation = $nbre_habitation;
        // $propriete->nbre_chambre = $nbre_chambre;
        $propriete->nbre_cuisine = $nbre_cuisine;
        $propriete->nbre_douche = $nbre_douche;
        $propriete->loyer = $loyer;
        $propriete->compteur = $compteur;
        $propriete->caution_type = $caution_type;
        $propriete->caution_eau_electricite = $caution_eau_electricite;
        $propriete->autres = $autres;
        $propriete->garage = $garage;
        $propriete->statut = $statut;
        $propriete->user_id = $user_id;
        $propriete->save();

        return $propriete;
    }

    
    //Show single propriete for admin
    function ShowSinglePropriete($id, $user_id){
        $propriete = Propriete::where('user_id', $user_id)
        ->where('id', '=', $id)
        ->with('Ville', 'propriete_pictures.picture', 'Quartier', 'User')
        ->first();


        // Récupérer 8 propriétés avec le même loyer
        $proprietes_similaires = Propriete::where('loyer', $propriete->loyer)
        ->where('id', '!=', $id) // Exclure la propriété actuelle
        ->take(8) // Limiter à 8 résultats
        ->with('Ville', 'propriete_pictures.picture', 'Quartier', 'User')
        ->get();

            
        return array(
            "propriete" => $propriete,
            "proprietes_similaires" => $proprietes_similaires
        );
    }

    //Delete propriete
    function DeletePropriete($id){
            // Vérifier si la propriété existe
            $propriete = Propriete::find($id);
            if (!$propriete) {
                throw new ImmoApiException("Cette propriete n'existe pas. Veuillez corriger puis réessayer");
            }

            // Supprimer les photos liées
            $proprietePictures = ProprietePicture::where('propriete_id', $id)->get();
            foreach ($proprietePictures as $proprietePicture) {
                $picture = $proprietePicture->picture;
                $proprietePicture->delete();

                // Supprimer le fichier de stockage
                if ($picture && $picture->path) {
                    $filePath = public_path($picture->path);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                // Supprimer l’image si elle n’est plus liée à aucune propriété
                if ($picture && optional($picture->propriete_pictures)->isEmpty()) {
                    $picture->delete();
                }
            }

            // Supprimer la propriété
            $propriete->delete();

            return response()->json(["message" => "Propriété supprimée avec succès"]);
    }
    
    //Show All propriete by ville for proprio
    function ShowVillePropriete($inputData, $user_id, $ville_id){

        $per_page = $inputData["per_page"] ?? 15;
        $sort_by_price = $inputData["sort_by_price"] ;
        $sort_by_feature = $inputData["sort_by_feature"] ;

        $propriete = Propriete::where('ville_id', $ville_id)
            ->where('user_id', $user_id)
            ->with('propriete_pictures.picture', 'Ville');

            // Filtrer par prix
            if (!empty($sort_by_price)) {
                // Tri par prix
                if ($sort_by_price === "is_sort_by_price_desc") {
                    $propriete->orderBy('loyer', 'DESC');
                } elseif ($sort_by_price === "is_sort_by_price_asc") {
                    $propriete->orderBy('loyer', 'ASC');
                }
            }
        
            // Filtrer par caractéristiques spéciales
            if (!empty($sort_by_feature)) {
                $propriete->where('feature', $sort_by_feature);
            }
    
            return $propriete->paginate($per_page);

    }

    //Show All propriete by ville for proprio
    function ShowTypePropriete($inputData, $type_id, $user_id){

        $per_page = $inputData["per_page"] ?? 10;
        $sort_by_price = $inputData["sort_by_price"] ;
        $sort_by_ville = $inputData["sort_by_ville"] ;
        
        if ($type_id == 1) {
            $propriete = Propriete::where('feature', '01 chambre salon')
            ->where('user_id', $user_id)
            ->with('propriete_pictures.picture', 'Ville');

            // Filtrer par prix
            if (!empty($sort_by_price)) {
                // Tri par prix
                if ($sort_by_price === "is_sort_by_price_desc") {
                    $propriete->orderBy('loyer', 'DESC');
                } elseif ($sort_by_price === "is_sort_by_price_asc") {
                    $propriete->orderBy('loyer', 'ASC');
                }
            }
        
        
            // Filtrer par ville
            if (!empty($sort_by_ville)) {
                $propriete->where('ville_id', $sort_by_ville);
                
            }

            return $propriete->paginate($per_page);
        }
        elseif ($type_id == 2) {
            $propriete = Propriete::where('feature', '02 chambres salon')
            ->where('user_id', $user_id)
            ->with('propriete_pictures.picture', 'Ville');
            
            
            // Filtrer par prix
            if (!empty($sort_by_price)) {
                // Tri par prix
                if ($sort_by_price === "is_sort_by_price_desc") {
                    $propriete->orderBy('loyer', 'DESC');
                } elseif ($sort_by_price === "is_sort_by_price_asc") {
                    $propriete->orderBy('loyer', 'ASC');
                }
            }
        
        
            // Filtrer par ville
            if (!empty($sort_by_ville)) {
                $propriete->where('ville_id', $sort_by_ville);
                
            }

            return $propriete->paginate($per_page);;
        }
        elseif ($type_id == 3) {
            $propriete = Propriete::where('feature', '03 chambres salon')
            ->where('user_id', $user_id)
            ->with('propriete_pictures.picture', 'Ville')
            ->orderBy('id', 'DESC')
            ->paginate($per_page);

            // Filtrer par prix
            if (!empty($sort_by_price)) {
                // Tri par prix
                if ($sort_by_price === "is_sort_by_price_desc") {
                    $propriete->orderBy('loyer', 'DESC');
                } elseif ($sort_by_price === "is_sort_by_price_asc") {
                    $propriete->orderBy('loyer', 'ASC');
                }
            }
        
        
            // Filtrer par ville
            if (!empty($sort_by_ville)) {
                $propriete->where('ville_id', $sort_by_ville);
                
            }

            return $propriete->paginate($per_page);;
        }
        elseif ($type_id == 4) {
            $propriete = Propriete::where('feature', '04 chambres salon')
            ->where('user_id', $user_id)
            ->with('propriete_pictures.picture', 'Ville')
            ->orderBy('id', 'DESC')
            ->paginate($per_page);

            // Filtrer par prix
            if (!empty($sort_by_price)) {
                // Tri par prix
                if ($sort_by_price === "is_sort_by_price_desc") {
                    $propriete->orderBy('loyer', 'DESC');
                } elseif ($sort_by_price === "is_sort_by_price_asc") {
                    $propriete->orderBy('loyer', 'ASC');
                }
            }
        
        
            // Filtrer par ville
            if (!empty($sort_by_ville)) {
                $propriete->where('ville_id', $sort_by_ville);
                
            }

            return $propriete->paginate($per_page);;
        }

    }
    

    //add picture
    function addPictures ($request, $id) {
        $idPropriete = Propriete::where('id', '=', $id)->get();
        if ($idPropriete->isEmpty()) {
            throw new ImmoApiException("Cette propriete n'existe pas. Veuillez corriger puis réessayer");
        }
        //Insert file to database
        if ($request->has('image')) {
            // foreach ($request->file('images') as $image) {
                $image = $request["image"];
                $filename =Str::random(32).".".$image->getClientOriginalExtension();
                $path = $image->move('files/', $filename);

                $picture = Picture::create([
                    'name'=>$filename,
                    'path'=>$path
                ]);

                ProprietePicture::create([
                    'propriete_id'=>$id,
                    'picture_id'=>$picture->id
                ]);
            // }
        }
        
        return response()->json([
            "status"=> "Success",
            "message"=> "Photo ajoutée avec succès"
        ]);
    }

    function deleteproprietepicture ($id) {
        $pictures = Picture::where('id', $id)->get();
        if ($pictures->isEmpty()) {
            throw new ImmoApiException("Cette photo n'existe pas. Veuillez corriger puis réessayer");
        }

        $foundPicture = $pictures->first();
        
        //Delete all lines of propriete picture matching to this found picture
        ProprietePicture::where('picture_id', $foundPicture->id)->delete();

        //Delete the picture in the storage
        $filePath = public_path()."/".$foundPicture->path;
        unlink($filePath);

        //Delete the picture information from database
        $foundPicture->delete();

        return response()->json([
            "status" => "success",
            "message" => "Photo supprimée avec succès"
        ]);
    }



    //Show All stats for proprio
    function ShowStatsPropriete($inputData, $user_id){

        $per_page = $inputData["per_page"] ?? 15;

        
            $propriete = Propriete::where('user_id', $user_id)
            ->count();

            $propriete_1cs = Propriete::where('feature', '01 chambre salon')
            ->where('user_id', $user_id)
            ->count();


            $propriete_2cs = Propriete::where('feature', '02 chambres salon')
            ->where('user_id', $user_id)
            ->count();

        
            $propriete_3cs = Propriete::where('feature', '03 chambres salon')
            ->where('user_id', $user_id)
            ->count();


            $propriete_4cs = Propriete::where('feature', '04 chambres salon')
            ->where('user_id', $user_id)
            ->count();

            return array([
                "all_proprietes" => $propriete,
                "propriete_1cs" => $propriete_1cs,
                "propriete_2cs" => $propriete_2cs,
                "propriete_3cs" => $propriete_3cs,
                "propriete_4cs" => $propriete_4cs
            ]);
        }








    //Show All propriete 
    function ShowAllPropriete($inputData){

        $per_page = $inputData["per_page"] ?? 15;

        $propriete = Propriete::with('propriete_pictures.picture', 'Ville')
            ->orderBy('id', 'DESC')
            ->paginate($per_page);
            return $propriete;
    }
   
    //Show single propriete for users
    function ShowOnePropriete($id){
        $propriete = Propriete::where('id', '=', $id)
        ->with('Ville', 'propriete_pictures.picture', 'Quartier', 'User')
        ->first();


        // Récupérer 8 propriétés avec le même loyer
        $proprietes_similaires = Propriete::where('loyer', $propriete->loyer)
        ->where('id', '!=', $id) // Exclure la propriété actuelle
        ->take(8) // Limiter à 8 résultats
        ->with('Ville', 'propriete_pictures.picture', 'Quartier', 'User')
        ->get();

            
        return array(
            "propriete" => $propriete,
            "proprietes_similaires" => $proprietes_similaires
        );
    }
    
    //Show All propriete by ville
    function VillePropriete($inputData, $ville_id){

        $per_page = $inputData["per_page"] ?? 15;
        $sort_by_price = $inputData["sort_by_price"] ;
        $sort_by_feature = $inputData["sort_by_feature"] ;

        $propriete = Propriete::where('ville_id', $ville_id)
            ->with('propriete_pictures.picture', 'Ville');

            // Filtrer par prix
            if (!empty($sort_by_price)) {
                // Tri par prix
                if ($sort_by_price === "is_sort_by_price_desc") {
                    $propriete->orderBy('loyer', 'DESC');
                } elseif ($sort_by_price === "is_sort_by_price_asc") {
                    $propriete->orderBy('loyer', 'ASC');
                }
            }
        
            // Filtrer par caractéristiques spéciales
            if (!empty($sort_by_feature)) {
                $propriete->where('feature', $sort_by_feature);
            }
    
            return $propriete->paginate($per_page);


    }


    //Show All propriete
    function ShowPropriete($inputData, $user_id){
        
        $per_page = $inputData["per_page"] ?? 15;

        $propriete = Propriete::where('user_id', $user_id)
            ->with('propriete_pictures.picture', 'Ville')
            ->orderBy('id', 'DESC')
            ->paginate($per_page);
            return $propriete;

    
    }


    //search proprietes for users
    function SearchPropriete($inputData) {
        $per_page = $inputData["per_page"] ?? 18;
    
        $sort_by_price = $inputData["sort_by_price"] ;
        $sort_by_feature = $inputData["sort_by_feature"] ;
        $sort_by_ville = $inputData["sort_by_ville"] ;

        $query = Propriete::query();
    
        // Filtrer par prix
        if (!empty($sort_by_price)) {
            // Tri par prix
            if ($sort_by_price === "is_sort_by_price_desc") {
                $query->orderBy('loyer', 'DESC');
            } elseif ($sort_by_price === "is_sort_by_price_asc") {
                $query->orderBy('loyer', 'ASC');
            }
        }
    
        // Filtrer par caractéristiques spéciales
        if (!empty($sort_by_feature)) {
            $query->where('feature', $sort_by_feature);
        }
    
        // Filtrer par ville
        if (!empty($sort_by_ville)) {
            $query->where('ville_id', $sort_by_ville);
            
        }
    
        // Charger les relations nécessaires
        $query->with('Ville', 'propriete_pictures.picture', 'Quartier', 'User');
    
        return $query->paginate($per_page);
    }

    //search proprietes for admin
    function SearchAdminPropriete($inputData, $user_id) {
        $per_page = $inputData["per_page"] ?? 18;
    
        $sort_by_price = $inputData["sort_by_price"] ;
        $sort_by_feature = $inputData["sort_by_feature"] ;
        $sort_by_ville = $inputData["sort_by_ville"] ;

        $query = Propriete::query()->where('user_id', $user_id);
    
        // Filtrer par prix
        if (!empty($sort_by_price)) {
            // Tri par prix
            if ($sort_by_price === "is_sort_by_price_desc") {
                $query->orderBy('loyer', 'DESC');
            } elseif ($sort_by_price === "is_sort_by_price_asc") {
                $query->orderBy('loyer', 'ASC');
            }
        }
    
        // Filtrer par caractéristiques spéciales
        if (!empty($sort_by_feature)) {
            $query->where('feature', $sort_by_feature);
        }
    
        // Filtrer par ville
        if (!empty($sort_by_ville)) {
            $query->where('ville_id', $sort_by_ville);
            
        }
    
        // Charger les relations nécessaires
        $query->with('Ville', 'propriete_pictures.picture', 'Quartier', 'User');
    
        return $query->paginate($per_page);
    }

}
