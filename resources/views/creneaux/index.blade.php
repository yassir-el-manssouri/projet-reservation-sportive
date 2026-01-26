@extends('layouts.app')

@section('title', 'Créneaux Disponibles')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-8 mb-10 text-white">
        <h1 class="text-3xl font-bold mb-2">Créneaux Disponibles</h1>
        <p class="opacity-90">Consultez les disponibilités en temps réel</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <form action="{{ route('creneaux.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-gray-700 font-bold mb-2">📅 Date</label>
                <input type="date" name="date" value="{{ $date }}" class="w-full border rounded-lg px-4 py-2" onchange="this.form.submit()">
            </div>
            
            <div>
                <label class="block text-gray-700 font-bold mb-2">🏟️ Terrain</label>
                <select name="terrain_id" class="w-full border rounded-lg px-4 py-2" onchange="this.form.submit()">
                    <option value="">Tous les terrains</option>
                    @foreach(\App\Models\Terrain::all() as $t)
                        <option value="{{ $t->id }}" {{ request('terrain_id') == $t->id ? 'selected' : '' }}>
                            {{ $t->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                    Actualiser
                </button>
            </div>
        </form>
    </div>

    @foreach($terrains as $terrain)
    <div class="bg-white rounded-xl shadow-lg mb-8 overflow-hidden border border-gray-100">
        <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $terrain->nom }}</h2>
                <p class="text-sm text-gray-500">{{ $terrain->type }} • <span class="text-green-600 font-bold">{{ $terrain->prix_heure }} DH/h</span></p>
            </div>
            <a href="{{ route('terrains.show', $terrain->id) }}" class="text-blue-600 hover:underline text-sm">Voir détails →</a>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @for($h = 8; $h <= 22; $h++)
                    @php
                        // Vérifie si ce créneau est occupé
                        $isReserved = $terrain->reservations->contains(function ($resa) use ($h) {
                            $debut = \Carbon\Carbon::parse($resa->date_debut)->hour;
                            return $debut === $h;
                        });
                        
                        // Formatage de l'heure (ex: 08:00)
                        $heureAffichage = sprintf('%02d:00', $h);
                    @endphp

                    @if($isReserved)
                        <div class="bg-gray-100 border border-gray-200 rounded-lg p-3 text-center opacity-60 cursor-not-allowed">
                            <span class="block text-gray-500 font-bold text-lg mb-1">{{ $heureAffichage }}</span>
                            <span class="text-xs text-red-500 font-bold uppercase">Réservé</span>
                        </div>
                    @else
                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="terrain_id" value="{{ $terrain->id }}">
                            <input type="hidden" name="date" value="{{ $date }}">
                            <input type="hidden" name="heure_debut" value="{{ $h }}">

                            <button type="submit" class="w-full bg-white border-2 border-green-500 rounded-lg p-3 text-center hover:bg-green-50 transition group cursor-pointer h-full">
                                <span class="block text-gray-800 font-bold text-lg mb-1 group-hover:text-green-700">{{ $heureAffichage }}</span>
                                <span class="inline-block px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full group-hover:bg-green-200">
                                    Réserver
                                </span>
                            </button>
                        </form>
                    @endif
                @endfor
            </div>
        </div>
    </div>
    @endforeach

    @if($terrains->isEmpty())
        <div class="text-center py-12 text-gray-500">
            Aucun terrain trouvé pour cette recherche.
        </div>
    @endif
</div>
@endsection