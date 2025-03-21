@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-header bg-primary text-primary-content">
                <h1 class="text-2xl font-bold">Détails de la commande #{{ $commande->id }}</h1>
            </div>
            <div class="card-body">
                <p><strong>Utilisateur:</strong> {{ $commande->user->name }}</p>
                <p><strong>Statut:</strong> {{ ucfirst($commande->statut) }}</p>
                <p><strong>Total:</strong> {{ number_format($commande->total, 2) }} €</p>
                <p><strong>Date de commande:</strong> {{ $commande->date_commande->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl mt-4">
            <div class="card-header bg-secondary text-secondary-content">
                <h2 class="text-xl font-bold">UPDATE STATUT</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('commandes.updateStatus', $commande->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="statut" class="block text-sm font-medium">Statut:</label>
                        <select name="statut" id="statut" class="select select-bordered w-full">
                            <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="en_preparation" {{ $commande->statut == 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                            <option value="prete" {{ $commande->statut == 'prete' ? 'selected' : '' }}>Prête</option>
                            <option value="payee" {{ $commande->statut == 'payee' ? 'selected' : '' }}>Payée</option>
                        </select>
                    </div>
                    <div id="montant_paye_section" class="form-group mb-4" style="display: none;">
                        <label for="montant_paye" class="block text-sm font-medium">Montant payé:</label>
                        <input type="number" name="montant_paye" id="montant_paye" class="input input-bordered w-full" step="0.01">
                    </div>
                    <button type="submit" class="btn btn-primary">MAJ</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('statut').addEventListener('change', function() {
            if (this.value === 'payee') {
                document.getElementById('montant_paye_section').style.display = 'block';
            } else {
                document.getElementById('montant_paye_section').style.display = 'none';
            }
        });
    </script>
@endsection