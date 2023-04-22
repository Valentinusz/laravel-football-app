<?php

namespace App\Providers;

use Illuminate\Auth\Access\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        \Illuminate\Support\Facades\Response::macro('admin', function() {
            return Response::deny("Ez a funkció csak admin jogosultságú felhasználók számára érhető el");
        });
    }
}
