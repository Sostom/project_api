<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => "admin"]);
        // Role::create(['name' => "locataire"]);
        Role::create(['name' => "user"]);
    }
}
