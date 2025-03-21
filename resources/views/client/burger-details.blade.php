@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12 bg-gradient-to-br from-red-50 to-orange-100 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-2xl min-h-screen">
    <h1 class="text-5xl font-extrabold mb-10 text-red-800 dark:text-red-200 text-center tracking-tight">{{ $burger->nom }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="relative">
            @if ($burger->image)
                <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->nom }}"
                     class="w-full h-80 object-cover rounded-xl border-4 border-red-300 dark:border-red-600 shadow-lg hover:scale-105 transition-transform duration-300">
                <!-- Suggestion: Add a subtle overlay for visual appeal -->
                <div class="absolute inset-0 bg-red-500 opacity-0 hover:opacity-10 rounded-xl transition-opacity duration-300"></div>
            @else
                <div class="w-full h-80 bg-red-100 dark:bg-gray-700 rounded-xl flex items-center justify-center text-red-500 dark:text-red-400 font-semibold text-xl border-4 border-red-300 dark:border-red-600 shadow-lg">
                    Aucune image disponible
                </div>
            @endif
        </div>
        <div class="flex flex-col justify-between">
            <div>
                <p class="text-3xl font-bold text-red-700 dark:text-red-300 mb-4">{{ number_format($burger->prix, 2, ',', ' ') }} FCFA</p>
                <p class="text-red-600 dark:text-red-400 text-lg leading-relaxed mb-6">{{ $burger->description }}</p>
                <p class="text-lg font-medium {{ $burger->stock <= 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }} mb-6">
                    {{ $burger->stock <= 0 ? 'Rupture de stock 😞' : 'En stock ✅' }}
                </p>
            </div>
            <a href="{{ route('commander', $burger) }}"
               class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg text-lg font-semibold focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all shadow-md inline-block self-start">
                Commander 🍔
            </a>
        </div>
    </div>
</div>
@endsection