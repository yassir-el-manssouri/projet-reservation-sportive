@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="container mx-auto px-4 py-16 flex justify-center">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-800">Créer un compte</h2>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Attention :</strong>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nom complet</label>
                <input type="text" name="nom" value="{{ old('nom') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Mot de passe (min 8 caractères)</label>
                <input type="password" name="password" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                S'inscrire
            </button>
        </form>
    </div>
</div>
@endsection