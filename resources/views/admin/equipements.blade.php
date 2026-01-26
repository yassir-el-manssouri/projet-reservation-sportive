@extends('layouts.app')

@section('title', 'Gestion des Équipements')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-6">

        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-gray-800 text-white rounded-xl shadow-lg p-6 sticky top-4">
                <h3 class="text-xl font-bold mb-6 px-4 border-b border-gray-700 pb-4">Menu Admin</h3>
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">📊 Tableau de bord</a>
                    <a href="{{ route('admin.terrains') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">⚽ Gérer Terrains</a>
                    <a href="{{ route('admin.equipements') }}" class="block py-2.5 px-4 rounded bg-blue-600">🎒 Gérer Équipements</a>
                    <a href="{{ route('admin.reservations') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">📅 Réservations</a>
                </nav>
            </div>
        </aside>

        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestion du Matériel</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white p-6 rounded-xl shadow-lg h-fit">
                    <h2 class="text-xl font-bold mb-4 border-b pb-2">Ajouter un équipement</h2>
                    <form action="{{ route('admin.equipements.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block font-bold text-sm text-gray-700">Nom</label>
                            <input type="text" name="nom" class="w-full border rounded p-2" placeholder="Ex: Ballon Nike" required>
                        </div>
                        <div>
                            <label class="block font-bold text-sm text-gray-700">Quantité (Stock)</label>
                            <input type="number" name="quantite" class="w-full border rounded p-2" placeholder="10" required>
                        </div>
                        <div>
                            <label class="block font-bold text-sm text-gray-700">Prix (optionnel)</label>
                            <input type="number" name="prix" class="w-full border rounded p-2" placeholder="0">
                        </div>
                        <div>
                            <label class="block font-bold text-sm text-gray-700">Image (URL)</label>
                            <input type="url" name="image" class="w-full border rounded p-2" placeholder="https://...">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700 transition">
                            + Ajouter au stock
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($equipements as $equipement)
                    <div class="bg-white p-4 rounded-xl shadow border border-gray-100 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            @if($equipement->image)
                                <img src="{{ $equipement->image }}" class="w-16 h-16 object-cover rounded bg-gray-100">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-2xl">🎒</div>
                            @endif
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">{{ $equipement->nom }}</h3>
                                <p class="text-gray-500 text-sm">Stock : <span class="font-bold text-blue-600">{{ $equipement->quantite }}</span></p>
                            </div>
                        </div>
                        
                        <form action="{{ route('admin.equipements.delete', $equipement->id) }}" method="POST" onsubmit="return confirm('Supprimer cet équipement ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded hover:bg-red-100 transition">
                                🗑️
                            </button>
                        </form>
                    </div>
                    @endforeach
                    
                    @if($equipements->isEmpty())
                        <div class="col-span-2 text-center py-10 text-gray-500 bg-white rounded-xl border border-dashed">
                            Aucun équipement dans l'inventaire.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection