@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-6">

        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-gray-800 text-white rounded-xl shadow-lg p-6 sticky top-4">
                <h3 class="text-xl font-bold mb-6 px-4 border-b border-gray-700 pb-4">Menu Admin</h3>
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block py-2.5 px-4 rounded transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        📊 Tableau de bord
                    </a>
                    <a href="{{ route('admin.terrains') }}" 
                       class="block py-2.5 px-4 rounded transition {{ request()->routeIs('admin.terrains') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        ⚽ Gérer Terrains
                    </a>
                    <a href="{{ route('admin.equipements.index') }}" 
                       class="block py-2.5 px-4 rounded transition {{ request()->routeIs('admin.equipements*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        🎾 Gérer Équipements
                    </a>
                    <a href="{{ route('admin.reservations') }}" 
                       class="block py-2.5 px-4 rounded transition {{ request()->routeIs('admin.reservations') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        📅 Réservations
                    </a>
                </nav>
            </div>
        </aside>

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestion du Matériel</h1>

            <div class="bg-white p-6 rounded-lg shadow-md mb-8 border border-gray-100">
                <h2 class="text-lg font-bold mb-4 text-gray-700">Ajouter un équipement</h2>
                <form action="{{ route('admin.equipements.store') }}" method="POST" class="flex flex-wrap gap-4 items-end">
                    @csrf
                    <div class="flex-grow">
                        <label class="block text-sm font-bold mb-1 text-gray-600">Nom</label>
                        <input type="text" name="nom" class="w-full border rounded px-3 py-2" placeholder="Ex: Raquette de Tennis" required>
                    </div>
                    <div class="w-24">
                        <label class="block text-sm font-bold mb-1 text-gray-600">Stock</label>
                        <input type="number" name="quantite" class="w-full border rounded px-3 py-2" placeholder="10" required>
                    </div>
                    <div class="w-32">
                        <label class="block text-sm font-bold mb-1 text-gray-600">Prix (DH)</label>
                        <input type="number" step="0.01" name="prix" class="w-full border rounded px-3 py-2" placeholder="20.00" required>
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 font-bold h-[42px]">
                        + Ajouter
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase">Équipement</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase">Stock Total</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase">Prix / Unité</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($equipements as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-bold text-gray-800">{{ $item->nom }}</td>
                            <td class="p-4">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">{{ $item->quantite }} unités</span>
                            </td>
                            <td class="p-4 font-bold text-green-600">+{{ $item->prix }} DH</td>
                            <td class="p-4 text-right">
                                <form action="{{ route('admin.equipements.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Supprimer ?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 bg-red-50 hover:bg-red-100 px-3 py-1 rounded text-sm font-bold border border-red-200">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">Aucun équipement ajouté.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection