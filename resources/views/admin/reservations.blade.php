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
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Toutes les Réservations</h1>
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold">Total : {{ $reservations->count() }}</span>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase">Date & Heure</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase">Détails Réservation</th> <th class="p-4 text-xs font-bold text-gray-500 uppercase">Client</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase">Statut</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($reservations as $resa)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 align-top">
                                <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($resa->date_debut)->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($resa->date_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($resa->date_fin)->format('H:i') }}</div>
                            </td>
                            
                            <td class="p-4 align-top">
                                <div class="font-bold text-gray-900 mb-1">{{ $resa->terrain->nom }}</div>
                                
                                @if($resa->equipements->count() > 0)
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        @foreach($resa->equipements as $equipement)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                🎾 {{ $equipement->nom }} (x{{ $equipement->pivot->quantite }})
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Aucun matériel loué</span>
                                @endif
                            </td>
                            <td class="p-4 align-top font-semibold">{{ $resa->user->nom ?? 'Client Inconnu' }}</td>
                            
                            <td class="p-4 align-top">
                                <span class="px-2 py-1 rounded text-xs font-bold 
                                    {{ $resa->statut == 'confirmé' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ strtoupper($resa->statut) }}
                                </span>
                            </td>
                            
                            <td class="p-4 align-top text-right">
                                @if($resa->statut != 'annulé')
                                <form action="{{ route('admin.reservations.cancel', $resa->id) }}" method="POST" onsubmit="return confirm('Attention : Annuler cette réservation remettra le matériel en stock. Continuer ?');">
                                    @csrf
                                    <button class="text-red-500 bg-red-50 hover:bg-red-100 px-3 py-1 rounded text-sm font-bold border border-red-200 transition">
                                        Annuler & Rembourser
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400 italic text-sm">Annulé (Stock restauré)</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection