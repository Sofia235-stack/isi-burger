@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 bg-gray-100 dark:bg-gray-900">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">Gestion des Burgers</h1>

        <!-- Affichage des messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filtres -->
        <div class="mb-6 flex gap-4 items-center">
            <form method="GET" class="flex gap-4 w-full">
                <input type="text"
                       name="search"
                       placeholder="Rechercher..."
                       class="input input-bordered w-full max-w-xs"
                       value="{{ request('search') }}">
                <select name="sort" class="select select-bordered w-full max-w-xs">
                    <option value="">Trier par prix</option>
                    <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Prix croissant</option>
                    <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Prix décroissant</option>
                </select>
                <select name="archive" class="select select-bordered w-full max-w-xs">
                    <option value="all" {{ request('archive') === 'all' ? 'selected' : '' }}>Tous les burgers</option>
                    <option value="0" {{ request('archive') === '0' ? 'selected' : '' }}>Non archivés</option>
                    <option value="1" {{ request('archive') === '1' ? 'selected' : '' }}>Archivés</option>
                </select>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>
        </div>

        <!-- Liste des burgers -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($burgers as $burger)
                <div class="card shadow-lg dark:bg-gray-800 hover:shadow-xl transition-shadow duration-300">
                    <figure>
                        <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->name }}"
                             class="w-full h-48 object-cover"></figure>
                    <div class="card-body">
                        <h2 class="card-title text-gray-800 dark:text-gray-200">{{ $burger->name }}</h2>
                        <p class="text-gray-600 dark:text-gray-400">{{ $burger->description }}</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $burger->prix }} CFA</p>
                        <a href="{{ route('burgers.edit', $burger) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Modifier</a>
                        @if($burger->archive)
                            <form action="{{ route('burgers.unarchive', $burger->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Désarchiver</button>
                            </form>

                        @else
                            <form action="{{ route('burgers.archive', $burger->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning">Archiver</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-error shadow-lg">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728"></path>
                        </svg>
                        <span
                            class="ml-2">Aucun burger trouvé! Veuillez réessayer avec d'autres critères de recherche.</span>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $burgers->links() }}
        </div>
    </div>
@endsection
