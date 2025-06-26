<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }

    // 🔽 Add this static method BELOW the boot() method or anywhere in the class
    public static function redirectTo(): string
    {
        return match (auth()->user()->role) {
            'Admin' => '/admin',
            'Facility Manager' => '/facility',
            'User' => '/user',
            default => '/',
        };
    }
}
