@extends('layouts.app')

@section('title', 'Mes Réservations')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Historique de mes réservations</h1>

    @if($reservations->isEmpty())
        <div class="bg-white p-8 rounded-xl shadow text-center">
            <p class="text-gray-500 text-lg mb-4">Vous n'avez pas encore effectué de réservation.</p>
            <a href="{{ route('creneaux.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700">
                Réserver un terrain
            </a>
        </div>
    @else
        <div class="grid gap-6">
            @foreach($reservations as $resa)
            <div class="bg-white rounded-xl shadow-md p-6 flex flex-col md:flex-row justify-between items-center border-l-4 {{ $resa->statut == 'confirmé' ? 'border-green-500' : 'border-gray-400' }}">
                
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $resa->terrain->nom }}</h3>
                    <p class="text-gray-600">
                        📅 {{ \Carbon\Carbon::parse($resa->date_debut)->format('d/m/Y') }} 
                        ⏰ {{ \Carbon\Carbon::parse($resa->date_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($resa->date_fin)->format('H:i') }}
                    </p>
                </div>

                <div class="text-right mt-4 md:mt-0">
                    <span class="block text-2xl font-bold text-blue-600">{{ $resa->prix_total }} DH</span>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase {{ $resa->statut == 'confirmé' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $resa->statut }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection