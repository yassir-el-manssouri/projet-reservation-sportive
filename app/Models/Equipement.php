<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'quantite', 'prix', 'image'];

    // Relation (si tu veux lier équipement et réservation plus tard)
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_equipement')
                    ->withPivot('quantite');
    }
}