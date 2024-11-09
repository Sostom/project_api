<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::table('role_users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $admin = User::create([
            "name" => "admin",
            "phone" => "22969436101",
            "email" => "chrystokou07@gmail.com",
            "password" => Hash::make("123456789"),
        ]);
        
        // $collaborator = User::create([
        //     "name" => "collaborator",
        //     "email" => "collaborator@collaborator.com",
        //     "password" => Hash::make("123456789"),
        //     "phone" => "22912131415",
        // ]);
        
        $user = User::create([
            "name" => "user",
            "phone" => "22965858438",
            "email" => "user@user.com",
            "password" => Hash::make("123456789"),
        ]);

        $adminRole = Role::where('name', "admin")->first();
        // $collaboratorRole = Role::where('name', "collaborator")->first();
        $userRole = Role::where('name', "user")->first();

        $admin->roles()->attach($adminRole);
        // $collaborator->roles()->attach($collaboratorRole);
        $user->roles()->attach($userRole);
    }
}
