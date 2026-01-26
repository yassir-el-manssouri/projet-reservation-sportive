<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- INSCRIPTION ---
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
        ]);

        // 2. Création de l'utilisateur
        // ATTENTION : On utilise bien 'mot_de_passe' ici pour correspondre à ta base de données
        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'role' => 'client', 
            'mot_de_passe' => Hash::make($request->password), // <--- C'est ici la correction importante !
        ]);

        // 3. Connexion et redirection
        Auth::login($user);
        
        return redirect()->route('home')->with('success', 'Votre compte a été créé avec succès !');
    }

    // --- CONNEXION ---
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validation
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative de connexion
        // Note: Auth::attempt a besoin de la clé 'password' dans le tableau pour savoir quel champ hacher,
        // même si la colonne en base s'appelle 'mot_de_passe' (grâce à ton modèle User)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // --- REDIRECTION ADMIN VS CLIENT ---
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Bienvenue Admin !');
            }
            
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    // --- DECONNEXION ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}