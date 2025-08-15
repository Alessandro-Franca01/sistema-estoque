<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
    public function boot(): void
    {
        // TODO: Testear ainda mas vou preparar a implementação disso depois
        Gate::define('almoxarife', function ($user) {
            return $user->hasRole('almoxarife');
        });
    }
}
