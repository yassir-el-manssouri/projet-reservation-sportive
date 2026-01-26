<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Terrain;
use App\Models\Equipement;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 

class ReservationController extends Controller
{
    // ENREGISTRER UNE RÉSERVATION
    public function store(Request $request)
    {
        // ⛔ SÉCURITÉ : Empêcher l'admin de réserver
        if (Auth::user()->role === 'admin') {
            return back()->withErrors(['erreur' => "⚠️ Action interdite : Les administrateurs ne peuvent pas réserver. Veuillez utiliser un compte client."]);
        }

        // 1. Validation des données
        $request->validate([
            'terrain_id' => 'required|exists:terrains,id',
            'date' => 'required|date|after_or_equal:today',
            'heure_debut' => 'required|integer|min:8|max:22',
        ]);

        $dateDebut = Carbon::parse($request->date . ' ' . $request->heure_debut . ':00:00');
        $dateFin = $dateDebut->copy()->addHour();

        // Vérification disponibilité terrain
        $existe = Reservation::where('terrain_id', $request->terrain_id)
            ->where('statut', '!=', 'annulé')
            ->where(function ($query) use ($dateDebut, $dateFin) {
                $query->whereBetween('date_debut', [$dateDebut, $dateFin])
                      ->orWhereBetween('date_fin', [$dateDebut, $dateFin])
                      ->orWhere(function ($q) use ($dateDebut, $dateFin) {
                          $q->where('date_debut', '<=', $dateDebut)
                            ->where('date_fin', '>=', $dateFin);
                      });
            })
            ->exists();

        if ($existe) {
            return back()->withErrors(['creneau' => 'Ce terrain est déjà réservé à cette heure-là !']);
        }

        // On utilise une transaction pour être sûr que tout se passe bien (Stock + Réservation)
        DB::beginTransaction();

        try {
            $terrain = Terrain::findOrFail($request->terrain_id);
            $prix_total = $terrain->prix_heure;

            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'terrain_id' => $terrain->id,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'prix_total' => $prix_total,
                'statut' => 'confirmé'
            ]);

            // GESTION DU STOCK
            if ($request->has('equipements')) {
                foreach ($request->equipements as $equipement_id => $quantite) {
                    if ($quantite > 0) {
                        $equipement = Equipement::lockForUpdate()->find($equipement_id);
                        
                        if ($equipement) {
                            // 1. On vérifie s'il y a assez de stock
                            if ($equipement->quantite < $quantite) {
                                DB::rollBack(); // On annule tout si pas assez de stock
                                return back()->withErrors(['stock' => "Désolé, stock insuffisant pour : " . $equipement->nom]);
                            }

                            // 2. On attache à la réservation
                            $reservation->equipements()->attach($equipement_id, ['quantite' => $quantite]);
                            
                            // 3. ON DIMINUE LE STOCK
                            $equipement->decrement('quantite', $quantite);
                            
                            // 4. On met à jour le prix
                            $prix_total += ($equipement->prix * $quantite);
                        }
                    }
                }
                $reservation->update(['prix_total' => $prix_total]);
            }

            DB::commit(); // Tout est bon, on valide
            
            return redirect()->route('reservations.history')
                ->with('success', 'Réservation validée ! Le stock a été mis à jour.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['erreur' => "Une erreur est survenue lors de la réservation."]);
        }
    }

    // HISTORIQUE DES RÉSERVATIONS
    public function mesReservations()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with(['terrain', 'equipements'])
            ->orderBy('date_debut', 'desc')
            ->get();

        return view('reservations.history', compact('reservations'));
    }

    // 👇 API POUR VÉRIFIER LES DISPONIBILITÉS (AJAX)
    public function checkAvailability($terrain_id, $date)
    {
        // 1. On cherche les réservations actives pour ce terrain et cette date
        $reservations = Reservation::where('terrain_id', $terrain_id)
            ->whereDate('date_debut', $date)
            ->where('statut', '!=', 'annulé')
            ->get();

        // 2. On extrait juste l'heure de début (ex: 9, 10, 14...)
        $heuresPrises = $reservations->map(function ($resa) {
            return \Carbon\Carbon::parse($resa->date_debut)->format('G'); 
        });

        // 3. On renvoie la liste en format JSON pour le JavaScript
        return response()->json($heuresPrises);
    }
}