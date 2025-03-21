@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Mes Commandes</h1>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="w-full table-auto">
                <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Statut</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($commandes as $commande)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $commande->id }}</td>
                        <td class="px-4 py-2">{{ $commande->statut }}</td>
                        <td class="px-4 py-2">{{ number_format($commande->total, 2, ',', ' ') }} FCFA</td>
                        <td class="px-4 py-2">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('commandes.show', $commande) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Voir les détails
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">Aucune commande trouvée.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
