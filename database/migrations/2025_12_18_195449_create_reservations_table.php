<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            // Lien vers l'utilisateur (client)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Lien vers le terrain
            $table->foreignId('terrain_id')->constrained()->onDelete('cascade');
            
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->decimal('prix_total', 10, 2)->nullable();
            $table->string('statut')->default('confirmé'); // confirmé, annulé...
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};