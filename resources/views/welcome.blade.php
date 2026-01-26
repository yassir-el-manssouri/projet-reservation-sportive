@extends('layouts.app')

@section('title', 'Accueil - SportReserve')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 text-white">
    <div class="container mx-auto px-4 py-24 md:py-32">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                Réservez Votre Terrain <br>
                <span class="text-yellow-300">En Un Clic</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">
                La plateforme N°1 de réservation de terrains sportifs au Maroc
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('terrains.index') }}" 
                   class="bg-white text-blue-600 px-8 py-4 rounded-lg hover:bg-blue-50 transition font-bold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                    🏟️ Voir les Terrains
                </a>
                <a href="{{ route('creneaux.index') }}" 
                   class="bg-yellow-400 text-blue-900 px-8 py-4 rounded-lg hover:bg-yellow-300 transition font-bold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                    📅 Créneaux Disponibles
                </a>
            </div>
        </div>
    </div>
    
    <!-- Decoration -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F9FAFB"/>
        </svg>
    </div>
</div>

<div class="container mx-auto px-4 py-16">
    
</div>
@endsection