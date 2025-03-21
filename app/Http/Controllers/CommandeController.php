<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Burger;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Notifications\NouvelleCommandeNotification;
use App\Notifications\CommandeConfirmationNotification;
use App\Notifications\FacturePDFNotification;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::paginate(2);
        return view('commandes.index', compact('commandes'));
    }

    public function show($id)
    {
        $commande = Commande::findOrFail($id);
        return view('commandes.show', compact('commande'));
    }

    public function store(Request $request)
    {
        // Création d'une nouvelle commande
        $commande = new Commande([
            'user_id' => auth()->id(),
            'statut' => 'en attente',
            'total' => 0,
        ]);
        $commande->save();

        // Ajouter les burgers à la commande et calculer le total
        foreach ($request->input('burgers') as $burgerId) {
            $burger = Burger::find($burgerId);
            $commande->burgers()->attach($burger);
            $commande->total += $burger->price;
        }

        $commande->save();

        // Envoyer la notification au gestionnaire
        $gestionnaires = User::where('role', 'gestionnaire')->get();
        foreach ($gestionnaires as $gestionnaire) {
            $gestionnaire->notify(new NouvelleCommandeNotification($commande));
        }

        // Envoyer la notification de confirmation au client
        $commande->user->notify(new CommandeConfirmationNotification($commande));

        return redirect()->route('commandes.index')->with('success', 'Commande passée avec succès.');
    }

    // Modifier le statut d'une commande
    public function updateStatus(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        $commande->statut = $request->statut;

        if ($request->statut == 'payee') {
            $commande->date_commande = now();
            $commande->total = $request->montant_paye;
        }

        if ($request->statut == 'prete') {
            $commande->user->notify(new FacturePDFNotification($commande));
        }


        $commande->save();
        return redirect()->route('commandes.show', $commande->id)->with('success', 'Statut de la commande mis à jour avec succès.');
    }

    // Annuler une commande
    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();
        return redirect()->route('commandes.index')->with('success', 'Commande annulée avec succès.');
    }
}
