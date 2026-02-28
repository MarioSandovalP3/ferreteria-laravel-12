<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            RolesSeeder::class,
            ModelHasRolesSeeder::class,
            RoleHasPermissionSeeder::class,
            CountrySeeder::class,
            RegionalSeeder::class,
            PartnerRoleTypeSeeder::class,
            PartnerSeeder::class,
            StoreSeeder::class,
            CategoryByTypeSeeder::class, // Updated to use new category seeder
            BrandSeeder::class,
            ProductSeeder::class,
            ExchangeRateSeeder::class, // Exchange rates
        ]);
    }
}
