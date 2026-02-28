<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\RegionalSettings;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Region;

class Regional extends Component
{
    public $timezone;
    public $utc_offset;
    public $date_format;
    public $country_id;

    public $serverTimezone;
    public $serverTime;
    public $currency;
    public $currency_symbol;

    public $countries = [];
    public $region_name;
    public $city;
    public $zip;
    public $lat;
    public $lon;

    public $dateFormats = [
        // 🌍 Estándares internacionales
        'Y-m-d',             // 2025-11-09 (ISO)
        'Y-m-d H:i:s',             // 2025-11-09 14:35:00 (ISO)
        'Y-m-d\TH:i:sP',           // 2025-11-09T14:35:00-04:00 (ISO8601 completo)

        // 🇪🇺 Europa / LatAm (día-mes-año)
        'd/m/Y',                    // 09/11/2025
        'd/m/Y H:i',               // 09/11/2025 14:35
        'd/m/Y h:i A',             // 09/11/2025 02:35 PM
        'd M Y, H:i',              // 09 Nov 2025, 14:35
        'l, d F Y H:i',            // Sunday, 09 November 2025 14:35

        // 🇺🇸 Estados Unidos (mes-día-año)
        'm/d/Y h:i A',             // 11/09/2025 02:35 PM
        'M d, Y h:i A',            // Nov 09, 2025 02:35 PM
        'l, F d, Y h:i A',         // Sunday, November 09, 2025 02:35 PM

        // 🕓 Formatos con segundos o zona horaria
        'd/m/Y H:i:s',             // 09/11/2025 14:35:00
        'm/d/Y h:i:s A',           // 11/09/2025 02:35:00 PM
        'D, d M Y H:i:s T',        // Sun, 09 Nov 2025 14:35:00 VET

        // 🌐 Locales extendidos
        'l, d \d\e F \d\e Y, h:i A', // Domingo, 09 de Noviembre de 2025, 02:35 PM
    ];


    public function mount()
    {
        $settings = RegionalSettings::with(['country.region'])->first();

        $this->date_format = $settings->date_format ?? 'Y-m-d H:i:s';
        $this->country_id  = $settings->country_id ?? null;

        if ($settings && $settings->country) {
            $country = $settings->country;

            $this->timezone         = $country->timezone ?? config('app.timezone');
            $this->currency         = $country->currency ?? 'USD';
            $this->currency_symbol  = $country->currency_symbol ?? '$';
            $this->region_name           = $country->region?->region_name ?? null;
            $this->city             = $country->region?->city ?? null;
            $this->zip              = $country->region?->zip ?? null;
            $this->lat              = $country->region?->lat ?? null;
            $this->lon              = $country->region?->lon ?? null;
        } else {
            $this->timezone         = config('app.timezone');
            $this->currency         = 'USD';
            $this->currency_symbol  = '$';
            $this->region_name           = null;
            $this->city             = null;
            $this->zip              = null;
            $this->lat              = null;
            $this->lon              = null;
        }

        config(['app.timezone' => $this->timezone]);
        date_default_timezone_set($this->timezone);

        $this->serverTimezone = date_default_timezone_get();
        $this->serverTime     = now($this->timezone);

        $this->countries = Country::orderBy('name_en')->get();
    }


    public function render()
    {
        $now = Carbon::now($this->timezone)->locale(app()->getLocale());

        return view('livewire.settings.regional-settings', [
            'dateFormats' => $this->dateFormats,
            'now'         => $now,
        ]);
    }

    public function Update()
{
    if (!Auth::user() || Auth::user()->role !== 'Super Admin') {
        $this->dispatch('notify', [
            'type' => 'error',
            'message' => __('You are not authorized to change regional settings.')
        ]);
        return;
    }

    $this->validate([
        'date_format' => 'required|string',
        'country_id'  => 'nullable|exists:countries,id',
    ]);

    $settings = RegionalSettings::first() ?? new RegionalSettings();
    $settings->date_format = $this->date_format;
    $settings->country_id  = $this->country_id;

    $settings->save();

    $region = Region::where('country_id', $this->country_id)->first();
    if ($region) {
        $region->update([
            'region_name' => $this->region_name,
            'city'        => $this->city,
            'zip'         => $this->zip,
            'lat'         => $this->lat,
            'lon'         => $this->lon,
        ]);
    }

    // 🔥 Reaplicar configuración
    $this->timezone        = $settings->country->timezone ?? config('app.timezone');
    $this->currency        = $settings->country->currency ?? 'USD';
    $this->currency_symbol = $settings->country->currency_symbol ?? '$';

    config([
        'app.timezone' => $this->timezone,
        'app.date_format' => $this->date_format,
        'app.currency' => $this->currency,
        'app.currency_symbol' => $this->currency_symbol,
    ]);
    date_default_timezone_set($this->timezone);

    $this->serverTimezone = date_default_timezone_get();

    // ❌ Antes: $this->serverTime = now()->format($this->date_format);
    // ✅ Ahora:
    $this->serverTime = now($this->timezone);

    $this->dispatch('profile-updated', [
        'type' => 'success',
        'message' => __('Regional settings updated successfully!'),
    ]);
}


}
