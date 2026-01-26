<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les colonnes modifiables.
     */
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'mot_de_passe',
        'role',
    ];

    /**
     * Les colonnes cachées.
     */
    protected $hidden = [
        'mot_de_passe', // On cache 'mot_de_passe' au lieu de 'password'
        'remember_token',
    ];

    /**
     * Casting des attributs.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mot_de_passe' => 'hashed', // Important pour le hachage automatique
        ];
    }

    /**
     * IMPORTANT : Indiquer à Laravel quel est le champ mot de passe
     * car on n'utilise pas le défaut 'password'.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}