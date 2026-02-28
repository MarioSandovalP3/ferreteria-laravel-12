<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'customer',
                'description' => 'Partner who purchases products or services',
            ],
            [
                'name' => 'supplier',
                'description' => 'Partner who provides products or services',
            ],
            [
                'name' => 'reseller',
                'description' => 'Partner who resells products or services',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }
}
