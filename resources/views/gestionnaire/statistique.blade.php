@extends('layouts.app')

@section('content')
    @if(auth()->check() && auth()->user()->isGestionnaire())
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4">Statistiques et Rapports</h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="card bg-base-100 shadow-md p-4">
                    <h2 class="text-xl font-semibold">Commandes en cours de la journée</h2>
                    <p class="text-2xl">{{ $commandesEnCours }}</p>
                </div>
                <div class="card bg-base-100 shadow-md p-4">
                    <h2 class="text-xl font-semibold">Commandes validées de la journée</h2>
                    <p class="text-2xl">{{ $commandesValidees }}</p>
                </div>
                <div class="card bg-base-100 shadow-md p-4">
                    <h2 class="text-xl font-semibold">Recettes journalières</h2>
                    <p class="text-2xl">{{ $recettesJour }} €</p>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-2xl font-semibold mb-4">Nombre de commande par mois</h3>
                <div class="card bg-base-100 shadow-md p-4">
                    <canvas id="commandesParMoisChart"></canvas>
                </div>
            </div>

            <div>
                <h3 class="text-2xl font-semibold mb-4">Nombre de Produit par catégorie par mois</h3>
                <div class="card bg-base-100 shadow-md p-4">
                    <canvas id="produitsParCategorieParMoisChart"></canvas>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Data for commandes par mois chart
            const commandesParMoisData = @json($chartCommandes);
            const commandesParMoisLabels = commandesParMoisData.map(item => `Mois ${item.month}`);
            const commandesParMoisCounts = commandesParMoisData.map(item => item.total);

            console.log(commandesParMoisData, commandesParMoisLabels, commandesParMoisCounts);

            const commandesParMoisCtx = document.getElementById('commandesParMoisChart').getContext('2d');
            new Chart(commandesParMoisCtx, {
                type: 'line',
                data: {
                    labels: commandesParMoisLabels,
                    datasets: [{
                        label: 'Nombre de commandes',
                        data: commandesParMoisCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Data for produits par categorie par mois chart
            const produitsParCategorieParMoisData = @json($chartProduitsParCategorie);
            const categories = [...new Set(produitsParCategorieParMoisData.map(item => item.categorie))];
            const months = [...new Set(produitsParCategorieParMoisData.map(item => item.month))];

            const datasets = categories.map(categorie => {
                return {
                    label: categorie,
                    data: months.map(month => {
                        const item = produitsParCategorieParMoisData.find(data => data.month == month && data.categorie == categorie);
                        return item ? item.total : 0;
                    }),
                    backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.2)`,
                    borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
                    borderWidth: 1
                };
            });

            const produitsParCategorieParMoisCtx = document.getElementById('produitsParCategorieParMoisChart').getContext('2d');
            new Chart(produitsParCategorieParMoisCtx, {
                type: 'bar',
                data: {
                    labels: months.map(month => `Mois ${month}`),
                    datasets: datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            });
        </script>
    @else
        <p class="text-red-500">Vous n'êtes pas autorisé à accéder à cette page.</p>
    @endif
@endsection