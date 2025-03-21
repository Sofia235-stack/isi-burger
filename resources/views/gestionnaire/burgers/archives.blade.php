@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Burgers Archivés</h1>
        <a href="{{ route('gestionnaire.dashboard') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
            Retour au dashboard
        </a>
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="w-full table-auto">
                <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Image</th>
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Prix</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($burgers as $burger)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">
                            @if ($burger->image)
                                <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->nom }}"
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-400">Aucune</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 font-semibold">{{ $burger->nom }}</td>
                        <td class="px-4 py-2">{{ number_format($burger->prix, 2, ',', ' ') }}</td>
                        <td class="px-4 py-2 text-sm">{{ Str::limit($burger->description, 60) }}</td>
                        <td class="px-4 py-2 text-center">
                            <form action="{{ route('burgers.unarchive', $burger) }}" method="POST"
                                  onsubmit="return confirm('Désarchiver ce burger ?');">
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
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">Aucun burger archivé</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
