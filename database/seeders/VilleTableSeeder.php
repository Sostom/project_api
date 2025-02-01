<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ville;

class VilleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ville::create(['name' => "Cotonou"]);
        Ville::create(['name' => "Abomey - Calavi"]);
        Ville::create(['name' => "Bohicon"]);
        Ville::create(['name' => "Parakou"]);
        Ville::create(['name' => "Natitingou"]);
        Ville::create(['name' => "Savalou"]);
        Ville::create(['name' => "Porto - Novo"]);
        Ville::create(['name' => "Ouidah"]);
        Ville::create(['name' => "Grand - Popo"]);
    }
}
