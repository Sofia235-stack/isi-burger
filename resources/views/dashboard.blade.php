@extends('layouts.app')

@section('content')

@if (auth()->check() && auth()->user()->isClient())
<div class="container mx-auto px-4 py-12 bg-gradient-to-br from-yellow-50 to-green-100 dark:from-gray-800 dark:to-gray-900 min-h-screen">
    <!-- Titre -->
    <h1 class="text-4xl font-extrabold mb-8 text-center text-yellow-700 dark:text-yellow-300 tracking-tight">
        Bienvenue, {{ auth()->user()->name }} 👋
    </h1>

    <!-- Grille des cartes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Carte : Dernières Commandes -->
        <div class="card bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
            <div class="card-body">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Dernières Commandes
                </h2>
                <a href="{{ route('cart.show') }}" class="text-yellow-600 dark:text-yellow-400 hover:underline font-medium">
                    Voir toutes mes commandes
                </a>
            </div>
        </div>

        <!-- Carte : Actions Rapides -->
        <div class="card bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
            <div class="card-body">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Actions Rapides
                </h2>
                <a href="{{ route('home') }}" class="btn inline-block px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all shadow-md">
                    Commander un Burger
                </a>
            </div>
        </div>
    </div>
</div>

@elseif (auth()->check() && auth()->user()->isGestionnaire())
<div class="container mx-auto px-4 py-12 bg-gradient-to-br from-teal-50 to-cyan-100 dark:from-gray-800 dark:to-gray-900 min-h-screen">
    <!-- Titre -->
    <h1 class="text-4xl font-extrabold mb-8 text-center text-teal-700 dark:text-teal-300 tracking-tight">
        Bienvenue, {{ auth()->user()->name }} 👋
    </h1>

    <!-- Grille des cartes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Carte : Dernières Commandes du Jour -->
        <div class="card bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
            <div class="card-body">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Dernières Commandes du Jour
                </h2>
                <a href="{{ route('commandes.index') }}" class="text-teal-600 dark:text-teal-400 hover:underline font-medium">
                    Voir toutes les commandes des clients
                </a>
            </div>
        </div>

        <!-- Carte : Actions Rapides -->
        <div class="card bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
            <div class="card-body">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Actions Rapides
                </h2>
                <a href="{{ route('commandes.index') }}" class="btn inline-block px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all shadow-md">
                    Lister Commandes
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection