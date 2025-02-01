<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Ville;
use Illuminate\Http\Request;
use App\Services\VilleService;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ImmoApiException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class VilleController extends Controller
{
     //Create Ville
    function store(Request $request){
        try {
            $validator = Validator::make($request->all(), Ville::$CreateRule);
            if($validator->fails()){
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => "error",
                     'message' => "Impossible d'enregistrer la ville. Veuillez corriger puis réessayer"
                ]);
            }

            $inputData = $request->all();
            $name = $inputData["name"];
            $image = $inputData["image"] ?? null;


            $service = new VilleService();
            $dataResult = $service->CreateVille($name, $image);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);

        } catch (ImmoApiException $ex) {
              Log:: error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        }
        catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'enregistrer de la ville.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible d'enregistrer la ville. Veuillez réessayer",
            ]);
        }
    }
    
    
    //Show all villes
    function index(Request $request){
        try {
            $inputData = $request->all();

            $service = new VilleService();
            $dataResult = $service->ShowVille($inputData);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);

        } catch (ImmoApiException $ex) {
              Log:: error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        }
        catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage des villes.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible d'afficher les villes. Veuillez réessayer",
            ]);
        }
    }

    //Delete ville 
    function delete ($id){
        try {
            $service = new VilleService();
            $dataResult = $service->DeleteVille($id);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);

        } catch (ImmoApiException $ex) {
              Log:: error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        }
        catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de la suppression de cette ville.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de supprimer la ville. Veuillez réessayer",
            ]);
        }
    }

    //Update ville
    function update(Request $request, $id){
        try {
            $validator = Validator::make($request->all(), Ville::$UpdateRule);
            if($validator->fails()){
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => "error",
                     'message' => "Impossible de modifier la ville. Veuillez corriger puis réessayer"
                ]);
            }

            $inputData = $request->all();
            $id = $id;
            $name = $inputData["name"];
            $image = $inputData["image"] ?? null;

            $service = new VilleService();
            $dataResult = $service->UpdateVille($id, $name, $image);

            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);

        } catch (ImmoApiException $ex) {
              Log:: error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        }
        catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de la modification de la ville.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de modifier la ville. Veuillez réessayer",
            ]);
        }
    }

    //Show single ville
    function show(Request $request, $id){
        try {
            $service = new VilleService();
            $dataResult = $service->ShowSingleVille($id);

        //result
            return response()->json([
                'data' => $dataResult,
                'status' => "success",
                'message' => "",
            ]);

        } catch (ImmoApiException $ex) {
              Log:: error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => $ex->getMessage(),
            ]);
        }
        catch (QueryException $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Une erreur interne est survenue lors de l'affichage de la ville.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible d'afficher la ville. Veuillez réessayer",
            ]);
        }
    }
}
