@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12 bg-gradient-to-br from-orange-50 to-red-100 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-2xl min-h-screen">
    <h1 class="text-5xl font-extrabold mb-12 text-orange-800 dark:text-orange-200 text-center tracking-tight">🍔 Catalogue des Burgers</h1>

    <!-- Formulaire de filtrage -->
    <form action="{{ route('burgers.catalogue') }}" method="GET" class="mb-10 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-orange-200 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label class="block text-orange-700 dark:text-orange-300 font-semibold mb-2">Rechercher par nom</label>
                <input type="text" name="search" class="w-full p-3 rounded-lg bg-orange-50 dark:bg-gray-700 text-orange-800 dark:text-orange-200 border-2 border-orange-300 focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                       placeholder="Nom du burger" value="{{ request('search') }}">
            </div>
            <div>
                <label class="block text-orange-700 dark:text-orange-300 font-semibold mb-2">Prix min</label>
                <input type="number" name="price_min" class="w-full p-3 rounded-lg bg-orange-50 dark:bg-gray-700 text-orange-800 dark:text-orange-200 border-2 border-orange-300 focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                       placeholder="Prix minimum" value="{{ request('price_min') }}">
            </div>
            <div>
                <label class="block text-orange-700 dark:text-orange-300 font-semibold mb-2">Prix max</label>
                <input type="number" name="price_max" class="w-full p-3 rounded-lg bg-orange-50 dark:bg-gray-700 text-orange-800 dark:text-orange-200 border-2 border-orange-300 focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                       placeholder="Prix maximum" value="{{ request('price_max') }}">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all shadow-md font-semibold">
                    Filtrer
                </button>
            </div>
        </div>
    </form>

    <!-- Liste des burgers -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($burgers as $burger)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-orange-200 dark:border-gray-700 overflow-hidden">
                @if($burger->image)
                    <img src="{{ asset('images/' . $burger->image) }}" class="w-full h-56 object-cover rounded-t-xl border-b-2 border-orange-300 dark:border-orange-600" alt="{{ $burger->nom }}">
                @else
                    <div class="w-full h-56 bg-orange-100 dark:bg-gray-700 rounded-t-xl flex items-center justify-center text-orange-500 dark:text-orange-400 font-medium">
                        Aucune image disponible
                    </div>
                @endif
                <div class="p-6">
                    <h5 class="text-2xl font-bold text-orange-800 dark:text-orange-100 mb-2">{{ $burger->nom }}</h5>
                    <p class="text-orange-600 dark:text-orange-300 text-sm mb-3">{{ Str::limit($burger->description, 80) }}</p>
                    <p class="text-lg font-semibold text-orange-700 dark:text-orange-200 mb-4">
                        Prix: {{ number_format($burger->prix, 2, ',', ' ') }} FCFA
                    </p>
                    <a href="{{ route('burgers.show', $burger->id) }}" 
                       class="block w-full text-center px-5 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all shadow-md font-semibold">
                        Voir Détails
                    </a>
                </div>
            </div>
        @empty
            <p class="text-orange-600 dark:text-orange-400 text-center text-xl font-medium col-span-full">Aucun burger trouvé.</p>
        @endforelse
    </div>
</div>
@endsection