@extends('layouts.app')

@section('title', 'Réserver ' . $terrain['nom'] . ' - SportReserve')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-indigo-800 text-white py-12">
    <div class="container mx-auto px-4">
        <nav class="text-sm mb-4 text-blue-200">
            <a href="{{ route('home') }}" class="hover:text-white">Accueil</a>
            <span class="mx-2">›</span>
            <a href="{{ route('terrains.index') }}" class="hover:text-white">Terrains</a>
            <span class="mx-2">›</span>
            <span class="text-white">Réservation</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-bold">Réserver : {{ $terrain['nom'] }}</h1>
        <p class="text-blue-100 mt-2">{{ $terrain['type'] }} • {{ $terrain['prix_heure'] }} DH/heure</p>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Colonne principale - Sélection du créneau -->
        <div class="lg:col-span-2">
            <!-- Sélection de la date -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">📅 Sélectionnez une date</h2>
                <form method="GET" class="flex gap-4">
                    <input type="date" 
                           name="date"
                           value="{{ $date }}"
                           min="{{ date('Y-m-d') }}"
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-bold">
                        Rechercher
                    </button>
                </form>
                <p class="text-sm text-gray-600 mt-3">
                    Vous consultez les créneaux pour le 
                    <strong>{{ \Carbon\Carbon::parse($date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</strong>
                </p>
            </div>

            <!-- Créneaux disponibles -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">⏰ Créneaux Horaires</h2>
                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full font-semibold">
                        {{ count(array_filter($creneaux, fn($c) => $c['disponible'])) }} disponibles
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($creneaux as $creneau)
                        @if($creneau['disponible'])
                            <button onclick="selectCreneau('{{ $creneau['heure'] }}', '{{ $creneau['heure_fin'] }}', {{ $creneau['prix'] }})" 
                                    class="creneau-btn bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-500 text-green-700 p-5 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-200 transform hover:scale-105 hover:shadow-lg">
                                <div class="font-bold text-xl mb-1">{{ $creneau['heure'] }}</div>
                                <div class="text-sm opacity-75 mb-2">{{ $creneau['heure_fin'] }}</div>
                                <div class="text-xs font-semibold bg-green-200 px-2 py-1 rounded-full">
                                    {{ $creneau['prix'] }} DH
                                </div>
                            </button>
                        @else
                            <div class="bg-gray-100 border-2 border-gray-300 text-gray-400 p-5 rounded-xl cursor-not-allowed opacity-60">
                                <div class="font-bold text-xl mb-1">{{ $creneau['heure'] }}</div>
                                <div class="text-sm mb-2">{{ $creneau['heure_fin'] }}</div>
                                <div class="text-xs font-semibold">
                                    ✗ Réservé
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Message si aucun créneau -->
                @if(count(array_filter($creneaux, fn($c) => $c['disponible'])) == 0)
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">😔</div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Aucun créneau disponible</h3>
                        <p class="text-gray-600">Essayez une autre date ou consultez d'autres terrains</p>
                        <a href="{{ route('terrains.index') }}" 
                           class="inline-block mt-4 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-bold">
                            Voir d'autres terrains
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Colonne latérale - Résumé de réservation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-xl p-6 sticky top-4">
                <h3 class="text-xl font-bold mb-6 border-b pb-3">📋 Récapitulatif</h3>
                
                <!-- Info terrain -->
                <div class="mb-6">
                    <div class="text-sm text-gray-600 mb-2">Terrain</div>
                    <div class="font-bold text-lg text-gray-900">{{ $terrain['nom'] }}</div>
                    <div class="text-sm text-gray-600">{{ $terrain['type'] }}</div>
                </div>

                <!-- Date sélectionnée -->
                <div class="mb-6">
                    <div class="text-sm text-gray-600 mb-2">Date</div>
                    <div class="font-semibold text-gray-900" id="selected-date">
                        {{ \Carbon\Carbon::parse($date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                    </div>
                </div>

                <!-- Créneau sélectionné -->
                <div class="mb-6">
                    <div class="text-sm text-gray-600 mb-2">Créneau horaire</div>
                    <div class="font-semibold text-gray-900" id="selected-creneau">
                        <span class="text-gray-400 italic">Aucun créneau sélectionné</span>
                    </div>
                </div>

                <!-- Prix -->
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-700">Prix de base</span>
                        <span class="font-bold" id="prix-base">0 DH</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-blue-200">
                        <span class="text-lg font-bold">Total</span>
                        <span class="text-2xl font-bold text-blue-600" id="prix-total">0 DH</span>
                    </div>
                </div>

                <!-- Bouton de réservation -->
                <button id="btn-reserver" 
                        disabled
                        class="w-full bg-gray-400 text-white py-4 rounded-lg font-bold text-lg mb-3 cursor-not-allowed">
                    Sélectionnez un créneau
                </button>

                <a href="{{ route('terrains.show', $terrain['id']) }}" 
                   class="block text-center text-gray-600 hover:text-gray-800 font-semibold">
                    ← Retour aux détails
                </a>

                <!-- Informations supplémentaires -->
                <div class="mt-6 pt-6 border-t space-y-3">
                    <div class="flex items-start text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Confirmation immédiate par email</span>
                    </div>
                    <div class="flex items-start text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Annulation gratuite jusqu'à 24h avant</span>
                    </div>
                    <div class="flex items-start text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Paiement en ligne sécurisé</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedCreneau = null;

function selectCreneau(heureDebut, heureFin, prix) {
    // Retirer la sélection précédente
    document.querySelectorAll('.creneau-btn').forEach(btn => {
        btn.classList.remove('ring-4', 'ring-blue-500', 'ring-offset-2');
    });
    
    // Ajouter la nouvelle sélection
    event.currentTarget.classList.add('ring-4', 'ring-blue-500', 'ring-offset-2');
    
    // Mettre à jour le récapitulatif
    document.getElementById('selected-creneau').innerHTML = 
        `<strong>${heureDebut}</strong> - <strong>${heureFin}</strong>`;
    
    document.getElementById('prix-base').textContent = prix + ' DH';
    document.getElementById('prix-total').textContent = prix + ' DH';
    
    // Activer le bouton de réservation
    const btnReserver = document.getElementById('btn-reserver');
    btnReserver.disabled = false;
    btnReserver.classList.remove('bg-gray-400', 'cursor-not-allowed');
    btnReserver.classList.add('bg-blue-600', 'hover:bg-blue-700', 'transition', 'cursor-pointer');
    btnReserver.textContent = 'Réserver maintenant';
    
    btnReserver.onclick = function() {
        alert(`Réservation confirmée !\\n\\nTerrain : {{ $terrain['nom'] }}\\nCréneau : ${heureDebut} - ${heureFin}\\nPrix : ${prix} DH\\n\\n(Fonctionnalité complète à venir en S3)`);
    };
    
    selectedCreneau = {
        heure_debut: heureDebut,
        heure_fin: heureFin,
        prix: prix
    };
}
</script>
@endsection