<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'terrain_id',
        'date_debut',
        'date_fin',
        'prix_total',
        'statut'
    ];

    /**
     * Relation : Une réservation appartient à un Terrain
     */
    public function terrain()
    {
        return $this->belongsTo(Terrain::class);
    }

    /**
     * Relation : Une réservation appartient à un Utilisateur (Client)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : Une réservation peut avoir plusieurs équipements
     * 👇 C'EST CETTE FONCTION QUI MANQUAIT 👇
     */
    public function equipements()
    {
        // On précise le nom de ta table pivot : 'reservation_equipement'
        return $this->belongsToMany(Equipement::class, 'reservation_equipement')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }
}