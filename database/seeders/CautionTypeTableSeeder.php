<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CautionType;

class CautionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CautionType::create(['type' => "Aucun"]);
        CautionType::create(['type' => "Sur négociation"]);
        CautionType::create(['type' => "1-1-1"]);
        CautionType::create(['type' => "2-1-1"]);
        CautionType::create(['type' => "3-1-1"]);
        CautionType::create(['type' => "Autre"]);
    }
}
