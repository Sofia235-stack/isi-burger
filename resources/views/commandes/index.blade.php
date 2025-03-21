@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-semibold mb-8 text-center text-gray-800">Liste des Commandes</h1>
        
        <div class="shadow-lg rounded-lg overflow-hidden bg-white">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-gray-600 uppercase text-sm">
                            <th class="py-4 px-6">ID</th>
                            <th class="py-4 px-6">Utilisateur</th>
                            <th class="py-4 px-6">Statut</th>
                            <th class="py-4 px-6">Total</th>
                            <th class="py-4 px-6">Date</th>
                            <th class="py-4 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($commandes as $commande)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6 text-gray-700">{{ $commande->id }}</td>
                                <td class="py-4 px-6 text-gray-700">{{ $commande->user->name }}</td>
                                <td class="py-4 px-6">
                                    <span class="badge font-medium
                                        @if($commande->statut == 'en_attente') bg-yellow-100 text-yellow-800
                                        @elseif($commande->statut == 'en_preparation') bg-blue-100 text-blue-800
                                        @elseif($commande->statut == 'prete') bg-green-100 text-green-800
                                        @elseif($commande->statut == 'payee') bg-purple-100 text-purple-800
                                        @endif
                                        px-3 py-1 rounded-full text-sm">
                                        {{ $commande->statut }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-gray-700 font-medium">{{ $commande->total }} €</td>
                                <td class="py-4 px-6 text-gray-600">{{ $commande->date_commande }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('commandes.show', $commande->id) }}" 
                                           class="btn bg-blue-600 text-white hover:bg-blue-700 btn-sm rounded-lg px-4 py-2 transition-colors">
                                            Voir
                                        </a>
                                        <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn bg-red-500 text-white hover:bg-red-600 btn-sm rounded-lg px-4 py-2 transition-colors">
                                                Annuler
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-6 bg-gray-50">
                {{ $commandes->links() }}
            </div>
        </div>
    </div>
@endsection