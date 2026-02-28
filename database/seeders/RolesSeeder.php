<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([ // Full system access. You can manage users, roles, global settings, security, logs, and backups.
            "name" => "Super Admin",
            "guard_name" => "web"
        ]);
        DB::table('roles')->insert([  // Full control of core operations. Cannot remove the Super Admin or edit critical system settings.
            "name" => "Admin",
            "guard_name" => "web"
        ]);
        DB::table('roles')->insert([  // Can manage products, orders, and customer inquiries. Cannot access user management or system settings.
            "name" => "Customers",
            "guard_name" => "web"
        ]);
    }
}

