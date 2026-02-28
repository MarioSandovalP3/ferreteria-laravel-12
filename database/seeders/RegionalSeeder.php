<?php

namespace Database\Seeders;

use App\Models\RegionalSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Support\Facades\Http;

class RegionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Evita duplicados
        if (RegionalSettings::exists()) {
            return;
        }

        // 🌐 Detectar ubicación del servidor
        try {
            $response = Http::get('http://ip-api.com/json');
            $data = $response->json();

            $countryCode = $data['countryCode'] ?? 'US';
            $timezone = $data['timezone'] ?? 'UTC';
            $regionName = $data['regionName'] ?? null;
            $city = $data['city'] ?? null;
            $zip = $data['zip'] ?? null;
            $lat = $data['lat'] ?? null;
            $lon = $data['lon'] ?? null;
        } catch (\Exception $e) {
            $countryCode = 'US';
            $timezone = 'UTC';
        }

        // Buscar el país
        $country = Country::where('iso_code', $countryCode)->first();

        if (!$country) {
            $country = Country::where('iso_code', 'US')->first();
        }

        // Crear o actualizar región asociada
        $region = Region::updateOrCreate(
            [
                'country_id' => $country?->id,
                'region_name' => $regionName,
                'city' => $city,
            ],
            [
                'zip' => $zip,
                'lat' => $lat,
                'lon' => $lon,
            ]
        );

        // Crear configuración regional
        $settings = new RegionalSettings();
        $settings->date_format = 'Y-m-d H:i:s';
        $settings->country_id = $country?->id;
        $settings->save();

        config(['app.timezone' => $timezone]);
        date_default_timezone_set($timezone);

    }
}
