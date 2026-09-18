<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('manage-accounts', function ($user) {
            return is_owner();
        });

        Gate::define('manage-content', function ($user) {
            return is_staff();
        });
    }
}
