@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg transform transition-all hover:shadow-xl mt-12">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-100 bg-gradient-to-r from-green-500 to-teal-500 bg-clip-text text-transparent">
            Modifier le Burger
        </h2>
        <form action="{{ route('burgers.update', $burger) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du burger</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                       value="{{ $burger->nom }}"
                       required>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prix (€)</label>
                <input type="number" 
                       name="price" 
                       id="price" 
                       step="0.01" 
                       min="0" 
                       class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                       value="{{ $burger->prix }}" 
                       required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" 
                          id="description" 
                          rows="4" 
                          class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                          required>{{ $burger->description }}</textarea>
            </div>

            <div>
                <label for="categorie" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catégorie</label>
                <input type="text" 
                       name="categorie" 
                       id="categorie" 
                       class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                       value="{{ $burger->categorie }}" 
                       required>
            </div>

            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock disponible</label>
                <input type="number" 
                       name="stock" 
                       id="stock" 
                       min="0" 
                       class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                       value="{{ $burger->stock }}" 
                       required>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nouvelle image (optionnel)</label>
                <input type="file" 
                       name="image" 
                       id="image" 
                       class="w-full p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-500 file:text-white hover:file:bg-green-600 transition">
            </div>

            <button type="submit" 
                    class="w-full bg-gradient-to-r from-green-500 to-teal-500 text-white px-6 py-3 rounded-lg font-semibold hover:from-green-600 hover:to-teal-600 transform hover:-translate-y-1 transition-all duration-300 shadow-md">
                Mettre à jour
            </button>
        </form>
    </div>
@endsection