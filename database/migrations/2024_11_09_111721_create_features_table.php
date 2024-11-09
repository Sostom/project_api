<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('propriete_id');
            $table->foreign('propriete_id')->references('id')->on('proprietes');
            $table->unsignedBigInteger('nbre_habitation');
            $table->unsignedBigInteger('nbre_salon');
            $table->unsignedBigInteger('nbre_chambre');
            $table->unsignedBigInteger('nbre_douche');
            $table->unsignedBigInteger('nbre_cuisine');
            $table->unsignedBigInteger('nbre_jardin');
            $table->unsignedBigInteger('nbre_cuisine');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
