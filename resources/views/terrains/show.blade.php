@extends('layouts.app')

@section('title', $terrain->nom)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('terrains.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour aux terrains
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="h-96 lg:h-full bg-cover bg-center" 
                 style="background-image: url('{{ $terrain->image ? asset('uploads/' . $terrain->image) : 'https://via.placeholder.com/800x600?text=Pas+d+image' }}')">
            </div>
            
            <div class="p-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $terrain->nom }}</h1>
                
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Description</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $terrain->description }}</p>
                </div>
                
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Tarif</h2>
                    <div class="flex items-baseline">
                        <span class="text-4xl font-bold text-green-600">{{ $terrain->prix_heure }} DH</span>
                        <span class="text-gray-500 ml-2">par heure</span>
                    </div>
                </div>
                
                <div class="border-t pt-6">
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                            <p class="font-bold">Oups !</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @auth
                        <form action="{{ route('reservations.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="terrain_id" value="{{ $terrain->id }}" id="terrain-id">
                            
                            <input type="hidden" name="heure_debut" id="heure-input" required>

                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-gray-700 font-bold mb-2">📅 Date de réservation</label>
                                    <input type="date" name="date" id="date-input" 
                                           class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 transition" 
                                           required min="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-bold mb-2">⏰ Créneaux Disponibles</label>
                                    
                                    <div id="slots-message" class="text-gray-500 italic text-sm mb-2">
                                        Veuillez d'abord sélectionner une date.
                                    </div>

                                    <div id="slots-loader" class="hidden text-blue-600 font-bold text-sm mb-2">
                                        Chargement des disponibilités...
                                    </div>

                                    <div id="slots-container" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 mt-6">
                                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    🎾 Location de matériel (Optionnel)
                                </h3>
                                
                                @php 
                                    $equipements = \App\Models\Equipement::all(); 
                                @endphp

                                @if($equipements->isEmpty())
                                    <p class="text-sm text-gray-500 italic">Aucun équipement disponible.</p>
                                @else
                                    <div class="space-y-3">
                                        @foreach($equipements as $equipement)
                                        <div class="flex items-center justify-between bg-white p-3 rounded shadow-sm border border-gray-100">
                                            <div>
                                                <span class="font-bold text-gray-700 block">{{ $equipement->nom }}</span>
                                                <span class="text-xs text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded border border-green-100">
                                                    +{{ $equipement->prix }} DH
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs text-gray-400">Stock: {{ $equipement->quantite }}</span>
                                                <label class="text-xs text-gray-500 uppercase font-bold ml-1">Qté:</label>
                                                <input type="number" 
                                                       name="equipements[{{ $equipement->id }}]" 
                                                       min="0" 
                                                       max="{{ $equipement->quantite ?? 10 }}" 
                                                       value="0" 
                                                       class="w-16 border border-gray-300 rounded px-2 py-1 text-center font-bold outline-none focus:border-blue-500">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <button type="submit" id="btn-submit" disabled
                                class="block w-full bg-gray-400 cursor-not-allowed text-white text-center py-4 px-6 rounded-lg transition-all duration-200 text-lg font-bold shadow-lg mt-6">
                                Choisir un créneau
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-50 p-6 rounded-lg text-center border border-gray-200">
                            <p class="text-gray-600 mb-4 font-medium">Vous devez être connecté pour réserver.</p>
                            <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white py-3 px-8 rounded-lg hover:bg-blue-700 font-bold shadow transition">
                                Se connecter
                            </a>
                        </div>
                    @endauth

                    <p class="text-sm text-gray-500 text-center mt-4 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Paiement sur place - Annulation gratuite jusqu'à 24h
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const terrainId = document.getElementById('terrain-id')?.value;
        const dateInput = document.getElementById('date-input');
        const slotsContainer = document.getElementById('slots-container');
        const slotsMessage = document.getElementById('slots-message');
        const slotsLoader = document.getElementById('slots-loader');
        const heureInput = document.getElementById('heure-input');
        const btnSubmit = document.getElementById('btn-submit');

        if(!dateInput) return;

        dateInput.addEventListener('change', function() {
            const date = this.value;
            if (!date) return;

            slotsContainer.innerHTML = ''; 
            slotsMessage.classList.add('hidden');
            slotsLoader.classList.remove('hidden');
            
            btnSubmit.disabled = true;
            btnSubmit.classList.add('bg-gray-400', 'cursor-not-allowed');
            btnSubmit.classList.remove('bg-green-600', 'hover:bg-green-700', 'transform', 'hover:-translate-y-0.5');
            btnSubmit.innerText = "Choisir un créneau";

            fetch(`/api/disponibilites/${terrainId}/${date}`)
                .then(response => response.json())
                .then(heuresPrises => {
                    slotsLoader.classList.add('hidden');
                    slotsContainer.innerHTML = '';

                    if(heuresPrises.length >= 15) {
                         slotsContainer.innerHTML = '<div class="col-span-full text-red-500 font-bold text-center">Complet ce jour !</div>';
                         return;
                    }

                    for (let h = 8; h <= 22; h++) {
                        const isTaken = heuresPrises.includes(h.toString());
                        const slot = document.createElement('div');
                        
                        slot.textContent = h + 'h00';
                        slot.classList.add('text-center', 'py-2', 'rounded-lg', 'font-bold', 'border', 'text-sm', 'transition', 'duration-200');

                        if (isTaken) {
                            slot.classList.add('bg-red-50', 'text-red-400', 'border-red-100', 'cursor-not-allowed', 'opacity-60');
                            slot.title = "Déjà réservé";
                        } else {
                            slot.classList.add('bg-white', 'text-green-600', 'border-green-200', 'cursor-pointer', 'hover:bg-green-50', 'hover:border-green-400', 'shadow-sm');
                            
                            slot.onclick = function() {
                                document.querySelectorAll('#slots-container div').forEach(el => {
                                    if(!el.classList.contains('cursor-not-allowed')) {
                                        el.classList.remove('bg-green-600', 'text-white', 'border-green-600', 'ring-2', 'ring-green-300');
                                        el.classList.add('bg-white', 'text-green-600', 'border-green-200');
                                    }
                                });
                                
                                this.classList.remove('bg-white', 'text-green-600', 'border-green-200');
                                this.classList.add('bg-green-600', 'text-white', 'border-green-600', 'ring-2', 'ring-green-300');

                                heureInput.value = h;

                                btnSubmit.disabled = false;
                                btnSubmit.classList.remove('bg-gray-400', 'cursor-not-allowed');
                                btnSubmit.classList.add('bg-green-600', 'hover:bg-green-700', 'transform', 'hover:-translate-y-0.5');
                                btnSubmit.innerText = `✅ Réserver à ${h}h00`;
                            };
                        }
                        slotsContainer.appendChild(slot);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    slotsLoader.innerText = "Erreur de chargement.";
                });
        });
    });
</script>
@endsection