<?php

namespace App\Providers;

use App\Models\SettingsModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
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
    Paginator::useBootstrapFour();

    if (!in_array(request()->ip(), ['127.0.0.1', '::1'])) {
        URL::forceScheme('https');
    }

    $settings = SettingsModel::first();
    View::share('settings', $settings);
}


}