<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terrain;
use Carbon\Carbon;

class CreneauController extends Controller
{
    // Affiche la page des créneaux en lisant la VRAIE base de données
    public function index(Request $request)
    {
        // 1. Date choisie (ou aujourd'hui)
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        
        // 2. Filtre Terrain (optionnel)
        $terrainId = $request->input('terrain_id');

        // 3. REQUÊTE INTELLIGENTE :
        // On récupère les terrains ET leurs réservations pour la date choisie
        $query = Terrain::with(['reservations' => function($q) use ($date) {
            $q->whereDate('date_debut', $date)
              ->where('statut', '!=', 'annulé');
        }]);

        if ($terrainId) {
            $query->where('id', $terrainId);
        }

        $terrains = $query->get();

        // 4. On envoie les données réelles à la vue
        return view('creneaux.index', compact('terrains', 'date'));
    }

    // Garde cette fonction pour l'affichage détaillé par terrain si tu l'utilises
    public function getCreneauxByTerrain($id, Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        
        $terrain = Terrain::with(['reservations' => function($q) use ($date) {
            $q->whereDate('date_debut', $date);
        }])->findOrFail($id);

        $creneaux = [];
        for ($h = 8; $h <= 22; $h++) {
            $isReserved = $terrain->reservations->contains(function ($resa) use ($h) {
                return Carbon::parse($resa->date_debut)->hour == $h;
            });

            $creneaux[] = [
                'heure' => sprintf('%02d:00', $h),
                'disponible' => !$isReserved,
                'prix' => $terrain->prix_heure
            ];
        }

        return view('creneaux.by-terrain', compact('terrain', 'creneaux', 'date'));
    }

    public function getCreneauxDisponibles($date)
    {
        return response()->json(['message' => 'API non active']);
    }
}