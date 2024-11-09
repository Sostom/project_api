<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\LoginService;
use App\Services\RegisterService;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ImmoApiException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Services\ResetService;

class AuthController extends Controller
{   
    //Register Users
    public function register(Request $request){
        try {
            $validator = Validator::make($request->all(), User::$RegisterRule);
            if($validator->fails()){
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => "error",
                    'message' => "Impossible de s'inscrire. Veuillez corriger puis réessayer"
                ]);
            }
            $inputData = $request->all();
            $name = $inputData["name"];
            $phone = $inputData["phone"];
            $password = $inputData["password"];

            $service = new RegisterService();
            $dataResult = $service->Register($name, $phone, $password);
            
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
                'message' => "Une erreur interne est survenue lors de l'inscription.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de s'inscrire. Veuillez réessayer",
            ]);
        }
	}

    //Login Users
    public function login(Request $request){

        try {
            $inputData = $request->all();
            $phone = $inputData["phone"];
            $password = $inputData["password"];

            $service = new LoginService();
            $dataResult = $service->Login($phone, $password);

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
                'message' => "Une erreur interne est survenue lors de l'authentification.",
            ]);
        }
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => "error",
                'message' => "Impossible de s'authentifier. Veuillez réessayer",
            ]);
        }
	}

    //Logout 
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        $msg =  ['message' => 'Logged Out'];
        return $msg;
    }

    //ForgotPassword

    // function forgotPassword(Request $request){
    //     try {

    //         //validate data
    //         $validator = Validator::make($request->all(), User::$rulesPasswordForgot);
    //         if($validator->fails()){
    //             return response()->json([
    //                 'data' => $validator->errors(),
    //                 'status' => "error",
    //                 'message' => "Un utilisateur avec cet email n'existe pas. Veuillez corriger puis réessayer"]);
    //         }

    //         //recup data
    //         $inputData = $request->all();
    //         $email = $inputData["email"];


    //         $service = new LoginService();
    //         $dataResult = $service->forgotPassword($email);

    //     //result
    //         return response()->json([
    //             'data' => $dataResult,
    //             'status' => "success",
    //             'message' => "Le code pour réinitialiser votre mot de passe a été envoyé",
    //         ]);

    //     } catch (ImmoApiException $ex) {
    //         Log:: error($ex->getMessage());
    //         return response()->json([
    //             'status' => "error",
    //             'message' => $ex->getMessage(),
    //         ]);
    //     }
    // }
    
    //end ForgotPassword



    //reinitialiserPassword

    // function resetpassword(Request $request){
    //     try {

    //         //validate data
    //         $validator = Validator::make($request->all(), User::$ResetPasswordRule);
    //         if($validator->fails()){
    //             return response()->json([
    //                 'data' => $validator->errors(),
    //                 'status' => "error",
    //                 'message' => "Impossible de reinitialiser le mot de passe. Veuillez corriger puis réessayer",   ]
    //                 );
    //         }

    //         //recup data
    //         $inputData = $request->all();
    //         $email = $inputData["email"];
    //         $token = $inputData["token"];
    //         $password = $inputData["password"];


    //         $service = new LoginService();
    //         $dataResult = $service->reinitialiserPassword($email,$token, $password);

    //     //result
    //         return response()->json([
    //             'data' => $dataResult,
    //             'status' => "success",
    //             'message' => "",
    //         ]);

    //     } catch (ImmoApiException $ex) {
    //         Log:: error($ex->getMessage());
    //         return response()->json([
    //             'status' => "error",
    //             'message' => $ex->getMessage(),
    //         ]);
    //     }
    //     catch (QueryException $ex) {
    //         Log::error($ex->getMessage());
    //         return response()->json([
    //             'status' => "error",
    //             'message' => "Une erreur interne est survenue lors de la reinitialisation du mot de passe.",
    //         ]);
    //     }
    //     catch (Exception $ex) {
    //         Log::error($ex->getMessage());
    //         return response()->json([
    //             'status' => "error",
    //             'message' => "Impossible de reinitialiser le mot de passe. Veuillez réessayer",
    //         ]);
    //     }
    // }
    
    //end reinitialiserPassword


    //Test
    public function Test(){ 
        $msg =  ['message' => 'Well'];
        return $msg;
    }

    //Verify email
    // function verify($id,$hash) {
    //     $user= User::find($id);

    //     abort_if(!$user,403);

    //     abort_if(!hash_equals($hash, sha1($user->getEmailForVerification())),403);

    //     if (!$user->hasVerifiedEmail()) {
    //         $user->markEmailAsVerified();
    //         event(new Verified($user));
    //     }
    //     return view('emailVerified');
    // }

    //Resend email verification

    // function resendEmailNotification (Request $request) {
    //     if ($request->user()->hasVerifiedEmail()) {
    //         return response()->json(["message" => "Vous avez déjà vérifié votre email"], 400);
    //     } else {
    //         $request->user()->sendEmailVerificationNotification();
    //         return response()->json([
    //             "status"=>"success",
    //             "message" => "Verification email sent"
    //         ]);
    //     }
    // }

}
