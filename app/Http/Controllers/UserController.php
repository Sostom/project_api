<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;
use App\Services\UserService;
use App\Services\RegisterService;
use App\Models\User;
use App\Exceptions\ImmoApiException;

class UserController extends Controller
{
       //Show all users
       function index(Request $request){
        try {
            $inputData = $request->all();
            $user = new UserService();
            $dataResult = $user->ShowUser($inputData);

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
                'message' => "Une erreur interne est survenue lors de l'affichage des utilisateurs.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de afficher les utilisateurs. Veuillez réessayer",
            ]);
        }
    }

    //Create users
    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(), User::$RegisterRule);
            if($validator->fails()){
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => "error",
                     'message' => "Impossible d'enrégistrer cet utilisateur. Veuillez corriger puis réessayer",   ]);
            }
            $inputData = $request->all();
            $name = $inputData["name"];
            $phone = $inputData["phone"];
            $password = $inputData["password"];

            $service = new RegisterService();
            $dataResult = $service->Register($name, $password, $phone);

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
                'message' => "Une erreur interne est survenue lors de l'enrégistrement.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de l'enregistrer. Veuillez réessayer",
            ]);
        }
	}

    //Delete users
    function deleteuser ($id){
        try {
            $service = new UserService();
            $dataResult = $service->DeleteUser($id);

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
                'message' => "Une erreur interne est survenue lors de la suppression de l'utlisateur.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de supprimer l'utilisateur. Veuillez réessayer",
            ]);
        }
    }

    //Block user
    function blockuser(Request $request, $id){
        try {
            $service = new UserService();
            $dataResult = $service->BlockUser($id);

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
                'message' => "Une erreur interne est survenue lors du blocage de l'utilisateur.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de bloquer l'utlisateur. Veuillez réessayer",
            ]);
        }
    }

    //Unblock User
    function unblockuser(Request $request, $id){
        try {
            $service = new UserService();
            $dataResult = $service->UnBlockUser($id);

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
                'message' => "Une erreur interne est survenue lors du déblocage de l'utilisateur.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de débloquer l'utlisateur. Veuillez réessayer",
            ]);
        }
    }
}
