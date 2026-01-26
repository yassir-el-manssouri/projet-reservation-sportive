<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terrain;
use App\Models\Equipement;

class TerrainController extends Controller
{
    // Afficher la liste (Public)
    public function index()
    {
        $terrains = Terrain::all(); 
        return view('terrains.index', compact('terrains'));
    }

    // Afficher les détails (Public)
    public function show($id)
    {
        $terrain = Terrain::findOrFail($id);
        $equipements = Equipement::all();
        return view('terrains.show', compact('terrain', 'equipements'));
    }

    // Ajouter un terrain (Admin)
public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'type' => 'required|string',
        'prix_heure' => 'required|numeric',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        
        // ✅ CHANGEMENT ICI : Enregistrer seulement le nom du fichier
        $data['image'] = $filename;
    }

    Terrain::create($data);

    return back()->with('success', 'Terrain ajouté avec succès !');
}
}