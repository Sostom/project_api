<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Propriete;
use Illuminate\Http\Request;
use App\Services\ProprieteService;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ImmoApiException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class ProprieteController extends Controller
{
    //Create Propriete
    function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), Propriete::$CreateRule);
            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => "error",
                    'message' => "Impossible d'enregistrer la propriété. Veuillez corriger puis réessayer"
                ]);
            }

            $inputData = $request->all();
            $type = $inputData["type"];
            // $designation = $inputData["designation"];
            $ville_id = $inputData["ville_id"];
            $quartier_id = $inputData["quartier_id"];
            $feature = $inputData["feature"];
            $indication = $inputData["indication"];
            $nbre_habitation = $inputData["nbre_habitation"];
            // $nbre_chambre = $inputData["nbre_chambre"];
            $nbre_cuisine = $inputData["nbre_cuisine"];
            $nbre_douche = $inputData["nbre_douche"];
            $loyer = $inputData["loyer"];
            $compteur = $inputData["compteur"];
            $caution_type = $inputData["caution_type"];
            $caution_eau_electricite = $inputData["caution_eau_electricite"];
            $autres = $inputData["autres"];
            $garage = $inputData["garage"];
            $statut = $inputData["statut"];
            $user_id = $inputData["user_id"];
    
            $service = new ProprieteService();
            
            $dataResult = $service->CreatePropriete($type, $ville_id, $quartier_id, $feature, $indication, 
                $nbre_habitation, $nbre_cuisine, $nbre_douche, $loyer, $compteur,
                $caution_type, $caution_eau_electricite, $autres, $garage, $statut, $user_id, $request);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'ajout.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible d'enregistrer. Veuillez réessayer",
            ]);
        }
    }
    
    //Update Propriete
    function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), Propriete::$updateRule);
            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => "error",
                    'message' => "Impossible de modifier. Veuillez corriger puis réessayer"
                ]);
            }

            $inputData = $request->all();
            $id = $id;
            $type = $inputData["type"];
            $ville_id = $inputData["ville_id"];
            $quartier_id = $inputData["quartier_id"];
            $feature = $inputData["feature"];
            $indication = $inputData["indication"];
            $nbre_habitation = $inputData["nbre_habitation"];
            // $nbre_chambre = $inputData["nbre_chambre"];
            $nbre_cuisine = $inputData["nbre_cuisine"];
            $nbre_douche = $inputData["nbre_douche"];
            $loyer = $inputData["loyer"];
            $compteur = $inputData["compteur"];
            $caution_type = $inputData["caution_type"];
            $caution_eau_electricite = $inputData["caution_eau_electricite"];
            $autres = $inputData["autres"];
            $garage = $inputData["garage"];
            $statut = $inputData["statut"];
            $user_id = $inputData["user_id"];

            $service = new ProprieteService();
            $dataResult = $service->UpdatePropriete($id, $type, $ville_id, $quartier_id, $feature, $indication, 
            $nbre_habitation, $nbre_cuisine, $nbre_douche, $loyer, $compteur,
            $caution_type, $caution_eau_electricite, $autres, $garage, $statut, $user_id, $request);
            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de la modification.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de modifier. Veuillez réessayer",
            ]);
        }
    }

    //Show single propriete
    function show(Request $request, $id)
    {
        try {
            $inputData = $request->all();
            $user_id = $inputData["user_id"];
            $service = new ProprieteService();
            $dataResult = $service->ShowSinglePropriete($id, $user_id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible d'afficher . Veuillez réessayer",
            ]);
        }
    }

    //Delete propriete
    function deletepropriete($id)
    {
        try {
            $service = new ProprieteService();
            $dataResult = $service->DeletePropriete($id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de la suppression.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de supprimer. Veuillez réessayer",
            ]);
        }
    }

    //Show All proprietes in a ville for proprio
    function getProprietesByVille(Request $request)
    {
        try {
            $inputData = $request->all();
            $ville_id = $inputData["ville_id"];
            $user_id = $inputData["user_id"];

            $service = new ProprieteService();
            $dataResult = $service->ShowVillePropriete($inputData, $user_id, $ville_id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de afficher. Veuillez réessayer",
            ]);
        }
    }

    //Show All proprietes in a ville
    function getProprietesByType(Request $request)
    {
        try {
            $inputData = $request->all();
            $type_id = $inputData["type_id"];
            $user_id = $inputData["user_id"];

            $service = new ProprieteService();
            $dataResult = $service->ShowTypePropriete($inputData, $type_id, $user_id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de afficher. Veuillez réessayer",
            ]);
        }
    }
    
    //Show Stats
    function getStats(Request $request)
    {
        try {
            $inputData = $request->all();
            $user_id = $inputData["user_id"];

            $service = new ProprieteService();
            $dataResult = $service->ShowStatsPropriete($inputData, $user_id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de afficher. Veuillez réessayer",
            ]);
        }
    }

    //Add picture to propriete
    function addPictures(Request $request, $id)
    {
        try {
            $service = new ProprieteService();
            $dataResult = $service->addPictures($request, $id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'ajout de la photo de la propriété.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible d'ajouter une photo à la propriété. Veuillez réessayer",
            ]);
        }
    }

    //Add picture to propriete
    function deleteproprietepicture($id)
    {
        try {
            $service = new ProprieteService();
            $dataResult = $service->deleteproprietepicture($id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de la suppression de la photo.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de supprimer la photo. Veuillez réessayer",
            ]);
        }
    }

    //Show All proprietes
    function searchAdminProp(Request $request)
    {
        try {
            $inputData = $request->all();
            $user_id = $inputData["user_id"];

            $service = new ProprieteService();
            $dataResult = $service->SearchAdminPropriete($inputData, $user_id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de afficher. Veuillez réessayer",
            ]);
        }
    }

    // FIN ADMIN REQUETES



    //Search proprietes
    function searchProp(Request $request)
    {
        try {
            $inputData = $request->all();
            // $user_id = $inputData["user_id"];

            $service = new ProprieteService();
            $dataResult = $service->SearchPropriete($inputData);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de afficher. Veuillez réessayer",
            ]);
        }
    }


    //Show All proprietes for simple user
    function indexAll(Request $request)
    {
        try {
            $inputData = $request->all();

            $service = new ProprieteService();
            $dataResult = $service->ShowAllPropriete($inputData);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage.".$ex->getMessage(),
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de afficher. Veuillez réessayer",
            ]);
        }
    }

    
    //Show single propriete for simple user
    function showOne(Request $request, $id)
    {
        try {
            $service = new ProprieteService();
            $dataResult = $service->ShowOnePropriete($id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible d'afficher . Veuillez réessayer",
            ]);
        }
    }
    
     //Show All proprietes in a ville for users
    function ProprietesByVille(Request $request)
    {
        try {
            $inputData = $request->all();
            $ville_id = $inputData["ville_id"];

            $service = new ProprieteService();
            $dataResult = $service->VillePropriete($inputData, $ville_id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de afficher. Veuillez réessayer",
            ]);
        }
    }



    //Show All proprietes
    function index(Request $request)
    {
        try {
            $inputData = $request->all();
            $user_id = $inputData["user_id"];

            $service = new ProprieteService();
            $dataResult = $service->ShowPropriete($inputData, $user_id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);
        } catch (ImmoApiException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de afficher. Veuillez réessayer",
            ]);
        }
    }




}

    
