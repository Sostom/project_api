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
        Schema::create('proprietes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Ordinaire', 'Sanitaire']);
            // $table->string('designation')->references('name')->on('designations');
            $table->unsignedBigInteger('ville_id')->references('id')->on('villes');
            $table->unsignedBigInteger('quartier_id')->nullable()->references('id')->on('quartiers');
            $table->string('indication')->nullable();
            $table->string('feature');
            $table->unsignedBigInteger('nbre_habitation');
            // $table->unsignedBigInteger('nbre_chambre');
            $table->unsignedBigInteger('nbre_cuisine');
            $table->unsignedBigInteger('nbre_douche');
            $table->unsignedBigInteger('loyer');
            $table->enum('compteur', ['Oui', 'Non']);
            $table->string('caution_type');
            $table->string('caution_eau_electricite');
            $table->string('autres')->nullable();
            $table->enum('garage', ['Oui', 'Non']);
            $table->enum('statut', ['disponible', 'occupé'])->default('disponible');
            $table->unsignedBigInteger('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proprietes');
    }
};
