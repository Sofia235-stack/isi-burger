<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function clientDashboard()
    {
        return view('dashboard');
    }

    public function managerDashboard()
    {
        $pendingOrders = Commande::where('statut', 'En attente')->count();
        $todayOrders = Commande::whereDate('created_at', today())->count();
        $burgers = \App\Models\Burger::all(); // Ajoute cette ligne
        $notifications = auth()->user()->unreadNotifications;
        $commandes = Commande::paginate(10);

        return view('gestionnaire.dashboard', compact('pendingOrders', 'todayOrders', 'burgers', 'notifications', 'commandes'));
    }


    public function statistics()
    {
        $dailyRevenue = Commande::where('statut', 'Payée')
            ->whereDate('created_at', today())
            ->sum('payment_amount');

        $monthlyOrders = Commande::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->whereYear('created_at', now()->year)
            ->get();

        $productsByCategory = Commande::with('burgers')
            ->whereMonth('created_at', now()->month)
            ->get()
            ->flatMap->burgers
            ->groupBy('name')
            ->map->count();

        return view('gestionnaire.statistique', compact('dailyRevenue', 'monthlyOrders', 'productsByCategory'));
    }
}
