@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <!-- Titre principal -->
        <h1 class="text-4xl font-extrabold mb-8 text-center text-dark-blue-800 dark:text-gray-100 tracking-tight">
            Nos Burgers 🍔
        </h1>

        <!-- Affichage des messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-800 border-l-4 border-green-500 text-green-700 dark:text-green-200 rounded-lg shadow-md">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 dark:bg-red-800 border-l-4 border-red-500 text-red-700 dark:text-red-200 rounded-lg shadow-md">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Filtres -->
        <div class="mb-8 flex flex-col sm:flex-row gap-4 items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg">
            <form method="GET" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <input type="text"
                           name="search"
                           placeholder="Rechercher un burger..."
                           class="input w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                           value="{{ request('search') }}">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <select name="sort" class="select w-full sm:w-48 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    <option value="">Trier par prix</option>
                    <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Prix croissant</option>
                    <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Prix décroissant</option>
                </select>
                <button type="submit" class="btn px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all">
                    Filtrer
                </button>
            </form>
            <a href="{{ route('cart.show') }}" class="btn px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all">
                Voir le Panier
            </a>
        </div>

        <!-- Liste des burgers -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($burgers as $burger)
                <div class="relative group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <!-- Image du burger -->
                    <figure class="relative">
                        <img src="{{ asset($burger->image) }}" alt="{{ $burger->name }}"
                             class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105">
                        <!-- Badge de stock -->
                        @if($burger->stock <= 0)
                            <div class="absolute top-4 right-4 bg-red-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                Rupture de Stock
                            </div>
                        @elseif($burger->stock <= 5)
                            <div class="absolute top-4 right-4 bg-yellow-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                Stock Faible
                            </div>
                        @endif
                    </figure>
                    <div class="p-6">
                        <!-- Nom et description -->
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $burger->name }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">{{ $burger->description }}</p>
                        <!-- Prix -->
                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400 mb-4">{{ $burger->prix }} CFA</p>
                        <!-- Actions -->
                        <div class="flex flex-col gap-3">
                            @if($burger->stock > 0)
                                <form action="{{ route('burgers.addToCart', $burger) }}" method="POST" class="flex items-center gap-3">
                                    @csrf
                                    <input type="number" name="quantite" value="1" min="1" max="{{ $burger->stock }}"
                                           class="w-20 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <button type="submit" class="flex-1 btn py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all">
                                        Ajouter au Panier
                                    </button>
                                </form>
                            @else
                                <div class="text-center">
                                    <span class="btn py-2 bg-red-600 text-white rounded-lg cursor-not-allowed opacity-75">Rupture de Stock</span>
                                </div>
                            @endif
                            <a href="{{ route('burgers.show', $burger->id) }}" class="btn py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all text-center">
                                Voir Détails
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-6 bg-red-100 dark:bg-red-800 rounded-xl shadow-md text-center">
                    <div class="flex items-center justify-center text-red-700 dark:text-red-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728"></path>
                        </svg>
                        <span>Aucun burger trouvé ! Veuillez réessayer avec d'autres critères de recherche.</span>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $burgers->links('pagination::tailwind') }}
        </div>
    </div>
@endsection