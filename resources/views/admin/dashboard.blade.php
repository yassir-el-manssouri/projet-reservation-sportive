@extends('layouts.app')

@section('title', 'Tableau de bord')

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
            <div class="flex justify-between items-center mb-8 bg-white p-4 rounded-xl shadow-sm">
                <h1 class="text-2xl font-bold text-gray-800">Vue d'ensemble</h1>
                <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full font-bold text-sm">Mode Admin</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500 flex justify-between items-center transform hover:scale-105 transition duration-300">
                    <div>
                        <h3 class="text-gray-500 font-bold uppercase text-sm">Total Terrains</h3>
                        <p class="text-4xl font-bold text-gray-800">{{ $totalTerrains }}</p>
                    </div>
                    <div class="text-blue-500 text-4xl">⚽</div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500 flex justify-between items-center transform hover:scale-105 transition duration-300">
                    <div>
                        <h3 class="text-gray-500 font-bold uppercase text-sm">Réservations Totales</h3>
                        <p class="text-4xl font-bold text-gray-800">{{ $totalReservations }}</p>
                    </div>
                    <div class="text-green-500 text-4xl">📅</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-700">Dernières Réservations</h2>
                    <a href="{{ route('admin.reservations') }}" class="text-sm text-blue-600 hover:underline font-semibold">Voir tout →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <th class="p-4">Date</th>
                                <th class="p-4">Détails (Terrain + Matériel)</th> <th class="p-4">Client</th>
                                <th class="p-4">Prix</th>
                                <th class="p-4">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($reservationsRecentes ?? [] as $resa)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($resa->date_debut)->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($resa->date_debut)->format('H:i') }}</div>
                                </td>
                                
                                <td class="p-4">
                                    <div class="font-bold text-gray-900">{{ $resa->terrain->nom }}</div>
                                    @if($resa->equipements->count() > 0)
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($resa->equipements as $eq)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                    🎾 {{ $eq->nom }} (x{{ $eq->pivot->quantite }})
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>

                                <td class="p-4 text-sm font-semibold">{{ $resa->user->nom ?? 'Client Supprimé' }}</td>
                                <td class="p-4 font-bold text-green-600">{{ $resa->prix_total }} DH</td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        {{ $resa->statut === 'confirmé' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($resa->statut) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500 italic">
                                    Aucune réservation pour le moment.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection