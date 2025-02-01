<?php 
namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Exceptions\ImmoApiException;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PasswordResetNotification;
use App\Models\PasswordReset;

class LoginService{
    //Login
    function Login($phone, $password){
        $phoneUser = User::where('phone', '=', $phone)->where('state', '=', true)->get();
        if ($phoneUser->isEmpty()) {
            throw new ImmoApiException("Ce numéro de téléphone n'existe pas. Veuillez corriger puis réessayer");
        }
        $foundUser = $phoneUser->first();
    
        //vérification du mot de passe
        $passwordlUser = $foundUser->password;
        if (!Hash::check($password, $passwordlUser)) {
            throw new ImmoApiException("Ce mot de passe ne correspond pas. Veuillez corriger puis réessayer");
        }
    
        $tokenResult = $foundUser->createToken('authToken')->plainTextToken;

        // $roles = Role::join('role_users', 'roles.id', 'role_users.role_id')
        // ->join('users', 'role_users.user_id', 'users.id')
        // ->where('users.id', $foundUser->id)
        // ->get('roles.name');
    
        return response()->json([
            'status_code' => 200,
            'access_token' => $tokenResult,
            // 'role'=>$roles,
            'token_type' => 'Bearer',
        ]);
        
    }

    //ForgotPassword

    // function forgotPassword($email) {
    //     $emailUser = User::where('email', '=', $email)->get();
    //     if ($emailUser->isEmpty()) {
    //         throw new ImmoApiException("Cette adresse email n'existe pas. Veuillez corriger puis réessayer");
    //     }
    //     $foundUser = $emailUser->first();
    //     //Générer un code à 4 chiffres
    //     $resetPasswordToken = str_pad(random_int(1,9999), 6, '0', STR_PAD_LEFT);

    //     $userPassReset = PasswordReset::where('email', $foundUser->email)->first();

    //     if (!$userPassReset) {
    //         PasswordReset::create([
    //             'email'=> $foundUser->email,
    //             'token'=> $resetPasswordToken,
    //         ]);
    //     } else {
    //         PasswordReset::where('email', $foundUser->email)->delete();
    //         $userPassReset->create([
    //             'email'=> $foundUser->email,
    //             'token'=> $resetPasswordToken
    //         ]);
    //     }
    //     $foundUser->notify(new PasswordResetNotification($resetPasswordToken));
    //     return $foundUser;
    // }

    //end forgotPassword

    //reinitialiserPassword

    // function reinitialiserPassword($email,$token, $password){
    //     //vérification de l'email
    //     $emailUser = User::where('email', '=', $email)->get();
    //     if ($emailUser->isEmpty()) {
    //         throw new ImmoApiException("Cette adresse email n'existe pas. Veuillez corriger puis réessayer");
    //     }
    //     $foundUser = $emailUser->first();

    //     $resetRequest = PasswordReset::where('email', $foundUser->email)->first();

    //     if (!$resetRequest || $resetRequest->token != $token) {
    //         throw new ImmoApiException("Vous avez oubliez le token ou le token est incorrect. Veillez réessayer.");
    //     } else {
    //         // Vérifier si le code est expiré ou non
    //         if ($resetRequest->created_at < now()->subHour()) {
    //             $resetRequest->delete();
    //             return response(['message' => 'Le code a expiré'], 422);
    //         } else {
    //             $foundUser->fill([
    //                 'password'=> Hash::make($password)
    //             ]);
                
    //             $foundUser->save();
                
    //             $foundUser->tokens()->delete();
    //             PasswordReset::where('token', $token)->delete();
                
    //             $token = $foundUser->createToken('authToken')->plainTextToken;
    //             return response()->json([
    //                 'user_id' => $foundUser->id,
    //                 'message' => 'Mot de passe réinitialisé avec succès',
    //                 'access_token' => $token,
    //                 'token_type' => 'Bearer',
    //             ]);
    //         }
    //     }

    // }
    
    //end reinitialiserPassword

}
