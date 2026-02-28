<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RegionalSettings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $user;

    public $serverTimezone;
    public $serverTime;
    public $currency;
    public $currency_symbol;
    public $date_format;
    public $region_name;
    public $city_name;
    public $zip_code;
    public $latitude;
    public $longitude;

    public function mount()
    {
        $this->user = Auth::user();

        // ✅ Leer configuración actual de Laravel (middleware ya la aplicó)
        $this->serverTimezone = config('app.timezone');
        $this->date_format = config('app.date_format') ?? 'Y-m-d H:i:s';

        // ✅ Formatear hora del servidor con la configuración actual
        $this->serverTime = now(config('app.timezone'));

        

        // ✅ Moneda y símbolo (puedes extender config/app.php con estos campos)
        $this->currency = config('app.currency', 'USD');
        $this->currency_symbol = config('app.currency_symbol', '$');

        
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
