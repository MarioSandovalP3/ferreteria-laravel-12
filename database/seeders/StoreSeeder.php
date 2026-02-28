<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Store::create([
            'name' => 'Ferretería PRO',
            'slug' => 'ferreteria-pro',
            'description' => 'Somos líderes en la distribución de herramientas y materiales de construcción. Más de 20 años equipando a profesionales.',
            'email' => 'contacto@ferreteriapro.com',
            'phone' => '+1 (809) 555-1234',
            'whatsapp' => '+1 (809) 555-5678',
            'address' => 'Av. Industrial 1234, Parque Industrial',
            'regional_settings_id' => 1, // Assuming first regional setting exists
            'business_hours' => [
                'monday' => ['open' => '08:00', 'close' => '18:00'],
                'tuesday' => ['open' => '08:00', 'close' => '18:00'],
                'wednesday' => ['open' => '08:00', 'close' => '18:00'],
                'thursday' => ['open' => '08:00', 'close' => '18:00'],
                'friday' => ['open' => '08:00', 'close' => '18:00'],
                'saturday' => ['open' => '08:00', 'close' => '14:00'],
                'sunday' => ['open' => 'closed', 'close' => 'closed'],
            ],
            'facebook' => 'https://facebook.com/ferreteriapro',
            'instagram' => 'https://instagram.com/ferreteriapro',
            'twitter' => 'https://twitter.com/ferreteriapro',
            'tax_rate' => 18.00,
            'shipping_cost' => 150.00,
            'free_shipping_threshold' => 2000.00,
            'meta_title' => 'Ferretería PRO - Equipamiento Industrial de Alta Calidad',
            'meta_description' => 'Encuentra las mejores herramientas y materiales de construcción. Envío rápido, garantía total y soporte 24/7.',
            'meta_keywords' => 'ferretería, herramientas, construcción, equipamiento industrial, República Dominicana',
            'is_active' => true,
            'maintenance_mode' => false,
        ]);
    }
}
