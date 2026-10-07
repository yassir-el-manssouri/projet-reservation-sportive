<div align="center">

# ⚽ SportReserve — Plateforme de Réservation de Terrains & Complexes Sportifs

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-red.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

Système de gestion et de réservation en ligne pour clubs, complexes multisports et terrains (Football à 5/7, Tennis, Padel, Basketball).

[Fonctionnalités](#-fonctionnalités) • [Stack Technique](#%EF%B8%8F-stack-technique) • [Installation](#-installation--configuration)

</div>

---

## 🌟 Fonctionnalités

- 🏟️ **Catalogue Multisports des Terrains :** Présentation détaillée des terrains avec photos, revêtements (gazon synthétique, terre battue), éclairage nocturne et vestiaires.
- 📆 **Planning & Créneaux Dynamiques :** Calendrier interactif empêchant les doubles réservations, sélection intuitive des plages horaires (1h, 1h30).
- 👥 **Gestion des Équipes & Matchmaking :** Possibilité de créer des parties publiques pour compléter des joueurs manquants.
- 💳 **Tarifs & Règlements :** Gestion des acomptes, tarifs préférentiels (heures creuses / heures pleines) et abonnements mensuels.
- 🛡️ **Back-Office Administrateur :** Validation des paiements, gestion de l'occupation, statistiques de fréquentation et facturation.

---

## 🛠️ Stack Technique

- **Framework Backend :** [Laravel 12](https://laravel.com/) (Architecture MVC, Eloquent ORM, Blade)
- **Langage :** PHP 8.2+
- **Frontend & Assets :** Vite, Blade Templates, Tailwind CSS / JavaScript
- **Base de Données :** MySQL / MariaDB
- **Tests :** PHPUnit 11

---

## 📂 Structure du Répertoire

```bash
projet-reservation-sportive/
├── app/
│   ├── Http/Controllers/   # Contrôleurs Réservations, Terrains, Clients, Admin
│   └── Models/             # Modèles Eloquent (Terrain, Reservation, User, Payment)
├── config/                 # Fichiers de configuration Laravel
├── database/
│   ├── migrations/         # Migrations de schéma de base de données
│   └── seeders/            # Données de test (terrains et utilisateurs de démo)
├── resources/
│   ├── views/              # Vues Blade (Accueil, Terrains, Réservations, Dashboard)
│   └── js/ & css/          # Scripts et styles compilés par Vite
├── routes/
│   └── web.php             # Définition des routes de l'application
├── tests/                  # Tests unitaires et fonctionnels PHPUnit
├── composer.json           # Dépendances PHP
├── package.json            # Dépendances JS / Vite
└── vite.config.js          # Configuration Vite
```

---

## 🚀 Installation & Configuration

### 1. Cloner le projet
```bash
git clone https://github.com/yassir-el-manssouri/projet-reservation-sportive.git
cd projet-reservation-sportive
```

### 2. Installer les dépendances PHP & JS
```bash
composer install
npm install
```

### 3. Configurer l'environnement
Copiez le fichier `.env.example` en `.env` :
```bash
cp .env.example .env
```
Puis configurez votre base de données dans `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sports_arena_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Générer la clé de l'application
```bash
php artisan key:generate
```

### 5. Exécuter les migrations & seeders
```bash
php artisan migrate --seed
```

### 6. Lancer l'application
Dans deux terminaux séparés :
```bash
# Terminal 1 : Serveur Backend Laravel
php artisan serve

# Terminal 2 : Compilation des assets Vite
npm run dev
```
Accédez à l'application sur `http://127.0.0.1:8000`.

---

## 👤 Auteur

- **Yassir EL MANSSOURI** - [@yassir-el-manssouri](https://github.com/yassir-el-manssouri) | [LinkedIn](https://www.linkedin.com/in/yassir-el-manssouri/)
- Étudiant / Ingénieur à l'École Marocaine des Sciences de l'Ingénieur (EMSI).
---


