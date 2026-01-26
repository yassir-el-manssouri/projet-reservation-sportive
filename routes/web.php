<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TerrainController;
use App\Http\Controllers\CreneauController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\Admin\EquipementController; 

/*
|--------------------------------------------------------------------------
| Routes Web - Réservation Sportive
|--------------------------------------------------------------------------
*/

// 1. Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 2. Routes Authentification (Invités)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// 3. Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// 4. Routes Publiques (Terrains & Créneaux & API)
Route::get('/terrains', [TerrainController::class, 'index'])->name('terrains.index');
Route::get('/terrains/{id}', [TerrainController::class, 'show'])->name('terrains.show');
Route::get('/creneaux', [CreneauController::class, 'index'])->name('creneaux.index');
Route::get('/terrains/{id}/creneaux', [CreneauController::class, 'getCreneauxByTerrain'])->name('creneaux.byTerrain');
Route::get('/creneaux/disponibles/{date}', [CreneauController::class, 'getCreneauxDisponibles'])->name('creneaux.disponibles');

// 👇 ROUTE API AJOUTÉE POUR LE JS
Route::get('/api/disponibilites/{terrain}/{date}', [ReservationController::class, 'checkAvailability']);


// 5. Routes Réservations Clients (Connectés)
Route::middleware('auth')->group(function () {
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/mes-reservations', [ReservationController::class, 'mesReservations'])->name('reservations.history');
});

// 6. ZONE ADMIN (Sécurisée)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // DASHBOARD
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // GESTION TERRAINS
    Route::get('/terrains', [AdminController::class, 'terrains'])->name('admin.terrains');
    Route::post('/terrains', [AdminController::class, 'storeTerrain'])->name('admin.terrains.store');
    Route::delete('/terrains/{id}', [AdminController::class, 'destroyTerrain'])->name('admin.terrains.delete');

    // GESTION RÉSERVATIONS
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
    Route::post('/reservations/{id}/cancel', [AdminController::class, 'cancelReservation'])->name('admin.reservations.cancel');

    // GESTION ÉQUIPEMENTS
    Route::get('/equipements', [EquipementController::class, 'index'])->name('admin.equipements.index');
    Route::post('/equipements', [EquipementController::class, 'store'])->name('admin.equipements.store');
    Route::delete('/equipements/{equipement}', [EquipementController::class, 'destroy'])->name('admin.equipements.destroy');
});