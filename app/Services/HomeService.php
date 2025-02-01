<?php 
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\ImmoApiException;

class HomeService {
    //User
    //Modify password 
    function modifyPassword($phone, $old_password, $password) {
        //vérification de l'email
        $phoneUser = User::where('phone', '=', $phone)->get();
        if ($phoneUser->isEmpty()) {
            throw new ImmoApiException("Utilisateur non trouvé. Veuillez vous reconnecter puis réessayer");
        }
        $foundUser = $phoneUser->first();

        //vérification du mot de passe
        $passwordlUser = $foundUser->password;
        if (!Hash::check($old_password, $passwordlUser)) {
            throw new ImmoApiException("Cet mot de passe ne correspond pas. Veuillez corriger puis réessayer");
        }

        $foundUser->password = Hash::make($password);
        $foundUser->save();

        return response()->json([
            'statut' =>"Success",
            'message' => "Mot de passe modifié avec succès"
        ]);
    }

    //Modify password 
    function updateProfile($id,$name, $phone) {
        //vérification de l'existence de l'utilisateur
        $user = User::where('id', '=', $id)->get();
        if ($user->isEmpty()) {
            throw new ImmoApiException("Cet utilisateur n'existe pas.Veuillez corriger puis réessayer");
        }
        $foundUser = $user->first();

        $foundUser->name = $name;
        // $foundUser->email = $email;
        $foundUser->phone = $phone;
        $foundUser->save();

        return response()->json([
            'statut' =>"Success",
            'message' => "Profile modifié avec succès"
        ]);
    }

}