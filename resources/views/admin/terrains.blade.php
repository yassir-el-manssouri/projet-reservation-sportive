@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-6">

        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-gray-800 text-white rounded-xl shadow-lg p-6 sticky top-4">
                <h3 class="text-xl font-bold mb-6 px-4 border-b border-gray-700 pb-4">Menu Admin</h3>
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">📊 Tableau de bord</a>
                    <a href="{{ route('admin.terrains') }}" class="block py-2.5 px-4 rounded bg-blue-600">⚽ Gérer Terrains</a>
                    <a href="{{ route('admin.equipements.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">🎾 Gérer Équipements</a>
                    <a href="{{ route('admin.reservations') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">📅 Réservations</a>
                </nav>
            </div>
        </aside>

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestion des Terrains</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Attention ! L'image n'est pas passée :</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="w-full lg:w-1/3">
                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                        <h2 class="text-lg font-bold mb-4 text-gray-700">Nouveau Terrain</h2>
                        
                        <form action="{{ route('admin.terrains.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-1 text-gray-600">Nom du terrain</label>
                                <input type="text" name="nom" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-1 text-gray-600">Type de sport</label>
                                <select name="type" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>Football</option>
                                    <option>Basketball</option>
                                    <option>Tennis</option>
                                    <option>Padel</option>
                                    <option>Volleyball</option>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-1 text-gray-600">Prix / Heure (DH)</label>
                                <input type="number" name="prix_heure" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-1 text-gray-600">Photo du terrain</label>
                                <input type="file" name="image" class="w-full border rounded-lg px-3 py-2 bg-white">
                                <p class="text-xs text-gray-500 mt-1">Formats: JPG, PNG (Max 2Mo)</p>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-1 text-gray-600">Description</label>
                                <textarea name="description" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                            </div>
                            
                            <button class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-bold shadow transition">
                                + Créer Terrain
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full lg:w-2/3 space-y-4">
                    @foreach($terrains as $terrain)
                    <div class="bg-white p-4 rounded-lg shadow-md flex items-center gap-4 border border-gray-100">
                        <div class="w-20 h-20 flex-shrink-0">
                            @if($terrain->image)
                                <img src="{{ asset('uploads/' . $terrain->image) }}" class="w-full h-full rounded-lg object-cover bg-gray-200 border">
                            @else
                                <div class="w-full h-full rounded-lg bg-gray-200 flex items-center justify-center text-gray-400 text-xs">No Img</div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-800">{{ $terrain->nom }}</h3>
                            <p class="text-sm text-gray-500">{{ $terrain->type }} • {{ $terrain->prix_heure }} DH</p>
                        </div>
                        
                        <form action="{{ route('admin.terrains.delete', $terrain->id) }}" method="POST" onsubmit="return confirm('Supprimer ?');">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 bg-red-50 px-4 py-2 rounded-lg text-sm font-bold">Supprimer</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection