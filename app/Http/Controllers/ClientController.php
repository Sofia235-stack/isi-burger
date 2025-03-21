<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function dashboard()
    {
        // Logique pour le dashboard du gestionnaire
        return view('client.dashboard');
    }

    public function catalogue()
    {
        // Afficher le catalogue des burgers
        $burgers = \App\Models\Burger::all();
        // dd($burgers);
        return view('client.catalogue', compact('burgers'));
    }

    public function showBurgerDetails($id)
    {
        $burger = \App\Models\Burger::findOrFail($id);
        return view('client.burger_details', compact('burger'));
    }

    public function showCommande(Commande $commande)
    {
        // Détails de la commande du client
        return view('client.commande', compact('commande'));
    }

    public function facture(Commande $commande)
    {
        // Télécharger la facture en PDF
        // Utilisation de DomPDF ou une autre bibliothèque pour générer le PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('facture', compact('commande'));
        return $pdf->download('facture_' . $commande->id . '.pdf');
    }

    public function commander(Request $request, $burgerId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Vous devez être connecté pour passer une commande.');
        }

        // Logique pour passer une commande
        // ...

        // return redirect()->route('commande.show', $commande->id);
    }
}
