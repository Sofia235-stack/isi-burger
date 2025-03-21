@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl mt-12">
        <!-- Titre -->
        <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600 dark:text-indigo-400">Ajouter un Nouveau Burger</h2>

        <!-- Formulaire -->
        <form action="{{ route('burgers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nom du burger -->
            <div class="mb-5">
                <label for="nom" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Nom du Burger</label>
                <input type="text" name="nom" id="nom"
                       class="w-full p-3 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                       required>
            </div>

            <!-- Prix -->
            <div class="mb-5">
                <label for="prix" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Prix (FCFA)</label>
                <input type="number" name="prix" id="prix" step="0.01" min="0"
                       class="w-full p-3 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                       required>
            </div>

            <!-- Description -->
            <div class="mb-5">
                <label for="description" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full p-3 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                          required></textarea>
            </div>

            <!-- Catégorie -->
            <div class="mb-5">
                <label for="categorie" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Catégorie</label>
                <input type="text" name="categorie" id="categorie"
                       class="w-full p-3 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                       value="Autre" required>
            </div>

            <!-- Stock -->
            <div class="mb-5">
                <label for="stock" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Stock Disponible</label>
                <input type="number" name="stock" id="stock" min="0"
                       class="w-full p-3 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                       required>
            </div>

            <!-- Image -->
            <div class="mb-6">
                <label for="image" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Image</label>
                <input type="file" name="image" id="image"
                       class="w-full p-3 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800"
                       required>
            </div>

            <!-- Bouton Enregistrer -->
            <div class="text-center">
                <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all shadow-md">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
@endsection