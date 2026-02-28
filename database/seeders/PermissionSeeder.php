<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        DB::table('permissions')->insert([
            "name" => "Dasboard_View",
            "guard_name" => "web"
        ]);
        

        /** Super Admin */
        DB::table('permissions')->insert([
            "name" => "User_View",
            "guard_name" => "web"
        ]);
        DB::table('permissions')->insert([
            "name" => "User_Search",
            "guard_name" => "web"
        ]);
        DB::table('permissions')->insert([
            "name" => "User_Create",
            "guard_name" => "web"
        ]);
        DB::table('permissions')->insert([
            "name" => "User_Edit",
            "guard_name" => "web"
        ]);
        DB::table('permissions')->insert([
            "name" => "User_Restore",
            "guard_name" => "web"
        ]);
        DB::table('permissions')->insert([
            "name" => "User_Delete",
            "guard_name" => "web"
        ]);
        DB::table('permissions')->insert([
            "name" => "User_Permanent_Delete",
            "guard_name" => "web"
        ]);

       

    }
}
