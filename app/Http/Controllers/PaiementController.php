<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function store(Request $request, Commande $commande)
    {
        if ($commande->status === 'Payée') {
            return back()->withErrors(['payment' => 'Cette commande est déjà payée']);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:'.$commande->total,
        ]);

        $commande->update([
            'status' => 'Payée',
            'payment_date' => now(),
            'payment_amount' => $validated['amount'],
        ]);

        return back()->with('success', 'Paiement enregistré');
    }
}

