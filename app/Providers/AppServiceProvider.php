<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Store;
use Illuminate\Support\Facades\Cache;

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
        // Share store data with all store layout views
        view()->composer('components.layouts.home.*', function ($view) {
            $store = Cache::remember('store_data', 3600, function () {
                return Store::first();
            });
            
            $view->with('store', $store);
        });
    }
}
