@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="container mx-auto px-4 py-16 flex justify-center">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-800">Connexion</h2>
        
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Mot de passe</label>
                <input type="password" name="password" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                Se connecter
            </button>
        </form>
        
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Pas encore de compte ?</p>
            <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Créer un compte</a>
        </div>
    </div>
</div>
@endsection