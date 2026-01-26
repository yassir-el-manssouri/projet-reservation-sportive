<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipement;

class EquipementController extends Controller
{
    // Afficher la liste des équipements
    public function index()
    {
        $equipements = Equipement::all();
        return view('admin.equipements.index', compact('equipements'));
    }

    // Ajouter un nouvel équipement
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'quantite' => 'required|integer|min:1',
            'prix' => 'required|numeric|min:0',
        ]);

        Equipement::create([
            'nom' => $request->nom,
            'quantite' => $request->quantite,
            'prix' => $request->prix,
        ]);

        return back()->with('success', 'Équipement ajouté avec succès !');
    }

    // Supprimer un équipement
    public function destroy(Equipement $equipement)
    {
        $equipement->delete();
        return back()->with('success', 'Équipement supprimé.');
    }
}