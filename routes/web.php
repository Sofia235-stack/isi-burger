<?php

use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\StatistiquesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route d’accueil publique
Route::get('/', [BurgerController::class, 'index'])->name('home');

// Routes publiques pour les burgers
Route::get('/burgers/create', [BurgerController::class, 'create'])->name('burgers.create'); // placée avant la route dynamique
Route::get('/burgers/{id}', [BurgerController::class, 'show'])
    ->where('id', '[0-9]+') // Contrainte pour que ce soit uniquement un nombre
    ->name('burgers.show');

// Dashboard générique
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes authentifiées
Route::middleware(['auth'])->group(function () {
    // Routes Client
    Route::get('/dashboard', [DashboardController::class, 'clientDashboard'])->name('dashboard');
    Route::get('/orders', [CommandeController::class, 'clientOrders'])->name('client.orders');
    Route::post('/orders', [CommandeController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [CommandeController::class, 'show'])->name('orders.show');

    // Gestion du panier
    Route::post('/burgers/{burger}/add-to-cart', [BurgerController::class, 'addToCart'])->name('burgers.addToCart');
    Route::get('/cart', [CardController::class, 'show'])->name('cart.show');
    Route::patch('/cart/{cartItem}', [CardController::class, 'update'])->name('cart.update');
    Route::get('/cart/{cartItem}/remove', [CardController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/checkout', [CardController::class, 'checkout'])->name('cart.checkout');

    // Routes Gestionnaire
    Route::middleware(['role:gestionnaire'])->group(function () {
        // Dashboard gestionnaire
        Route::get('/gestionnaire/dashboard', [DashboardController::class, 'managerDashboard'])->name('gestionnaire.dashboard');
        Route::get('gestionnaire/burgers', [BurgerController::class, 'gestionnaireIndex'])->name('gestionnaire.burgers');

        // Gestion des commandes (gestionnaire)
        Route::resource('commandes', CommandeController::class);
        Route::put('commandes/{commande}/updateStatus', [CommandeController::class, 'updateStatus'])->name('commandes.updateStatus');
        Route::get('/gestionnaire/orders', [CommandeController::class, 'index'])->name('manager.orders');
        Route::put('/gestionnaire/orders/{order}/status', [CommandeController::class, 'updateStatus'])->name('orders.update.status');
        Route::delete('/gestionnaire/orders/{order}', [CommandeController::class, 'destroy'])->name('orders.destroy');

        // Gestion des burgers (gestionnaire)
        Route::post('/burgers', [BurgerController::class, 'store'])->name('burgers.store');
        Route::get('/burgers/{burger}/edit', [BurgerController::class, 'edit'])->name('burgers.edit');
        Route::put('/burgers/{burger}', [BurgerController::class, 'update'])->name('burgers.update');
        Route::delete('/burgers/{burger}', [BurgerController::class, 'destroy'])->name('burgers.destroy');

        // Paiements (gestionnaire)
        Route::post('/gestionnaire/orders/{order}/payment', [PaiementController::class, 'store'])->name('payments.store');

        // Statistiques (gestionnaire)
        Route::get('/gestionnaire/statistics', [StatistiquesController::class, 'index'])->name('gestionnaire.statistics');
    });

    Route::put('/burgers/{burger}/archive', [BurgerController::class, 'archive'])->name('burgers.archive');
    Route::put('/burgers/{burger}/unarchive', [BurgerController::class, 'unarchive'])->name('burgers.unarchive');

    Route::post('/notifications/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');


});

// Fallback pour les pages non trouvées
Route::fallback(function () {
    return response()->view('errors', [], 404);
});

require __DIR__ . '/auth.php';
