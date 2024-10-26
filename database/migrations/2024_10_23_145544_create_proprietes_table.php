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
            $table->foreignId('designation_id')->constrained()->onDelete('cascade');
            $table->foreignId('ville_id')->constrained()->onDelete('cascade');
            $table->foreignId('quartier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('indication')->nullable();
            $table->json('description')->nullable(); // Utilisation de JSON pour stocker les détails comme un tableau
            $table->unsignedBigInteger('prix');
            $table->string('picture')->nullable(); // Stocker les chemins des photos (par exemple, sous forme de JSON si plusieurs)
            $table->enum('statut', ['disponible', 'occupé'])->default('disponible');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
