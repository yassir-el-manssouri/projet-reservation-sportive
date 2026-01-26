<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // On crée la table 'equipements'
        Schema::create('equipements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');         // Ex: Ballon de foot
            $table->integer('quantite');   // Ex: 10 en stock
            $table->decimal('prix', 8, 2)->nullable(); // Prix de location
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipements');
    }
};