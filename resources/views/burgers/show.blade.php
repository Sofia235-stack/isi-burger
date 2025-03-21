@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transform transition-all hover:shadow-3xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="relative p-8">
                <img src="{{ asset($burger->image) }}" 
                     alt="{{ $burger->name }}" 
                     class="w-full h-72 object-cover rounded-lg shadow-md transform transition-transform hover:scale-105">
                <div class="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                    Disponible
                </div>
            </div>
            <div class="p-8 flex flex-col justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold mb-3 text-gray-900 dark:text-white bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">
                        {{ $burger->name }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed italic">{{ $burger->description }}</p>
                    <p class="text-4xl font-bold mb-6 text-orange-600 dark:text-orange-400">{{ $burger->prix }} CFA</p>
                </div>
                
                @if($burger->stock > 0)
                    <form method="POST" action="{{ route('orders.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="burger_id" value="{{ $burger->id }}">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Quantité</label>
                            <input type="number" 
                                   name="quantity" 
                                   min="1" 
                                   max="{{ $burger->stock }}" 
                                   value="1" 
                                   class="w-24 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        </div>
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-lg font-semibold hover:from-orange-600 hover:to-red-600 transform hover:-translate-y-1 transition-all duration-300 shadow-md">
                            Ajouter au Panier
                        </button>
                    </form>
                @else
                    <div class="bg-red-100 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-r-lg">
                        <p class="text-red-700 dark:text-red-300 font-semibold">Rupture de stock</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection