<?php

namespace App\Http\Middleware;

use App\Models\SettingsModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class LoadSettings
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle (Request $request, Closure $next)
    {
        $settings = Cache::remember('app_settings', 300, function() {
            return SettingsModel::first();
        });

        View::share('settings', $settings);
        $request->attributes->set('settings', $settings);
        return $next($request);
    }
}
