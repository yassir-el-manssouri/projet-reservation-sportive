<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ATTENTION : Ici on crée la table 'terrains', pas 'clients'
        Schema::create('terrains', function (Blueprint $table) {
            $table->id();
            $table->string('nom');          // Ex: Terrain A
            $table->string('type');         // Ex: Foot, Basket, Tennis 
            $table->decimal('prix_heure', 8, 2); // Ex: 150.00 
            $table->string('image')->nullable(); // Pour l'affichage sur le site
            $table->text('description')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terrains');
    }
};