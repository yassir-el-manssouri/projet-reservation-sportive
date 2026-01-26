<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Ce code s'exécute à chaque fois qu'on essaie d'aller sur /admin
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Est-ce que l'utilisateur est connecté ?
        // 2. Est-ce que son rôle est bien 'admin' ?
        if (Auth::check() && Auth::user()->role === 'admin') {
            // C'est bon, on le laisse passer vers la page demandée
            return $next($request);
        }

        // Sinon, on le rejette vers l'accueil avec un message d'erreur
        return redirect('/')->with('error', "Accès interdit : Vous n'êtes pas administrateur.");
    }
}