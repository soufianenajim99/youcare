<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        // Gate::define('is_organisateur',
        //  function (User $user) {
        //     $user->organisateur()->first();
        //  });
         Gate::define('is_organisateur', function (User $user) {
            return $user->organisateur()->first();
        });
        // Gate::define('volunteer', fn(User $user) => $user->benevole()->first());
    }
}