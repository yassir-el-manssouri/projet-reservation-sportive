<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terrain;
use App\Models\Reservation;

class AdminController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        // Stats
        $totalTerrains = Terrain::count();
        $totalReservations = Reservation::count();
        
        // Les 5 dernières réservations
        // On ajoute 'equipements' ici aussi pour voir les détails sur l'accueil si besoin
        $reservationsRecentes = Reservation::with(['user', 'terrain', 'equipements'])
            ->latest()
            ->take(5)
            ->get();

        // Récupération des terrains pour éviter l'erreur dans la vue dashboard
        $terrains = Terrain::all();

        return view('admin.dashboard', compact(
            'totalTerrains', 
            'totalReservations', 
            'reservationsRecentes',
            'terrains'
        ));
    }

    // GESTION TERRAINS
    public function terrains()
    {
        $terrains = Terrain::all();
        return view('admin.terrains', compact('terrains'));
    }

    // ✅ MÉTHODE CORRIGÉE AVEC UPLOAD D'IMAGE
    public function storeTerrain(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string',
            'prix_heure' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['image'] = $filename;
        }

        Terrain::create($data);
        
        return back()->with('success', 'Terrain ajouté avec succès !');
    }

    public function destroyTerrain($id)
    {
        Terrain::destroy($id);
        return back()->with('success', 'Terrain supprimé !');
    }

    // GESTION RÉSERVATIONS
    public function reservations()
    {
        // 👇 MODIFICATION 1 : On charge 'equipements' pour pouvoir les afficher dans le tableau
        $reservations = Reservation::with(['user', 'terrain', 'equipements'])->latest()->get();
        
        return view('admin.reservations', compact('reservations'));
    }

    // ANNULATION AVEC REMISE EN STOCK
    public function cancelReservation($id)
    {
        // 👇 MODIFICATION 2 : On charge la réservation AVEC ses équipements
        $reservation = Reservation::with('equipements')->findOrFail($id);

        // On vérifie si elle n'est pas déjà annulée pour ne pas remettre le stock 2 fois
        if ($reservation->statut !== 'annulé') {
            
            // BOUCLE : Pour chaque équipement loué dans cette réservation...
            foreach ($reservation->equipements as $equipement) {
                // On regarde combien le client en avait pris (ex: 2 raquettes)
                $qtyLouee = $equipement->pivot->quantite;

                // On remet cette quantité dans le stock global
                $equipement->increment('quantite', $qtyLouee);
            }

            // Enfin, on marque comme annulé
            $reservation->update(['statut' => 'annulé']);
        }

        return back()->with('success', 'Réservation annulée et stock restauré ! 🔄');
    }
}