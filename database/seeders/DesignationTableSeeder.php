<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Designation::create(['name' => "Chambres à Louer"]);
        Designation::create(['name' => "Appartements meublés"]);
        Designation::create(['name' => "Maisons à Louer"]);
        Designation::create(['name' => "Maisons à Vendre"]);
        // Designation::create(['name' => "Parcelles à Vendre"]);
    }
}
