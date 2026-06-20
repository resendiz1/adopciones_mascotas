<?php

namespace App\Providers;

use App\Models\Mascota;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('same-shelter', function ($user, Mascota $mascota) {
            return $user->shelter?->id === $mascota->refugio_id;
        });
    }
}
