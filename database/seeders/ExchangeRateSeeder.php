<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExchangeRate;
use App\Models\Country;

class ExchangeRateSeeder extends Seeder
{
    public function run(): void
    {
        // Get Venezuela (assuming it exists in countries table)
        $venezuela = Country::where('country_code', 'VE')->first();
        
        if ($venezuela) {
            // Create current exchange rate for Venezuela
            ExchangeRate::create([
                'country_id' => $venezuela->id,
                'rate' => 50.25, // Example rate: 1 USD = 50.25 Bs
                'effective_date' => now()->format('Y-m-d'),
                'notes' => 'Tasa oficial del BCV',
                'is_active' => true,
            ]);
            
            $this->command->info('✅ Created exchange rate for Venezuela: 1 USD = 50.25 Bs');
        }
        
        // You can add more countries here
        // Example for Colombia
        $colombia = Country::where('country_code', 'CO')->first();
        if ($colombia) {
            ExchangeRate::create([
                'country_id' => $colombia->id,
                'rate' => 4250.00, // Example: 1 USD = 4,250 COP
                'effective_date' => now()->format('Y-m-d'),
                'notes' => 'Tasa de referencia',
                'is_active' => true,
            ]);
            
            $this->command->info('✅ Created exchange rate for Colombia: 1 USD = 4,250 COP');
        }
    }
}
