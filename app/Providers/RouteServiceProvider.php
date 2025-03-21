<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Le chemin vers la route "home" de votre application.
     *
     * Typiquement, les utilisateurs sont redirigés ici après leur authentification.
     *
     * @var string
     */
    public const HOME = '/dashboard'; // Valeur par défaut si aucune logique personnalisée n'est définie.

    /**
     * Définir vos liaisons de modèle de route, filtres de pattern et autres configurations de route.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Rediriger l'utilisateur après la connexion en fonction de son rôle.
     *
     * @return string
     */
    public static function redirectTo()
    {
        // Vérifie si l'utilisateur est connecté et s'il a un rôle
        if (auth()->check()) {
            if (auth()->user()->role == 'gestionnaire') {
                return route('gestionnaire.dashboard'); // Redirige vers le dashboard du gestionnaire
            }

            return route('client.dashboard'); // Redirige vers le dashboard du client
        }

        // Redirection par défaut si l'utilisateur n'est pas authentifié
        return route('login');
    }
}
