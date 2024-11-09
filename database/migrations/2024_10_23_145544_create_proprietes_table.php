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
            $table->unsignedBigInteger('designation_id')->references('id')->on('designations');
            $table->unsignedBigInteger('ville_id')->references('id')->on('villes');
            $table->unsignedBigInteger('quartier_id')->nullable()->references('id')->on('quartiers');
            $table->string('indication')->nullable();
            $table->unsignedBigInteger('prix');
            $table->enum('statut', ['disponible', 'occupé'])->default('disponible');
            $table->unsignedBigInteger('user_id')->references('id')->on('users');
            $table->timestamp('created_at')->useCurrent();
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
