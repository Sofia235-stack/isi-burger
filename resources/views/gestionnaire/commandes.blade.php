@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Liste des Commandes</h1>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="w-full table-auto">
                <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Client</th>
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
                        <td class="px-4 py-2">{{ $commande->client->name }}</td>
                        <td class="px-4 py-2">{{ $commande->statut }}</td>
                        <td class="px-4 py-2">{{ number_format($commande->total, 2, ',', ' ') }} FCFA</td>
                        <td class="px-4 py-2">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <form action="{{ route('gestionnaire.commandes.annuler', $commande) }}" method="POST"
                                  class="inline-block">
                                @csrf
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Annuler
                                </button>
                            </form>
                            <form action="{{ route('gestionnaire.commandes.statut', $commande) }}" method="POST"
                                  class="inline-block">
                                @csrf
                                <select name="statut" onchange="this.form.submit()"
                                        class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm">
                                    <option
                                        value="en_attente" {{ $commande->statut === 'en_attente' ? 'selected' : '' }}>En
                                        attente
                                    </option>
                                    <option
                                        value="en_preparation" {{ $commande->statut === 'en_preparation' ? 'selected' : '' }}>
                                        En préparation
                                    </option>
                                    <option value="prete" {{ $commande->statut === 'prete' ? 'selected' : '' }}>Prête
                                    </option>
                                    <option value="payee" {{ $commande->statut === 'payee' ? 'selected' : '' }}>Payée
                                    </option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">Aucune commande trouvée.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
