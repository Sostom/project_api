<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\RoleUser;
use App\Exceptions\ImmoApiException;

class UserService{
    //Show all users
    function ShowUser($inputData){
        $per_page = $inputData["per_page"] ?? 10;
        
        if (array_key_exists('search', $inputData)) {
            $search = $inputData["search"];
            $user = User::select('id', 'name', 'email', 'phone', 'state')
                ->where('name', '<>', 'admin')
                ->where(function($query) use ($search) {
                    $query->where('name', 'like', "%$search%")
                          ->orWhere('phone', 'like', "%$search%");
                })
                ->orderBy('created_at', 'DESC')
                ->paginate($per_page);
        } else {
            $user = User::select('id', 'name', 'email', 'phone', 'country', 'city', 'address', 'state')
                ->where('name', '<>', 'admin')
                ->orderBy('created_at', 'DESC')
                ->paginate($per_page);
        }
        
        return $user;
    }
    

    //Delete User
    function DeleteUser($id){
        $idUser = User::where('users.id', '=', $id)->get();
        if ($idUser->isEmpty()) {
            throw new ImmoApiException("Cet utilisateur n'existe pas. Veuillez corriger puis réessayer");
        }
        $role_users = RoleUser::where('role_users.user_id', '=', $id)->delete();
    
        $user = User::where('users.id', '=', $id)->delete();
        return $user;
    }

    //Bloc user
    function BlockUser($id){
        $idUser = User::where('id', '=', $id)->get();
        if ($idUser->isEmpty()) {
            throw new ImmoApiException("Cet utilisateur n'existe pas. Veuillez corriger puis réessayer");
        }
        $user = $idUser->first();
        $user->state = false;
        $user->tokens()->delete();
        $user->save();

        return $user;
    }

    //Unblock user
    function UnBlockUser($id){
        $idUser = User::where('id', '=', $id)->get();
        if ($idUser->isEmpty()) {
            throw new ImmoApiException("Cet utilisateur n'existe pas. Veuillez corriger puis réessayer");
        }
        $user = $idUser->first();
        $user->state = true;
        $user->save();

        return $user;
    }
}