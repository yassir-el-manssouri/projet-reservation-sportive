<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terrain extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'type',
        'prix_heure',
        'image',
        'description'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}