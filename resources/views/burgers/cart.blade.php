@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12 bg-gradient-to-br from-amber-50 to-orange-100 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-2xl min-h-screen">
    <h1 class="text-5xl font-bold mb-10 text-amber-800 dark:text-amber-200 text-center tracking-tight">  Votre Panier</h1>

    @if($cartItems->isEmpty())
        <p class="text-amber-600 dark:text-amber-400 text-center text-xl font-medium animate-pulse">Votre panier est vide. Ajoutez de délicieux burgers ! 🍔</p>
    @else
        <div class="space-y-8">
            @foreach($cartItems as $item)
                <div class="flex items-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-amber-200 dark:border-gray-700">
                    <img src="{{ $item->burger->image }}" alt="{{ $item->burger->name }}" class="w-28 h-28 object-cover rounded-lg border-2 border-amber-300 dark:border-amber-600 shadow-md">
                    <div class="flex-1 ml-6">
                        <h2 class="text-2xl font-bold text-amber-800 dark:text-amber-100">{{ $item->burger->name }}</h2>
                        <p class="text-amber-600 dark:text-amber-400 text-lg">Prix unitaire: <span class="font-semibold">{{ $item->burger->prix }} CFA</span></p>
                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-4 mt-4">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->burger->stock }}" class="w-20 p-2 rounded-lg bg-amber-50 dark:bg-gray-700 text-amber-800 dark:text-amber-200 border-2 border-amber-300 focus:ring-2 focus:ring-amber-500 focus:border-transparent text-center">
                            <button type="submit" class="btn px-5 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all shadow-md">🔄 Mettre à jour</button>
                            <a href="{{ route('cart.remove', $item) }}" class="btn px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all shadow-md">❌ Supprimer</a>
                        </form>
                    </div>
                    <p class="text-xl font-bold text-amber-800 dark:text-amber-100 ml-8">{{ $item->burger->prix * $item->quantity }} CFA</p>
                </div>
            @endforeach

            <div class="text-right mt-10">
                <p class="text-4xl font-extrabold text-amber-800 dark:text-amber-100">Total: {{ $total }} CFA</p>
                <a href="{{ route('cart.checkout') }}" class="btn mt-6 px-8 py-4 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all text-xl font-semibold shadow-lg">✅ Passer la commande</a>
            </div>
        </div>
    @endif
</div>
@endsection