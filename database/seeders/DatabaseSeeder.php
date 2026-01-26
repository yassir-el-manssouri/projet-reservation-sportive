<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Terrain;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ADMIN
        User::create([
            'nom' => 'Administrateur Principal',
            'email' => 'admin@sportreserve.com',
            'telephone' => '0600000000',
            'mot_de_passe' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // 2. CLIENT
        User::create([
            'nom' => 'Client Test',
            'email' => 'client@test.com',
            'telephone' => '0611111111',
            'mot_de_passe' => Hash::make('client123'),
            'role' => 'client'
        ]);

        // 3. TERRAINS (Liens simplifiés "w=800" uniquement)
        $terrains = [
            [
                'nom' => 'Terrain de Football Principal',
                'type' => 'Football',
                'prix_heure' => 150.00,
                'image' => 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=800',
                'description' => 'Terrain synthétique professionnel approuvé FIFA.'
            ],
            [
                'nom' => 'Terrain de Basketball Couvert',
                'type' => 'Basketball',
                'prix_heure' => 100.00,
                'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800',
                'description' => 'Salle climatisée avec parquet en bois.'
            ],
            [
                'nom' => 'Court de Tennis Clay',
                'type' => 'Tennis',
                'prix_heure' => 80.00,
                'image' => 'https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?w=800',
                'description' => 'Surface en terre battue de haute qualité.'
            ],
            [
                'nom' => 'Terrain de Padel',
                'type' => 'Padel',
                'prix_heure' => 120.00,
                // Image : Court bleu/vert (très stable)
                'image' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?auto=format&fit=crop&w=800&q=80',
                'description' => 'Terrain moderne avec parois en verre.'
            ],
            [
                'nom' => 'Terrain de Volleyball',
                'type' => 'Volleyball',
                'prix_heure' => 90.00,
                // Image : Filet sur la plage (nouvelle image stable)
                'image' => 'https://images.unsplash.com/photo-1592656094267-764a45160876?w=800',
                'description' => 'Terrain de beach volley avec sable fin importé.'
            ]
        ];

        foreach ($terrains as $t) {
            Terrain::create($t);
        }
    }
}