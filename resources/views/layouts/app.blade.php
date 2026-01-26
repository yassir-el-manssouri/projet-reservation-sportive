<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Réservation Sportive')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-2xl font-bold flex items-center gap-2">
                        ⚽ <span>SportReserve</span>
                    </a>
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('terrains.index') }}" class="hover:text-blue-200 transition">Nos Terrains</a>
                        <a href="{{ route('creneaux.index') }}" class="hover:text-blue-200 transition">Créneaux Disponibles</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-purple-600 hover:bg-purple-500 text-white px-3 py-1.5 rounded text-sm font-bold shadow-sm transition">
                                🛠 Admin
                            </a>
                        @endif

                        @if(Auth::user()->role !== 'admin')
                            <a href="{{ route('reservations.history') }}" class="hover:text-blue-200 text-sm font-medium transition">
                                📅 Mes Réservations
                            </a>
                        @endif

                        <span class="mx-2 text-blue-200">|</span>
                        <span class="font-semibold">{{ Auth::user()->nom }}</span>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="ml-4 bg-red-500 px-4 py-2 rounded-lg hover:bg-red-400 transition font-semibold text-sm shadow">
                                Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition font-semibold shadow">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 border border-blue-400 px-4 py-2 rounded-lg hover:bg-blue-500 transition font-semibold shadow">
                            Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        <div class="container mx-auto px-4 mt-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md mb-6 animate-pulse" role="alert">
                    <p class="font-bold">Succès</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md mb-6" role="alert">
                    <p class="font-bold">Erreur</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
        </div>

        @yield('content')
    </main>
    
  <footer class="bg-gray-800 text-white text-center py-6 mt-12">
    <div class="container mx-auto">
        <p>
            &copy; {{ date('Y') }} SportReserve 
            <span class="mx-2">|</span> 
            By Yassir El Manssouri & Anass Benbassou
        </p>
    </div>
</footer>
</body>
</html>