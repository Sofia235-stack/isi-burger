<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Burger;
use Illuminate\Http\Request;

class StatistiquesController extends Controller
{
    public function index()
    {
        // Commandes du jour
        $commandesEnCours = Commande::whereDate('created_at', today())->where('statut', 'en attente')->count();
        $commandesValidees = Commande::whereDate('updated_at', today())->where('statut', 'payee')->count();
        $recettesJour = Commande::whereDate('updated_at', today())->sum('total');

        // Statistiques mensuelles
        $commandesParMois = Commande::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->get();

        // Nombre de produits par catégorie par mois
        $produitsParCategorieParMois = Burger::selectRaw('EXTRACT(MONTH FROM commandes.created_at) as month, burgers.categorie, COUNT(*) as total')
            ->join('commande_burger', 'burger_id', '=', 'burgers.id')
            ->join('commandes', 'commandes.id', '=', 'commande_burger.commande_id')
            ->groupBy('month', 'burgers.categorie')
            ->get();

        // Préparer les données pour Chart.js
        $chartCommandes = $commandesParMois->map(function ($item) {
            return [
                'month' => $item->month,
                'total' => $item->total
            ];
        });

        $chartProduitsParCategorie = $produitsParCategorieParMois->map(function ($item) {
            return [
                'month' => $item->month,
                'categorie' => $item->categorie,
                'total' => $item->total
            ];
        });

        // Passer les données à la vue
        return view('gestionnaire.statistique', compact(
            'commandesEnCours',
            'commandesValidees',
            'recettesJour',
            'chartCommandes',
            'chartProduitsParCategorie'
        ));
    }
}