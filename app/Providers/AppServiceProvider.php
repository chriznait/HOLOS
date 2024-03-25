<?php

namespace App\Providers;

use App\Helpers\Menu;
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
        view()->composer('layouts.app-menu', function($view) {
            $view->with('menus', Menu::menus());
        });
    }
}
