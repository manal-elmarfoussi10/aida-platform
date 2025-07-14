<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Charger les routes web
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Charger les routes API
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }

    // Redirection après login selon le rôle
    public static function redirectTo(): string
    {
        return match (auth()->user()?->role) {
            'Admin' => '/admin',
            'Facility Manager' => '/facility',
            'User' => '/user',
            default => '/',
        };
    }
}
