<?php
namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Exceptions\ImmoApiException;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserRegisteredNotification;

class RegisterService{
        //Register
        function Register($name, $phone, $password){
            //vérification du numero de téléphone
            $phoneUser = User::where('phone', '=', $phone)->get();
            if (!$phoneUser->isEmpty()) {
                throw new ImmoApiException("Ce numéro de téléphone existe déjà. Veuillez corriger puis réessayer");
            }

            $user = new User();
            $user->name = $name;
            $user->phone = $phone;
            $user->password = Hash::make($password);
            $user->save();

            $user->roles()->attach(Role::where('name', 'user')->first());

            // $user->notify(new UserRegisteredNotification());

            $tokenResult = $user->createToken('authToken')->plainTextToken;
    
            return response()->json([
                'status_code' => 200,
                'user' => $user,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
        }
}