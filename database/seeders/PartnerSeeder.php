<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;
use App\Models\PartnerRoleType;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First partner: Tech Solutions LLC (customer + supplier)
        $partner1 = Partner::create([
            'name' => 'Tech Solutions LLC',
            'tax_id' => 'J-12345678-9',
            'email' => 'info@tech.com',
            'address' => null,
            'phone' => null,
            'type' => 'company',
            'is_active' => true,
        ]);
        
        $customerRole = PartnerRoleType::where('name', 'customer')->first();
        $supplierRole = PartnerRoleType::where('name', 'supplier')->first();
        $resellerRole = PartnerRoleType::where('name', 'reseller')->first();
        
        $partner1->roles()->attach([$customerRole->id, $supplierRole->id]);

        // Second partner: Carlos Pérez (customer)
        $partner2 = Partner::create([
            'name' => 'Carlos Pérez',
            'tax_id' => null,
            'email' => 'carlos@example.com',
            'address' => null,
            'phone' => null,
            'type' => 'person',
            'is_active' => true,
        ]);
        
        $partner2->roles()->attach($customerRole->id);

        // Third partner: Distribuidor Global (supplier + reseller)
        $partner3 = Partner::create([
            'name' => 'Distribuidor Global',
            'tax_id' => null,
            'email' => 'distribuidor@global.com',
            'address' => null,
            'phone' => null,
            'type' => 'company',
            'is_active' => true,
        ]);
        
        $partner3->roles()->attach([$supplierRole->id, $resellerRole->id]);
    }
}
