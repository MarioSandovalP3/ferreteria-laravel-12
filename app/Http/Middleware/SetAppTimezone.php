<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\RegionalSettings;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;

class SetAppTimezone
{
    public function handle($request, Closure $next)
    {
        // Obtener configuración guardada
        $settings = RegionalSettings::with('country')->first();

        $timezone = $settings?->country?->timezone ?? config('app.timezone');
        $format   = $settings?->date_format ?? 'Y-m-d H:i:s';
        $currency = $settings?->country?->currency ?? 'USD';
        $symbol   = $settings?->country?->currency_symbol ?? '$';

        // Aplicar configuración dinámica
        Config::set('app.timezone', $timezone);
        Config::set('app.date_format', $format);
        Config::set('app.currency', $currency);
        Config::set('app.currency_symbol', $symbol);

        // Aplicar al runtime
        date_default_timezone_set($timezone);
        Date::setTestNow(); // fuerza Carbon a usar el nuevo timezone

        return $next($request);
    }
}
