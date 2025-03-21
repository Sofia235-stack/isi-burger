<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BurgerController extends Controller
{
    public function index(Request $request)
    {
        $query = Burger::where('archive', true);

        // Recherche
        if ($search = $request->input('search')) {
            $query->where('nom', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('categorie', 'like', "%{$search}%");
        }

        // Tri par prix
        if ($sort = $request->input('sort')) {
            $query->orderBy('prix', $sort === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('nom');
        }

        $burgers = $query->paginate(6);
        return view('burgers.index', compact('burgers'));
    }

    public function gestionnaireIndex(Request $request)
    {
        // On commence par récupérer tous les burgers
        $query = Burger::query();

        // Recherche
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('categorie', 'like', "%{$search}%");
            });
        }

        // Tri par prix
        if ($sort = $request->input('sort')) {
            $query->orderBy('prix', $sort === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('nom');
        }

        // Définir la variable $burgers avant la logique d'archive
        $burgers = $query->paginate(6);

        // On crée une requête pour les burgers archivés et non archivés
        if ($archive = $request->input('archive')) {
            if ($archive === '0') {
                $burgers = Burger::where('archive', false)->paginate(3);
            } elseif ($archive === '1') {
                $burgers = Burger::where('archive', true)->paginate(3);
            }
        }

        // On retourne la vue avec les burgers filtrés
        return view('gestionnaire.burgers', compact('burgers'));
    }

    public function archive(Burger $burger)
    {
        $burger->archive = true;
        $burger->save();

        return redirect()->route('gestionnaire.dashboard')->with('success', 'Burger archivé avec succès.');
    }

    public function unarchive(Burger $burger)
    {
        $burger->archive = false;
        $burger->save();

        return redirect()->route('gestionnaire.dashboard')->with('success', 'Burger désarchivé avec succès.');
    }

    public function addToCart(Request $request, Burger $burger)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('message', 'Veuillez vous connecter pour ajouter au panier.');
        }

        $quantity = $request->input('quantite', 1);

        if (!is_numeric($quantity) || $quantity <= 0) {
            return back()->with('error', 'Quantité invalide');
        }

        if ($burger->stock < $quantity) {
            return back()->with('error', 'Stock insuffisant');
        }

        $cartItem = Card::where('user_id', auth()->id())
            ->where('burger_id', $burger->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            Card::create([
                'user_id' => auth()->id(),
                'burger_id' => $burger->id,
                'quantity' => $quantity
            ]);
        }

        return redirect()->route('cart.show')->with('success', 'Burger ajouté au panier');
    }

    // Méthodes gestionnaire
    public function create()
    {
        return view('burgers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'description' => 'required|string',
            'categorie' => 'required|string|max:100',
            'image' => 'required|image|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        $imagePath = $request->file('image')->store('burgers', 'public');

        Burger::create([
            'nom' => $validated['nom'],
            'prix' => $validated['prix'],
            'description' => $validated['description'],
            'categorie' => $validated['categorie'],
            'image' => $imagePath,
            'stock' => $validated['stock'],
            'archive' => false,
        ]);

        return redirect()->route('gestionnaire.dashboard')->with('success', 'Burger ajouté avec succès');
    }

    public function show($id)
    {
        $burger = Burger::findOrFail($id);
        return view('burgers.show', compact('burger'));
    }

    public function edit(Burger $burger)
    {
        return view('burgers.edit', compact('burger'));
    }

    public function update(Request $request, Burger $burger)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'description' => 'required|string',
            'categorie' => 'required|string|max:100',
            'image' => 'nullable|image|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        // Si une nouvelle image est envoyée, supprimer l’ancienne image
        if ($request->hasFile('image')) {
            if ($burger->image && Storage::disk('public')->exists($burger->image)) {
                Storage::disk('public')->delete($burger->image);
            }

            $imagePath = $request->file('image')->store('burgers', 'public');
            $burger->image = $imagePath;
        }

        $burger->update([
            'nom' => $validated['nom'],
            'prix' => $validated['prix'],
            'description' => $validated['description'],
            'categorie' => $validated['categorie'],
            'stock' => $validated['stock'],
            'image' => $burger->image,
        ]);

        return redirect()->route('gestionnaire.dashboard')->with('success', 'Burger modifié avec succès');
    }

    public function destroy(Burger $burger)
    {
        $burger->update(['archive' => false]);
        return redirect()->route('gestionnaire.dashboard')->with('success', 'Burger archivé avec succès');
    }
}
