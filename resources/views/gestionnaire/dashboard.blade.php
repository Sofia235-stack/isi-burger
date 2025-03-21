@extends('layouts.app')

@section('gestionnaire-dashboard')
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Bienvenue sur votre dashboard, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600 mb-8">Voici les statistiques et les informations de gestion des burgers.</p>

        <div class="relative">
            <button class="relative">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 00-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @if($notifications->count() > 0)
                    <span
                        class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                {{ $notifications->count() }}
            </span>
                @endif
            </button>
            @if($notifications->count() > 0)
                <div class="absolute right-0 z-10 mt-2 w-64 bg-white shadow-xl rounded-xl p-4">
                    @foreach ($notifications as $notification)
                        <div class="mb-2 border-b pb-2">
                        {{--<p class="text-sm">{{ $notification->data['message'] }}</p>--}}
                            <a href="{{ route('commandes.show', $notification->data['commande_id']) }}"
                               class="text-blue-500 text-xs">Voir la commande</a>
                        </div>
                    @endforeach
                    <form method="POST" action="{{ route('notifications.markAsRead') }}">
                        @csrf
                        <button type="submit" class="w-full mt-2 bg-blue-500 text-white py-1 px-2 rounded text-sm">
                            Marquer tout comme lu
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Widgets pour les statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-2">Burgers en stock</h2>
                <p class="text-2xl font-bold">{{ $burgers->where('stock', '>', 0)->count() }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-2">Burgers en rupture</h2>
                <p class="text-2xl font-bold text-red-500">{{ $burgers->where('stock', '<=', 0)->count() }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-2">Total des burgers</h2>
                <p class="text-2xl font-bold">{{ $burgers->count() }}</p>
            </div>
        </div>

        <!-- Boutons d'actions -->
        <div class="mb-6 flex items-center space-x-4">
            <a href="{{ route('burgers.create') }}"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                Ajouter un nouveau burger
            </a>
            <button onclick="toggleArchived()"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Afficher les burgers archivés
            </button>
        </div>

        <!-- Tableau des burgers actifs -->
        <div class="overflow-x-auto bg-white rounded-lg shadow mb-10">
            <table class="w-full table-auto">
                <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Image</th>
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Prix FCFA</th>
                    <th class="px-4 py-2">Stock</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($burgers->where('archive', false) as $burger)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">
                            @if ($burger->image)
                                <img src="{{ asset('storage/app/public/burgers/' . $burger->image) }}"
                                     alt="{{ $burger->nom }}"
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-400">Aucune</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 font-semibold">{{ $burger->nom }}</td>
                        <td class="px-4 py-2">{{ number_format($burger->prix, 2, ',', ' ') }}</td>
                        <td class="px-4 py-2 {{ $burger->stock <= 0 ? 'text-red-500' : '' }}">
                            {{ $burger->stock <= 0 ? 'Rupture' : $burger->stock }}
                        </td>
                        <td class="px-4 py-2 text-sm">{{ Str::limit($burger->description, 60) }}</td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <a href="{{ route('burgers.edit', $burger) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Modifier</a>
                            <form action="{{ route('burgers.destroy', $burger) }}" method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ce burger ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Supprimer
                                </button>
                            </form>
                            @if (!$burger->archive)
                                <form action="{{ route('burgers.archive', $burger) }}" method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Voulez-vous archiver ce burger ?');">
                                    @csrf
                                    <button type="submit"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                        Archiver
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">Aucun burger trouvé.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Liste des burgers archivés (masquée par défaut) -->
        <div id="archiveBurgersSection" style="display: none;"
             class="overflow-x-auto bg-white rounded-lg shadow mb-10">
            <h2 class="text-2xl font-bold mb-4 p-4">Burgers Archivés</h2>
            <table class="w-full table-auto">
                <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Image</th>
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Prix FCFA</th>
                    <th class="px-4 py-2">Stock</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($burgers->where('archive', true) as $archiveBurger)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">
                            @if ($archiveBurger->image)
                                <img src="{{ asset('storage/' . $archiveBurger->image) }}"
                                     alt="{{ $archiveBurger->nom }}"
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-400">Aucune</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 font-semibold">{{ $archiveBurger->nom }}</td>
                        <td class="px-4 py-2">{{ number_format($archiveBurger->prix, 2, ',', ' ') }}</td>
                        <td class="px-4 py-2">{{ $archiveBurger->stock }}</td>
                        <td class="px-4 py-2 text-sm">{{ Str::limit($archiveBurger->description, 60) }}</td>
                        <td class="px-4 py-2 text-center">
                            <form action="{{ route('burgers.unarchive', $archiveBurger) }}" method="POST"
                                  onsubmit="return confirm('Voulez-vous désarchiver ce burger ?');">
                                @csrf
                                <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                    Désarchiver
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">Aucun burger archivé.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleArchived() {
            const section = document.getElementById('archiveBurgersSection');
            section.style.display = (section.style.display === 'none' || section.style.display === '') ? 'block' : 'none';
        }
    </script>
@endsection
