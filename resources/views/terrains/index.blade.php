@extends('layouts.app')

@section('title', 'Nos Terrains')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Nos Terrains de Sport</h1>
        <p class="text-lg text-gray-600">Découvrez nos installations</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($terrains as $terrain)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="h-48 bg-cover bg-center" 
                 style="background-image: url('{{ $terrain->image ? asset('uploads/' . $terrain->image) : 'https://via.placeholder.com/400x300?text=Pas+d+image' }}')">
            </div>
            
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $terrain->nom }}</h2>
                <p class="text-gray-600 mb-4 line-clamp-3">{{ $terrain->description }}</p>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-2xl font-bold text-green-600">{{ $terrain->prix_heure }} DH</span>
                    <span class="text-sm text-gray-500">par heure</span>
                </div>
                <a href="{{ route('terrains.show', $terrain->id) }}" class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700">
                    Voir Détails
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection