<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
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
        // Surface N+1 queries, silently discarded attributes and typos early.
        Model::shouldBeStrict(! $this->app->isProduction());

        // German resource URIs: /kontakte/neu, /kontakte/{id}/bearbeiten
        Route::resourceVerbs([
            'create' => 'neu',
            'edit' => 'bearbeiten',
        ]);
    }
}
