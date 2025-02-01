<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\HomeService;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ImmoApiException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class UserinfoController extends Controller
{
    
    //User
    //Modify password
    public function modifyPassword(Request $request){
        try {
            $validator = Validator::make($request->all(), User::$modifyPasswordRule);
            if($validator->fails()){
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => "error",
                     'message' => "Impossible de modifier le mot de passe. Veuillez corriger puis réessayer",   ],
                );
            }
            $inputData = $request->all();
            $email = $inputData["email"];
            $old_password = $inputData["old_password"];
            $password = $inputData["password"];

            $service = new HomeService();
            $dataResult = $service->modifyPassword($email,$old_password, $password);

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
                'message' => "Une erreur interne est survenue lors de la modification du mot de passe.",
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de modification le mot de passe. Veuillez réessayer",
            ]);
        }
    }

    //Update profile 
    function updateProfile(Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), User::$UpdateRule);
            if($validator->fails()){
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => "error",
                     'message' => "Impossible de s'enregistrer la catégorie. Veuillez corriger puis réessayer"
                ]);
            }

            $inputData = $request->all();
            $id = $id;
            $name = $inputData["name"];
            $email = $inputData["email"];
            $phone = $inputData["phone"];
            $country = $inputData["country"];
            $city = $inputData["city"];
            $address = $inputData["address"];

            $service = new HomeService();
            $dataResult = $service->UpdateProfile($id,$name,$email, $phone, $country, $city, $address);

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
                'message' => "Une erreur interne est survenue lors de la modification la catégorie.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de modifier la catégorie. Veuillez réessayer",
            ]);
        }
    } 
}
